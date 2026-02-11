<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/helpers.php';
require __DIR__ . '/../middleware/auth.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(419);
    echo json_encode(['error' => 'Invalid request']);
    exit;
}

$pdo = require __DIR__ . '/../config/database.php';
$courseId = (int)($_POST['course_id'] ?? 0);
$couponCode = strtoupper(trim($_POST['coupon'] ?? ''));

$courseStmt = $pdo->prepare('SELECT id, price, discount_price FROM courses WHERE id = ?');
$courseStmt->execute([$courseId]);
$course = $courseStmt->fetch();
if (!$course) {
    echo json_encode(['error' => 'Course not found']);
    exit;
}

$amount = (float)($course['discount_price'] ?? $course['price']);
if ($couponCode !== '') {
    $couponStmt = $pdo->prepare('SELECT discount_type, value FROM coupons WHERE code = ? AND is_active = 1 AND (valid_till IS NULL OR valid_till >= CURDATE())');
    $couponStmt->execute([$couponCode]);
    if ($coupon = $couponStmt->fetch()) {
        if ($coupon['discount_type'] === 'percent') {
            $amount -= ($amount * ((float)$coupon['value'] / 100));
        } else {
            $amount -= (float)$coupon['value'];
        }
    }
}
$amount = max($amount, 1);

$pdo->beginTransaction();
$orderStmt = $pdo->prepare('INSERT INTO orders (user_id, course_id, amount, status, created_at) VALUES (?, ?, ?, ?, NOW())');
$orderStmt->execute([auth_user()['id'], $courseId, $amount, 'paid']);
$orderId = (int)$pdo->lastInsertId();

$paymentStmt = $pdo->prepare('INSERT INTO payments (order_id, payment_gateway, transaction_id, amount, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
$paymentStmt->execute([$orderId, 'razorpay', 'demo_txn_' . time(), $amount, 'paid']);

$unlockStmt = $pdo->prepare('INSERT INTO user_courses (user_id, course_id, progress_percent, unlocked_at) VALUES (?, ?, 0, NOW()) ON DUPLICATE KEY UPDATE unlocked_at = VALUES(unlocked_at)');
$unlockStmt->execute([auth_user()['id'], $courseId]);
$pdo->commit();

echo json_encode([
    'status' => 'success',
    'gateway' => 'Razorpay/UPI/Card',
    'order_id' => $orderId,
    'amount' => number_format($amount, 2, '.', ''),
    'auto_unlock' => true,
]);
