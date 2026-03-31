<?php
session_start();
include('config.php'); // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hash password dengan MD5

    // Gunakan prepared statement untuk keamanan
    $query = $koneksi->prepare("SELECT * FROM pengguna WHERE username = ? AND role = 'admin'");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if ($password === $row['password']) {
            // Set session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role']; // Simpan role

            // Redirect ke halaman home
            header("Location: home.php");
            exit();
        } else {
            // Password salah
            echo "<script>alert('Password salah.'); window.location.href = 'login.php';</script>";
        }
    } else {
        // Username tidak ditemukan
        echo "<script>alert('Username tidak ditemukan.'); window.location.href = 'login.php';</script>";
    }
}
?>
