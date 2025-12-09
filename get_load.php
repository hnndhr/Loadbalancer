
<?php
include 'config.php';

function getKasirLoad($conn, $tabel) {
  if (!$conn) return ['error' => true];

  $now = date('Y-m-d H:i:s');
  $res = $conn->query("SELECT COUNT(*) AS aktif FROM $tabel WHERE end_time > '$now'");
  $aktif = $res->fetch_assoc()['aktif'] ?? 0;

  $res2 = $conn->query("SELECT COUNT(*) AS total FROM $tabel");
  $total = $res2->fetch_assoc()['total'] ?? 0;

  return ['aktif' => $aktif, 'total' => $total];
}

$data = [
  'tunai' => getKasirLoad(connectDB($db_kasir_tunai), 'tunai'),
  'non1' => getKasirLoad(connectDB($db_kasir_non1), 'nontunai'),
  'non2' => getKasirLoad(connectDB($db_kasir_non2), 'nontunai'),
];

header('Content-Type: application/json');
echo json_encode($data);
?>
