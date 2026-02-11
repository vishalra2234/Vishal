<?php
require_once __DIR__ . '/app/helpers/helpers.php';
require __DIR__ . '/app/middleware/auth.php';
$title='User Dashboard';
require __DIR__ . '/app/views/partials/header.php';
$cards = ['My Courses','My Test Results','My Certificates','Saved Jobs','Order History','Referral Earnings','Profile Settings'];
?>
<section class="max-w-7xl mx-auto px-4 py-10">
<h1 class="text-3xl font-bold mb-6">Welcome, <?= e(auth_user()['name']) ?></h1>
<div class="grid md:grid-cols-3 gap-4">
<?php foreach ($cards as $card): ?>
  <a href="#" class="bg-white p-5 rounded-xl shadow-sm hover:shadow transition"><h2 class="font-semibold"><?= e($card) ?></h2></a>
<?php endforeach; ?>
</div>
</section>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
