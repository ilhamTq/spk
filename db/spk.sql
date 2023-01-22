-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Inang: 127.0.0.1
-- Waktu pembuatan: 23 Agu 2016 pada 06.55
-- Versi Server: 5.5.32
-- Versi PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Basis data: `spk_susu`
--
CREATE DATABASE IF NOT EXISTS `spk_susu` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `spk_susu`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id_admin` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `username` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `level` varchar(10) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `nama`, `username`, `password`, `level`) VALUES
(1, 'user', 'user', '21232f297a57a5a743894a0e4a801fc3', 'pimpinan'),
(2, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'entry');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria_produk`
--

CREATE TABLE IF NOT EXISTS `kriteria_produk` (
  `id_kriteria_produk` int(11) NOT NULL AUTO_INCREMENT,
  `kode_kriteria_produk` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `nama_kriteria_produk` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_kriteria_produk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=8 ;

--
-- Dumping data untuk tabel `kriteria_produk`
--

INSERT INTO `kriteria_produk` (`id_kriteria_produk`, `kode_kriteria_produk`, `nama_kriteria_produk`) VALUES
(2, 'K02', 'Vitamin Kompleks'),
(3, 'K03', 'Kalsium'),
(4, 'K04', 'Glukosa'),
(5, 'K05', 'Lemak'),
(7, 'K09', 'Harga');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_kriteria_produk`
--

CREATE TABLE IF NOT EXISTS `nilai_kriteria_produk` (
  `id_nilai_kriteria_produk` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria_produk_1` int(11) NOT NULL,
  `id_kriteria_produk_2` int(11) NOT NULL,
  `nilai` float NOT NULL,
  `teknis` enum('1','2') COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_nilai_kriteria_produk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=11 ;

--
-- Dumping data untuk tabel `nilai_kriteria_produk`
--

INSERT INTO `nilai_kriteria_produk` (`id_nilai_kriteria_produk`, `id_kriteria_produk_1`, `id_kriteria_produk_2`, `nilai`, `teknis`) VALUES
(1, 2, 3, 2, NULL),
(2, 2, 4, 2, NULL),
(3, 2, 5, 3, NULL),
(4, 2, 7, 2, NULL),
(5, 3, 4, 3, NULL),
(6, 3, 5, 3, NULL),
(7, 3, 7, 2, NULL),
(8, 4, 5, 1, NULL),
(9, 4, 7, 2, NULL),
(10, 5, 7, 3, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_produk`
--

CREATE TABLE IF NOT EXISTS `nilai_produk` (
  `id_nilai_produk` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria_produk` int(11) NOT NULL,
  `id_produk_1` int(11) NOT NULL,
  `id_produk_2` int(11) NOT NULL,
  `nilai` float NOT NULL,
  PRIMARY KEY (`id_nilai_produk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=509 ;

--
-- Dumping data untuk tabel `nilai_produk`
--

INSERT INTO `nilai_produk` (`id_nilai_produk`, `id_kriteria_produk`, `id_produk_1`, `id_produk_2`, `nilai`) VALUES
(489, 0, 8, 9, 0.1),
(488, 0, 5, 9, 0.4),
(487, 0, 5, 8, 3),
(486, 0, 4, 9, 2),
(485, 0, 4, 8, 3),
(484, 0, 4, 5, 6),
(483, 0, 3, 9, 5),
(482, 0, 3, 8, 1),
(481, 0, 3, 5, 6),
(480, 0, 3, 4, 2),
(136, 5, 4, 5, 1),
(135, 5, 3, 5, 3),
(134, 5, 3, 4, 3),
(133, 5, 2, 5, 3),
(132, 5, 2, 4, 0.25),
(131, 5, 2, 3, 7),
(130, 5, 1, 5, 0.1),
(129, 5, 1, 4, 3),
(128, 5, 1, 3, 0.02),
(127, 5, 1, 2, 6),
(239, 3, 5, 8, 2),
(238, 3, 4, 8, 3),
(237, 3, 4, 5, 2),
(236, 3, 3, 8, 3),
(235, 3, 3, 5, 2),
(234, 3, 3, 4, 2),
(233, 3, 1, 8, 2),
(232, 3, 1, 5, 0.333),
(231, 3, 1, 4, 0.25),
(230, 3, 1, 3, 0.2),
(96, 2, 4, 5, 4),
(95, 2, 3, 5, 2),
(94, 2, 3, 4, 8),
(93, 2, 2, 5, 3),
(92, 2, 2, 4, 3),
(91, 2, 2, 3, 6),
(90, 2, 1, 5, 5),
(89, 2, 1, 4, 1),
(88, 2, 1, 3, 2),
(87, 2, 1, 2, 2),
(209, 4, 5, 8, 3),
(208, 4, 4, 8, 2),
(207, 4, 4, 5, 4),
(206, 4, 3, 8, 2),
(205, 4, 3, 5, 2),
(204, 4, 3, 4, 2),
(203, 4, 1, 8, 2),
(202, 4, 1, 5, 2),
(201, 4, 1, 4, 3),
(200, 4, 1, 3, 5),
(479, 0, 1, 9, 3),
(478, 0, 1, 8, 1),
(477, 0, 1, 5, 8),
(476, 0, 1, 4, 2),
(475, 0, 1, 3, 2),
(460, 7, 1, 3, 1),
(461, 7, 1, 4, 1),
(462, 7, 1, 5, 1),
(463, 7, 1, 8, 1),
(464, 7, 1, 9, 1),
(465, 7, 3, 4, 1),
(466, 7, 3, 5, 1),
(467, 7, 3, 8, 1),
(468, 7, 3, 9, 1),
(469, 7, 4, 5, 1),
(470, 7, 4, 8, 1),
(471, 7, 4, 9, 1),
(472, 7, 5, 8, 1),
(473, 7, 5, 9, 1),
(474, 7, 8, 9, 1),
(490, 3, 1, 9, 1),
(491, 3, 3, 9, 1),
(492, 3, 4, 9, 1),
(493, 3, 5, 9, 1),
(494, 3, 8, 9, 1),
(495, 2, 1, 8, 1),
(496, 2, 1, 9, 1),
(497, 2, 3, 8, 1),
(498, 2, 3, 9, 1),
(499, 2, 4, 8, 1),
(500, 2, 4, 9, 1),
(501, 2, 5, 8, 1),
(502, 2, 5, 9, 1),
(503, 2, 8, 9, 1),
(504, 4, 1, 9, 1),
(505, 4, 3, 9, 1),
(506, 4, 4, 9, 1),
(507, 4, 5, 9, 1),
(508, 4, 8, 9, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `nama_produk` varchar(50) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=10 ;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `kode_produk`, `nama_produk`) VALUES
(1, 'K01', 'Frisianflag 123'),
(9, 'P0ii', 'Susu kaleng'),
(3, 'K03', 'SGM Explore'),
(4, 'K04', 'Pediasure'),
(5, 'K05', 'Bebelac'),
(8, 'K08', 'Dancow 123');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
