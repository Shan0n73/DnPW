<?php
session_start();
require_once __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = trim($_POST['nama'] ?? '');
    $no_anggota = trim($_POST['no_anggota'] ?? '');
    $alamat     = trim($_POST['alamat'] ?? '');
    $no_hp      = trim($_POST['no_hp'] ?? '');

    if (empty($nama) || empty($no_anggota)) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'pesan' => 'Nama dan No. Anggota wajib diisi.'
        ];
        header('Location: tambah.php');
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            "INSERT INTO anggota (nama, no_anggota, alamat, no_hp) 
             VALUES (:nama, :no_anggota, :alamat, :no_hp) 
             RETURNING id"
        );

        $stmt->execute([
            'nama'       => $nama,
            'no_anggota' => $no_anggota,
            'alamat'     => $alamat,
            'no_hp'      => $no_hp,
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'pesan' => 'Anggota berhasil ditambahkan.'
        ];
        header('Location: list.php');
        exit;

    } catch (PDOException $e) {
        // 23505 adalah SQLState yang mengindikasi kesalahan Unique Violation pada PostgreSQL
        if ($e->getCode() === '23505') {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'pesan' => 'No. Anggota sudah dipakai, gunakan nomor lain.'
            ];
        } else {
            $_SESSION['flash'] = [
                'type' => 'danger',
                'pesan' => 'Gagal menyimpan data: ' . $e->getMessage() // lat 1 - Flash message error dengan try catch jika no. anggota ada duplikatnya
            ];
        }
        header('Location: tambah.php');
        exit;
    }
}