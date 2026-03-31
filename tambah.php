<?php
	include('config.php');
	include('fungsi.php');

	// mendapatkan data edit
	if(isset($_GET['jenis'])) {
		$jenis	= $_GET['jenis'];
	}
	if(isset($_GET['bobot'])) {
		$bobot	= $_GET['bobot'];
	}
	if (isset($_POST['tambah'])) {
		$jenis	= $_POST['jenis'];
		$nama 	= $_POST['nama'];
		$bobot = $_POST['bobot'];
		
		// Panggil fungsi untuk menambah data
		tambahData($jenis,$nama,$bobot);

		// Redirect langsung ke halaman kriteria.php tanpa perlu klik OK
		echo "<script>window.location.href = 'kriteria.php';</script>";
		exit();
	}

	include('header.php');
?>

<section class="content">
	<h2>Tambah <?php echo htmlspecialchars($jenis); ?></h2>

	<form class="ui form" method="post" action="tambah.php">
		<div class="inline field">
			<label>Nama <?php echo htmlspecialchars($jenis); ?></label>
			<input type="text" name="nama" placeholder="<?php echo htmlspecialchars($jenis); ?> baru" required>
			<input type="hidden" name="jenis" value="<?php echo htmlspecialchars($jenis); ?>">
			</div>
			<div class="field">
            <label>NIP</label>
            <input type="text" name="nip" id="nip" placeholder="NIP" pattern="\d{18}" title="NIP harus terdiri dari 18 angka" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            <div class="ui checkbox">
                <input type="checkbox" id="no_nip" name="no_nip" onchange="handleNipOption()">
                <label for="no_nip">Tidak memiliki NIP</label>
            </div>
        </div>
		</div>
		<br>
		<input class="ui green button" type="submit" name="tambah" value="SIMPAN">
	</form>
	<br>
	<a href="kriteria.php" class="ui button">Kembali</a>
	<script>
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

    // JavaScript untuk membatasi input NIP hanya 18 angka
    const nipInput = document.getElementById('nip');
    nipInput.addEventListener('input', function (event) {
        // Menghapus karakter selain angka
        this.value = this.value.replace(/[^0-9]/g, '');

        // Membatasi panjang input hanya 18 karakter
        if (this.value.length > 18) {
            this.value = this.value.substring(0, 18);
        }
    });
</script>
</section>

<?php include('footer.php'); ?>
