<?php

// Memuat file konfigurasi database dari direktori config
// Nama file: database.php (lowercase d)
require_once __DIR__ . '/../config/database.php';

class AuthController {
    private $db;
    private $pdo;
    private $secret_key = "aksi_relawan_secret_key_2025"; // Ganti dengan secret key yang aman

    public function __construct() {
        $database = new Database();
        $this->pdo = $database->getConnection();

        // Tambahkan pengecekan jika koneksi gagal
        if ($this->pdo === null) {
            // Hentikan eksekusi atau lempar exception jika koneksi gagal
            // Ini akan menghasilkan respons error 500 yang lebih terkontrol
            http_response_code(503); // Service Unavailable
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
            exit; // Hentikan eksekusi controller
            // Atau: throw new Exception("Database connection failed");
        }
        // Properti $this->db mungkin tidak diperlukan lagi jika hanya butuh $pdo
        // $this->db = $database;
    }

    private function generateJWT($user) {
        $issued_at = time();
        $expiration = $issued_at + (60 * 60); // Token berlaku 1 jam

        $payload = [
            'iss' => 'aksi_relawan_api', // issuer
            'aud' => 'aksi_relawan_app', // audience
            'iat' => $issued_at, // issued at
            'exp' => $expiration, // expiration
            'data' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username']
            ]
        ];

        // Encode Header
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $header = base64_encode($header);

        // Encode Payload
        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        // Create Signature
        $signature = hash_hmac('sha256', "$header.$payload", $this->secret_key, true);
        $signature = base64_encode($signature);

        // Create JWT Token
        $jwt = "$header.$payload.$signature";

        return $jwt;
    }

    private function verifyJWT($token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        list($header, $payload, $signature) = $parts;

        // Verify Signature
        $valid_signature = base64_encode(
            hash_hmac('sha256', "$header.$payload", $this->secret_key, true)
        );

        if ($signature !== $valid_signature) {
            return false;
        }

        // Decode Payload
        $payload = json_decode(base64_decode($payload), true);

        // Check Expiration
        if (isset($payload['exp']) && $payload['exp'] < time()) {
            return false;
        }

        return $payload;
    }

    /**
     * Menangani registrasi pengguna baru.
     */
    public function register() {
        // 1. Ambil data JSON dari body request
        $data = json_decode(file_get_contents('php://input'), true);

        // 2. Validasi data (username, email, password)
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            http_response_code(400); // Bad Request
            return ['status' => 'error', 'message' => 'Username, email, dan password wajib diisi'];
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            return ['status' => 'error', 'message' => 'Format email tidak valid'];
        }

        // 3. Cek apakah username atau email sudah terdaftar
        try {
            $sqlCheck = "SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1";
            $stmtCheck = $this->pdo->prepare($sqlCheck);
            $stmtCheck->bindParam(':username', $data['username']);
            $stmtCheck->bindParam(':email', $data['email']);
            $stmtCheck->execute();

            if ($stmtCheck->fetch()) {
                // Username atau email sudah ada
                http_response_code(409); // Conflict
                // Beri pesan yang lebih spesifik jika perlu (misal, cek mana yang duplikat)
                return ['status' => 'error', 'message' => 'Username atau Email sudah terdaftar'];
            }
        } catch (PDOException $e) {
            http_response_code(500); // Internal Server Error
            // Sebaiknya log error ini daripada menampilkannya ke user
            error_log("Database error check user: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Terjadi masalah saat memeriksa data pengguna'];
        }

        // 4. Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // 5. Simpan pengguna ke database
        $username = $data['username'];
        $email = $data['email'];
        // Kolom full_name akan NULL karena skema diubah jadi NULLABLE

        try {
            // Query INSERT tanpa menyertakan full_name
            $sqlInsert = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmtInsert = $this->pdo->prepare($sqlInsert);
            $stmtInsert->bindParam(':username', $username);
            $stmtInsert->bindParam(':email', $email);
            $stmtInsert->bindParam(':password', $hashedPassword);

            if ($stmtInsert->execute()) {
                http_response_code(201); // Created
                // Ambil ID user baru jika perlu: $newUserId = $this->pdo->lastInsertId();
                return ['status' => 'success', 'message' => 'Registrasi berhasil'];
            } else {
                http_response_code(500);
                // Ambil info error jika ada
                $errorInfo = $stmtInsert->errorInfo();
                error_log("Database error insert user: " . ($errorInfo[2] ?? 'Unknown error'));
                return ['status' => 'error', 'message' => 'Registrasi gagal, terjadi kesalahan saat menyimpan data'];
            }
        } catch (PDOException $e) {
            http_response_code(500);
            error_log("Database error insert user: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Terjadi masalah saat menyimpan pengguna baru'];
        }
    }

    /**
     * Menangani login pengguna.
     */
    public function login() {
        // 1. Ambil data JSON dari body request
        $data = json_decode(file_get_contents('php://input'), true);

        // 2. Validasi data (email, password)
        if (empty($data['email']) || empty($data['password'])) {
            http_response_code(400);
            return ['status' => 'error', 'message' => 'Email dan password wajib diisi'];
        }

        try {
            // 3. Cari pengguna berdasarkan email
            $sql = "SELECT id, username, email, password, full_name, phone, address FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $data['email']);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // 4. Verifikasi password
            if (!$user || !password_verify($data['password'], $user['password'])) {
                http_response_code(401);
                return ['status' => 'error', 'message' => 'Email atau password salah'];
            }

            // 5. Generate JWT token
            $jwt = $this->generateJWT($user);
            
            // 6. Hapus password dari response
            unset($user['password']);
            unset($user['token']);

            // 7. Berikan response sukses dengan data user dan token
            return [
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'user' => $user,
                    'token' => $jwt
                ]
            ];

        } catch (PDOException $e) {
            http_response_code(500);
            error_log("Database error during login: " . $e->getMessage());
            return ['status' => 'error', 'message' => 'Terjadi kesalahan saat proses login'];
        }
    }

    /**
     * Menangani logout pengguna.
     */
    public function logout() {
        try {
            // Dapatkan token dari header Authorization
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? '';
            
            error_log("Auth Header: " . $authHeader); // Log header
            
            if (strpos($authHeader, 'Bearer ') === 0) {
                $token = substr($authHeader, 7);
                error_log("Token from request: " . $token);
                
                // Verify JWT
                $payload = $this->verifyJWT($token);
                if (!$payload) {
                    return [
                        'status' => 'error',
                        'message' => 'Token tidak valid'
                    ];
                }

                return [
                    'status' => 'success',
                    'message' => 'Logout berhasil'
                ];
            }
            
            error_log("No valid Bearer token in header");
            return [
                'status' => 'error',
                'message' => 'Token tidak ditemukan'
            ];
            
        } catch (Exception $e) {
            error_log("Error during logout: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat logout'
            ];
        }
    }
}
?> 