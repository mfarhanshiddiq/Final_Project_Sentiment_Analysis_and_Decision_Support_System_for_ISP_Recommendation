<?php
// Memasukkan konfigurasi dan fungsi
include('config.php');
include('fungsi.php');

// Cek apakah parameter ID ada
if (isset($_GET['id'])) {
    $id_alternatif = intval($_GET['id']); // Mengamankan input

    // Update status menjadi "Tidak Disetujui"
    $updateQuery = "UPDATE alternatif SET status = 'Tidak Disetujui' WHERE id = $id_alternatif";
    $updateResult = mysqli_query($koneksi, $updateQuery);

    if ($updateResult) {
        // Redirect ke halaman ranking
        header('Location: ranking_pengawas.php');
        exit(); // Menghentikan eksekusi setelah redirect
    } else {
        // Jika gagal update status
        echo "<h2>Terjadi kesalahan saat menandai alternatif sebagai Tidak Disetujui.</h2>";
        echo "<a href='ranking_pengawas.php' class='ui button'>Kembali</a>";
    }
} else {
    // Jika parameter ID tidak ada
    echo "<h2>ID Alternatif tidak valid.</h2>";
    echo "<a href='ranking_pengawas.php' class='ui button'>Kembali</a>";
}
?>
