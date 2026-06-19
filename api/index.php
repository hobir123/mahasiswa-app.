<?php

// 1. Muat dulu engine utama Laravel biar fungsi config() dikenali
require __DIR__ . '/../public/index.php';

// 2. Paksa Laravel mengabaikan cache config lokal yang read-only
config(['app.hub' => true]);