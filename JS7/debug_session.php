<?php
$page_title = "Debug Session";
include __DIR__ . '/includes/header.php';
?>
<section>
    <h2>Isi $_SESSION Mentah</h2>
    <pre><?php print_r($_SESSION); ?></pre>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>