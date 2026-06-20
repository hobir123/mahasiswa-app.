<?php

// 1. Muat autoload dari composer
require __DIR__ . '/../vendor/autoload.php';

// 2. Jalankan aplikasi Laravel bootstrap
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Konfigurasi folder storage agar menggunakan folder temp (/tmp) milik Vercel
// Ini krusial karena Vercel bersifat serverless (read-only)
$app->useStoragePath('/tmp');

// 4. Tangani request secara penuh ke server web
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);