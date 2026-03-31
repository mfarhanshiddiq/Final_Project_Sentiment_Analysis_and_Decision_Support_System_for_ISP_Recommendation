<?php
include('config.php');
include('fungsi.php');
require('fpdf/fpdf.php');

// Buat instance FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Tambahkan logo
$logoPath = 'logo.jpg';
if (file_exists($logoPath)) {
    $pdf->Image($logoPath, 10, 10, 30);
} else {
    die('Error: File logo.jpg tidak ditemukan!');
}
$pdf->SetY(10);
$pdf->SetX(50);


// Menambahkan teks kop surat
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(110, 5, 'PEMERINTAH PROVINSI SUMATERA BARAT', 0, 1, 'C');
$pdf->Cell(190, 5, 'DINAS PENDIDIKAN', 0, 1, 'C');
$pdf->Cell(190, 5, 'SEKOLAH MENENGAH KEJURUAN NEGERI 6 PADANG', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, 'Jalan Suliki no. 1 Padang Timur, Padang 25121', 0, 1, 'C');
$pdf->Cell(190, 5, 'Telepon (0751) 21907, Email: smksixpadang@gmail.com', 0, 1, 'C');
$pdf->Ln(10);  // Beri jarak setelah kop surat
$pdf->Line(10, 40, 200, 40);  // Garis horizontal


// Menambahkan garis horizontal
$pdf->Line(10, 40, 200, 40);  // Garis horizontal pada y=40

// Bagian Judul Laporan
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Hasil Pemilihan Guru Terbaik', 0, 1, 'C');
$pdf->Ln(10); // Menambahkan jarak

// Bagian 1: Tabel Hasil Perhitungan
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(7, 10, 'No', 1);  // Kolom nomor
$pdf->Cell(38, 10, 'Kriteria', 1);
$pdf->Cell(27, 10, 'Priority Vector', 1);

// Menambahkan header untuk alternatif
$jmlAlternatif = getJumlahAlternatif();
for ($i = 0; $i < $jmlAlternatif; $i++) {
    $namaAlternatif = getAlternatifNama($i);
    $pdf->Cell(25, 10, $namaAlternatif, 1);
}
$pdf->Ln();

// Menambahkan data hasil perhitungan
$jmlKriteria = getJumlahKriteria();
$pdf->SetFont('Arial', '', 10);

// Variabel untuk menghitung total
$totalPriorityVector = 0;
$totalAlternatif = array_fill(0, $jmlAlternatif, 0);

for ($x = 0; $x < $jmlKriteria; $x++) {
    $priorityVector = round(getKriteriaPV(getKriteriaID($x)), 5);
    $totalPriorityVector += $priorityVector;

    $pdf->Cell(7, 10, $x + 1, 1);  // Nomor urut
    $pdf->Cell(38, 10, getKriteriaNama($x), 1);
    $pdf->Cell(27, 10, $priorityVector, 1);

    for ($y = 0; $y < $jmlAlternatif; $y++) {
        $nilai = round(getAlternatifPV(getAlternatifID($y), getKriteriaID($x)), 5);
        $totalAlternatif[$y] += $nilai;
        $pdf->Cell(25, 10, $nilai, 1);
    }

    $pdf->Ln();
}

// Menambahkan baris total untuk alternatif
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(72, 10, 'Total', 1, 0, 'C');  // Gabungkan kolom "No", "Kriteria", dan "Priority Vector"
for ($i = 0; $i < $jmlAlternatif; $i++) {
    $pdf->Cell(25, 10, round($totalAlternatif[$i], 5), 1);
}
$pdf->Ln();

// Bagian 2: Peringkat
$pdf->Ln(10); // Tambahkan jarak
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Peringkat', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(8, 10, 'No', 1);
$pdf->Cell(35, 10, 'Alternatif', 1);
$pdf->Cell(25, 10, 'Nilai', 1);
$pdf->Cell(25, 10, 'Status', 1);
$pdf->Ln();

// Query untuk peringkat alternatif yang disetujui
$query = "SELECT a.nama, r.nilai, a.status
          FROM alternatif a
          JOIN ranking r
          ON a.id = r.id_alternatif
          WHERE a.status = 'Disetujui'
          ORDER BY r.nilai DESC";
$result = mysqli_query($koneksi, $query);

$i = 0;
$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_array($result)) {
    $i++;
    $pdf->Cell(8, 10, $i, 1);
    $pdf->Cell(35, 10, htmlspecialchars($row['nama']), 1);
    $pdf->Cell(25, 10, round($row['nilai'], 5), 1);
    $pdf->Cell(25, 10, ($row['status'] == 'Disetujui') ? 'Disetujui' : 'Tidak Disetujui', 1);
    $pdf->Ln();
}

// Tambahkan tempat tanda tangan di bagian bawah laporan
$pdf->SetY(-60);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(120, 5, '', 0, 0, 'L');
$pdf->Cell(32, 5, 'Padang,', 0, 1, 'C');
$pdf->Cell(120, 5, '', 0, 0, 'L');
$pdf->Cell(60, 5, 'Pengawas Pemilihan Guru', 0, 1, 'C');
$pdf->Ln(10);
$pdf->Cell(120, 5, '', 0, 0, 'L');
$pdf->Cell(71, 5, 'RDS. Deta Mahendra, S. Pd, MM', 0, 1, 'C');
$pdf->Cell(120, 5, '', 0, 0, 'L');
$pdf->Cell(62, 5, 'NIP. 197406062005011010', 0, 1, 'C');
// Output PDF
$pdf->Output('I', 'laporan_hasil.pdf');  // 'I' untuk menampilkan di browser, 'D' untuk download
?>
