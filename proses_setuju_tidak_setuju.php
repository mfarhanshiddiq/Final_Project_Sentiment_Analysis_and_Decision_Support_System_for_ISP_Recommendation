<?php
// Memasukkan konfigurasi dan fungsi
include('config.php');
include('fungsi.php');

// Cek apakah parameter ID ada
if (isset($_GET['id'])) {
    $id_alternatif = intval($_GET['id']); // Mengamankan input

    // Ambil nama alternatif berdasarkan ID
    $query = "SELECT nama FROM alternatif WHERE id = $id_alternatif";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nama_alternatif = $row['nama'];

        // Update status menjadi "Disetujui"
        $updateQuery = "UPDATE alternatif SET status = 'Disetujui' WHERE id = $id_alternatif";
        $updateResult = mysqli_query($koneksi, $updateQuery);

        if ($updateResult) {
            // Tampilkan halaman konfirmasi
            echo "<h2>Alternatif <strong>$nama_alternatif</strong> telah disetujui.</h2>";
            echo "<a href='hasil.php' class='ui button'>Kembali ke Perangkingan</a>";
        } else {
            // Jika gagal update status
            echo "<h2>Terjadi kesalahan saat menyetujui alternatif.</h2>";
            echo "<a href='hasil.php' class='ui button'>Kembali</a>";
        }
    } else {
        // Jika ID tidak ditemukan
        echo "<h2>Alternatif dengan ID $id_alternatif tidak ditemukan.</h2>";
        echo "<a href='hasil.php' class='ui button'>Kembali</a>";
    }
} else {
    // Jika parameter ID tidak ada
    echo "<h2>ID Alternatif tidak valid.</h2>";
    echo "<a href='.php' class='ui button'>Kembali</a>";
}
?>
