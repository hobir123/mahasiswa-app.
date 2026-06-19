<?php

// Paksa Laravel mengabaikan cache config lama yang bikin error 500
config(['app.hub' => true]);

// Panggil file utama Laravel
require __DIR__ . '/../public/index.php';