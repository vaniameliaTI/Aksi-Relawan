<?php

/**
 * Mendefinisikan rute API.
 * Format: 'METHOD /path' => [ControllerClass::class, 'methodName']
 *
 * Catatan: Penggunaan ::class memerlukan PHP 5.5+ dan autoloader
 * atau require manual di index.php. Untuk kesederhanaan awal,
 * kita akan menggunakan string nama kelas dan require manual.
 */

return [
    // Rute untuk Testing
    'GET /api/test' => ['TestController', 'test'],

    // Rute Autentikasi
    'POST /api/register' => ['AuthController', 'register'],
    'POST /api/login' => ['AuthController', 'login'],
    'POST /api/logout' => ['AuthController', 'logout'],

    // Rute Organisasi
    'POST /api/organization/register' => ['OrganizationAuthController', 'register'],
    'POST /api/organization/login' => ['OrganizationAuthController', 'login'],
    'GET /api/organization/profile' => ['OrganizationProfileController', 'getProfile'],
    'PUT /api/organization/profile' => ['OrganizationProfileController', 'updateProfile'],
    'POST /api/organization/upload-photo' => ['OrganizationProfileController', 'uploadPhoto'],
    'GET /api/organization/stats' => ['OrganizationProfileController', 'getStats'],

    // Rute Profile
    'GET /api/profile' => ['ProfileController', 'getProfile'],
    'PUT /api/profile' => ['ProfileController', 'updateProfile'],
    'POST /api/profile/photo' => ['ProfileController', 'uploadPhoto'],

    // Contoh Rute untuk Relawan (sesuaikan path dan method jika perlu)
    // 'GET /api/relawan' => ['RelawanController', 'getAll'],
    // 'GET /api/relawan/{id}' => ['RelawanController', 'getById'], // Perlu penanganan parameter {id}
    // 'POST /api/relawan' => ['RelawanController', 'create'],
    // 'PUT /api/relawan/{id}/status' => ['RelawanController', 'updateStatus'], // Perlu penanganan parameter {id}
]; 