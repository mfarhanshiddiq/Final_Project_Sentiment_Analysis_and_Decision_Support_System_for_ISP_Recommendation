<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM pengguna WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $user = $result->fetch_assoc();
    // Cek apakah pengguna adalah admin
    if ($user['role'] !== 'admin') {
        die("Anda tidak memiliki akses untuk mengubah profil.");
    }
} else {
    die("Gagal mengambil data pengguna: " . $koneksi->error);
}

// Proses pembaruan profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Cek jika username sudah ada
    $checkQuery = "SELECT * FROM pengguna WHERE username = ? AND id != ?";
    $checkStmt = $koneksi->prepare($checkQuery);
    $checkStmt->bind_param("si", $username, $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo "<script>alert('Username sudah digunakan. Silakan pilih username lain.');</script>";
    } else {
        // Query untuk pembaruan
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE pengguna SET nama = ?, username = ?, password = ? WHERE id = ?";
            $stmt = $koneksi->prepare($updateQuery);
            $stmt->bind_param("sssi", $nama, $username, $hashedPassword, $user_id);
        } else {
            $updateQuery = "UPDATE pengguna SET nama = ?, username = ? WHERE id = ?";
            $stmt = $koneksi->prepare($updateQuery);
            $stmt->bind_param("ssi", $nama, $username, $user_id);
        }

        if ($stmt->execute()) {
            echo "<script>alert('Profil berhasil diperbarui!');</script>";
            header("Location: profil.php");
            exit();
        } else {
            echo "Error updating profile: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pemilihan Guru Terbaik</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Gaya untuk dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none; /* Sembunyikan dropdown secara default */
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block; /* Tampilkan dropdown saat hover */
        }

        .profile:hover .dropdown-content {
            display: block; /* Tampilkan dropdown saat hover pada profil */
        }
    </style>
</head>

<body>
<header style="display: flex; justify-content: space-between; align-items: center; padding: 20px; background-color: #808080; color: white;">
    <!-- Judul di sebelah kiri -->
    <h1 style="margin: 0;">Pemilihan Guru Terbaik</h1>

    <!-- Profil di sebelah kanan dengan dropdown -->
    <div class="profile" style="display: flex; align-items: center; position: relative;">
        <div class="dropdown" style="display: flex; align-items: center;">
            <a href="#" style="display: flex; align-items: center; text-decoration: none; color: white;">
                <!-- Ikon FontAwesome Profil -->
                <i class="fas fa-user-circle" style="font-size: 40px; color: white; margin-right: 10px;"></i>
            </a>
            <!-- Dropdown content -->
            <div class="dropdown-content" style="display: none; position: absolute; top: 100%; right: 0; background-color: white; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px;">
                <a href="profil.php" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">Profil</a>
                <a href="#" id="logout" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">Logout</a>
            </div>
        </div>
    </div>

    <!-- Script untuk menampilkan dropdown saat mengklik link profil -->
    <script>
        const dropdown = document.querySelector('.dropdown');
        const dropdownContent = document.querySelector('.dropdown-content');
        const profileLink = dropdownContent.querySelector('a[href="profil.php"]'); // Mengambil link profil
        const logoutLink = dropdownContent.querySelector('#logout'); // Mengambil link logout

        dropdown.addEventListener('click', (event) => {
            event.preventDefault(); // Mencegah perilaku default anchor
            // Toggle dropdown content display
            dropdownContent.style.display = dropdownContent.style.display === 'none' || dropdownContent.style.display === '' ? 'block' : 'none';
        });

        // Menambahkan event listener untuk redirect ke profil saat link diklik
        profileLink.addEventListener('click', () => {
            window.location.href = 'profil.php'; // Redirect ke halaman profil
        });

        // Menambahkan event listener untuk logout
        logoutLink.addEventListener('click', (event) => {
            event.preventDefault(); // Mencegah perilaku default anchor
            // Di sini Anda bisa menambahkan logika untuk menghapus sesi atau token jika perlu
            window.location.href = 'index.php'; // Redirect ke halaman index setelah logout
        });

        // Tutup dropdown jika pengguna mengklik di luar dropdown
        window.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) {
                dropdownContent.style.display = 'none';
            }
        });
    </script>
</header>


<style>
    .content {
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        font-size: 16px;
        font-weight: bold;
        display: block;
        margin-bottom: 8px;
    }

    .form-group input {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    .btn {
        width: 100%;
        padding: 12px;
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #45a049;
    }
</style>


<div class="wrapper">
    <nav id="navigation" role="navigation">
        <ul>
            <li><a class="item" href="home.php">Home</a></li> 
            <li><a class="item" href="kriteria.php">Kriteria</a></li>
            <li><a class="item" href="alternatif.php">Alternatif</a></li>
            <li><a class="item" href="bobot_kriteria.php">Perbandingan Kriteria</a></li>
            <li><a class="item" href="bobot.php?c=1">Perbandingan Alternatif</a></li>
            <li><a class="item" href="ranking.php">Ranking</a></li>
            <li><a class="item" href="laporan_hasil.php">Laporan Hasil</a></li>
        </ul>
    </nav>
    <div class="content">
        <h2>Profil</h2>
        <form method="post">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password baru (biarkan kosong jika tidak ingin mengubah)">
            </div>
            <button type="submit" class="btn">Ubah</button>
        </form>
    </div>
</div>

</body>
</html>
