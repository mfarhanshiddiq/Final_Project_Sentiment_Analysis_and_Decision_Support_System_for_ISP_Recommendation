<?php
include('config.php');
include('fungsi.php');

// Panggil fungsi untuk menghapus hasil penilaian
clearPreviousResults($koneksi); // Pastikan fungsi ini ada di fungsi.php

// Menghitung perangkingan setelah menghapus hasil sebelumnya
$jmlKriteria    = getJumlahKriteria();
$jmlAlternatif  = getJumlahAlternatif();
$nilai          = array();

// Mendapatkan nilai tiap alternatif
for ($x = 0; $x < $jmlAlternatif; $x++) {
    $nilai[$x] = 0; // Inisialisasi nilai untuk setiap alternatif

    for ($y = 0; $y < $jmlKriteria; $y++) {
        $id_alternatif  = getAlternatifID($x);
        $id_kriteria    = getKriteriaID($y);

        $pv_alternatif  = getAlternatifPV($id_alternatif, $id_kriteria);
        $pv_kriteria    = getKriteriaPV($id_kriteria);

        // Validasi nilai alternatif dan kriteria
        if (is_numeric($pv_alternatif) && is_numeric($pv_kriteria)) {
            $nilai[$x] += ($pv_alternatif * $pv_kriteria); // Hitung total nilai
        }
    }
}

// Update nilai ranking
for ($i = 0; $i < $jmlAlternatif; $i++) { 
    $id_alternatif = getAlternatifID($i);
    $query = "INSERT INTO ranking (id_alternatif, nilai) VALUES ($id_alternatif, $nilai[$i]) ON DUPLICATE KEY UPDATE nilai=$nilai[$i]";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Gagal mengupdate ranking";
        exit();
    }
}

// Header
include('header.php');
?>



    <section class="content">
    <h2 class="ui header">Perangkingan</h2>
    <table class="ui celled collapsing table">
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Alternatif</th>
                <th>Nilai</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            $query  = "SELECT a.id AS id, a.nama AS nama, r.id_alternatif AS id_alternatif, r.nilai AS nilai, a.status AS status 
                       FROM alternatif a 
                       JOIN ranking r 
                       ON a.id = r.id_alternatif 
                       ORDER BY r.nilai DESC";
            $result = mysqli_query($koneksi, $query);

            if (!$result) {
                die("Query Error: " . mysqli_error($koneksi));
            }

            $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                $i++;
            ?>
                <tr>
                    <td><?php echo ($i == 1) ? "<div class='ui ribbon label'>Pertama</div>" : $i; ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo $row['nilai']; ?></td>
                    

                </tr>
            <?php   
            }
            ?>
        </tbody>
    </table>
    
</section>

<?php include('footer.php'); ?>
