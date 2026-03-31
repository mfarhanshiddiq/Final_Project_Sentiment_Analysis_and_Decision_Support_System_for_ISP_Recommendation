<?php
include('config.php');
include('fungsi.php');

// Mengambil ID dari query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = getAlternatifById($id); // Mengambil data alternatif berdasarkan ID
    if (!$data) {
        echo "Data tidak ditemukan.";
        exit();
    }
}

// Jika tombol update ditekan
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $kategori = $_POST['kategori'];

    // Validasi NIP, jika tidak valid, atur ke tanda strip
    if (empty($nip) || strlen($nip) != 18 || !ctype_digit($nip)) {
        $nip = '-';
    }

    // Memperbarui data alternatif
    if (updateDataAlternatif($id, $nama, $nip, $kategori)) {
        header('Location: alternatif.php'); // Redirect ke halaman alternatif.php setelah update berhasil
        exit();
    } else {
        echo "Gagal memperbarui data.";
    }
}

include('header.php');
?>

<section class="content">
    <h2 class="ui header">Edit Provider</h2>

    <form class="ui form" method="post" action="" onsubmit="return confirmUpdate();">
        <div class="field">
            <label>Nama Provider</label>
            <input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
        </div>
        
        <br>
        <button class="ui green button" type="submit" name="update">Update</button>
    </form>

    <!-- Tombol Kembali -->
    <br>
    <a href="alternatif.php" class="ui button">Kembali</a>
</section>

<?php include('footer.php'); ?>

<!-- Script untuk konfirmasi sebelum update -->
<script>
function confirmUpdate() {
    return confirm("Apakah Anda yakin ingin mengubah data ini?");
}

// JavaScript untuk menangani opsi NIP
function handleNipOption() {
    const nipInput = document.getElementById('nip');
    const noNipCheckbox = document.getElementById('no_nip');

    if (noNipCheckbox.checked) {
        nipInput.value = '-'; // Set ke "-"
        nipInput.setAttribute('readonly', true); // Nonaktifkan input
        nipInput.removeAttribute('required'); // Hapus required
    } else {
        nipInput.value = ''; // Kosongkan input
        nipInput.removeAttribute('readonly'); // Aktifkan input
        nipInput.setAttribute('required', 'required'); // Tambahkan kembali required
    }
}

// Inisialisasi checkbox saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const noNipCheckbox = document.getElementById('no_nip');
    if (noNipCheckbox.checked) {
        handleNipOption();
    }
});
</script>
