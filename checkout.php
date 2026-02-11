<?php
require_once __DIR__ . '/app/helpers/helpers.php';
require __DIR__ . '/app/middleware/auth.php';
$title='Checkout';
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-2xl mx-auto px-4 py-10">
  <h1 class="text-3xl font-bold mb-4">Secure Checkout</h1>
  <div class="bg-white rounded-xl p-6 shadow-sm space-y-4">
    <input id="courseId" class="w-full border p-2 rounded" value="1" placeholder="Course ID" />
    <input id="coupon" class="w-full border p-2 rounded" placeholder="Coupon code" />
    <button id="payNow" class="bg-brand text-white px-5 py-2 rounded-lg"><i class="fa fa-lock mr-2"></i>Pay with Razorpay / UPI / Card</button>
    <pre id="checkoutResult" class="bg-gray-100 p-3 rounded text-xs"></pre>
  </div>
</section>
<script>
document.getElementById('payNow').addEventListener('click', async () => {
  const fd = new FormData();
  fd.append('course_id', document.getElementById('courseId').value);
  fd.append('coupon', document.getElementById('coupon').value);
  const res = await fetch('/app/ajax/payment_checkout.php', { method: 'POST', body: fd });
  const data = await res.json();
  document.getElementById('checkoutResult').textContent = JSON.stringify(data, null, 2);
});
</script>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
