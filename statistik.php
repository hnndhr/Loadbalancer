<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Statistik Kasir</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f6f1;
      color: #3b2d1f;
    }

    .glass {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(10px);
    }

    .title-gradient {
      background: linear-gradient(to right, #4b2e05, #a07644);
      -webkit-background-clip: text;
      color: transparent;
    }
  </style>
</head>

<body class="min-h-screen px-6 py-6">

  <?php include 'navbar.php'; ?>

  <div class="text-center mt-10">
    <h2 class="text-4xl font-bold title-gradient">Statistik Proses Kasir</h2>
    <p class="text-[#7b5a3a] mt-2 text-lg">Monitoring performa dan beban kerja kasir</p>
  </div>

  <div class="mt-10 overflow-x-auto max-w-4xl mx-auto glass p-6 rounded-2xl shadow-xl">
    <table class="min-w-full border-collapse rounded-xl overflow-hidden shadow">
      <thead class="bg-[#7b5a3a] text-white">
        <tr>
          <th class="py-3 px-4 text-left">Kasir</th>
          <th class="py-3 px-4 text-left">Total Proses (detik)</th>
          <th class="py-3 px-4 text-left">Rata-rata Proses (detik)</th>
          <th class="py-3 px-4 text-left">Jumlah Transaksi</th>
        </tr>
      </thead>

      <tbody id="analytics-body" class="bg-white divide-y divide-gray-200"></tbody>
    </table>
  </div>

  <script>
    function loadAnalytics() {
      fetch('analyze.php')
        .then(res => res.json())
        .then(data => {
          const tbody = document.getElementById('analytics-body');
          tbody.innerHTML = '';

          for (const [kasir, stat] of Object.entries(data)) {
            const row = document.createElement('tr');
            row.classList.add("hover:bg-[#f3e9dd]");

            row.innerHTML = `
              <td class="py-3 px-4">${kasir}</td>
              <td class="py-3 px-4">${stat.total ?? '-'}</td>
              <td class="py-3 px-4">${stat.avg ?? '-'}</td>
              <td class="py-3 px-4">${stat.count ?? '-'}</td>
            `;
            tbody.appendChild(row);
          }
        });
    }

    loadAnalytics();
    setInterval(loadAnalytics, 10000);
  </script>

</body>
</html>
