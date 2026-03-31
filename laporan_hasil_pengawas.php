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
include('header_pengawas.php');
?>

<section class="content">
    <h2 class="ui header">Hasil Perhitungan</h2>
    <table class="ui celled table">
        <thead>
            <tr>
                <th>Kriteria</th>
                <th>Priority Vector (rata-rata)</th>
                <?php
                for ($i = 0; $i < $jmlAlternatif; $i++) { 
                    echo "<th>" . getAlternatifNama($i) . "</th>\n";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($x = 0; $x < $jmlKriteria; $x++) { 
                echo "<tr>";
                echo "<td>" . getKriteriaNama($x) . "</td>";
                echo "<td>" . round(getKriteriaPV(getKriteriaID($x)), 5) . "</td>";

                for ($y = 0; $y < $jmlAlternatif; $y++) { 
                    echo "<td>" . round(getAlternatifPV(getAlternatifID($y), getKriteriaID($x)), 5) . "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <?php
                for ($i = 0; $i < $jmlAlternatif; $i++) { 
                    if (isset($nilai[$i])) {
                        echo "<th>" . round($nilai[$i], 5) . "</th>";
                    } else {
                        echo "<th>-</th>"; // Jika tidak ada, tampilkan tanda -
                    }
                }
                ?>
            </tr>
        </tfoot>
    </table>


<?php include('footer.php'); ?>
