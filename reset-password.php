<?php require_once __DIR__ . '/app/helpers/helpers.php'; $title='Reset Password'; require __DIR__ . '/app/views/partials/header.php'; $token = (string)($_GET['token'] ?? ''); ?>
<section class="max-w-xl mx-auto p-6 mt-8 bg-white rounded-xl shadow-sm">
<h1 class="text-2xl font-bold mb-4">Reset Password</h1>
<?php if (!empty($_SESSION['error'])): ?><p class="text-red-600 text-sm mb-2"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></p><?php endif; ?>
<form method="post" action="/app/controllers/AuthController.php" class="space-y-3">
<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="reset_password"><input type="hidden" name="token" value="<?= e($token) ?>">
<input required type="password" minlength="8" name="password" placeholder="New Password" class="w-full border p-2 rounded-lg">
<button class="w-full bg-brand text-white py-2 rounded-lg">Update Password</button>
</form></section><?php require __DIR__ . '/app/views/partials/footer.php'; ?>
