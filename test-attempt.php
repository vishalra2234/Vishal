<?php
require_once __DIR__ . '/app/helpers/helpers.php';
require __DIR__ . '/app/middleware/auth.php';
$title='Attempt Test';
$pdo = require __DIR__ . '/app/config/database.php';
$testId = (int)($_GET['test_id'] ?? 0);
$qStmt = $pdo->prepare('SELECT id, question_text, option_a, option_b, option_c, option_d, correct_option, marks FROM questions WHERE test_id = ? ORDER BY id ASC LIMIT 20');
$qStmt->execute([$testId]);
$questions = $qStmt->fetchAll();
$testStmt = $pdo->prepare('SELECT title, duration_minutes, negative_marking FROM tests WHERE id = ? LIMIT 1');
$testStmt->execute([$testId]);
$test = $testStmt->fetch();
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-5xl mx-auto px-4 py-10">
  <h1 class="text-2xl font-bold mb-2"><?= e($test['title'] ?? 'Test') ?></h1>
  <p class="text-sm mb-6">Time Left: <span id="timer" class="font-semibold"></span></p>
  <form id="testForm" class="space-y-4">
    <?php foreach ($questions as $index => $q): ?>
      <div class="bg-white p-4 rounded-xl shadow-sm" data-correct="<?= e($q['correct_option']) ?>" data-marks="<?= e((string)$q['marks']) ?>">
        <p class="font-medium mb-2"><?= ($index + 1) ?>. <?= e($q['question_text']) ?></p>
        <?php foreach (['a','b','c','d'] as $opt): ?>
          <label class="block text-sm"><input type="radio" name="q<?= (int)$q['id'] ?>" value="<?= strtoupper($opt) ?>"> <?= e($q['option_'.$opt]) ?></label>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
    <button type="submit" class="bg-brand text-white px-5 py-2 rounded-lg">Submit Test</button>
  </form>
</section>
<script>
const duration = <?= (int)($test['duration_minutes'] ?? 0) ?> * 60;
let left = duration;
const timerNode = document.getElementById('timer');
const interval = setInterval(() => {
  left--; if (left <= 0) { clearInterval(interval); document.getElementById('testForm').requestSubmit(); }
  const m = Math.floor(left / 60), s = left % 60;
  timerNode.textContent = `${m}:${String(s).padStart(2,'0')}`;
}, 1000);

document.getElementById('testForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const blocks = [...document.querySelectorAll('[data-correct]')];
  let score = 0;
  const negative = <?= (float)($test['negative_marking'] ?? 0.25) ?>;
  blocks.forEach((block) => {
    const selected = block.querySelector('input[type=radio]:checked');
    const marks = Number(block.dataset.marks || 1);
    if (!selected) return;
    if (selected.value === block.dataset.correct) score += marks;
    else score -= negative;
  });

  const fd = new FormData();
  fd.append('csrf_token', '<?= csrf_token() ?>');
  fd.append('test_id', '<?= (int)$testId ?>');
  fd.append('score', Math.max(score, 0));
  const res = await fetch('/app/ajax/test_submit.php', {method: 'POST', body: fd});
  const data = await res.json();
  alert(`Submitted. Score: ${data.score}`);
  window.location.href = '/dashboard.php';
});
</script>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
