const countdownNode = document.getElementById('countdown');
if (countdownNode) {
  const end = new Date();
  end.setDate(end.getDate() + 5);
  const tick = () => {
    const diff = end.getTime() - Date.now();
    if (diff <= 0) {
      countdownNode.textContent = 'Test is live now!';
      return;
    }
    const d = Math.floor(diff / (1000 * 60 * 60 * 24));
    const h = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const m = Math.floor((diff / (1000 * 60)) % 60);
    countdownNode.textContent = `${d}d ${h}h ${m}m left`;
  };
  tick();
  setInterval(tick, 30000);
}

const jobList = document.getElementById('job-alert-list');
if (jobList) {
  fetch('/app/ajax/jobs.php')
    .then((res) => res.json())
    .then((jobs) => {
      if (!jobs.length) {
        jobList.innerHTML = '<p class="text-sm text-gray-500">No jobs found.</p>';
        return;
      }
      jobList.innerHTML = jobs
        .map(
          (job) => `<div class="border rounded-lg p-3 flex items-center justify-between">
            <div><h3 class="font-semibold">${job.title}</h3><p class="text-xs text-gray-500">${job.state} • ${job.qualification}</p></div>
            <a href="${job.official_link}" target="_blank" class="text-brand text-sm">Apply</a>
          </div>`
        )
        .join('');
    });
}
