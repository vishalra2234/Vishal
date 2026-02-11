<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/helpers.php';
require __DIR__ . '/../middleware/auth.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(419);
    echo json_encode(['message' => 'Invalid request']);
    exit;
}

$jobId = (int)($_POST['job_id'] ?? 0);
if ($jobId <= 0) {
    http_response_code(422);
    echo json_encode(['message' => 'Invalid job']);
    exit;
}

$pdo = require __DIR__ . '/../config/database.php';
$check = $pdo->prepare('SELECT id FROM saved_jobs WHERE user_id = ? AND job_id = ? LIMIT 1');
$check->execute([auth_user()['id'], $jobId]);
if (!$check->fetch()) {
    $insert = $pdo->prepare('INSERT INTO saved_jobs (user_id, job_id, created_at) VALUES (?, ?, NOW())');
    $insert->execute([auth_user()['id'], $jobId]);
}

echo json_encode(['message' => 'Job saved successfully']);
