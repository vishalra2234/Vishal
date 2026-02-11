<?php

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$config = [
    'app_name' => 'GovPrep Hub',
    'base_url' => getenv('APP_URL') ?: 'http://localhost:8000',
    'db' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'name' => getenv('DB_NAME') ?: 'govprep',
        'user' => getenv('DB_USER') ?: 'root',
        'pass' => getenv('DB_PASS') ?: '',
        'charset' => 'utf8mb4',
    ],
    'razorpay_key' => getenv('RAZORPAY_KEY') ?: 'rzp_test_key',
    'razorpay_secret' => getenv('RAZORPAY_SECRET') ?: 'rzp_test_secret',
];

return $config;
