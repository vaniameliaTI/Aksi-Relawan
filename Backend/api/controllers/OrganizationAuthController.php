<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/auth.php';

class OrganizationAuthController {
    private $conn;
    private $table_name = "organizations";
    private $members_table = "organization_members";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function register() {
        // Get posted data
        $data = json_decode(file_get_contents("php://input"));
        
        // Validate input
        if (!isset($data->organization_name) || !isset($data->official_email) || !isset($data->password)) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Data tidak lengkap"
            ]);
            return;
        }

        try {
            // Check if email already exists
            $query = "SELECT id FROM " . $this->table_name . " WHERE official_email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $data->official_email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                http_response_code(400);
                echo json_encode([
                    "status" => "error",
                    "message" => "Email sudah terdaftar"
                ]);
                return;
            }

            // Hash password
            $hashed_password = password_hash($data->password, PASSWORD_DEFAULT);

            // Insert organization
            $query = "INSERT INTO " . $this->table_name . "
                    (organization_name, registration_number, office_address, official_phone, 
                     official_email, password, field_of_work, description, status)
                    VALUES
                    (:name, :reg_number, :address, :phone, :email, :password, :field, :desc, 'pending')";

            $stmt = $this->conn->prepare($query);

            // Bind values
            $stmt->bindParam(":name", $data->organization_name);
            $stmt->bindParam(":reg_number", $data->registration_number);
            $stmt->bindParam(":address", $data->office_address);
            $stmt->bindParam(":phone", $data->official_phone);
            $stmt->bindParam(":email", $data->official_email);
            $stmt->bindParam(":password", $hashed_password);
            $stmt->bindParam(":field", $data->field_of_work);
            $stmt->bindParam(":desc", $data->description);

            if ($stmt->execute()) {
                $organization_id = $this->conn->lastInsertId();
                echo json_encode([
                    "status" => "success",
                    "message" => "Registrasi berhasil",
                    "data" => [
                        "organization_id" => $organization_id
                    ]
                ]);
            } else {
                throw new Exception("Gagal melakukan registrasi");
            }
        } catch(Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ]);
        }
    }

    public function login() {
        // Get posted data
        $data = json_decode(file_get_contents("php://input"));
        
        // Validate input
        if (!isset($data->email) || !isset($data->password)) {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Email dan password diperlukan"
            ]);
            return;
        }

        try {
            // Check organization
            $query = "SELECT * FROM " . $this->table_name . " 
                     WHERE official_email = :email 
                     AND status = 'active'";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $data->email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verify password
                error_log("Stored password hash: " . $row['password']);
                error_log("Input password: " . $data->password);
                if (password_verify($data->password, $row['password'])) {
                    // Generate JWT token
                    $token = Auth::generateToken([
                        'id' => $row['id'],
                        'email' => $row['official_email'],
                        'role' => 'organization_admin',
                        'organization_id' => $row['id']
                    ]);
                    
                    // Return success response
                    echo json_encode([
                        "status" => "success",
                        "message" => "Login berhasil",
                        "data" => [
                            "token" => $token,
                            "organization" => [
                                "id" => $row['id'],
                                "organization_name" => $row['organization_name'],
                                "official_email" => $row['official_email'],
                                "official_phone" => $row['official_phone'],
                                "office_address" => $row['office_address'],
                                "field_of_work" => $row['field_of_work']
                            ]
                        ]
                    ]);
                } else {
                    http_response_code(401);
                    echo json_encode([
                        "status" => "error",
                        "message" => "Password salah"
                    ]);
                }
            } else {
                http_response_code(401);
                echo json_encode([
                    "status" => "error",
                    "message" => "Email tidak ditemukan atau akun tidak aktif"
                ]);
            }
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Terjadi kesalahan: " . $e->getMessage()
            ]);
        }
    }

    public function verifyAdminToken() {
        $userId = Auth::getUserIdFromToken();
        
        if (!$userId) {
            http_response_code(401);
            echo json_encode([
                "status" => "error",
                "message" => "Token tidak valid"
            ]);
            return false;
        }

        // Verifikasi apakah user adalah admin organisasi
        $query = "SELECT id FROM " . $this->table_name . " 
                 WHERE id = :org_id AND status = 'active'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":org_id", $userId);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            http_response_code(403);
            echo json_encode([
                "status" => "error",
                "message" => "Akses ditolak. Akun organisasi tidak aktif"
            ]);
            return false;
        }

        return true;
    }
} 