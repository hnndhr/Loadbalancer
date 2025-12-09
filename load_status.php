
<?php
require 'config.php';

header('Content-Type: application/json');

$result = [
    'tunai' => null,
    'non1' => null,
    'non2' => null,
    'debug' => []
];

// Fungsi bantu ngecek koneksi dan jumlah
function checkKasir($config, $nama_kasir, $tabel) {
    $status = ['jumlah' => null, 'error' => null];
    $conn = @connectDB($config);
    if (!$conn) {
        $status['error'] = "Gagal koneksi ke $nama_kasir ({$config['host']})";
        return $status;
    }

    $res = @$conn->query("SELECT COUNT(*) AS total FROM $tabel");
    if (!$res) {
        $status['error'] = "Query ke $tabel di $nama_kasir gagal: " . $conn->error;
        $conn->close();
        return $status;
    }

    $status['jumlah'] = $res->fetch_assoc()['total'];
    $conn->close();
    return $status;
}

// Kasir Tunai
$tunai = checkKasir($db_kasir_tunai, "Kasir Tunai", "tunai");
$result['tunai'] = $tunai['jumlah'];
$result['debug']['tunai'] = $tunai;

// Kasir Non Tunai 1
$non1 = checkKasir($db_kasir_non1, "Kasir Non Tunai 1", "nontunai");
$result['non1'] = $non1['jumlah'];
$result['debug']['non1'] = $non1;

// Kasir Non Tunai 2
$non2 = checkKasir($db_kasir_non2, "Kasir Non Tunai 2", "nontunai");
$result['non2'] = $non2['jumlah'];
$result['debug']['non2'] = $non2;

echo json_encode($result, JSON_PRETTY_PRINT);
