<?php

class ProfileController {
    private $db;
    private $uploadDir = '/var/www/aksi-relawan/Backend/uploads/profile_photos/';

    public function __construct($db) {
        $this->db = $db;
        
        // Create upload directory if it doesn't exist
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    public function getProfile($userId) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, username, email, phone, address, photo_url 
                FROM users 
                WHERE id = ?
            ");
            $stmt->execute([$userId]);
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$profile) {
                return ['status' => 'error', 'message' => 'Profile not found'];
            }

            return ['status' => 'success', 'data' => $profile];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Database error'];
        }
    }

    public function updateProfile($userId, $data) {
        try {
            $stmt = $this->db->prepare("
                UPDATE users 
                SET username = ?, phone = ?, address = ? 
                WHERE id = ?
            ");
            
            $stmt->execute([
                $data['full_name'],
                $data['phone'],
                $data['address'],
                $userId
            ]);

            return ['status' => 'success', 'message' => 'Profile updated successfully'];
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => 'Failed to update profile'];
        }
    }

    public function uploadPhoto($userId) {
        try {
            if (!isset($_FILES['photo'])) {
                return ['status' => 'error', 'message' => 'No photo uploaded'];
            }

            $file = $_FILES['photo'];
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            
            if (!in_array($file['type'], $allowedTypes)) {
                return ['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG and GIF are allowed'];
            }

            if ($file['size'] > 5 * 1024 * 1024) { // 5MB limit
                return ['status' => 'error', 'message' => 'File size too large. Maximum size is 5MB'];
            }

            // Generate unique filename
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = uniqid('profile_') . '.' . $extension;
            $filepath = $this->uploadDir . $filename;

            // Move uploaded file
            if (!move_uploaded_file($file['tmp_name'], $filepath)) {
                return ['status' => 'error', 'message' => 'Failed to save photo'];
            }

            // Update database with new photo URL
            $photoUrl = '/uploads/profile_photos/' . $filename;
            $stmt = $this->db->prepare("UPDATE users SET photo_url = ? WHERE id = ?");
            $stmt->execute([$photoUrl, $userId]);

            return [
                'status' => 'success',
                'message' => 'Photo uploaded successfully',
                'photo_url' => $photoUrl
            ];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Failed to upload photo'];
        }
    }
} 