<?php
require_once __DIR__ . '/app/helpers/helpers.php';
$title='Test Series';
$pdo = require __DIR__ . '/app/config/database.php';
$tests = $pdo->query('SELECT id, title, duration_minutes, total_marks, negative_marking FROM tests ORDER BY id DESC')->fetchAll();
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-6xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold mb-6">MCQ Test Series</h1>
  <div class="space-y-4">
    <?php foreach ($tests as $test): ?>
      <article class="bg-white rounded-xl p-5 shadow-sm flex justify-between items-center">
        <div>
          <h2 class="font-semibold"><?= e($test['title']) ?></h2>
          <p class="text-sm text-gray-600">Duration: <?= (int)$test['duration_minutes'] ?> min • Marks: <?= (int)$test['total_marks'] ?> • Negative: <?= e((string)$test['negative_marking']) ?></p>
        </div>
        <a href="/test-attempt.php?test_id=<?= (int)$test['id'] ?>" class="bg-brand text-white px-4 py-2 rounded-lg text-sm">Start Test</a>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
