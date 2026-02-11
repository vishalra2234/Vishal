<?php
require_once __DIR__ . '/../app/helpers/helpers.php';
require __DIR__ . '/../app/middleware/admin.php';
$title='Manage Module';
require __DIR__ . '/../app/views/partials/header.php';
$module = $_GET['module'] ?? 'users';
?>
<section class="max-w-7xl mx-auto px-4 py-10">
  <h1 class="text-3xl font-bold capitalize mb-2">Manage <?= e(str_replace('_', ' ', $module)) ?></h1>
  <p class="text-gray-600 mb-4">CRUD operations are powered via protected AJAX endpoints in <code>app/ajax</code>.</p>
  <div class="bg-white rounded-xl p-6 shadow-sm">
    <button id="loadData" class="bg-brand text-white px-4 py-2 rounded-lg">Load <?= e($module) ?></button>
    <pre id="moduleData" class="mt-4 bg-gray-100 p-4 rounded text-xs overflow-auto"></pre>
  </div>
</section>
<script>
document.getElementById('loadData').addEventListener('click', async () => {
  const res = await fetch('/app/ajax/admin_module.php?module=<?= e($module) ?>');
  const data = await res.json();
  document.getElementById('moduleData').textContent = JSON.stringify(data, null, 2);
});
</script>
<?php require __DIR__ . '/../app/views/partials/footer.php'; ?>
