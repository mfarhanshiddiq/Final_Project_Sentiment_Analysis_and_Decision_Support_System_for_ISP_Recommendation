<?php
// Memulai output buffering untuk mencegah output sebelum header
ob_start();
include('config.php');
include('fungsi.php');



include('header_pengawas.php');
?>

<section class="content">
    <h2 class="ui header">Data Provider</h2>

    <table class="ui celled table">
        <thead>
            <tr>
                <th class="collapsing">No</th>
                <th>Nama Provider</th>
                
            </tr>
        </thead>
        <tbody>
        <?php
        // Menampilkan data dari tabel alternatif
        $query = "SELECT id, nama, nip, kategori FROM alternatif ORDER BY id";
        $result = mysqli_query($koneksi, $query);

        if (!$result) {
            die("Query Error: " . mysqli_error($koneksi));
        }

        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $i++;
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($row['nip']); ?></td>
                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                
            </tr>
        <?php } ?>
        </tbody>
        
    </table>

    <br>
</section>

<?php include('footer.php'); ?>
<?php
// Mengakhiri output buffering
ob_end_flush();
?>
