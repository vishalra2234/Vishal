<?php

declare(strict_types=1);

require_once __DIR__ . '/../helpers/helpers.php';

if (!auth_user()) {
    redirect('/login.php');
}
