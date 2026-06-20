<?php

// Bersihkan cache konfigurasi lama secara otomatis di server Vercel
unset($_ENV['APP_KEY']);

// Teruskan request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';