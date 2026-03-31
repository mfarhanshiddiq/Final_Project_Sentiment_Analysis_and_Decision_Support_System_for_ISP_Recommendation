<?php
	include('config.php');
	include('fungsi.php');

	// Mendapatkan data edit
	if(isset($_GET['jenis']) && isset($_GET['id'])) {
		$id 	= $_GET['id'];
		$jenis	= $_GET['jenis'];

		// Ambil nama dari database
		$query 	= "SELECT nama FROM $jenis WHERE id=$id";
		$result	= mysqli_query($koneksi, $query);
		
		while ($row = mysqli_fetch_array($result)) {
			$nama = $row['nama'];
		}
	}

	if (isset($_POST['update'])) {
		$id 	= $_POST['id'];
		$jenis	= $_POST['jenis'];
		$nama 	= $_POST['nama'];

		$query 	= "UPDATE $jenis SET nama='$nama' WHERE id=$id";
		$result	= mysqli_query($koneksi, $query);

		if (!$result) {
			echo "Update gagal";
			exit();
		} else {
			header('Location: '.$jenis.'.php');
			exit();
		}
	}

	include('header.php');
?>

<section class="content">
	<h2>Edit <?php echo $jenis ?></h2>

	<form class="ui form" method="post" action="edit.php" onsubmit="return confirmUpdate();">
		<div class="inline field">
			<label>Nama <?php echo $jenis ?></label>
			<input type="text" name="nama" value="<?php echo $nama ?>">
			<input type="hidden" name="id" value="<?php echo $id ?>">
			<input type="hidden" name="jenis" value="<?php echo $jenis ?>">
		</div>
		<br>
		<input class="ui green button" type="submit" name="update" value="UPDATE">
	</form>
	<br>
	<a href="kriteria.php" class="ui button">Kembali</a>
</section>

<?php include('footer.php'); ?>

<!-- Tambahkan JavaScript untuk konfirmasi -->
<script>
	function confirmUpdate() {
		return confirm('Apakah Anda yakin ingin mengubah data ini?');
	}
</script>
