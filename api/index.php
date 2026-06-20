<?php

// Muat autoload dari composer
require __DIR__ . '/../vendor/autoload.php';

// Jalankan aplikasi Laravel bootstrap
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Atur folder storage ke folder temporer Vercel (karena Vercel read-only)
$app->useStoragePath('/tmp');

// Jalankan Kernel Laravel
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);