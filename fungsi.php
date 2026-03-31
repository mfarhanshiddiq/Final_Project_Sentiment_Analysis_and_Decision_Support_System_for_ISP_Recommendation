<?php
function clearPreviousResults($koneksi) {
    // Hapus semua entri di tabel ranking
    $deleteRankingQuery = "DELETE FROM ranking";
    $result = mysqli_query($koneksi, $deleteRankingQuery);
    if (!$result) {
        echo "Gagal menghapus data ranking: " . mysqli_error($koneksi);
        exit();
    }
    
}

// mencari ID kriteria
// berdasarkan urutan ke berapa (C1, C2, C3)
function getKriteriaID($no_urut) {
	include('config.php');
	$query  = "SELECT id FROM kriteria ORDER BY id";
	$result = mysqli_query($koneksi, $query);

	while ($row = mysqli_fetch_array($result)) {
		$listID[] = $row['id'];
	}

	return $listID[($no_urut)];
}

// mencari ID alternatif
// berdasarkan urutan ke berapa (A1, A2, A3)
function getAlternatifID($no_urut) {
	include('config.php');
	$query  = "SELECT id FROM alternatif ORDER BY id";
	$result = mysqli_query($koneksi, $query);

	while ($row = mysqli_fetch_array($result)) {
		$listID[] = $row['id'];
	}

	return $listID[($no_urut)];
}

// mencari nama kriteria
function getKriteriaNama($no_urut) {
    include('config.php');
    $query  = "SELECT nama FROM kriteria ORDER BY id";
    $result = mysqli_query($koneksi, $query);
    
    $nama = []; // Inisialisasi $nama sebagai array kosong
    
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $nama[] = $row['nama'];
        }
    }
    
    // Mengembalikan nama jika index array ada, jika tidak mengembalikan null atau string kosong
    return isset($nama[$no_urut]) ? $nama[$no_urut] : null;
}

// mencari nama alternatif
function getAlternatifNama($no_urut) {
    include('config.php');
    $query  = "SELECT nama FROM alternatif ORDER BY id";
    $result = mysqli_query($koneksi, $query);
    
    $nama = []; // Inisialisasi $nama sebagai array kosong
    
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $nama[] = $row['nama'];
        }
    }
    
    // Mengembalikan nama jika index array ada, jika tidak mengembalikan null atau string kosong
    return isset($nama[$no_urut]) ? $nama[$no_urut] : null;
}


// mencari priority vector alternatif
function getAlternatifPV($id_alternatif,$id_kriteria) {
	include('config.php');
	$query = "SELECT nilai FROM pv_alternatif WHERE id_alternatif=$id_alternatif AND id_kriteria=$id_kriteria";
	$result = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_array($result)) {
		$id_kriteria = $row['nilai'];
	}

	return $id_kriteria;
}

// mencari priority vector kriteria
function getKriteriaPV($id_kriteria) {
	include('config.php');
	$query = "SELECT nilai FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
	$result = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_array($result)) {
		$pv = $row['nilai'];
	}

	return $pv;
}

// mencari jumlah alternatif
// Fungsi untuk mendapatkan jumlah alternatif dari database
function getJumlahAlternatif() {
    global $koneksi; // Pastikan $koneksi didefinisikan di config.php
    
    $query = "SELECT COUNT(*) as jumlah FROM alternatif";  // Pastikan tabel 'alternatif' ada
    $result = mysqli_query($koneksi, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['jumlah'];
    } else {
        return 0;  // Jika query gagal, kembalikan 0
    }
}

// mencari jumlah kriteria
// Fungsi untuk mendapatkan jumlah kriteria dari database
function getJumlahKriteria() {
    global $koneksi; // Pastikan $koneksi didefinisikan di config.php
    
    $query = "SELECT COUNT(*) as jumlah FROM kriteria";  // Pastikan tabel 'kriteria' ada
    $result = mysqli_query($koneksi, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['jumlah'];
    } else {
        return 0;  // Jika query gagal, kembalikan 0
    }
}

// menambah data kriteria / alternatif
function tambahData($tabel,$nama) {
	include('config.php');

	$query 	= "INSERT INTO $tabel (nama) VALUES ('$nama')";
	$tambah	= mysqli_query($koneksi, $query);

	if (!$tambah) {
		echo "Gagal mmenambah data".$tabel;
		exit();
	}
}
// menambakan data guru
function tambahAlternatif($tabel, $nama, $nip, $jabatan) {
    include('config.php');

    // Menghindari SQL injection dengan menggunakan prepared statements
    $stmt = $koneksi->prepare("INSERT INTO $tabel (nama, nip, jabatan) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama, $nip, $jabatan); // s: string, i: integer

    // Eksekusi dan periksa hasilnya
    if ($stmt->execute()) {
        echo "Data berhasil ditambahkan.";
    } else {
        echo "Gagal menambah data: " . $stmt->error;
    }

    $stmt->close();
    $koneksi->close();
}
// edit alternatif
function getAlternatifById($id) {
    global $koneksi;
    $query = "SELECT * FROM alternatif WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
    return $data;
}


// Fungsi untuk memperbarui data alternatif
function updateDataAlternatif($id, $nama, $nip, $kategori) {
    global $koneksi;
    $query = "UPDATE alternatif SET nama = ?, nip = ?, kategori = ? WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("sssi", $nama, $nip, $kategori, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}


// hapus kriteria
function deleteKriteria($id) {
	include('config.php');

	// hapus record dari tabel kriteria
	$query 	= "DELETE FROM kriteria WHERE id=$id";
	mysqli_query($koneksi, $query);

	// hapus record dari tabel pv_kriteria
	$query 	= "DELETE FROM pv_kriteria WHERE id_kriteria=$id";
	mysqli_query($koneksi, $query);

	// hapus record dari tabel pv_alternatif
	$query 	= "DELETE FROM pv_alternatif WHERE id_kriteria=$id";
	mysqli_query($koneksi, $query);

	$query 	= "DELETE FROM perbandingan_kriteria WHERE kriteria1=$id OR kriteria2=$id";
	mysqli_query($koneksi, $query);

	$query 	= "DELETE FROM perbandingan_alternatif WHERE pembanding=$id";
	mysqli_query($koneksi, $query);
}

// hapus alternatif
function deleteAlternatif($id) {
    include('config.php');

    // Sanitize the input to avoid SQL Injection
    $id = mysqli_real_escape_string($koneksi, $id);

    // Pastikan id yang digunakan valid (integer)
    if (!is_numeric($id)) {
        echo "ID tidak valid.";
        return;
    }

    // Hapus record dari tabel alternatif
    $query  = "DELETE FROM alternatif WHERE id = $id";
    if (mysqli_query($koneksi, $query)) {
        echo "Data alternatif berhasil dihapus.";
    } else {
        // Tangkap kesalahan query
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
    
	// hapus record dari tabel pv_alternatif
	$query 	= "DELETE FROM pv_alternatif WHERE id_alternatif=$id";
	mysqli_query($koneksi, $query);

	// hapus record dari tabel ranking
	$query 	= "DELETE FROM ranking WHERE id_alternatif=$id";
	mysqli_query($koneksi, $query);

	$query 	= "DELETE FROM perbandingan_alternatif WHERE alternatif1=$id OR alternatif2=$id";
	mysqli_query($koneksi, $query);
}

// hapus guru
function deleteGuru($id_guru) {
	include('config.php');

	$query 	= "DELETE FROM guru WHERE id_guru=$id";
	mysqli_query($koneksi, $query);
}

// memasukkan nilai priority vektor kriteria
function inputKriteriaPV ($id_kriteria,$pv) {
	include ('config.php');

	$query = "SELECT * FROM pv_kriteria WHERE id_kriteria=$id_kriteria";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// jika result kosong maka masukkan data baru
	// jika telah ada maka diupdate
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO pv_kriteria (id_kriteria, nilai) VALUES ($id_kriteria, $pv)";
	} else {
		$query = "UPDATE pv_kriteria SET nilai=$pv WHERE id_kriteria=$id_kriteria";
	}


	$result = mysqli_query($koneksi, $query);
	if(!$result) {
		echo "Gagal memasukkan / update nilai priority vector kriteria";
		exit();
	}

}

// memasukkan nilai priority vektor alternatif
function inputAlternatifPV ($id_alternatif,$id_kriteria,$pv) {
	include ('config.php');

	$query  = "SELECT * FROM pv_alternatif WHERE id_alternatif = $id_alternatif AND id_kriteria = $id_kriteria";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// jika result kosong maka masukkan data baru
	// jika telah ada maka diupdate
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO pv_alternatif (id_alternatif,id_kriteria,nilai) VALUES ($id_alternatif,$id_kriteria,$pv)";
	} else {
		$query = "UPDATE pv_alternatif SET nilai=$pv WHERE id_alternatif=$id_alternatif AND id_kriteria=$id_kriteria";
	}

	$result = mysqli_query($koneksi, $query);
	if (!$result) {
		echo "Gagal memasukkan / update nilai priority vector alternatif";
		exit();
	}

}


// memasukkan bobot nilai perbandingan kriteria
function inputDataPerbandinganKriteria($kriteria1,$kriteria2,$nilai) {
	include('config.php');

	$id_kriteria1 = getKriteriaID($kriteria1);
	$id_kriteria2 = getKriteriaID($kriteria2);

	$query  = "SELECT * FROM perbandingan_kriteria WHERE kriteria1 = $id_kriteria1 AND kriteria2 = $id_kriteria2";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// jika result kosong maka masukkan data baru
	// jika telah ada maka diupdate
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO perbandingan_kriteria (kriteria1,kriteria2,nilai) VALUES ($id_kriteria1,$id_kriteria2,$nilai)";
	} else {
		$query = "UPDATE perbandingan_kriteria SET nilai=$nilai WHERE kriteria1=$id_kriteria1 AND kriteria2=$id_kriteria2";
	}

	$result = mysqli_query($koneksi, $query);
	if (!$result) {
		echo "Gagal memasukkan data perbandingan";
		exit();
	}

}

// memasukkan bobot nilai perbandingan alternatif
function inputDataPerbandinganAlternatif($alternatif1,$alternatif2,$pembanding,$nilai) {
	include('config.php');


	$id_alternatif1 = getAlternatifID($alternatif1);
	$id_alternatif2 = getAlternatifID($alternatif2);
	$id_pembanding  = getKriteriaID($pembanding);

	$query  = "SELECT * FROM perbandingan_alternatif WHERE alternatif1 = $id_alternatif1 AND alternatif2 = $id_alternatif2 AND pembanding = $id_pembanding";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	// jika result kosong maka masukkan data baru
	// jika telah ada maka diupdate
	if (mysqli_num_rows($result)==0) {
		$query = "INSERT INTO perbandingan_alternatif (alternatif1,alternatif2,pembanding,nilai) VALUES ($id_alternatif1,$id_alternatif2,$id_pembanding,$nilai)";
	} else {
		$query = "UPDATE perbandingan_alternatif SET nilai=$nilai WHERE alternatif1=$id_alternatif1 AND alternatif2=$id_alternatif2 AND pembanding=$id_pembanding";
	}

	$result = mysqli_query($koneksi, $query);
	if (!$result) {
		echo "Gagal memasukkan data perbandingan";
		exit();
	}

}

// mencari nilai bobot perbandingan kriteria
function getNilaiPerbandinganKriteria($kriteria1,$kriteria2) {
	include('config.php');

	$id_kriteria1 = getKriteriaID($kriteria1);
	$id_kriteria2 = getKriteriaID($kriteria2);

	$query  = "SELECT nilai FROM perbandingan_kriteria WHERE kriteria1 = $id_kriteria1 AND kriteria2 = $id_kriteria2";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}

	if (mysqli_num_rows($result)==0) {
		$nilai = 1;
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$nilai = $row['nilai'];
		}
	}

	return $nilai;
}

// mencari nilai bobot perbandingan alternatif
function getNilaiPerbandinganAlternatif($alternatif1,$alternatif2,$pembanding) {
	include('config.php');

	$id_alternatif1 = getAlternatifID($alternatif1);
	$id_alternatif2 = getAlternatifID($alternatif2);
	$id_pembanding  = getKriteriaID($pembanding);

	$query  = "SELECT nilai FROM perbandingan_alternatif WHERE alternatif1 = $id_alternatif1 AND alternatif2 = $id_alternatif2 AND pembanding = $id_pembanding";
	$result = mysqli_query($koneksi, $query);

	if (!$result) {
		echo "Error !!!";
		exit();
	}
	if (mysqli_num_rows($result)==0) {
		$nilai = 1;
	} else {
		while ($row = mysqli_fetch_array($result)) {
			$nilai = $row['nilai'];
		}
	}

	return $nilai;
}

// menampilkan nilai IR
function getNilaiIR($jmlKriteria) {
	include('config.php');
	$query  = "SELECT nilai FROM ir WHERE jumlah=$jmlKriteria";
	$result = mysqli_query($koneksi, $query);
	while ($row = mysqli_fetch_array($result)) {
		$nilaiIR = $row['nilai'];
	}

	return $nilaiIR;
}

// mencari Principe Eigen Vector (λ maks)
function getEigenVector($matrik_a,$matrik_b,$n) {
	$eigenvektor = 0;
	for ($i=0; $i <= ($n-1) ; $i++) {
		$eigenvektor += ($matrik_a[$i] * (($matrik_b[$i]) / $n));
	}

	return $eigenvektor;
}

// mencari Cons Index
function getConsIndex($matrik_a,$matrik_b,$n) {
	$eigenvektor = getEigenVector($matrik_a,$matrik_b,$n);
	$consindex = (($eigenvektor - $n)/$n-1);

	return $consindex;
}

// Mencari Consistency Ratio
function getConsRatio($matrik_a,$matrik_b,$n) {
	$consindex = getConsIndex($matrik_a,$matrik_b,$n);
	$consratio = $consindex / getNilaiIR($n);

	return $consratio;
}

// menampilkan tabel perbandingan bobot
function showTabelPerbandingan($jenis,$kriteria) {
	include('config.php');

	if ($kriteria == 'kriteria') {
		$n = getJumlahKriteria();
	} else {
		$n = getJumlahAlternatif();
	}

	$query = "SELECT nama FROM $kriteria ORDER BY id";
	$result	= mysqli_query($koneksi, $query);
	if (!$result) {
		echo "Error koneksi database!!!";
		exit();
	}

	// buat list nama pilihan
	while ($row = mysqli_fetch_array($result)) {
		$pilihan[] = $row['nama'];
	}

	// tampilkan tabel
	?>

	<form class="ui form" action="proses.php" method="post">
	<table class="ui celled selectable collapsing table">
		<thead>
			<tr>
				<th colspan="2">Pilih yang lebih penting</th>
				<th>Nilai perbandingan</th>
			</tr>
		</thead>
		<tbody>

	<?php

	//inisialisasi
	$urut = 0;

	for ($x=0; $x <= ($n - 2); $x++) {
		for ($y=($x+1); $y <= ($n - 1) ; $y++) {

			$urut++;

	?>
			<tr>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="1" checked="" class="hidden" type="radio">
							<label><?php echo $pilihan[$x]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="2" class="hidden" type="radio">
							<label><?php echo $pilihan[$y]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">

	<?php
	if ($kriteria == 'kriteria') {
		$nilai = getNilaiPerbandinganKriteria($x,$y);
	} else {
		$nilai = getNilaiPerbandinganAlternatif($x,$y,($jenis-1));
	}

	?>
						<input type="text" name="bobot<?php echo $urut?>" value="<?php echo $nilai?>" required>
					</div>
				</td>
			</tr>
			<?php
		}
	}

	?>
		</tbody>
	</table>
	<input type="text" name="jenis" value="<?php echo $jenis; ?>" hidden>
	<br><br><input class="ui submit button" type="submit" name="submit" value="SUBMIT">
	</form>

	<?php
}

?>