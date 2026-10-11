<?php
session_start();

$nama = trim($_POST['nama'] ?? '');
$no_anggota = trim($_POST['no_anggota'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}
if ($no_anggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}

if ($no_hp !== '' && !preg_match('/^[0-9+]+$/', $no_hp)) {
    $errors[] = "No. HP hanya boleh berisi angka dan tanda +."; // Lat 2, Validasi tambahan untuk No. HP (opsional, jika diisi harus angka/tanda +)
}


if (isset($_SESSION['anggota'])) {
    foreach ($_SESSION['anggota'] as $item) {
        if ($item['no_anggota'] === $no_anggota) {
            $errors[] = "No. Anggota sudah pernah terdaftar."; // Lat2, yang mungkin bisa ditambahkan = cek apakah no_anggota sudah terdaftar di session
            break;
        }
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}

$_SESSION['anggota'][] = [
    'nama' => $nama,
    'no_anggota' => $no_anggota,
    'alamat' => $alamat,
    'no_hp' => $no_hp,
];

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil ditambahkan.'];
header('Location: list.php');
exit;