<?php
include('config.php');
include('fungsi.php');

// header pengawas yang sudah memuat session check
include('header.php');
?>


    <!-- Bagian Konten -->
    <section class="content">
        <h2>Selamat Datang, Admin!</h2>
        <h2 class="ui header">Analytical Hierarchy Process (AHP)</h2>
        <p>Analytic Hierarchy Process (AHP) merupakan suatu model pendukung keputusan yang dikembangkan oleh Thomas L. Saaty. Model ini menguraikan masalah multi faktor atau multi kriteria yang kompleks menjadi suatu hirarki. Hirarki  didefinisikan sebagai representasi dari permasalahan kompleks dalam struktur multi level dimana level pertama adalah tujuan, yang diikuti oleh level faktor, kriteria, sub kriteria, dan seterusnya hingga level terakhir dari alternatif.</p>

        <p>AHP sering digunakan karena struktur hirarki, validitas dalam perbandingan kriteria dan alternatif, serta daya tahan terhadap analisis sensitivitas dalam pengambilan keputusan.</p>

        <ol class="ui list">
            <li>Struktur yang berhirarki berdasarkan kriteria dan subkriteria.</li>
            <li>Validitas hingga batas toleransi inkonsistensi kriteria dan alternatif.</li>
            <li>Daya tahan terhadap analisis sensitivitas.</li>
        </ol>
        
        <p>
            Sistem Pemilihan Provider Ideal menggunakan metode Analytical Hierarchy Process (AHP) untuk mempermudah 
            pengambilan keputusan secara akurat berdasarkan kriteria yang telah ditentukan.
        </p>

        <h3>Langkah-Langkah:</h3>
        <ol>
            <li>Tambah dan kelola <strong>Kriteria</strong> penilaian.</li>
            <li>Input dan kelola <strong>Alternatif</strong> (Povider).</li>
            <li>Hitung hasil <strong>Ranking</strong> untuk menentukan provider ideal.</li>
            <li>Download <strong>Laporan Hasil</strong> sebagai dokumen resmi.</li>
        </ol>

    </section>
</div>

<?php include('footer.php'); ?>
