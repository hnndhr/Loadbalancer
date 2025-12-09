<?php
$conn = new mysqli("localhost", "root", "", "lb_logs");
$result = $conn->query("SELECT * FROM request_logs ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log Sistem</title>

  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f6f1;
    }

    .title-gradient {
      background: linear-gradient(to right, #4b2e05, #a07644);
      -webkit-background-clip: text;
      color: transparent;
    }

    .glass {
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(150, 120, 80, 0.2);
    }
  </style>
</head>

<body class="min-h-screen px-6 py-10 text-[#3b2d1f]">

  <?php include "navbar.php"; ?>

  <div class="max-w-6xl mx-auto mt-20">

    <!-- TITLE -->
    <div class="text-center mb-10">
      <h1 class="text-4xl font-extrabold title-gradient tracking-wide">
        Log Sistem Load Balancer
      </h1>
      <p class="text-[#7b5a3a] mt-2">Riwayat permintaan yang diproses server</p>
    </div>

    <!-- TABLE WRAPPER -->
    <div class="glass shadow-xl rounded-2xl overflow-hidden p-6">

      <div class="overflow-x-auto rounded-xl">
        <table class="min-w-full text-sm text-left">

          <!-- HEADER -->
          <thead class="bg-[#7b5a3a] text-white">
            <tr>
              <th class="px-4 py-3">ID</th>
              <th class="px-4 py-3">IP</th>
              <th class="px-4 py-3">Kasir</th>
              <th class="px-4 py-3">Jenis Query</th>
              <th class="px-4 py-3">Nama</th>
              <th class="px-4 py-3">Jumlah</th>
              <th class="px-4 py-3">Metode</th>
              <th class="px-4 py-3">Status</th>
              <th class="px-4 py-3">Waktu</th>
            </tr>
          </thead>

          <!-- BODY -->
          <tbody class="bg-white">
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr class="border-b border-[#e6dccd] hover:bg-[#f2e9df] transition">

                <td class="px-4 py-3"><?= $row['id'] ?></td>
                <td class="px-4 py-3"><?= $row['client_ip'] ?></td>
                <td class="px-4 py-3"><?= $row['kasir_tujuan'] ?></td>
                <td class="px-4 py-3"><?= $row['query_type'] ?></td>
                <td class="px-4 py-3"><?= $row['nama'] ?></td>
                <td class="px-4 py-3"><?= $row['jumlah_barang'] ?></td>
                <td class="px-4 py-3"><?= $row['metode'] ?></td>

                <!-- Status badge -->
                <td class="px-4 py-3">
                  <?php if ($row['status_code'] == 200): ?>
                    <span class="bg-green-200 text-green-800 px-3 py-1 rounded-lg text-xs font-semibold">
                      200 OK
                    </span>
                  <?php elseif ($row['status_code'] == 503): ?>
                    <span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded-lg text-xs font-semibold">
                      503 Unavailable
                    </span>
                  <?php else: ?>
                    <span class="bg-red-200 text-red-800 px-3 py-1 rounded-lg text-xs font-semibold">
                      <?= $row['status_code'] ?> Error
                    </span>
                  <?php endif; ?>
                </td>

                <td class="px-4 py-3"><?= $row['timestamp'] ?></td>

              </tr>
            <?php endwhile; ?>
          </tbody>

        </table>
      </div>
    </div>

  </div>

  <?php $conn->close(); ?>

</body>

</html>