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
    $stmt = $pdo->prepare('INSERT INTO users (name, email, mobile, password, referral_code, role) VALUES (?, ?, ?, ?, ?, ?)');
    $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $stmt->execute([trim($_POST['name']), trim($_POST['email']), trim($_POST['mobile']), $hashed, trim($_POST['referral_code']), 'student']);
    redirect('/login.php');
}

if ($action === 'login') {
    $stmt = $pdo->prepare('SELECT id, name, email, password, role FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([trim($_POST['email'])]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password'])) {
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
    $_SESSION['success'] = 'Password reset link sent (demo mode).';
    redirect('/forgot-password.php');
}

redirect('/login.php');
