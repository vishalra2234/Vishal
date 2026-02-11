<?php require_once __DIR__ . '/app/helpers/helpers.php'; $title='Forgot Password'; require __DIR__ . '/app/views/partials/header.php'; ?>
<section class="max-w-xl mx-auto p-6 mt-8 bg-white rounded-xl shadow-sm">
<h1 class="text-2xl font-bold mb-4">Forgot Password</h1>
<?php if (!empty($_SESSION['success'])): ?><p class="text-green-600 text-sm mb-2"><?= e($_SESSION['success']); unset($_SESSION['success']); ?></p><?php endif; ?>
<?php if (!empty($_SESSION['reset_link_demo'])): ?><p class="text-xs bg-blue-50 p-2 rounded mb-3">Demo reset link: <a class="text-brand" href="<?= e($_SESSION['reset_link_demo']) ?>">Open reset link</a></p><?php unset($_SESSION['reset_link_demo']); endif; ?>
<form method="post" action="/app/controllers/AuthController.php" class="space-y-3">
<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="forgot">
<input required type="email" name="email" placeholder="Registered Email" class="w-full border p-2 rounded-lg">
<button class="w-full bg-brand text-white py-2 rounded-lg">Send Reset Link</button>
</form></section><?php require __DIR__ . '/app/views/partials/footer.php'; ?>
