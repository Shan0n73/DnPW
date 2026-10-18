<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';


// lat 3, membatasi percobaan login jika passwordnya salah
if (!isset($_SESSION['login_attempts'][$username])) {
    $_SESSION['login_attempts'][$username] = [
        'count' => 0,
        'last_attempt' => time()
    ];
}

$attempt = &$_SESSION['login_attempts'][$username];

// cek apakah user sedang diblokir sementara (60 detik = 1 menit) - 3
if ($attempt['count'] >= 3 && (time() - $attempt['last_attempt']) < 60) {
    $sisaWaktu = 60 - (time() - $attempt['last_attempt']);
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => "Terlalu banyak percobaan gagal. Silakan coba lagi dalam {$sisaWaktu} detik."
    ];
    header('Location: login.php');
    exit;
}

// reset percobaan jika batas waktu pemblokiran sudah lewat - lat 3
if ((time() - $attempt['last_attempt']) >= 60) {
    $attempt['count'] = 0;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];

    // lat 2, fitur remember me
    if ($remember) {
        $secretKey = "SimpusMini_Secret_Key_Secure"; // key internal server
        $cookieValue = $user['id'] . ':' . hash_hmac('sha256', $user['id'], $secretKey);
        // set cookie selama 30 hari
        setcookie('remember_token', $cookieValue, time() + (30 * 24 * 60 * 60), '/', '', false, true);
    }
    header('Location: ../index.php');
    exit;
}

$attempt['count']++;
$attempt['last_attempt'] = time();

$_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
header('Location: login.php');
exit;
