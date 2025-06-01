<?php

class Auth {
    private static $secret_key = "aksi_relawan_secret_key_2025"; // Gunakan secret key yang sama dengan AuthController

    public static function generateToken($data) {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'data' => $data,
            'exp' => time() + (60 * 60 * 24) // 24 jam
        ]);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, self::$secret_key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

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

        // Verify Signature (gunakan base64url)
        $valid_signature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(
            hash_hmac('sha256', "$header.$payload", self::$secret_key, true)
        ));

        if ($signature !== $valid_signature) {
            return false;
        }

        // Decode Payload
        $payload = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

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