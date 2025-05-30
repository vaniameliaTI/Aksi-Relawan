<?php
require_once __DIR__ . '/../utils/auth.php';
require_once __DIR__ . '/../config/database.php';

class ProfileController {
    private $db;
    // Dalam Docker, path relatif terhadap root container
    private $uploadDir = '/var/www/html/uploads/profile_photos/';
    // URL path untuk akses via web
    private $uploadUrlPath = '/uploads/profile_photos/';

    public function __construct() {
        // Membuat koneksi database
        $database = new Database();
        $this->db = $database->getConnection();
        
        // Pastikan direktori uploads dan profile_photos ada
        $baseUploadDir = '/var/www/html/uploads';
        if (!file_exists($baseUploadDir)) {
            mkdir($baseUploadDir, 0777, true);
            chmod($baseUploadDir, 0777); // Pastikan izin penuh
        }
        
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
            chmod($this->uploadDir, 0777); // Pastikan izin penuh
        }
    }

    public function getProfile() {
        // Dapatkan user ID dari token
        $userId = Auth::requireAuth();
        
        try {
            $stmt = $this->db->prepare("
                SELECT id, username, email, phone, address, photo_url, full_name 
                FROM users 
                WHERE id = ?
            ");
            $stmt->execute([$userId]);
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$profile) {
                return ['status' => 'error', 'message' => 'Profile not found'];
            }

            // Jika photo_url ada tapi bukan URL lengkap, tambahkan base URL
            if (!empty($profile['photo_url']) && strpos($profile['photo_url'], 'http') !== 0) {
                // Gunakan URL relatif
                $profile['photo_url'] = $profile['photo_url'];
            }

            return ['status' => 'success', 'data' => $profile];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    }

    public function updateProfile() {
        // Dapatkan user ID dari token
        $userId = Auth::requireAuth();
        
        // Dapatkan data dari request JSON
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            return ['status' => 'error', 'message' => 'Invalid request data'];
        }
        
        try {
            // Check if photo_url is present in data to update photo_url as well
            if (array_key_exists('photo_url', $data)) {
                // If photo_url is empty string, do not update other fields to avoid deleting data unintentionally
                if ($data['photo_url'] === '') {
                    $stmt = $this->db->prepare("
                        UPDATE users 
                        SET photo_url = ?
                        WHERE id = ?
                    ");
                    $stmt->execute([
                        $data['photo_url'],
                        $userId
                    ]);
                } else {
                    $stmt = $this->db->prepare("
                        UPDATE users 
                        SET username = ?, full_name = ?, phone = ?, address = ?, photo_url = ?
                        WHERE id = ?
                    ");
                    
                    $stmt->execute([
                        $data['username'] ?? '',
                        $data['full_name'] ?? '',
                        $data['phone'] ?? '',
                        $data['address'] ?? '',
                        $data['photo_url'] ?? '',
                        $userId
                    ]);
                }
            } else {
                $stmt = $this->db->prepare("
                    UPDATE users 
                    SET username = ?, full_name = ?, phone = ?, address = ? 
                    WHERE id = ?
                ");
                
                $stmt->execute([
                    $data['username'] ?? '',
                    $data['full_name'] ?? '',
                    $data['phone'] ?? '',
                    $data['address'] ?? '',
                    $userId
                ]);
            }

            return ['status' => 'success', 'message' => 'Profile updated successfully'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to update profile: ' . $e->getMessage()];
        }
    }

    public function uploadPhoto() {
        // Dapatkan user ID dari token
        $userId = Auth::requireAuth();
        
        try {
            if (!isset($_FILES['photo'])) {
                error_log("No photo uploaded");
                return ['status' => 'error', 'message' => 'No photo uploaded'];
            }

            $file = $_FILES['photo'];
            error_log("Received file: " . print_r($file, true));
            
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            
            if (!in_array($file['type'], $allowedTypes)) {
                error_log("Invalid file type: " . $file['type']);
                return ['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG and GIF are allowed'];
            }

            if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
                error_log("File too large: " . $file['size']);
                return ['status' => 'error', 'message' => 'File size too large. Maximum size is 5MB'];
            }

            // Hapus foto lama
            try {
                // Dapatkan URL foto lama
                $stmtGet = $this->db->prepare("SELECT photo_url FROM users WHERE id = ?");
                $stmtGet->execute([$userId]);
                $oldPhoto = $stmtGet->fetchColumn();
                
                // Jika foto lama ada, hapus file
                if ($oldPhoto) {
                    $oldPhotoPath = str_replace($this->uploadUrlPath, $this->uploadDir, $oldPhoto);
                    error_log("Mencoba menghapus foto lama: " . $oldPhotoPath);
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                        error_log("Foto lama berhasil dihapus");
                    }
                }
            } catch (Exception $e) {
                error_log("Gagal menghapus foto lama: " . $e->getMessage());
                // Lanjutkan proses meskipun gagal menghapus foto lama
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('profile_') . '.' . $extension;
            $filepath = $this->uploadDir . $filename;
            
            error_log("Attempting to save file to: " . $filepath);
            
            // Debug directory permissions
            error_log("Upload directory exists: " . (file_exists($this->uploadDir) ? 'yes' : 'no'));
            error_log("Upload directory writable: " . (is_writable($this->uploadDir) ? 'yes' : 'no'));

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                error_log("Failed to move uploaded file: " . error_get_last()['message']);
                return ['status' => 'error', 'message' => 'Failed to save photo: ' . error_get_last()['message']];
            }

            // Set permissions on the uploaded file
            chmod($filepath, 0644);
            
            // URL absolut untuk foto (domain + path)
            $serverName = $_SERVER['HTTP_HOST'] ?? 'localhost:8080';
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $baseUrl = $protocol . $serverName;
            
            // URL relatif untuk foto
            $photoUrl = $this->uploadUrlPath . $filename;
            
            // Update database with new photo URL
            $stmt = $this->db->prepare("UPDATE users SET photo_url = ? WHERE id = ?");
            $stmt->execute([$photoUrl, $userId]);

            error_log("Photo uploaded successfully. URL: " . $photoUrl);
            return [
                'status' => 'success',
                'message' => 'Photo uploaded successfully',
                'photo_url' => $photoUrl
            ];
        } catch (Exception $e) {
            error_log("Exception during photo upload: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Failed to upload photo: ' . $e->getMessage()];
        }
    }
} 