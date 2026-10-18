<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Anggota Baru</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <div>
            <label for="nama">Nama *</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div>
            <label for="no_anggota">No. Anggota *</label>
            <input type="text" id="no_anggota" name="no_anggota" required>
        </div>
        <div>
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat"></textarea>
        </div>
        <div>
            <label for="no_hp">No. HP</label>
            <input type="text" id="no_hp" name="no_hp">
        </div>
        <button type="submit">Simpan</button>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>