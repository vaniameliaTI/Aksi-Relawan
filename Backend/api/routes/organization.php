<?php
require_once __DIR__ . '/../controllers/OrganizationProfileController.php';

// Inisialisasi controller
$profileController = new OrganizationProfileController();

// Mendapatkan method dan path dari request
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api/organization', '', $path);

// Routing berdasarkan method dan path
switch ($method) {
    case 'GET':
        if ($path === '/profile') {
            $profileController->getProfile();
        } elseif ($path === '/stats') {
            $profileController->getStats();
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint not found']);
        }
        break;

    case 'PUT':
        if ($path === '/profile') {
            $profileController->updateProfile();
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint not found']);
        }
        break;

    case 'POST':
        if ($path === '/upload-photo') {
            $profileController->uploadPhoto();
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Endpoint not found']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
        break;
}
?> 