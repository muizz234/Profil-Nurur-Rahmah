<?php

// Buat folder sementara di /tmp untuk cache Vercel
$tmpDirectories = [
    '/tmp/views',
    '/tmp/framework/sessions',
    '/tmp/framework/views',
    '/tmp/framework/cache'
];

foreach ($tmpDirectories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Forward request ke public/index.php
require __DIR__ . '/../public/index.php';
