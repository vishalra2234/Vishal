<?php
require_once __DIR__ . '/app/helpers/helpers.php';
require __DIR__ . '/app/middleware/auth.php';
$title='User Dashboard';
$pdo = require __DIR__ . '/app/config/database.php';
$userId = (int)auth_user()['id'];

$myCoursesStmt = $pdo->prepare('SELECT c.title, uc.progress_percent FROM user_courses uc JOIN courses c ON c.id = uc.course_id WHERE uc.user_id = ? ORDER BY uc.id DESC LIMIT 5');
$myCoursesStmt->execute([$userId]);
$myCourses = $myCoursesStmt->fetchAll();

$resultStmt = $pdo->prepare('SELECT t.title, r.score, r.attempted_at FROM results r JOIN tests t ON t.id = r.test_id WHERE r.user_id = ? ORDER BY r.id DESC LIMIT 5');
$resultStmt->execute([$userId]);
$results = $resultStmt->fetchAll();

$savedJobStmt = $pdo->prepare('SELECT j.title, j.last_date FROM saved_jobs sj JOIN jobs j ON j.id = sj.job_id WHERE sj.user_id = ? ORDER BY sj.id DESC LIMIT 5');
$savedJobStmt->execute([$userId]);
$savedJobs = $savedJobStmt->fetchAll();

$orderStmt = $pdo->prepare('SELECT o.id, c.title, o.amount, o.created_at FROM orders o JOIN courses c ON c.id = o.course_id WHERE o.user_id = ? ORDER BY o.id DESC LIMIT 5');
$orderStmt->execute([$userId]);
$orders = $orderStmt->fetchAll();

require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-7xl mx-auto px-4 py-10">
<h1 class="text-3xl font-bold mb-6">Welcome, <?= e(auth_user()['name']) ?></h1>

<div class="grid md:grid-cols-2 gap-6">
  <div class="bg-white p-5 rounded-xl shadow-sm">
    <h2 class="font-semibold mb-3">My Courses</h2>
    <?php if (!$myCourses): ?><p class="text-sm text-gray-500">No enrolled courses yet.</p><?php endif; ?>
    <?php foreach ($myCourses as $course): ?><p class="text-sm mb-2"><?= e($course['title']) ?> <span class="text-gray-500">(<?= e((string)$course['progress_percent']) ?>%)</span></p><?php endforeach; ?>
  </div>

  <div class="bg-white p-5 rounded-xl shadow-sm">
    <h2 class="font-semibold mb-3">My Test Results</h2>
    <?php if (!$results): ?><p class="text-sm text-gray-500">No attempts yet.</p><?php endif; ?>
    <?php foreach ($results as $result): ?><p class="text-sm mb-2"><?= e($result['title']) ?> - Score <?= e((string)$result['score']) ?></p><?php endforeach; ?>
  </div>

  <div class="bg-white p-5 rounded-xl shadow-sm">
    <h2 class="font-semibold mb-3">Saved Jobs</h2>
    <?php if (!$savedJobs): ?><p class="text-sm text-gray-500">No saved jobs yet.</p><?php endif; ?>
    <?php foreach ($savedJobs as $job): ?><p class="text-sm mb-2"><?= e($job['title']) ?> <span class="text-gray-500">(<?= e((string)$job['last_date']) ?>)</span></p><?php endforeach; ?>
  </div>

  <div class="bg-white p-5 rounded-xl shadow-sm">
    <h2 class="font-semibold mb-3">Order History</h2>
    <?php if (!$orders): ?><p class="text-sm text-gray-500">No paid orders yet.</p><?php endif; ?>
    <?php foreach ($orders as $order): ?><p class="text-sm mb-2">#<?= (int)$order['id'] ?> <?= e($order['title']) ?> - ₹<?= e((string)$order['amount']) ?></p><?php endforeach; ?>
  </div>
</div>
</section>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
