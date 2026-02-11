<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/helpers.php';
$pdo = require __DIR__ . '/../config/database.php';

$action = $_POST['action'] ?? '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf_token'] ?? '')) {
    http_response_code(419);
    exit('Invalid request');
}

if ($action === 'register') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $referralCode = trim($_POST['referral_code'] ?? '');

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $mobile === '' || strlen($password) < 8) {
        $_SESSION['error'] = 'Please enter valid registration details. Password must be at least 8 characters.';
        redirect('/register.php');
    }

    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Email already registered.';
        redirect('/register.php');
    }

    $insert = $pdo->prepare('INSERT INTO users (name, email, mobile, password, referral_code, role) VALUES (?, ?, ?, ?, ?, ?)');
    $hashed = password_hash($password, PASSWORD_BCRYPT);
    $insert->execute([$name, $email, $mobile, $hashed, $referralCode, 'student']);
    redirect('/login.php');
}

if ($action === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = (string)($_POST['password'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $_SESSION['error'] = 'Invalid credentials';
        redirect('/login.php');
    }

    $stmt = $pdo->prepare('SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
        ];
        redirect($user['role'] === 'admin' ? '/admin/index.php' : '/dashboard.php');
    }

    $_SESSION['error'] = 'Invalid credentials';
    redirect('/login.php');
}

if ($action === 'forgot') {
    $email = trim($_POST['email'] ?? '');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        if ($user = $stmt->fetch()) {
            $token = bin2hex(random_bytes(32));
            $tokenHash = hash('sha256', $token);
            $reset = $pdo->prepare('INSERT INTO password_resets (user_id, token_hash, expires_at, created_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 30 MINUTE), NOW())');
            $reset->execute([(int)$user['id'], $tokenHash]);
            $_SESSION['reset_link_demo'] = config('base_url') . '/reset-password.php?token=' . $token;
        }
    }

    $_SESSION['success'] = 'If your account exists, a password reset link has been generated.';
    redirect('/forgot-password.php');
}

if ($action === 'reset_password') {
    $token = (string)($_POST['token'] ?? '');
    $newPassword = (string)($_POST['password'] ?? '');

    if (strlen($newPassword) < 8 || strlen($token) < 10) {
        $_SESSION['error'] = 'Invalid reset request.';
        redirect('/reset-password.php?token=' . urlencode($token));
    }

    $tokenHash = hash('sha256', $token);
    $stmt = $pdo->prepare('SELECT id, user_id FROM password_resets WHERE token_hash = ? AND used_at IS NULL AND expires_at > NOW() LIMIT 1');
    $stmt->execute([$tokenHash]);
    $row = $stmt->fetch();

    if (!$row) {
        $_SESSION['error'] = 'Reset token is invalid or expired.';
        redirect('/forgot-password.php');
    }

    $pdo->beginTransaction();
    $updatePass = $pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
    $updatePass->execute([password_hash($newPassword, PASSWORD_BCRYPT), (int)$row['user_id']]);

    $markUsed = $pdo->prepare('UPDATE password_resets SET used_at = NOW() WHERE id = ?');
    $markUsed->execute([(int)$row['id']]);
    $pdo->commit();

    $_SESSION['success'] = 'Password reset successfully. Please login.';
    redirect('/login.php');
}

redirect('/login.php');
