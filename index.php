<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Sistem</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f6f1;
      color: #3b2d1f;
    }

    .glass {
      background: rgba(255, 255, 255, 0.65);
      backdrop-filter: blur(10px);
    }

    .title-gradient {
      background: linear-gradient(to right, #4b2e05, #a07644);
      -webkit-background-clip: text;
      color: transparent;
    }
  </style>
</head>

<body class="min-h-screen bg-[#f8f6f1] text-[#3b2d1f] font-inter">

  <?php include "navbar.php"; ?>

  <div class="w-full max-w-6xl mx-auto px-6 py-12">

    <!-- Header -->
    <div class="text-center mb-12">
      <h1 class="text-4xl font-extrabold title-gradient tracking-wide">
        Dashboard Sistem
      </h1>
      <p class="text-[#7b5a3a] mt-2">
        Pilih menu untuk melanjutkan
      </p>
    </div>

    <!-- Grid Menu -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-14">

      <!-- Menu: Input -->
      <a href="input.php"
        class="glass group rounded-2xl p-8 shadow-md border border-[#e7e0d3] bg-white/60 backdrop-blur-md
               transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">

        <div class="text-center">
          <div class="text-2xl font-semibold text-[#4b2e05] 
                      group-hover:text-[#a07644] transition">
            Input Pelanggan
          </div>
          <p class="text-[#7b5a3a] mt-2 text-sm">
            Tambah transaksi pelanggan baru
          </p>
        </div>
      </a>

      <!-- Menu: Statistik -->
      <a href="statistik.php"
        class="glass group rounded-2xl p-8 shadow-md border border-[#e7e0d3] bg-white/60 backdrop-blur-md
               transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">

        <div class="text-center">
          <div class="text-2xl font-semibold text-[#4b2e05] 
                      group-hover:text-[#a07644] transition">
            Statistik Kasir
          </div>
          <p class="text-[#7b5a3a] mt-2 text-sm">
            Lihat status & analisis kasir
          </p>
        </div>
      </a>

      <!-- Menu: Log -->
      <a href="log.php"
        class="glass group rounded-2xl p-8 shadow-md border border-[#e7e0d3] bg-white/60 backdrop-blur-md
               transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">

        <div class="text-center">
          <div class="text-2xl font-semibold text-[#4b2e05] 
                      group-hover:text-[#a07644] transition">
            Log Sistem
          </div>
          <p class="text-[#7b5a3a] mt-2 text-sm">
            Riwayat request load balancer
          </p>
        </div>
      </a>

    </div>

    <!-- Status Kasir Section -->
    <h2 class="text-3xl font-bold title-gradient mb-6 text-center">Status Kasir</h2>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

      <div class="glass card rounded-2xl p-6 flex flex-col items-center">
        <h3 class="text-xl font-semibold text-[#4b2e05] mb-2">Kasir 1</h3>
        <p class="text-sm text-[#7b5a3a]">Tunai</p>
        <span id="kasir1" class="text-5xl font-bold text-[#a07644] mt-3">0</span>
        <p class="text-[#7b5a3a] mt-1">pelanggan</p>
      </div>

      <div class="glass card rounded-2xl p-6 flex flex-col items-center">
        <h3 class="text-xl font-semibold text-[#4b2e05] mb-2">Kasir 2</h3>
        <p class="text-sm text-[#7b5a3a]">Non-Tunai 1</p>
        <span id="kasir2" class="text-5xl font-bold text-[#a07644] mt-3">0</span>
        <p class="text-[#7b5a3a] mt-1">pelanggan</p>
      </div>

      <div class="glass card rounded-2xl p-6 flex flex-col items-center">
        <h3 class="text-xl font-semibold text-[#4b2e05] mb-2">Kasir 3</h3>
        <p class="text-sm text-[#7b5a3a]">Non-Tunai 2</p>
        <span  id="kasir3" class="text-5xl font-bold text-[#a07644] mt-3">0</span>
        <p class="text-[#7b5a3a] mt-1">pelanggan</p>
      </div>

    </div>

  </div>

  <script>
    async function updateKasirStatus() {
      try {
        const res = await fetch('load_status.php');
        const data = await res.json();
        document.getElementById('kasir1').textContent = data.tunai ?? 0;
        document.getElementById('kasir2').textContent = data.non1 ?? 0;
        document.getElementById('kasir3').textContent = data.non2 ?? 0;
      } catch (err) {
        console.error('Gagal update status kasir:', err);
      }
    }
    // Update setiap 10 detik
    setInterval(updateKasirStatus, 10000);
    updateKasirStatus();
  </script>

</body>
</html>
