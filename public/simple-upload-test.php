<?php
// Simple PHP upload test - bypasses Laravel entirely
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Only POST method allowed']);
    exit;
}

echo json_encode([
    'php_version' => PHP_VERSION,
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'memory_limit' => ini_get('memory_limit'),
    'has_files' => !empty($_FILES),
    'files_count' => count($_FILES),
    'files_info' => $_FILES,
    'post_data' => $_POST,
    'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 'not set',
    'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'not set',
]);
?>