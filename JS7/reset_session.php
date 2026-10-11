<?php
session_start();
session_destroy();

session_start();
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Seluruh data session berhasil direset.'];
header('Location: index.php');
exit;