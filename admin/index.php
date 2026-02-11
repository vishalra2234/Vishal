<?php
require_once __DIR__ . '/../app/helpers/helpers.php';
require __DIR__ . '/../app/middleware/admin.php';
$title='Admin Dashboard';
require __DIR__ . '/../app/views/partials/header.php';
$pdo = require __DIR__ . '/../app/config/database.php';
$stats = [
  'Total Users' => (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn(),
  'Total Revenue' => (float)$pdo->query("SELECT COALESCE(SUM(amount),0) FROM payments WHERE status='paid'")->fetchColumn(),
  'Course Sales' => (int)$pdo->query('SELECT COUNT(*) FROM orders')->fetchColumn(),
  'Test Attempts' => (int)$pdo->query('SELECT COUNT(*) FROM results')->fetchColumn(),
];
?>
<section class="max-w-7xl mx-auto px-4 py-10">
<h1 class="text-3xl font-bold mb-6">Admin Analytics</h1>
<div class="grid md:grid-cols-4 gap-4 mb-8">
<?php foreach ($stats as $label => $value): ?>
  <div class="bg-white rounded-xl p-5 shadow-sm"><p class="text-sm text-gray-500"><?= e($label) ?></p><p class="text-2xl font-bold"><?= e((string)$value) ?></p></div>
<?php endforeach; ?>
</div>
<div class="bg-white p-6 rounded-xl shadow-sm">
  <h2 class="font-semibold mb-4">Management Modules</h2>
  <div class="grid md:grid-cols-3 gap-3 text-sm">
    <?php foreach (['Users','Courses','Lessons','Tests','Questions','Jobs','Blogs','Payments','Coupons','Notifications','Website Settings'] as $item): ?>
      <a href="/admin/manage.php?module=<?= urlencode(strtolower(str_replace(' ','_',$item))) ?>" class="border rounded-lg p-3 hover:border-brand"><?= e($item) ?></a>
    <?php endforeach; ?>
  </div>
</div>
</section>
<?php require __DIR__ . '/../app/views/partials/footer.php'; ?>
