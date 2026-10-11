<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';

$totalBuku = count($_SESSION['buku'] ?? []);
$totalAnggota = count($_SESSION['anggota'] ?? []);
?>
<section>
    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
    <div class="cards">
        <div class="card">
            <h3>Total Buku</h3>
            <p><?php echo $totalBuku; ?></p>
        </div>
        <div class="card">
            <h3>Total Anggota</h3>
            <p><?php echo $totalAnggota; ?></p>
        </div>
    </div>
    <div style="margin-top: 1.5rem;">
    <a href="reset_session.php" onclick="return confirm('Yakin ingin mengosongkan semua data session?')" style="color: #721c24; text-decoration: underline;">Reset Semua Data Session</a>
</div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>