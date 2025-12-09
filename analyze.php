<?php
include 'config.php';

function getStats($conn, $tabel) {
  if (!$conn) return ['total' => 0, 'avg' => 0, 'count' => 0];

  $q = $conn->query("
    SELECT 
      SUM(TIMESTAMPDIFF(SECOND, start_time, end_time)) AS total_durasi,
      AVG(TIMESTAMPDIFF(SECOND, start_time, end_time)) AS avg_durasi,
      COUNT(*) AS jumlah_transaksi
    FROM $tabel
  ");

  $r = $q->fetch_assoc();
  return [
    'total' => intval($r['total_durasi']),
    'avg' => intval($r['avg_durasi']),
    'count' => intval($r['jumlah_transaksi'])
  ];
}

// Ambil data per kasir
$tunai = getStats(connectDB($db_kasir_tunai), 'tunai');
$non1 = getStats(connectDB($db_kasir_non1), 'nontunai');
$non2 = getStats(connectDB($db_kasir_non2), 'nontunai');

// Hitung total dan rata-rata keseluruhan
$total_durasi_semua = $tunai['total'] + $non1['total'] + $non2['total'];
$total_transaksi = $tunai['count'] + $non1['count'] + $non2['count'];
$avg_keseluruhan = $total_transaksi > 0 ? intval($total_durasi_semua / $total_transaksi) : 0;

// Format output JSON
$data = [
  'Kasir Tunai' => $tunai,
  'Kasir Non-Tunai 1' => $non1,
  'Kasir Non-Tunai 2' => $non2,
  'Keseluruhan' => [
    'total' => $total_durasi_semua,
    'avg' => $avg_keseluruhan
  ]
];

header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);
?>
