<?php

class Auth {
    private static $secret_key = "aksi_relawan_secret_key_2025"; // Gunakan secret key yang sama dengan AuthController

    public static function getUserIdFromToken() {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        
        if (strpos($authHeader, 'Bearer ') === 0) {
            $token = substr($authHeader, 7);
            $payload = self::verifyJWT($token);
            
            if ($payload && isset($payload['data']['id'])) {
                return $payload['data']['id'];
            }
        }
        
        // Jika tidak ada token valid, return false
        return false;
    }
    
    private static function verifyJWT($token) {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }

        list($header, $payload, $signature) = $parts;

        // Verify Signature
        $valid_signature = base64_encode(
            hash_hmac('sha256', "$header.$payload", self::$secret_key, true)
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
    
    public static function requireAuth() {
        $userId = self::getUserIdFromToken();
        
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
            exit;
        }
        
        return $userId;
    }
}
?> 