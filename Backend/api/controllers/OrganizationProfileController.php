<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/auth.php';

class OrganizationProfileController {
    private $conn;
    // Define the upload directory path inside the Docker container, matching the volume mount
    private $uploadDir = '/var/www/html/uploads/organizations/';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        
        // Ensure the upload directory exists inside the container
        if (!file_exists($this->uploadDir)) {
            // Note: With Docker volumes, this mkdir might not be strictly needed
            // if the volume is created beforehand, but it's harmless.
            mkdir($this->uploadDir, 0777, true);
        }
    }

    // Mendapatkan profil organisasi
    public function getProfile() {
        try {
            $organizationId = Auth::requireAuth();
            error_log("[getProfile] Organization ID from token: " . $organizationId);

            $query = "SELECT 
                        id,
                        organization_name,
                        official_email,
                        official_phone,
                        office_address,
                        field_of_work,
                        description,
                        photo_url,
                        status,
                        created_at
                    FROM organizations 
                    WHERE id = :id";
            error_log("[getProfile] Query: $query");
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $organizationId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $organization = $stmt->fetch(PDO::FETCH_ASSOC);
                error_log("[getProfile] Organization data: " . json_encode($organization));
                unset($organization['password']);
                echo json_encode([
                    'status' => 'success',
                    'data' => $organization
                ]);

            exit;

            } else {
                error_log("[getProfile] Organization not found for id: $organizationId");
                http_response_code(404);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Organization not found'
                ]);
            exit;
            }
        } catch (Exception $e) {
            error_log("[getProfile] Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        exit;
        }
    }

    // Update profil organisasi
    public function updateProfile() {
        try {
            // Verifikasi token dan dapatkan ID organisasi
            $organizationId = Auth::requireAuth();
            
            // Log untuk debugging
            error_log("Organization ID from token: " . $organizationId);

            // Ambil data dari request
            $data = json_decode(file_get_contents("php://input"), true);
            
            // Validasi data yang diperlukan (tidak termasuk email)
            $requiredFields = ['organization_name', 'official_phone', 'office_address']; // Removed official_email
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty($data[$field])) {
                    http_response_code(400);
                    echo json_encode([
                        'status' => 'error',
                        'message' => "Field $field is required"
                    ]);
                    exit;
                    return;
                }
            }

            // Update data organisasi (tidak termasuk email)
            $query = "UPDATE organizations SET 
                        organization_name = :name,
                        official_phone = :phone,
                        office_address = :address,
                        field_of_work = :field_of_work,
                        description = :description,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = :id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $data['organization_name']);
            $stmt->bindParam(':phone', $data['official_phone']);
            $stmt->bindParam(':address', $data['office_address']);
            $stmt->bindParam(':field_of_work', $data['field_of_work']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':id', $organizationId);

            if ($stmt->execute()) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Profile updated successfully'
                ]);
            exit;
            } else {
                throw new Exception('Failed to update profile');
            }
        } catch (Exception $e) {
            error_log("Error in updateProfile: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        exit;
        }
    }

    // Upload foto profil
    public function uploadPhoto() {
        try {
            // Verifikasi token dan dapatkan ID organisasi
            $organizationId = Auth::requireAuth();
            
            // Log untuk debugging
            error_log("Organization ID from token: " . $organizationId);

            // Validasi file
            if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No file uploaded or upload error'
                ]);
                exit;
                return;
            }

            $file = $_FILES['photo'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxSize = 5 * 1024 * 1024; // 5MB

            // Validasi tipe file
            if (!in_array($file['type'], $allowedTypes)) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid file type. Only JPG, PNG, and GIF are allowed'
                ]);
                exit;
                return;
            }

            // Validasi ukuran file
            if ($file['size'] > $maxSize) {
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'File size too large. Maximum size is 5MB'
                ]);
                exit;
                return;
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('org_') . '.' . $extension;
            $filepath = $this->uploadDir . $filename;

            // Upload file
            if (move_uploaded_file($file['tmp_name'], $filepath)) {

                // --- Start: Delete old photo if exists ---
                $oldPhotoQuery = "SELECT photo_url FROM organizations WHERE id = :id";
                $oldPhotoStmt = $this->conn->prepare($oldPhotoQuery);
                $oldPhotoStmt->bindParam(':id', $organizationId);
                $oldPhotoStmt->execute();
                $oldPhotoResult = $oldPhotoStmt->fetch(PDO::FETCH_ASSOC);

                if ($oldPhotoResult && !empty($oldPhotoResult['photo_url'])) {
                    // Get the old photo path based on the URL stored in DB
                    // The URL is expected to be like /uploads/organizations/filename.jpg
                    // We need to construct the full path inside the container's filesystem
                    $oldPhotoUrl = $oldPhotoResult['photo_url'];

                    // Assuming the photo_url starts with /uploads/organizations/
                    // Replace this base URL part with the actual upload directory path
                    $oldPhotoRelativePath = str_replace('/uploads/organizations/', '', $oldPhotoUrl);
                    $oldPhotoPathToDelete = $this->uploadDir . $oldPhotoRelativePath;

                    error_log("[uploadPhoto] Attempting to delete old photo: " . $oldPhotoPathToDelete);

                    if (file_exists($oldPhotoPathToDelete)) {
                        if (unlink($oldPhotoPathToDelete)) {
                            error_log("[uploadPhoto] Old photo deleted successfully: " . $oldPhotoPathToDelete);
                        } else {
                            error_log("[uploadPhoto] Failed to delete old photo: " . $oldPhotoPathToDelete);
                            // Consider adding error handling or logging if unlink fails
                        }
                    } else {
                        error_log("[uploadPhoto] Old photo file not found on disk (path from DB): " . $oldPhotoPathToDelete);
                        // It might not exist if the URL format changed or file was manually removed
                    }
                }
                // --- End: Delete old photo if exists ---

                // Update database dengan URL foto BARU (gunakan URL path yang akan diakses dari frontend)
                $photoUrl = '/uploads/organizations/' . $filename;
                $query = "UPDATE organizations SET photo_url = :photo_url WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':photo_url', $photoUrl);
                $stmt->bindParam(':id', $organizationId);

                if ($stmt->execute()) {
                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Photo uploaded successfully',
                        'photo_url' => $photoUrl
                    ]);
                exit;
                } else {
                    // Jika gagal update database, hapus file yang sudah diupload
                    unlink($filepath);
                    throw new Exception('Failed to update photo URL in database');
                }
            } else {
                throw new Exception('Failed to upload file');
            }
        } catch (Exception $e) {
            error_log("Error in uploadPhoto: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        exit;
        }
    }

    // Mendapatkan statistik organisasi
    public function getStats() {
        try {
            $organizationId = Auth::requireAuth();
            error_log("[getStats] Organization ID from token: " . $organizationId);

            $query = "SELECT COUNT(*) as total FROM activities WHERE organization_id = :id";
            error_log("[getStats] Query total activities: $query");
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $organizationId);
            $stmt->execute();
            $totalActivities = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            error_log("[getStats] totalActivities: $totalActivities");

            $query = "SELECT COUNT(DISTINCT user_id) as total FROM activity_participants 
                     WHERE activity_id IN (SELECT id FROM activities WHERE organization_id = :id)";
            error_log("[getStats] Query total volunteers: $query");
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $organizationId);
            $stmt->execute();
            $totalVolunteers = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            error_log("[getStats] totalVolunteers: $totalVolunteers");

            $query = "SELECT COUNT(*) as total FROM activities 
                     WHERE organization_id = :id AND status = 'ongoing'";
            error_log("[getStats] Query active activities: $query");
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $organizationId);
            $stmt->execute();
            $activeActivities = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            error_log("[getStats] activeActivities: $activeActivities");

            echo json_encode([
                'status' => 'success',
                'data' => [
                    'totalActivities' => (int)$totalActivities,
                    'totalVolunteers' => (int)$totalVolunteers,
                    'activeActivities' => (int)$activeActivities
                ]
            ]);

            exit;

        } catch (Exception $e) {
            error_log("[getStats] Error: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        exit;
        }
    }
} 
?>