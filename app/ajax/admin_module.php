<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/helpers.php';
if (!auth_user() || !is_admin()) {
    http_response_code(403);
    exit;
}

header('Content-Type: application/json');
$allowed = ['users','courses','lessons','tests','questions','jobs','blogs','payments','coupons','notifications'];
$module = $_GET['module'] ?? 'users';
if (!in_array($module, $allowed, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid module']);
    exit;
}

$pdo = require __DIR__ . '/../config/database.php';
$stmt = $pdo->query("SELECT * FROM {$module} ORDER BY id DESC LIMIT 20");
echo json_encode($stmt->fetchAll());
