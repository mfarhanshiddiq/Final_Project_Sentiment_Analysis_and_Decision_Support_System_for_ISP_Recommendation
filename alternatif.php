<?php
// Memulai output buffering untuk mencegah output sebelum header
ob_start();
include('config.php');
include('fungsi.php');

// Menjalankan perintah edit
if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    header('Location: editalternatif.php?jenis=alternatif&id=' . $id);
    exit();
}

// Menjalankan perintah delete
if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    try {
        // Prepared statement untuk hapus data dari tabel alternatif
        $stmt_alt = $koneksi->prepare("DELETE FROM alternatif WHERE id = ?");
        $stmt_alt->bind_param("i", $id);
        $stmt_alt->execute();
        $stmt_alt->close();

        // Commit transaksi
        mysqli_commit($koneksi);

        // Redirect setelah penghapusan
        header('Location: alternatif.php');
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
    $pangkat = $_POST['kategori'];

    // Validasi NIP: Pastikan hanya terdiri dari 18 angka
    if (empty($nip) || strlen($nip) != 18 || !ctype_digit($nip)) {
        $nip = '-'; // Ganti dengan strip jika tidak valid
    }

    // Panggil fungsi tambahData untuk menyimpan data
    $query = "INSERT INTO alternatif (nama, nip, kategori) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sss", $nama, $nip, $pangkat);
    $stmt->execute();
    $stmt->close();

    // Redirect setelah penyimpanan
    header('Location: alternatif.php');
    exit();
}

include('header.php');
?>

<section class="content">
    <h2 class="ui header">Data Provider</h2>

    <table class="ui celled table">
        <thead>
            <tr>
                <th class="collapsing">No</th>
                <th>Nama Provider</th>
                <th>Aksi</th>
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
            $nip = !empty($row['nip']) && ctype_digit($row['nip']) && strlen($row['nip']) == 18 ? $row['nip'] : '-';
        ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                <td><?php echo htmlspecialchars($nip); ?></td>
                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                <td class="right aligned collapsing">
                    <form method="post" action="alternatif.php">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="edit" class="ui mini teal left labeled icon button">
                            <i class="right edit icon"></i>EDIT
                        </button>
                        <button type="submit" name="delete" class="ui mini red left labeled icon button" onclick="return confirm('Apakah Anda yakin ingin menghapus alternatif ini?')">
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
                    <a href="tambahalternatif.php?jenis=alternatif">
                        <div class="ui right floated small primary labeled icon button">
                            <i class="plus icon"></i>Tambah</div>
                    </a>
                </th>
            </tr>
        </tfoot>
    </table>

    <br>
</section>

<?php include('footer.php'); ?>
<?php
// Mengakhiri output buffering
ob_end_flush();
?>
