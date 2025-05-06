<?php
include 'koneksi.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Ambil data dari tabel users yang role-nya admin
    $query = "SELECT * FROM users WHERE username='$username' AND role='admin'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Cocokin password yang diketik sama password hash dari DB
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin'] = $username;
            header("Location: beranda.html");
            exit();
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Akun admin tidak ditemukan.";
    }
} else {
    echo "Akses tidak diizinkan.";
}
?>
