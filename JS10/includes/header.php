<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);

// Prefix relatif ke root proyek ini (bukan root domain) — supaya
// /assets, /index.php, dst tetap benar walau proyek diakses lewat
// subfolder (mis. dp2026.test/kode-praktikum/jobsheet-10/), bukan cuma
// lewat vhost yang document root-nya langsung folder ini.
$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1); // untuk mulai session dan cek user sudah login
?> 
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>

<body>
    <header>
        <h1>SIMPUS-Mini</h1>
        <button type="button" id="nav-toggle-btn" class="nav-toggle-label" aria-label="Menu">&#9776;</button>
        <nav>
            <ul>
                <li><a href="<?php echo $base; ?>index.php">Beranda</a></li>
                <li><a href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
                <?php if ($sudahLogin): ?>
                    <li><a href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                    <li><a href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                    <li><a href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="auth-status">
            <?php if ($sudahLogin): ?>
                <span><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                <a href="<?php echo $base; ?>auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?php echo $base; ?>auth/login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>
    <div class="toast-container" id="toast-container"></div>

    <div class="modal-overlay" id="modal-confirm">
        <div class="modal">
            <h3 id="modal-title">Konfirmasi</h3>
            <p id="modal-message"></p>
            <div class="modal-actions">
                <button type="button" class="btn" id="modal-cancel"
                    style="background:#e2e8f0;color:#1e293b;">Batal</button>
                <button type="button" class="btn btn-hapus" id="modal-ok">Ya, hapus</button>
            </div>
        </div>
    </div>

    <main>