<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pemilihan Provider Ideal</title>
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
    <h1 style="margin: 0;">Pemilihan Provider Ideal</h1>

    <!-- Profil di sebelah kanan dengan dropdown -->
    <div class="profile" style="display: flex; align-items: center; position: relative;">
        <div class="dropdown" style="display: flex; align-items: center;">
            <a href="#" style="display: flex; align-items: center; text-decoration: none; color: white;">
                <!-- Ikon FontAwesome Profil -->
                <i class="fas fa-user-circle" style="font-size: 40px; color: white; margin-right: 10px;"></i>
            </a>
            <!-- Dropdown content -->
            <div class="dropdown-content" style="display: none; position: absolute; top: 100%; right: 0; background-color: white; min-width: 160px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); z-index: 1; border-radius: 5px;">
                <a href="profil_pengawas.php" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">Profil</a>
                <a href="#" id="logout" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">Logout</a>
            </div>
        </div>
    </div>

    <!-- Script untuk menampilkan dropdown saat mengklik link profil -->
    <script>
        const dropdown = document.querySelector('.dropdown');
        const dropdownContent = document.querySelector('.dropdown-content');
        const profileLink = dropdownContent.querySelector('a[href="profil_pengawas.php"]'); // Mengambil link profil
        const logoutLink = dropdownContent.querySelector('#logout'); // Mengambil link logout

        dropdown.addEventListener('click', (event) => {
            event.preventDefault(); // Mencegah perilaku default anchor
            // Toggle dropdown content display
            dropdownContent.style.display = dropdownContent.style.display === 'none' || dropdownContent.style.display === '' ? 'block' : 'none';
        });

        // Menambahkan event listener untuk redirect ke profil saat link diklik
        profileLink.addEventListener('click', () => {
            window.location.href = 'profil_pengawas.php'; // Redirect ke halaman profil
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

<div class="wrapper">
    <nav id="navigation" role="navigation">
        <ul>
            <li><a class="item" href="home_pengawas.php">Home</a></li>
            
            <li><a class="item" href="kriteria_pengawas.php">Kriteria
                    <div class="ui blue tiny label" style="float: right;"><?php echo getJumlahKriteria(); ?></div>
                </a></li>
            <li><a class="item" href="alternatif_pengawas.php">Alternatif
                    <div class="ui blue tiny label" style="float: right;"><?php echo getJumlahAlternatif(); ?></div>
                </a></li>
            <li><a class="item" href="ranking_pengawas.php">Ranking</a></li>
            <li><a href="laporan_hasil_pengawas.php">Laporan Hasil</a></li>
        </ul>
    </nav>