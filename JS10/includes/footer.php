</main>

<footer> 
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 10</p>
</footer>
<script>
    window.__FLASH__ = <?php
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    echo json_encode($f); // bagian bawah, sekaligus injct flash ke JS
    ?>;
</script>
<script src="<?php echo $base; ?>assets/js/app.js"></script>
</body>

</html>