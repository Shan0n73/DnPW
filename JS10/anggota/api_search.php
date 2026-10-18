<?php
require __DIR__ . '/../includes/auth.php';
header('Content-Type: application/json');
require __DIR__ . '/../includes/koneksi.php';

$q = trim($_GET['q'] ?? '');
$sql = "SELECT id, no_anggota, nama, email, alamat, no_hp FROM anggota";
$params = [];
if ($q !== '') {
  $sql .= " WHERE nama ILIKE :kw OR no_anggota ILIKE :kw";
  $params['kw'] = "%$q%";
}
$sql .= " ORDER BY id DESC LIMIT 20";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
echo json_encode(['data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);