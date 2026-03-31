<?php
session_start();
include('config.php'); // Koneksi ke database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$pengawas_id = $_SESSION['user_id']; // Mengambil ID pengawas dari session
$query = "SELECT * FROM pengawas WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $pengawas_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pengawas = $result->fetch_assoc();
} else {
    die("Pengawas tidak ditemukan.");
}

// Proses pembaruan profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // Password tidak di-hash di sini

    // Cek apakah username sudah ada
    $checkQuery = "SELECT * FROM pengawas WHERE username = ? AND id != ?";
    $checkStmt = $koneksi->prepare($checkQuery);
    $checkStmt->bind_param("si", $username, $pengawas_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Jika username sudah ada, berikan peringatan kepada pengguna
        echo "<script>alert('Username sudah digunakan. Silakan pilih username lain.');</script>";
    } else {
        // Jika password baru diisi, hash password tersebut
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE pengawas SET username = ?, password = ? WHERE id = ?";
            $stmt = $koneksi->prepare($updateQuery);
            $stmt->bind_param("ssi", $username, $hashedPassword, $pengawas_id);
        } else {
            $updateQuery = "UPDATE pengawas SET username = ? WHERE id = ?";
            $stmt = $koneksi->prepare($updateQuery);
            $stmt->bind_param("si", $username, $pengawas_id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Profil berhasil diperbarui!'); window.location.href = 'profil_pengawas.php';</script>";
        } else {
            echo "Error updating profile: " . $koneksi->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Profil Pengawas</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Ubah Profil</h2>
    <form method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($pengawas['username']); ?>" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Password baru (biarkan kosong jika tidak ingin mengubah)">
        </div>
        <button type="submit" class="btn">Ubah</button>
    </form>
</div>

</body>
</html>
