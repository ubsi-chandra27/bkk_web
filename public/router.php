<?php
// Custom router for PHP built-in server
// Serves static files from public/ if they exist, otherwise forwards to index.php

$publicPath = __DIR__;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$filePath = realpath($publicPath . $uri);

// If the file exists and is inside public/ (security), serve it directly
if ($filePath !== false && is_file($filePath) && strpos($filePath, $publicPath) === 0) {
    // Set correct MIME type
    $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css'   => 'text/css',
        'js'    => 'application/javascript',
        'json'  => 'application/json',
        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'ico'   => 'image/x-icon',
        'webp'  => 'image/webp',
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'eot'   => 'application/vnd.ms-fontobject',
        'otf'   => 'font/otf',
        'map'   => 'application/json',
        'txt'   => 'text/plain',
        'pdf'   => 'application/pdf',
        'zip'   => 'application/zip',
        'html'  => 'text/html',
    ];
    $mime = $mimeTypes[$ext] ?? 'application/octet-stream';
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: public, max-age=3600');
    readfile($filePath);
    return true;
}

// Otherwise, route to index.php
require $publicPath . '/index.php';
