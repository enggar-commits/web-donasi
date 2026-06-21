<?php
require_once __DIR__ . '/config/database.php';

// Membuat hash password yang 100% valid dengan sistem Anda
$password_baru = password_hash('admin123', PASSWORD_DEFAULT);

// Update password untuk enggar dan fadil
$query = "UPDATE tb_users SET password = ? WHERE username IN ('enggar', 'fadil')";
$stmt = $pdo->prepare($query);

if ($stmt->execute([$password_baru])) {
    echo "<h1>SUKSES!</h1>";
    echo "<p>Password untuk akun 'enggar' dan 'fadil' berhasil direset menjadi: <b>admin123</b></p>";
    echo "<a href='/donasi/auth'>Kembali ke Halaman Login</a>";
} else {
    echo "Gagal mereset password.";
}
?>