<?php
require 'utils/cors.php';
require 'utils/auth.php';
require 'config/database.php';

// 1. Muat Definisi Rute
$routes = require 'routes/api.php';

// 2. Dapatkan Metode HTTP dan Path
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$requestPath = parse_url($requestUri, PHP_URL_PATH); // Hanya path, tanpa query string

// 3. Bangun Kunci Pencarian Rute
$routeKey = $requestMethod . ' ' . $requestPath;

// 4. Cari Rute yang Cocok
$controllerAction = null;
if (isset($routes[$routeKey])) {
    $controllerAction = $routes[$routeKey];
}

// 5. Proses Rute atau Berikan Error
if ($controllerAction) {
    $controllerName = $controllerAction[0];
    $methodName = $controllerAction[1];

    // Secara manual muat file controller (alternatif: gunakan autoloader)
    $controllerFile = 'controllers/' . $controllerName . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;

        if (class_exists($controllerName)) {
            $controller = new $controllerName();

            if (method_exists($controller, $methodName)) {
                // Panggil method controller
                try {
                    $result = $controller->$methodName(); // Untuk rute dengan parameter, perlu penyesuaian
                    // Jika respons adalah string, mungkin sudah JSON, jadi jangan encode lagi
                    if (is_string($result) && strpos($result, '{') === 0) {
                        echo $result;
                    } else {
                        echo json_encode($result);
                    }
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['status' => 'error', 'message' => 'Internal Server Error', 'details' => $e->getMessage()]);
                }
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => "Method '{$methodName}' not found in controller '{$controllerName}'"]);
            }
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => "Class '{$controllerName}' not found"]);
        }
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => "Controller file '{$controllerFile}' not found"]);
    }
} else {
    // Tidak ada rute yang cocok
    http_response_code(404);
    echo json_encode([
        'status' => 'error',
        'message' => 'Endpoint not found or method not allowed for this path',
        'requested' => $routeKey,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
}

?> 