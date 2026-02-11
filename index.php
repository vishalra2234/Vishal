<?php
require_once __DIR__ . '/app/helpers/helpers.php';
$title = 'GovPrep Hub - Home';
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="bg-gradient-to-r from-brand to-blue-700 text-white py-16">
  <div class="max-w-7xl mx-auto px-4 grid lg:grid-cols-2 gap-8 items-center">
    <div>
      <h1 class="text-4xl font-bold mb-4">Crack Govt Exams with Courses, Tests & Daily Job Alerts</h1>
      <p class="mb-6">Join thousands of aspirants preparing for SSC, Banking, Railway, UPSC and State exams.</p>
      <a href="/courses.php" class="bg-white text-brand px-6 py-3 rounded-xl font-semibold">Explore Paid Courses</a>
    </div>
    <div class="bg-white/10 backdrop-blur rounded-2xl p-6">
      <h3 class="font-semibold text-xl mb-3">This Week's Highlights</h3>
      <ul class="space-y-2 text-sm">
        <li><i class="fa fa-check mr-2"></i>12 Live classes</li>
        <li><i class="fa fa-check mr-2"></i>5 Free mock tests</li>
        <li><i class="fa fa-check mr-2"></i>150+ new job alerts</li>
      </ul>
    </div>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-12">
  <h2 class="text-2xl font-bold mb-6">Featured Paid Courses</h2>
  <div class="grid md:grid-cols-3 gap-6">
    <?php foreach ([['SSC CGL Mastery',4999],['Banking Foundation',3999],['Railway NTPC Pro',2999]] as [$name,$price]): ?>
      <article class="bg-white p-5 rounded-xl shadow-sm"><h3 class="font-semibold"><?= e($name) ?></h3><p class="text-brand mt-2">₹<?= e((string)$price) ?></p><a href="/courses.php" class="text-sm mt-4 inline-block">View Course →</a></article>
    <?php endforeach; ?>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-6">Free Courses & Weekly Free Test</h2>
  <div class="grid md:grid-cols-2 gap-6">
    <div class="bg-brandLight p-6 rounded-xl"><h3 class="font-semibold">Free Current Affairs Course</h3><p class="text-sm mt-2">Daily updates + quiz practice.</p></div>
    <div class="bg-brandLight p-6 rounded-xl"><h3 class="font-semibold">Sunday Mega Test</h3><p id="countdown" class="text-sm mt-2">Starts in loading...</p></div>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-8 grid lg:grid-cols-3 gap-6">
  <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm">
    <h2 class="text-xl font-bold mb-4">Latest Job Alerts</h2>
    <div id="job-alert-list" class="space-y-3"></div>
  </div>
  <div class="bg-white p-6 rounded-xl shadow-sm">
    <h2 class="text-xl font-bold mb-4">Latest Blogs</h2>
    <ul class="space-y-3 text-sm">
      <li><a href="/blog.php">How to Prepare for SSC in 90 Days</a></li>
      <li><a href="/blog.php">Best Books for Banking Exam 2026</a></li>
      <li><a href="/blog.php">UPSC Prelims Strategy</a></li>
    </ul>
  </div>
</section>

<section class="max-w-7xl mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-6">Testimonials</h2>
  <div class="grid md:grid-cols-3 gap-4">
    <?php foreach (['I cleared SSC with this platform','Best test series quality','Job alerts are very fast'] as $t): ?>
      <blockquote class="bg-white p-4 rounded-xl shadow-sm text-sm">"<?= e($t) ?>"</blockquote>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
