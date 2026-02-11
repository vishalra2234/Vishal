<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/helpers.php';
require __DIR__ . '/../middleware/auth.php';
$pdo = require __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(419);
    exit('Invalid request');
}

$testId = (int)$_POST['test_id'];
$score = (float)$_POST['score'];
$stmt = $pdo->prepare('INSERT INTO results (user_id, test_id, score, rank_position, attempted_at) VALUES (?, ?, ?, ?, NOW())');
$stmt->execute([auth_user()['id'], $testId, $score, 0]);

echo json_encode(['status' => 'success', 'score' => $score]);
