<?php
require_once __DIR__ . '/app/helpers/helpers.php';
$title='Job Alerts';
$pdo = require __DIR__ . '/app/config/database.php';
$states = $pdo->query('SELECT DISTINCT state FROM jobs ORDER BY state')->fetchAll();
$quals = $pdo->query('SELECT DISTINCT qualification FROM jobs ORDER BY qualification')->fetchAll();
require __DIR__ . '/app/views/partials/header.php';
?>
<section class="max-w-7xl mx-auto px-4 py-12">
  <h1 class="text-3xl font-bold mb-2">Latest Government Job Alerts</h1>
  <p class="text-gray-600 mb-6">Filter by state and qualification, save jobs and share instantly.</p>

  <div class="bg-white p-4 rounded-xl shadow-sm grid md:grid-cols-4 gap-3 mb-6">
    <select id="stateFilter" class="border p-2 rounded-lg"><option value="">All States</option><?php foreach ($states as $s): ?><option value="<?= e($s['state']) ?>"><?= e($s['state']) ?></option><?php endforeach; ?></select>
    <select id="qualificationFilter" class="border p-2 rounded-lg"><option value="">All Qualifications</option><?php foreach ($quals as $q): ?><option value="<?= e($q['qualification']) ?>"><?= e($q['qualification']) ?></option><?php endforeach; ?></select>
    <button id="filterJobs" class="bg-brand text-white rounded-lg">Apply Filters</button>
    <button id="resetJobs" class="border rounded-lg">Reset</button>
  </div>

  <div id="jobsContainer" class="space-y-3"></div>
</section>
<script>
async function loadJobs() {
  const state = document.getElementById('stateFilter').value;
  const qualification = document.getElementById('qualificationFilter').value;
  const qs = new URLSearchParams({state, qualification});
  const res = await fetch('/app/ajax/jobs.php?' + qs.toString());
  const data = await res.json();
  const html = data.map(job => `<article class="bg-white rounded-xl p-4 shadow-sm flex justify-between gap-4">
    <div>
      <h2 class="font-semibold">${job.title}</h2>
      <p class="text-xs text-gray-500">${job.state} • ${job.qualification} • Last Date: ${job.last_date}</p>
      <div class="mt-2 flex gap-3 text-sm">
        <a class="text-brand" target="_blank" href="${job.official_link}">Official Link</a>
        <button data-id="${job.id}" class="save-job text-green-600">Save Job</button>
        <button class="share-job text-purple-600" data-link="${job.official_link}">Share</button>
      </div>
    </div>
  </article>`).join('') || '<p class="text-gray-500">No jobs found.</p>';
  document.getElementById('jobsContainer').innerHTML = html;
}

document.getElementById('filterJobs').addEventListener('click', loadJobs);
document.getElementById('resetJobs').addEventListener('click', () => { document.getElementById('stateFilter').value=''; document.getElementById('qualificationFilter').value=''; loadJobs(); });
document.addEventListener('click', async (e) => {
  if (e.target.classList.contains('save-job')) {
    const fd = new FormData();
    fd.append('job_id', e.target.dataset.id);
    fd.append('csrf_token', '<?= csrf_token() ?>');
    const res = await fetch('/app/ajax/save_job.php', {method:'POST', body: fd});
    const data = await res.json();
    alert(data.message || 'Saved');
  }
  if (e.target.classList.contains('share-job')) {
    const link = e.target.dataset.link;
    if (navigator.share) {
      navigator.share({title:'Job Alert', url: link});
    } else {
      await navigator.clipboard.writeText(link);
      alert('Link copied');
    }
  }
});
loadJobs();
</script>
<?php require __DIR__ . '/app/views/partials/footer.php'; ?>
