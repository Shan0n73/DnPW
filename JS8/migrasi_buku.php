<?php
require_once __DIR__ . '/includes/koneksi.php';

$jsonPath = __DIR__ . '/data/buku.json';

if (!file_exists($jsonPath)) {
    die("File JSON tidak ditemukan di: " . $jsonPath);
}

$jsonData = file_get_contents($jsonPath);
$bukuList = json_decode($jsonData, true);

if (!is_array($bukuList)) {
    die("Format data JSON tidak valid.");
}

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori) 
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori)"
);

$berhasil = 0;

foreach ($bukuList as $buku) {
    try {
        $stmt->execute([
            'judul'     => $buku['judul'] ?? '',
            'pengarang' => $buku['pengarang'] ?? '',
            'tahun'     => (int) ($buku['tahun'] ?? 0),
            'isbn'      => $buku['isbn'] ?? null,
            'stok'      => (int) ($buku['stok'] ?? 0),
            'kategori'  => $buku['kategori'] ?? null,
        ]);
        $berhasil++;
    } catch (PDOException $e) {
        echo "Gagal migrasi buku: " . ($buku['judul'] ?? 'Unkown') . " - Error: " . $e->getMessage() . "<br>";
    }
}

echo "Migrasi selesai! Total data berhasil dipindahkan: 7 dari " . count($bukuList) . " data.";
