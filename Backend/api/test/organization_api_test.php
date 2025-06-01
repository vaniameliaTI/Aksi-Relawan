<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../utils/auth.php';

// Test data
$testOrganization = [
    'organization_name' => 'Selaras Jiwa',
    'official_email' => 'mahardika@selarasjiwa.com',
    'official_phone' => '081234567890',
    'office_address' => 'Jl. Contoh No. 123, Jakarta',
    'field_of_work' => 'Kesehatan Mental',
    'description' => 'Organisasi yang fokus pada kesehatan mental dan kesejahteraan psikologis'
];

// Generate test token dengan data yang valid sesuai database
$testToken = Auth::generateToken([
    'id' => 1,
    'type' => 'organization',
    'email' => 'mahardika@selarasjiwa.com'
]);

// Test endpoints
$baseUrl = 'http://localhost:8080/api/organization';

// Function to make API calls
function makeRequest($url, $method = 'GET', $data = null, $token = null) {
    $ch = curl_init();
    
    $headers = ['Content-Type: application/json'];
    if ($token) {
        $headers[] = 'Authorization: Bearer ' . $token;
    }
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    } elseif ($method === 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch) . "\n";
    }
    
    curl_close($ch);
    
    return [
        'code' => $httpCode,
        'response' => json_decode($response, true)
    ];
}

// Test cases
echo "Testing Organization API\n";
echo "=======================\n\n";

// 1. Test Get Profile (without token)
echo "1. Testing Get Profile (without token):\n";
$result = makeRequest($baseUrl . '/profile');
echo "Status Code: " . $result['code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

// 2. Test Get Profile (with token)
echo "2. Testing Get Profile (with token):\n";
$result = makeRequest($baseUrl . '/profile', 'GET', null, $testToken);
echo "Status Code: " . $result['code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

// 3. Test Update Profile
echo "3. Testing Update Profile:\n";
$result = makeRequest($baseUrl . '/profile', 'PUT', $testOrganization, $testToken);
echo "Status Code: " . $result['code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

// 4. Test Get Stats
echo "4. Testing Get Stats:\n";
$result = makeRequest($baseUrl . '/stats', 'GET', null, $testToken);
echo "Status Code: " . $result['code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

// 5. Test Upload Photo (simulated)
echo "5. Testing Upload Photo (simulated):\n";
echo "Note: File upload testing requires a different approach with curl\n";
echo "You can test this manually using Postman or a similar tool\n\n";

// 6. Test Invalid Endpoint
echo "6. Testing Invalid Endpoint:\n";
$result = makeRequest($baseUrl . '/invalid', 'GET', null, $testToken);
echo "Status Code: " . $result['code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

// 7. Test Invalid Method
echo "7. Testing Invalid Method:\n";
$result = makeRequest($baseUrl . '/profile', 'DELETE', null, $testToken);
echo "Status Code: " . $result['code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

// 8. Test Invalid Data
echo "8. Testing Invalid Data:\n";
$invalidData = [
    'organization_name' => '', // Empty required field
    'official_email' => 'invalid-email', // Invalid email format
    'official_phone' => '',
    'office_address' => ''
];
$result = makeRequest($baseUrl . '/profile', 'PUT', $invalidData, $testToken);
echo "Status Code: " . $result['code'] . "\n";
echo "Response: " . json_encode($result['response'], JSON_PRETTY_PRINT) . "\n\n";

echo "Testing completed.\n";
?> 