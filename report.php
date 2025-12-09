<?php
session_start();
$data = $_SESSION['report_data'] ?? null;
if (!$data) {
  die("Tidak ada data laporan untuk ditampilkan.");
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Laporan Pengiriman Data</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    body {
      background-color: #f8f6f3;
      font-family: 'Inter', sans-serif;
      color: #4b2e05;
    }

    .glass {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(12px);
      border: 1px solid rgba(210, 180, 140, 0.3);
    }

    .icon {
      width: 22px;
      height: 22px;
      color: #a07644;
      margin-right: 10px;
    }
  </style>
</head>

<body class="flex justify-center items-center min-h-screen">

  <div class="glass p-8 rounded-2xl shadow-2xl w-full max-w-lg">
    <h1 class="text-3xl font-bold text-center mb-6 text-[#4b2e05] tracking-wide">Laporan Pengiriman Data</h1>

    <div class="space-y-4">
      <div class="flex items-center">
        <i data-lucide="check-circle" class="icon"></i>
        <span class="font-medium"><?= htmlspecialchars($data['status']); ?></span>
      </div>

      <div class="flex items-center">
        <i data-lucide="user-check" class="icon"></i>
        <span>Kasir Tujuan:
          <span class="font-semibold capitalize"><?= htmlspecialchars($data['metode']); ?></span>
        </span>
      </div>

      <div class="flex items-center">
        <i data-lucide="timer" class="icon"></i>
        <span>Waktu Proses: <span class="font-semibold"><?= $data['execution_time']; ?> ms</span></span>
      </div>

      <div class="flex items-center">
        <i data-lucide="database" class="icon"></i>
        <span>Ukuran Data: <span class="font-semibold"><?= $data['data_size']; ?> bytes</span></span>
      </div>

      <div class="flex items-center">
        <i data-lucide="shopping-bag" class="icon"></i>
        <span>Jumlah Barang: <span class="font-semibold"><?= $data['jumlah_barang']; ?></span></span>
      </div>

      <div class="flex items-center">
        <i data-lucide="clock" class="icon"></i>
        <span>Arrival Time: <span class="font-semibold"><?= $data['arrival_time']; ?></span></span>
      </div>

      <div class="flex items-center">
        <i data-lucide="play-circle" class="icon"></i>
        <span>Start Time: <span class="font-semibold"><?= $data['start_time']; ?></span></span>
      </div>

      <div class="flex items-center">
        <i data-lucide="stop-circle" class="icon"></i>
        <span>End Time: <span class="font-semibold"><?= $data['end_time']; ?></span></span>
      </div>

      <div class="flex items-center">
        <i data-lucide="hourglass" class="icon"></i>
        <span>Waiting Time: <span class="font-semibold"><?= $data['waiting_time']; ?> detik</span></span>
      </div>
    </div>

    <div class="text-center mt-8">
      <a href="index.php"
        class="inline-flex items-center gap-2 bg-[#7b5a3a] text-white px-5 py-3 rounded-xl shadow-md hover:bg-[#5a4025] transition duration-200">
        <i data-lucide="arrow-left" class="w-5 h-5"></i>
        <span>Kembali ke Beranda</span>
      </a>
    </div>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>

</html>