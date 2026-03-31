<?php
include('config.php');
include('fungsi.php');

// Menjalankan perintah edit
if (isset($_POST['edit'])) {
    $id = $_POST['id_guru'];
    header('Location: editguru.php?jenis=guru&id=' . $id);
    exit();
}

// Menjalankan perintah delete
if (isset($_POST['delete'])) {
    $id = $_POST['id_guru'];

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Prepared statement untuk hapus data dari alternatif
        $stmt_alt = $koneksi->prepare("DELETE FROM alternatif WHERE id_guru = ?");
        $stmt_alt->bind_param("i", $id);
        $stmt_alt->execute();
        $stmt_alt->close();

        // Prepared statement untuk hapus data dari guru
        $stmt_guru = $koneksi->prepare("DELETE FROM guru WHERE id_guru = ?");
        $stmt_guru->bind_param("i", $id);
        $stmt_guru->execute();
        $stmt_guru->close();

        // Commit transaksi
        mysqli_commit($koneksi);
        
        // Redirect setelah penghapusan
        header('Location: guru.php');
        exit();
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($koneksi);
        echo "Error deleting records: " . $e->getMessage();
    }
}


// Menjalankan perintah tambah
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $pangkat = $_POST['pangkat'];
    tambahData('guru', $nama, $nip, $pangkat);
}

include('header.php');
?>

<section class="content">
    <h2 class="ui header">Data Guru</h2>

    <table class="ui celled table">
        <thead>
            <tr>
                <th class="collapsing">No</th>
                <th>Nama Guru</th>
                <th>NIP</th>
                <th>Pangkat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Menampilkan list guru
            $query = "SELECT id_guru, nama, nip, pangkat FROM guru ORDER BY id_guru";
            $result = mysqli_query($koneksi, $query);

            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                $i++;
        ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo htmlspecialchars($row['nama']) ?></td>
                <td><?php echo htmlspecialchars($row['nip']) ?></td>
                <td><?php echo htmlspecialchars($row['pangkat']) ?></td>
                <td class="right aligned collapsing">
                    <form method="post" action="guru.php">
                        <input type="hidden" name="id_guru" value="<?php echo $row['id_guru'] ?>">
                        <button type="submit" name="edit" class="ui mini teal left labeled icon button">
                            <i class="right edit icon"></i>EDIT
                        </button>
                        <button type="submit" name="delete" class="ui mini red left labeled icon button">
                            <i class="right remove icon"></i>DELETE
                        </button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
        <tfoot class="full-width">
            <tr>
                <th colspan="5">
                    <a href="tambahguru.php?jenis=guru">
                        <div class="ui right floated small primary labeled icon button">
                            <i class="plus icon"></i>Tambah
                        </div>
                    </a>
                </th>
            </tr>
        </tfoot>
    </table>

    <br>
</section>

<?php include('footer.php'); ?>
