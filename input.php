<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Input Data Kasir</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f6f1;
      color: #3b2d1f;
    }
    .glass {
      background: rgba(255, 255, 255, 0.75);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(175, 148, 110, 0.25);
    }
    .title-gradient {
      background: linear-gradient(to right,#4b2e05,#a07644);
      -webkit-background-clip: text;
      color: transparent;
    }
  </style>
</head>

<body class="min-h-screen px-6 py-6">

  <?php include 'navbar.php'; ?>

  <div class="w-full max-w-xl mx-auto glass p-8 rounded-2xl mt-10 shadow-lg">

    <h2 class="text-3xl font-extrabold title-gradient mb-6 pb-2 tracking-wide">
      Input Data Pelanggan
    </h2>

    <form id="customerForm" method="POST" action="process.php" class="space-y-6">

      <!-- Input Nama -->
      <div>
        <label class="block mb-2 text-[#5b3a1f] font-medium">Nama Pelanggan</label>
        <input type="text" name="nama" required
          class="w-full rounded-lg border border-[#d8c5a8] p-3 bg-white 
                 focus:outline-none focus:ring-2 focus:ring-[#a07644]">
      </div>

      <!-- Input Jumlah Barang -->
      <div>
        <label class="block mb-2 text-[#5b3a1f] font-medium">Jumlah Barang</label>
        <input type="number" name="jumlah_barang" required
          class="w-full rounded-lg border border-[#d8c5a8] p-3 bg-white 
                 focus:outline-none focus:ring-2 focus:ring-[#a07644]">
      </div>

      <!-- Select Metode Pembayaran -->
      <div>
        <label class="block mb-2 text-[#5b3a1f] font-medium">Metode Pembayaran</label>
        <select name="metode_pembayaran" required
          class="w-full rounded-lg border border-[#d8c5a8] p-3 bg-white 
                 focus:outline-none focus:ring-2 focus:ring-[#a07644]">
          <option value="">Pilih metode</option>
          <option value="tunai">Tunai</option>
          <option value="non-tunai">Non-Tunai</option>
        </select>
      </div>

      <!-- Submit Button -->
      <button type="submit"
        class="w-full bg-[#7b5a3a] text-white font-semibold py-3 rounded-xl 
               hover:bg-[#5a4025] transition duration-200 shadow-md">
        Kirim ke Kasir
      </button>

    </form>
  </div>

  <script>
    document.getElementById('customerForm').addEventListener('submit', async function (e) {
      e.preventDefault();

      const formData = new FormData(this);
      const response = await fetch('process.php', {
        method: 'POST',
        body: formData
      });

      if (response.redirected) {
        window.location.href = response.url;
        return;
      }

      const text = await response.text();
      if (text.trim().startsWith('<!DOCTYPE')) {
        document.open();
        document.write(text);
        document.close();
      } else {
        alert(text);
      }
    });
  </script>

</body>
</html>
