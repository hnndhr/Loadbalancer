<?php
include 'config.php';
session_start();

date_default_timezone_set('Asia/Jakarta');
$start_exec = microtime(true);

// --- Ambil input dari form ---
$nama = $_POST['nama'] ?? null;
$jumlah_barang = intval($_POST['jumlah_barang'] ?? 0);
$metode = $_POST['metode_pembayaran'] ?? null;

if (!$nama || !$jumlah_barang || !$metode) {
    die("Data tidak lengkap.");
}

// Normalisasi nama metode
$metode = strtolower($metode);

// --- Tentukan koneksi dan tabel sesuai metode pembayaran ---
if ($metode === 'tunai') {
    $conn = connectDB($db_kasir_tunai);
    $tabel = 'tunai';
    $kasir_label = 'Mila';
} else {
    // Untuk non-tunai → pilih kasir dengan pelanggan paling sedikit
    $conn1 = connectDB($db_kasir_non1);
    $conn2 = connectDB($db_kasir_non2);

    if (!$conn1 || !$conn2) {
        logRequest('Error', $_POST, 503, $db_logs);
        die("Koneksi ke kasir non-tunai gagal.");
    }

    $count1 = $conn1->query("SELECT COUNT(*) AS total FROM nontunai")->fetch_assoc()['total'] ?? 0;
    $count2 = $conn2->query("SELECT COUNT(*) AS total FROM nontunai")->fetch_assoc()['total'] ?? 0;

    if ($count1 < $count2) {
        $conn = $conn1;
        $kasir_label = 'Hellen';
    } elseif ($count2 < $count1) {
        $conn = $conn2;
        $kasir_label = 'Gurat';
    } else {
        $rand = rand(1,2);
        $conn = ($rand == 1 ? $conn1 : $conn2);
        $kasir_label = ($rand == 1 ? 'Hellen' : 'Gurat');
    }

    $tabel = 'nontunai';
}

// --- Hitung waktu otomatis ---
$arrival_time = date('Y-m-d H:i:s');
$q_last = $conn->query("SELECT end_time FROM $tabel ORDER BY end_time DESC LIMIT 1");
$last_end_time = ($q_last && $q_last->num_rows > 0) ? $q_last->fetch_assoc()['end_time'] : null;

if ($last_end_time && strtotime($last_end_time) > strtotime($arrival_time)) {
    $start_time = $last_end_time;
} else {
    $start_time = $arrival_time;
}

$end_time = date('Y-m-d H:i:s', strtotime($start_time) + $jumlah_barang);
$waiting_time = strtotime($start_time) - strtotime($arrival_time);

// --- Simpan ke database ---
$stmt = $conn->prepare("INSERT INTO $tabel (nama, jumlah_barang, metode_pembayaran, arrival_time, start_time, end_time, waiting_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sissssi", $nama, $jumlah_barang, $metode, $arrival_time, $start_time, $end_time, $waiting_time);

$status = "❌ Gagal menambah data";
$status_code = 500;

if ($stmt->execute()) {
    $status = "✅ Data berhasil dikirim ke kasir $kasir_label";
    $status_code = 200;
}

$stmt->close();
$conn->close();

// --- LOG REQUEST (sekali saja, setelah proses selesai) ---
logRequest($kasir_label, $_POST, $status_code, $db_logs);

// --- Waktu & ukuran data ---
$end_exec = microtime(true);
$execution_time = round(($end_exec - $start_exec) * 1000, 2);
$data_size = strlen(json_encode($_POST));

// --- Session Report ---
$_SESSION['report_data'] = [
  'status' => $status,
  'metode' => $kasir_label,
  'execution_time' => $execution_time,
  'data_size' => $data_size,
  'jumlah_barang' => $jumlah_barang,
  'arrival_time' => $arrival_time,
  'start_time' => $start_time,
  'end_time' => $end_time,
  'waiting_time' => $waiting_time
];

session_write_close();
header("Location: report.php");
exit;
?>