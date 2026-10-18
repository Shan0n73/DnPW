<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$nama = trim($_POST['nama'] ?? '');
$noAnggota = trim($_POST['no_anggota'] ?? '');
$email = trim($_POST['email'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');

if (!$id || !is_numeric($id)) {
    header('Location: list.php');
    exit;
}

$errors = [];
if ($nama === '') {
    $errors[] = "Nama wajib diisi.";
}

if ($noAnggota === '') {
    $errors[] = "No. Anggota wajib diisi.";
}

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Format email tidak valid.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE anggota SET nama = :nama, no_anggota = :no_anggota,
     email = :email, alamat = :alamat, no_hp = :no_hp WHERE id = :id" //update data member
);

$stmt->execute([
    'id' => (int) $id,
    'nama' => $nama,
    'no_anggota' => $noAnggota,
    'email' => $email,
    'alamat' => $alamat,
    'no_hp' => $noHp,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil diperbarui.'];
header('Location: list.php');
exit;
