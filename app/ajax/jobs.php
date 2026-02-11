<?php

declare(strict_types=1);

header('Content-Type: application/json');
$pdo = require __DIR__ . '/../config/database.php';

$state = $_GET['state'] ?? '';
$qualification = $_GET['qualification'] ?? '';

$sql = 'SELECT id, title, state, qualification, last_date, official_link FROM jobs WHERE 1=1';
$params = [];
if ($state !== '') {
    $sql .= ' AND state = ?';
    $params[] = $state;
}
if ($qualification !== '') {
    $sql .= ' AND qualification = ?';
    $params[] = $qualification;
}
$sql .= ' ORDER BY created_at DESC LIMIT 10';

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
echo json_encode($stmt->fetchAll());
