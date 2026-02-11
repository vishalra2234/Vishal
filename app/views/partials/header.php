<?php require_once __DIR__ . '/../../helpers/helpers.php'; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="GovPrep Hub - Courses, test series, job alerts, and exam preparation." />
    <title><?= e($title ?? 'GovPrep Hub') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: { brand: '#0b4ed8', brandLight: '#e8f0ff' }
          }
        }
      }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />
</head>
<body class="bg-gray-50 text-gray-800">
<header class="bg-white shadow sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="/index.php" class="text-2xl font-bold text-brand">GovPrep Hub</a>
        <nav class="hidden lg:flex gap-5 text-sm font-medium">
            <?php
            $menu = [
              'Home'=>'/index.php','Paid Courses'=>'/courses.php','Free Courses'=>'/free-courses.php','Test Series'=>'/tests.php',
              'Free Weekly Test'=>'/weekly-test.php','Live Classes'=>'/live-classes.php','Job Alerts'=>'/jobs.php',
              'Current Affairs'=>'/current-affairs.php','Quiz'=>'/quiz.php','PDF Notes'=>'/pdf-notes.php','Blog'=>'/blog.php','Contact'=>'/contact.php'
            ];
            foreach ($menu as $label => $url): ?>
                <a class="hover:text-brand" href="<?= $url ?>"><?= e($label) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="flex items-center gap-3">
            <?php if (auth_user()): ?>
                <a class="text-sm" href="/dashboard.php">Dashboard</a>
                <a class="bg-brand text-white px-3 py-2 rounded-lg text-sm" href="/logout.php">Logout</a>
            <?php else: ?>
                <a class="text-sm" href="/login.php">Login</a>
                <a class="bg-brand text-white px-3 py-2 rounded-lg text-sm" href="/register.php">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main>
