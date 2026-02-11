<?php
require_once __DIR__ . '/app/helpers/helpers.php';
$title = 'Paid Courses';
$pdo = require __DIR__ . '/app/config/database.php';
$courses = $pdo->query('SELECT id, title, description, price, discount_price, thumbnail FROM courses WHERE is_free = 0 ORDER BY id DESC')->fetchAll();
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-7xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold mb-2">Paid Courses</h1>
  <p class="text-gray-600 mb-6">Premium exam batches with recorded lessons, live support and downloadable notes.</p>
  <div class="grid md:grid-cols-3 gap-6">
    <?php foreach ($courses as $course): ?>
      <article class="bg-white rounded-xl shadow-sm overflow-hidden">
        <img loading="lazy" src="<?= e($course['thumbnail'] ?: '/assets/images/course-placeholder.svg') ?>" alt="<?= e($course['title']) ?>" class="h-40 w-full object-cover" />
        <div class="p-5">
          <h2 class="font-semibold mb-2"><?= e($course['title']) ?></h2>
          <p class="text-sm text-gray-600 mb-3"><?= e(substr((string)$course['description'], 0, 120)) ?></p>
          <p class="font-bold text-brand mb-4">₹<?= e((string)$course['discount_price']) ?> <span class="text-gray-400 line-through text-sm">₹<?= e((string)$course['price']) ?></span></p>
          <a href="/checkout.php?course_id=<?= (int)$course['id'] ?>" class="bg-brand text-white px-4 py-2 rounded-lg text-sm">Buy Now</a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
