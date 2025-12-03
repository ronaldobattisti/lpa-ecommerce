<?php
// Simple upload: put image in /web/images and return its public URL.
header('Content-Type: application/json');

$uploadDir = dirname(__DIR__) . '/images/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (empty($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => 'No file']);
    exit;
}

// Handle PHP upload errors (size limits, partial uploads, etc.)
if (!empty($_FILES['image']['error'])) {
    echo json_encode(['success' => false, 'error' => 'Upload error code: ' . $_FILES['image']['error']]);
    exit;
}

$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
$filename = uniqid('img') . '.' . $ext;
$target = $uploadDir . $filename;

if (!is_uploaded_file($_FILES['image']['tmp_name']) || !move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    echo json_encode(['success' => false, 'error' => 'Could not save file']);
    exit;
}

// Build URL using BASE_URL if present; fallback to current host.
$baseUrl = '';
if (file_exists(__DIR__ . '/../config/site.php')) {
    include __DIR__ . '/../config/site.php';
    if (defined('BASE_URL')) {
        $baseUrl = rtrim(BASE_URL, '/');
    }
}
if (!$baseUrl) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $baseUrl = $scheme . '://' . $host;
}

$url = $baseUrl . '/images/' . $filename;

echo json_encode(['success' => true, 'filename' => $filename, 'url' => $url]);
?>
