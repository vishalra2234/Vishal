<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/helpers.php';

if (!auth_user() || !is_admin()) {
    http_response_code(403);
    exit('Unauthorized access');
}
