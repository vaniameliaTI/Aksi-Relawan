<?php
require_once __DIR__ . '/../config/database.php';

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if($conn) {
        // Baca file SQL
        $sql = file_get_contents(__DIR__ . '/schema.sql');
        
        // Eksekusi perintah SQL
        $conn->exec($sql);
        
        $response = [
            "status" => "success",
            "message" => "Database berhasil diinisialisasi",
            "tables_created" => [
                "users",
                "activities",
                "activity_participants",
                "activity_photos"
            ]
        ];
        echo json_encode($response);
    }
} catch(PDOException $e) {
    $response = [
        "status" => "error",
        "message" => "Gagal menginisialisasi database",
        "error" => $e->getMessage()
    ];
    echo json_encode($response);
}
?> 