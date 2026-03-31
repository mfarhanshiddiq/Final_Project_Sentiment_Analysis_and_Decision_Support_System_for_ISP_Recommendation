-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Feb 2025 pada 07.14
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_guru`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `nip` varchar(100) NOT NULL,
  `kategori` enum('Guru Jurusan','Guru Umum') NOT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id`, `id_alternatif`, `nama`, `nip`, `kategori`, `status`) VALUES
(64, 0, 'Efrizal', '-', 'Guru Jurusan', 'Pending'),
(63, 0, 'Bulhadi', '198312312023211048', 'Guru Jurusan', 'Pending'),
(61, 0, 'Elga Elfira', '198406082009012002', 'Guru Jurusan', 'Disetujui'),
(62, 0, 'Mega Amelia', '198409082010012025', 'Guru Jurusan', 'Disetujui'),
(65, 0, 'Yefri  Asril', '-', 'Guru Jurusan', 'Pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ir`
--

CREATE TABLE `ir` (
  `jumlah` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ir`
--

INSERT INTO `ir` (`jumlah`, `nilai`) VALUES
(1, 0),
(2, 0),
(3, 0.58),
(4, 0.9),
(5, 1.12),
(6, 1.24),
(7, 1.32),
(8, 1.41),
(9, 1.45),
(10, 1.49);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama`) VALUES
(74, 'Prestasi'),
(75, 'Profesional'),
(76, 'Masa Kerja'),
(73, 'Keterampilan Mengajar'),
(72, 'Kehadiran');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','pengawas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `username`, `password`, `foto`, `created_at`, `role`) VALUES
(1, 'Wakil Kurikulum', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, '2024-12-03 04:32:54', 'admin'),
(2, 'Kepala Sekolah', 'pengawas', 'f414face756c143bb2be71c33c978073', NULL, '2024-11-03 11:03:37', 'pengawas');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbandingan_alternatif`
--

CREATE TABLE `perbandingan_alternatif` (
  `id` int(11) NOT NULL,
  `alternatif1` int(11) NOT NULL,
  `alternatif2` int(11) NOT NULL,
  `pembanding` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `perbandingan_alternatif`
--

INSERT INTO `perbandingan_alternatif` (`id`, `alternatif1`, `alternatif2`, `pembanding`, `nilai`) VALUES
(160, 64, 65, 73, 4),
(159, 63, 65, 73, 4),
(158, 63, 64, 73, 2),
(157, 62, 65, 73, 4),
(156, 62, 64, 73, 3),
(155, 62, 63, 73, 2),
(154, 61, 65, 73, 4),
(153, 61, 64, 73, 3),
(152, 61, 63, 73, 2),
(151, 61, 62, 73, 3),
(170, 64, 65, 74, 3),
(169, 63, 65, 74, 2),
(168, 63, 64, 74, 3),
(167, 62, 65, 74, 2),
(166, 62, 64, 74, 3),
(165, 62, 63, 74, 2),
(164, 61, 65, 74, 3),
(163, 61, 64, 74, 3),
(162, 61, 63, 74, 2),
(161, 61, 62, 74, 2),
(190, 64, 65, 76, 2),
(189, 63, 65, 76, 2),
(188, 63, 64, 76, 2),
(187, 62, 65, 76, 2),
(186, 62, 64, 76, 3),
(185, 62, 63, 76, 3),
(184, 61, 65, 76, 4),
(183, 61, 64, 76, 4),
(182, 61, 63, 76, 4),
(181, 61, 62, 76, 4),
(180, 64, 65, 75, 2),
(179, 63, 65, 75, 2),
(178, 63, 64, 75, 2),
(177, 62, 65, 75, 2),
(176, 62, 64, 75, 3),
(175, 62, 63, 75, 3),
(174, 61, 65, 75, 3),
(173, 61, 64, 75, 3),
(172, 61, 63, 75, 3),
(171, 61, 62, 75, 3),
(150, 64, 65, 72, 2),
(149, 63, 65, 72, 4),
(148, 63, 64, 72, 2),
(147, 62, 65, 72, 3),
(146, 62, 64, 72, 2),
(145, 62, 63, 72, 2),
(144, 61, 65, 72, 3),
(143, 61, 64, 72, 2),
(142, 61, 63, 72, 2),
(141, 61, 62, 72, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `perbandingan_kriteria`
--

CREATE TABLE `perbandingan_kriteria` (
  `id` int(11) NOT NULL,
  `kriteria1` int(11) NOT NULL,
  `kriteria2` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `perbandingan_kriteria`
--

INSERT INTO `perbandingan_kriteria` (`id`, `kriteria1`, `kriteria2`, `nilai`) VALUES
(31, 72, 75, 3),
(34, 73, 75, 2),
(33, 73, 74, 2),
(38, 75, 76, 5),
(37, 74, 76, 5),
(36, 74, 75, 3),
(35, 73, 76, 3),
(32, 72, 76, 5),
(30, 72, 74, 2),
(29, 72, 73, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pv_alternatif`
--

CREATE TABLE `pv_alternatif` (
  `id` int(11) NOT NULL,
  `id_alternatif` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pv_alternatif`
--

INSERT INTO `pv_alternatif` (`id`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(80, 65, 73, 0.0563915),
(79, 64, 73, 0.126773),
(78, 63, 73, 0.186136),
(77, 62, 73, 0.248419),
(76, 61, 73, 0.38228),
(85, 65, 74, 0.0898532),
(84, 64, 74, 0.125713),
(83, 63, 74, 0.189291),
(82, 62, 74, 0.246653),
(81, 61, 74, 0.348489),
(95, 65, 76, 0.080033),
(94, 64, 76, 0.102333),
(93, 63, 76, 0.132492),
(92, 62, 76, 0.217606),
(91, 61, 76, 0.467536),
(90, 65, 75, 0.0909526),
(89, 64, 75, 0.115027),
(88, 63, 75, 0.14858),
(87, 62, 75, 0.245439),
(86, 61, 75, 0.400001),
(75, 65, 72, 0.0749136),
(74, 64, 72, 0.131077),
(73, 63, 72, 0.205904),
(72, 62, 72, 0.231552),
(71, 61, 72, 0.356552);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pv_kriteria`
--

CREATE TABLE `pv_kriteria` (
  `id_kriteria` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pv_kriteria`
--

INSERT INTO `pv_kriteria` (`id_kriteria`, `nilai`) VALUES
(76, 0.0532771),
(74, 0.216544),
(73, 0.232974),
(75, 0.135812),
(72, 0.361393);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ranking`
--

CREATE TABLE `ranking` (
  `id_alternatif` int(11) NOT NULL,
  `nilai` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `ranking`
--

INSERT INTO `ranking` (`id_alternatif`, `nilai`) VALUES
(61, 0.372614),
(62, 0.239895),
(63, 0.186005),
(64, 0.125202),
(65, 0.0762846);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alternatif` (`id_alternatif`);

--
-- Indeks untuk tabel `ir`
--
ALTER TABLE `ir`
  ADD PRIMARY KEY (`jumlah`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `perbandingan_alternatif`
--
ALTER TABLE `perbandingan_alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pv_alternatif`
--
ALTER TABLE `pv_alternatif`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `pv_kriteria`
--
ALTER TABLE `pv_kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `perbandingan_alternatif`
--
ALTER TABLE `perbandingan_alternatif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT untuk tabel `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `pv_alternatif`
--
ALTER TABLE `pv_alternatif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
