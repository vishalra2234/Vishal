<?php require_once __DIR__ . '/app/helpers/helpers.php'; $title='Login'; require __DIR__ . '/app/views/partials/header.php'; ?>
<section class="max-w-xl mx-auto p-6 mt-8 bg-white rounded-xl shadow-sm">
<h1 class="text-2xl font-bold mb-4">Login</h1>
<?php if (!empty($_SESSION['error'])): ?><p class="text-red-500 text-sm"><?= e($_SESSION['error']); unset($_SESSION['error']); ?></p><?php endif; ?>
<form method="post" action="/app/controllers/AuthController.php" class="space-y-3">
<input type="hidden" name="csrf_token" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="login">
<input required type="email" name="email" placeholder="Email" class="w-full border p-2 rounded-lg">
<input required type="password" name="password" placeholder="Password" class="w-full border p-2 rounded-lg">
<button class="w-full bg-brand text-white py-2 rounded-lg">Login</button>
</form>
<a href="/forgot-password.php" class="text-sm text-brand mt-3 inline-block">Forgot Password?</a>
</section><?php require __DIR__ . '/app/views/partials/footer.php'; ?>
