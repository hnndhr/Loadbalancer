<?php
// =======================
// CONFIG DATABASE REMOTE 
// =======================

$db_kasir_tunai = [
  'host' => '10.175.160.50',
  'port' => '3307',
  'user' => 'Hana',
  'pass' => '123',
  'name' => 'kompgrid'
];

$db_kasir_non1 = [
  'host' => '10.175.160.50',
  'port' => '3307',
  'user' => 'Meelway',
  'pass' => '123',
  'name' => 'komgrid'
];

$db_kasir_non2 = [
  'host' => '10.175.160.30',
  'port' => 3306,
  'user' => 'goerat2',
  'pass' => '1',
  'name' => 'komgrid'
];

// =============================
// CONFIG DATABASE LOCAL (LOGS)
// =============================
$db_logs = [
    'host' => 'localhost',
    'port' => 3306,
    'user' => 'root',
    'pass' => '',
    'name' => 'lb_logs'
];

// =============================
// FUNGSI KONEKSI DATABASE
// =============================
function connectDB($config) {
    $port = $config['port'] ?? 3306;
    $conn = @new mysqli(
        $config['host'],
        $config['user'],
        $config['pass'],
        $config['name'],
        $port
    );

    if ($conn->connect_error) {
        return null; 
    }
    return $conn;
}

// =============================
// FUNGSI LOGGING KE DATABASE
// =============================
function logRequest($kasir, $data, $status_code, $db_logs) {

    $conn = connectDB($db_logs);
    if (!$conn) return;

    $stmt = $conn->prepare("
        INSERT INTO request_logs
        (client_ip, kasir_tujuan, query_type, nama, jumlah_barang, metode, status_code)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $client_ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $query_type = "INSERT";

    // Antisipasi jika index tidak ada
    $nama   = $data['nama'] ?? '-';
    $jumlah = isset($data['jumlah_barang']) ? intval($data['jumlah_barang']) : 0;
    $metode = $data['metode'] ?? '-';

    $stmt->bind_param(
        "ssssisi",
        $client_ip,
        $kasir,
        $query_type,
        $nama,
        $jumlah,
        $metode,
        $status_code
    );

    $stmt->execute();
    $stmt->close();
    $conn->close();
}
?>
