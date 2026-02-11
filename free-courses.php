<?php
require_once __DIR__ . '/app/helpers/helpers.php';
$title = 'Free Courses';
$pdo = require __DIR__ . '/app/config/database.php';
$courses = $pdo->query('SELECT title, description FROM courses WHERE is_free = 1 ORDER BY id DESC')->fetchAll();
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-5xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold mb-6">Free Courses</h1>
  <div class="space-y-4">
    <?php foreach ($courses as $course): ?>
      <div class="bg-white rounded-xl shadow-sm p-5">
        <h2 class="font-semibold"><?= e($course['title']) ?></h2>
        <p class="text-sm text-gray-600 mt-1"><?= e((string)$course['description']) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
