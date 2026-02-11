<?php
require_once __DIR__ . '/app/helpers/helpers.php';
$title='Blog';
$pdo = require __DIR__ . '/app/config/database.php';
$posts = $pdo->query('SELECT title, slug, excerpt, created_at FROM blogs ORDER BY id DESC LIMIT 20')->fetchAll();
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-6xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold mb-6">Preparation Blog</h1>
  <div class="grid md:grid-cols-2 gap-5">
    <?php foreach ($posts as $post): ?>
      <article class="bg-white rounded-xl shadow-sm p-5">
        <h2 class="font-semibold text-lg mb-2"><?= e($post['title']) ?></h2>
        <p class="text-sm text-gray-600 mb-3"><?= e((string)$post['excerpt']) ?></p>
        <p class="text-xs text-gray-400">Published: <?= e((string)$post['created_at']) ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
