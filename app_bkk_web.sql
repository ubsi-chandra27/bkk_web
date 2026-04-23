-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Apr 2026 pada 14.44
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_bkk_web`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2026-04-21-140800', 'App\\Database\\Migrations\\AlterTracerAktivitasNullable', 'default', 'App', 1776780407, 1),
(2, '2026-04-22-090000', 'App\\Database\\Migrations\\AddStatusPendaftaranToPelamar', 'default', 'App', 1776861631, 2),
(3, '2026-04-22-140800', 'App\\Database\\Migrations\\CreateTbJenisBerkas', 'default', 'App', 1776866953, 3),
(4, '2026-04-22-140833', 'App\\Database\\Migrations\\CreateTbSyaratBerkas', 'default', 'App', 1776867168, 4),
(5, '2026-04-22-110000', 'App\\Database\\Migrations\\RefactorBerkasStructure', 'default', 'App', 1776868513, 5),
(6, '2026-04-23-065117', 'App\\Database\\Migrations\\CreateTbBerkasLamaran', 'default', 'App', 1776927450, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Profil detail admin (BKK & DUDI)';

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `id_user`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `telepon`, `alamat`, `foto`, `created_at`, `updated_at`) VALUES
(1, 1, 'L', 'Jakarta', '2026-04-01', '01234356756', 'Menteng', '1775480118_3b6fe0571e1db9530e05.jpg', '2026-04-03 07:51:09', '2026-04-06 12:55:18'),
(3, 3, 'P', 'Jakarta', '2000-02-17', '08974567857', '', NULL, '2026-04-03 15:50:14', '2026-04-03 15:50:14'),
(23, 37, 'L', '', '2000-02-17', '08974567857', 'rusia', '1775482178_d6a6a5b7d04c3894d300.jpg', '2026-04-06 13:29:38', '2026-04-09 13:09:55'),
(25, 46, 'P', '', '2000-02-17', '08974567857', 'rusia', '1775666044_76540d124c6f19c0c525.jpg', '2026-04-08 16:34:04', '2026-04-09 13:09:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_aktivitas`
--

CREATE TABLE `tb_aktivitas` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_aktivitas` varchar(100) NOT NULL COMMENT 'Bekerja, Kuliah, Wirausaha, Belum Bekerja',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master status aktivitas alumni untuk tracer study';

--
-- Dumping data untuk tabel `tb_aktivitas`
--

INSERT INTO `tb_aktivitas` (`id`, `nama_aktivitas`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Bekerja', 1, '2026-04-01 14:21:12', '2026-04-01 14:21:12'),
(2, 'Kuliah', 1, '2026-04-01 14:21:12', '2026-04-01 14:21:12'),
(3, 'Wirausaha', 1, '2026-04-01 14:21:12', '2026-04-01 14:21:12'),
(4, 'Mencari Kerja', 1, '2026-04-01 14:21:12', '2026-04-16 14:57:38'),
(5, 'Berencana Kuliah', 1, '2026-04-16 14:58:30', '2026-04-16 14:58:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_alumni`
--

CREATE TABLE `tb_alumni` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pelamar` int(10) UNSIGNED NOT NULL,
  `id_angkatan` int(10) UNSIGNED DEFAULT NULL,
  `id_jurusan` int(10) UNSIGNED DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `no_ijazah` varchar(50) DEFAULT NULL,
  `is_verifikasi` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data khusus pelamar alumni';

--
-- Dumping data untuk tabel `tb_alumni`
--

INSERT INTO `tb_alumni` (`id`, `id_pelamar`, `id_angkatan`, `id_jurusan`, `nis`, `nisn`, `no_ijazah`, `is_verifikasi`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 1, '0986767685', '870878645465', '6645358658778', 0, '2026-04-16 15:41:04', '2026-04-17 17:48:31'),
(2, 5, 4, 2, '1220087372221', '3231231231231', '11122232122121', 0, '2026-04-21 12:57:20', '2026-04-21 12:57:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_angkatan`
--

CREATE TABLE `tb_angkatan` (
  `id` int(10) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL COMMENT 'Tahun lulus',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master tahun angkatan/lulus';

--
-- Dumping data untuk tabel `tb_angkatan`
--

INSERT INTO `tb_angkatan` (`id`, `tahun`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '2022', 1, '2026-04-07 13:56:43', '2026-04-07 13:56:43'),
(3, '2021', 1, '2026-04-20 12:53:11', '2026-04-20 12:53:11'),
(4, '2020', 1, '2026-04-20 12:53:20', '2026-04-20 12:53:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_berkas`
--

CREATE TABLE `tb_berkas` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pelamar` int(10) UNSIGNED NOT NULL,
  `id_jenis_berkas` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `nama_file` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `status` enum('belum','pending','valid','ditolak') DEFAULT 'belum',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Dokumen/berkas upload pelamar';

--
-- Dumping data untuk tabel `tb_berkas`
--

INSERT INTO `tb_berkas` (`id`, `id_pelamar`, `id_jenis_berkas`, `nama_file`, `path_file`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 0, 'Bean.pdf', 'uploads/berkas/1776421732_8b55907daa39dd682919.pdf', '', '2026-04-17 10:28:52', '2026-04-17 10:28:52'),
(2, 2, 0, 'download.jpeg', 'uploads/berkas/1776421896_5349cf7cc02d9c98429e.jpeg', '', '2026-04-17 10:31:36', '2026-04-17 10:31:36'),
(3, 2, 0, 'Bukti Ujian 19220744 (803).pdf', 'uploads/berkas/1776447803_189da192bb1db876185f.pdf', '', '2026-04-17 17:41:05', '2026-04-17 17:43:23'),
(4, 2, 1, 'Bukti Ujian 19220744 (0065).pdf', 'uploads/berkas/1776869797_93971720f528b42fd865.pdf', '', '2026-04-22 14:56:37', '2026-04-22 14:56:37'),
(5, 2, 3, 'Bukti Ujian 19220744 (221).pdf', 'uploads/berkas/1776929257_ed1f16bf3c3f800abfa0.pdf', '', '2026-04-23 07:27:37', '2026-04-23 07:27:37'),
(6, 2, 4, 'Bukti Ujian 19220744 (620) (1).pdf', 'uploads/berkas/1776929272_205376a15e19d42dfc97.pdf', '', '2026-04-23 07:27:52', '2026-04-23 07:27:52'),
(7, 2, 5, 'Bukti Ujian 19220744 (0098).pdf', 'uploads/berkas/1776929282_88d4541c26d9aff8f7e9.pdf', '', '2026-04-23 07:28:02', '2026-04-23 07:28:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_berkas_lamaran`
--

CREATE TABLE `tb_berkas_lamaran` (
  `id` int(20) UNSIGNED NOT NULL,
  `id_lamaran` int(10) UNSIGNED NOT NULL,
  `id_jenis_berkas` int(10) UNSIGNED NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_size` int(11) UNSIGNED DEFAULT NULL COMMENT 'Ukuran file dalam bytes',
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_berkas_lamaran`
--

INSERT INTO `tb_berkas_lamaran` (`id`, `id_lamaran`, `id_jenis_berkas`, `file_path`, `file_name`, `file_size`, `uploaded_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 9, 2, 'uploads/lamaran/1776929306_c6b8a2d27fe2fee8acd9.pdf', 'Bean.pdf', 157560, '2026-04-23 07:28:26', '2026-04-23 07:28:26', '2026-04-23 07:28:26', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_identitas_sekolah`
--

CREATE TABLE `tb_identitas_sekolah` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_sekolah` varchar(150) NOT NULL,
  `singkatan` varchar(50) DEFAULT NULL,
  `npsn` varchar(20) DEFAULT NULL,
  `nss` varchar(30) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `kepala_sekolah` varchar(150) DEFAULT NULL,
  `nip_kepala_sekolah` varchar(30) DEFAULT NULL,
  `akreditasi` enum('A','B','C','Belum') DEFAULT NULL,
  `tahun_akreditasi` year(4) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Identitas sekolah — hanya 1 baris data';

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jenis_berkas`
--

CREATE TABLE `tb_jenis_berkas` (
  `id_jenis_berkas` int(10) UNSIGNED NOT NULL,
  `nama_berkas` varchar(100) NOT NULL,
  `slug_berkas` varchar(50) NOT NULL,
  `berlaku_untuk` enum('semua','alumni','umum') NOT NULL DEFAULT 'semua',
  `keterangan` text DEFAULT NULL,
  `status_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `dibuat_pada` datetime DEFAULT NULL,
  `diperbarui_pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_jenis_berkas`
--

INSERT INTO `tb_jenis_berkas` (`id_jenis_berkas`, `nama_berkas`, `slug_berkas`, `berlaku_untuk`, `keterangan`, `status_aktif`, `dibuat_pada`, `diperbarui_pada`) VALUES
(1, 'CV / Resume', 'cv', 'semua', 'Curriculum vitae atau resume pelamar', 1, '2026-04-22 14:35:13', '2026-04-22 14:35:13'),
(2, 'Surat Lamaran', 'surat_lamaran', 'semua', 'Surat lamaran kerja berdasarkan lamaran\r\n', 1, '2026-04-22 14:35:13', '2026-04-23 08:22:37'),
(3, 'Ijazah', 'ijazah', 'semua', 'Ijazah terakhir', 1, '2026-04-22 14:35:13', '2026-04-22 14:35:13'),
(4, 'KTP', 'ktp', 'semua', 'Kartu Tanda Penduduk', 1, '2026-04-22 14:35:13', '2026-04-22 14:35:13'),
(5, 'SKCK', 'skck', 'semua', 'Surat Keterangan Catatan Kepolisian', 1, '2026-04-22 14:35:13', '2026-04-22 14:35:13'),
(6, 'Portofolio', 'porto', 'semua', 'Portofolio Pelamar', 1, '2026-04-23 08:21:59', '2026-04-23 08:26:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_jurusan`
--

CREATE TABLE `tb_jurusan` (
  `id` int(10) UNSIGNED NOT NULL,
  `kompetensi_keahlian` varchar(150) NOT NULL,
  `akronim` varchar(20) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master kompetensi keahlian/jurusan';

--
-- Dumping data untuk tabel `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `kompetensi_keahlian`, `akronim`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Teknik Komputer dan Jaringan', 'TKJ', 1, '2026-04-07 14:22:28', '2026-04-07 14:22:28'),
(2, 'Rekayasa Perangkat Lunak', 'RPL', 1, '2026-04-20 12:53:54', '2026-04-20 12:53:54'),
(3, 'Teknik Kendaraan Ringan', 'TKR', 1, '2026-04-20 12:54:20', '2026-04-20 12:54:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kerjasama`
--

CREATE TABLE `tb_kerjasama` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_kerjasama` varchar(150) NOT NULL COMMENT 'PKL, Kunjungan Industri, Penguji UKK, dll',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master jenis kerjasama dengan DUDI';

--
-- Dumping data untuk tabel `tb_kerjasama`
--

INSERT INTO `tb_kerjasama` (`id`, `nama_kerjasama`, `created_at`, `updated_at`) VALUES
(1, 'Praktik Kerja Lapangan (PKL)', '2026-04-01 14:21:13', '2026-04-01 14:21:13'),
(2, 'Kunjungan Industri', '2026-04-01 14:21:13', '2026-04-01 14:21:13'),
(3, 'Penguji UKK', '2026-04-01 14:21:13', '2026-04-01 14:21:13'),
(4, 'Sinkronisasi Kurikulum', '2026-04-01 14:21:13', '2026-04-01 14:21:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lamaran`
--

CREATE TABLE `tb_lamaran` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pelamar` int(10) UNSIGNED NOT NULL,
  `id_lowongan` int(10) UNSIGNED NOT NULL,
  `tanggal_melamar` datetime NOT NULL DEFAULT current_timestamp(),
  `tanggal_wawancara` datetime DEFAULT NULL,
  `status` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos') NOT NULL DEFAULT 'menunggu_diverifikasi',
  `catatan` text DEFAULT NULL,
  `dibuat_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data lamaran kerja pelamar';

--
-- Dumping data untuk tabel `tb_lamaran`
--

INSERT INTO `tb_lamaran` (`id`, `id_pelamar`, `id_lowongan`, `tanggal_melamar`, `tanggal_wawancara`, `status`, `catatan`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(8, 2, 1, '2026-04-19 00:00:00', NULL, 'diproses', '', 1, '2026-04-19 13:44:11', '2026-04-19 14:24:30'),
(9, 2, 2, '2026-04-23 00:00:00', NULL, 'menunggu_diverifikasi', NULL, NULL, '2026-04-23 07:28:26', '2026-04-23 07:28:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lamaran_status`
--

CREATE TABLE `tb_lamaran_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_lamaran` int(10) UNSIGNED NOT NULL,
  `status_lama` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos') DEFAULT NULL,
  `status_baru` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos') NOT NULL,
  `catatan` text DEFAULT NULL,
  `diubah_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Riwayat perubahan status lamaran';

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lowongan`
--

CREATE TABLE `tb_lowongan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_perusahaan` int(10) UNSIGNED NOT NULL,
  `posisi` varchar(100) NOT NULL COMMENT 'Nama jabatan: Staff IT, HRD, dll',
  `deskripsi_pekerjaan` text DEFAULT NULL,
  `kualifikasi` text DEFAULT NULL,
  `jenis_pekerjaan` enum('fulltime','parttime','magang','kontrak') NOT NULL,
  `lokasi_kerja` varchar(150) DEFAULT NULL,
  `batas_lamaran` date DEFAULT NULL,
  `status` enum('draft','aktif','ditutup','kadaluarsa') NOT NULL DEFAULT 'aktif',
  `dibuat_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data lowongan kerja dari DUDI';

--
-- Dumping data untuk tabel `tb_lowongan`
--

INSERT INTO `tb_lowongan` (`id`, `id_perusahaan`, `posisi`, `deskripsi_pekerjaan`, `kualifikasi`, `jenis_pekerjaan`, `lokasi_kerja`, `batas_lamaran`, `status`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(1, 1, 'finance', 'xxxxxxxxx', 'xxxxxxxxxx', 'fulltime', 'Jakarta Selatan', '2026-04-22', 'aktif', NULL, '2026-04-10 22:58:55', '2026-04-10 23:16:08'),
(2, 2, 'IT Support', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', 'kontrak', 'Jakarta Timur', '2026-04-30', 'aktif', 1, '2026-04-19 21:39:45', '2026-04-19 21:39:45'),
(4, 1, 'AI Engineer', 'xxxxxxxxxxxxxxxxxx', 'xxxxxxxxxxxxxxx', 'fulltime', 'Jakarta Timur', '2026-05-09', 'draft', 1, '2026-04-22 21:46:50', '2026-04-22 21:46:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lowongan_jurusan`
--

CREATE TABLE `tb_lowongan_jurusan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_lowongan` int(10) UNSIGNED NOT NULL,
  `id_jurusan` int(10) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Relasi lowongan dengan jurusan yang dituju';

--
-- Dumping data untuk tabel `tb_lowongan_jurusan`
--

INSERT INTO `tb_lowongan_jurusan` (`id`, `id_lowongan`, `id_jurusan`, `created_at`) VALUES
(2, 1, 1, '2026-04-10 23:16:08'),
(10, 4, 1, '2026-04-22 21:46:50'),
(11, 4, 2, '2026-04-22 21:46:50'),
(12, 4, 3, '2026-04-22 21:46:50'),
(13, 2, 1, '2026-04-22 21:47:28'),
(14, 2, 2, '2026-04-22 21:47:28'),
(15, 2, 3, '2026-04-22 21:47:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_mou`
--

CREATE TABLE `tb_mou` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_perusahaan` int(10) UNSIGNED NOT NULL,
  `id_kerjasama` int(10) UNSIGNED NOT NULL,
  `nomor_mou` varchar(100) DEFAULT NULL,
  `tanggal_mou` date DEFAULT NULL,
  `tanggal_berlaku` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `file_mou` varchar(255) DEFAULT NULL COMMENT 'Upload scan/PDF dokumen MOU',
  `status` enum('aktif','berakhir','diperpanjang') NOT NULL DEFAULT 'aktif',
  `created_by` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='MOU/perjanjian kerjasama sekolah dengan DUDI';

--
-- Dumping data untuk tabel `tb_mou`
--

INSERT INTO `tb_mou` (`id`, `id_perusahaan`, `id_kerjasama`, `nomor_mou`, `tanggal_mou`, `tanggal_berlaku`, `tanggal_berakhir`, `file_mou`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, NULL, NULL, 'aktif', NULL, '2026-04-09 22:11:57', '2026-04-09 22:11:57'),
(2, 1, 4, NULL, NULL, NULL, NULL, NULL, 'aktif', NULL, '2026-04-09 22:11:57', '2026-04-09 22:11:57'),
(3, 2, 1, NULL, NULL, NULL, NULL, NULL, 'aktif', NULL, '2026-04-10 20:42:23', '2026-04-10 20:42:23'),
(4, 2, 2, NULL, NULL, NULL, NULL, NULL, 'aktif', NULL, '2026-04-10 20:42:23', '2026-04-10 20:42:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelamar`
--

CREATE TABLE `tb_pelamar` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `account_id` varchar(20) NOT NULL COMMENT 'Format: PLM-202603300001',
  `jenis_pelamar` enum('alumni','umum') NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `nomer_nik` varchar(20) DEFAULT NULL,
  `status_pendaftaran` enum('menunggu_aktivasi','aktif','terdaftar') NOT NULL DEFAULT 'menunggu_aktivasi',
  `terdaftar_pada` datetime DEFAULT NULL,
  `diaktivasi_oleh` int(10) UNSIGNED DEFAULT NULL,
  `diaktivasi_pada` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Profil detail pelamar (alumni & umum)';

--
-- Dumping data untuk tabel `tb_pelamar`
--

INSERT INTO `tb_pelamar` (`id`, `id_user`, `account_id`, `jenis_pelamar`, `telepon`, `foto`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `nomer_nik`, `status_pendaftaran`, `terdaftar_pada`, `diaktivasi_oleh`, `diaktivasi_pada`, `created_at`, `updated_at`) VALUES
(2, 43, 'plm-001', 'alumni', '082121521388', '1776448007_9e00a40b87dda6df537d.jpg', 'L', 'Jakarta', '2026-04-18', 'babaksari', '12343121231', 'terdaftar', '2026-04-22 12:41:02', NULL, NULL, '2026-04-07 12:59:39', '2026-04-22 12:41:02'),
(4, 45, 'plm-002', 'umum', '08131313', '1775566983_051190a4d9f4c0e3c18b.jpg', 'L', 'Jakarta', '2026-04-09', 'bintara', '329081723123', 'terdaftar', '2026-04-22 12:41:10', NULL, NULL, '2026-04-07 13:03:03', '2026-04-22 12:41:10'),
(5, 47, 'plm-003', 'alumni', '089821982312', '1776776123_a02e4d7e7fbe42c54d72.png', 'L', 'Brebes', '2026-04-01', 'Tambun Selatan', '312312313423221', 'menunggu_aktivasi', NULL, NULL, NULL, '2026-04-21 12:44:55', '2026-04-21 12:55:23'),
(12, 54, 'plm-004', 'umum', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu_aktivasi', NULL, NULL, NULL, '2026-04-23 08:49:12', '2026-04-23 08:49:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_perusahaan`
--

CREATE TABLE `tb_perusahaan` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL COMMENT 'Diisi setelah akun Admin DUDI dibuat',
  `nama_perusahaan` varchar(150) NOT NULL,
  `bidang_usaha` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data perusahaan/DUDI mitra sekolah';

--
-- Dumping data untuk tabel `tb_perusahaan`
--

INSERT INTO `tb_perusahaan` (`id`, `id_user`, `nama_perusahaan`, `bidang_usaha`, `alamat`, `kota`, `no_telepon`, `email`, `website`, `logo`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 46, 'PT. Bank Rakyat Indonesia', 'Bank', 'Jalan Kembang Sepatu Raya No. 10 Jakarta', 'Jakarta', '08974567857', 'bri1@gmail.com', 'www.bri.com', '1775664239_e9fca902d353c37bec61.jpg', 1, '2026-04-08 16:03:59', '2026-04-09 15:11:57'),
(2, 37, 'CV.skynet', 'Internet', 'Tambun', 'Bekasi', '021-6784728', 'skynet21@wifi.com', 'www.skynet.com', '1775708311_02cae5e97d2e0b0c740d.jpg', 1, '2026-04-09 04:18:31', '2026-04-10 13:42:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_riwayat_kerja`
--

CREATE TABLE `tb_riwayat_kerja` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_pelamar` int(10) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `posisi_jabatan` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `is_masih_bekerja` tinyint(1) NOT NULL DEFAULT 0,
  `deskripsi_kerja` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Riwayat pengalaman kerja pelamar sebelumnya';

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_roles`
--

CREATE TABLE `tb_roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_role` varchar(50) NOT NULL COMMENT 'super_admin, admin_bkk, admin_dudi, pelamar_alumni, pelamar_umum',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Master role pengguna';

--
-- Dumping data untuk tabel `tb_roles`
--

INSERT INTO `tb_roles` (`id`, `nama_role`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', '2026-04-01 14:21:12', '2026-04-01 14:21:12'),
(2, 'Admin BKK', '2026-04-01 14:21:12', '2026-04-01 14:21:12'),
(3, 'Admin DUDI', '2026-04-01 14:21:12', '2026-04-01 14:21:12'),
(4, 'Pelamar Alumni', '2026-04-01 14:21:12', '2026-04-01 14:21:12'),
(5, 'Pelamar Umum', '2026-04-01 14:21:12', '2026-04-01 14:21:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_syarat_berkas`
--

CREATE TABLE `tb_syarat_berkas` (
  `id` int(11) NOT NULL,
  `id_lowongan` int(10) UNSIGNED NOT NULL,
  `id_jenis_berkas` int(10) UNSIGNED NOT NULL,
  `wajib` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_syarat_berkas`
--

INSERT INTO `tb_syarat_berkas` (`id`, `id_lowongan`, `id_jenis_berkas`, `wajib`) VALUES
(1, 4, 1, 1),
(2, 4, 5, 1),
(3, 4, 2, 1),
(4, 2, 1, 1),
(5, 2, 3, 1),
(6, 2, 4, 1),
(7, 2, 5, 1),
(8, 2, 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_tracer_alumni`
--

CREATE TABLE `tb_tracer_alumni` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_alumni` int(10) UNSIGNED NOT NULL,
  `id_aktivitas` int(10) UNSIGNED DEFAULT NULL,
  `status` enum('draft','terkirim','terverifikasi','disetujui') NOT NULL DEFAULT 'draft',
  `diverifikasi_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'FK ke tb_users (Admin BKK / Super Admin)',
  `diverifikasi_at` datetime DEFAULT NULL,
  `disetujui_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'FK ke tb_users (Super Admin / Admin BKK)',
  `disetujui_at` datetime DEFAULT NULL,
  `posisi_kerja` varchar(100) DEFAULT NULL,
  `nama_dudi` varchar(150) DEFAULT NULL,
  `bidang_dudi` varchar(100) DEFAULT NULL,
  `alamat_dudi` text DEFAULT NULL,
  `tahun_mulai_kerja` year(4) DEFAULT NULL,
  `is_relevan_jurusan` tinyint(1) DEFAULT NULL,
  `penghasilan_range` varchar(50) DEFAULT NULL,
  `universitas` varchar(150) DEFAULT NULL,
  `program_studi` varchar(100) DEFAULT NULL,
  `status_kuliah` varchar(50) DEFAULT NULL,
  `nama_usaha` varchar(150) DEFAULT NULL,
  `bidang_usaha` varchar(100) DEFAULT NULL,
  `modal_awal` decimal(15,2) DEFAULT NULL,
  `penghasilan_usaha` varchar(50) DEFAULT NULL,
  `rencana_universitas` varchar(150) DEFAULT NULL,
  `rencana_prodi` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data tracer study alumni';

--
-- Dumping data untuk tabel `tb_tracer_alumni`
--

INSERT INTO `tb_tracer_alumni` (`id`, `id_alumni`, `id_aktivitas`, `status`, `diverifikasi_oleh`, `diverifikasi_at`, `disetujui_oleh`, `disetujui_at`, `posisi_kerja`, `nama_dudi`, `bidang_dudi`, `alamat_dudi`, `tahun_mulai_kerja`, `is_relevan_jurusan`, `penghasilan_range`, `universitas`, `program_studi`, `status_kuliah`, `nama_usaha`, `bidang_usaha`, `modal_awal`, `penghasilan_usaha`, `rencana_universitas`, `rencana_prodi`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'disetujui', 1, '2026-04-20 12:51:52', 1, '2026-04-21 14:16:20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BSI', 'SI', 'semester 8', NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-16 15:41:04', '2026-04-21 14:16:20'),
(2, 2, 1, 'terkirim', NULL, NULL, NULL, NULL, 'Production staff', 'Inaco', 'Ager ager', 'tambun', '2021', 0, 'Rp 50.000.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-04-21 12:57:20', '2026-04-21 12:57:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_role` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Akun login semua aktor';

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id`, `id_role`, `nama`, `email`, `password`, `remember_token`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', 'admin@gmail.com', '$2y$10$QuQuAqoM8rvKN22HeiJ3meJ.HptsN6emVA5e368mfiXT1xnxcXRkG', NULL, 1, '2026-04-23 07:36:36', '2026-04-02 13:21:50', '2026-04-23 07:36:36'),
(3, 2, 'Admin BKK', 'admin@bkk.test', '$2y$10$8m8pns8/46mGFhl9eyaDeOfzYydqmhbBqXPGxnDSYy7Xe04Efbwja', NULL, 1, '2026-04-13 10:25:55', '2026-04-03 15:50:13', '2026-04-13 10:25:55'),
(37, 3, 'Admin DUDI', 'DUDI@gmail.com', '$2y$10$r0Py6UQ5jtw7tBZLzKRX2OR6yU4UWEUVtqXEKZVerSJnbxKRlirU2', NULL, 1, NULL, '2026-04-06 13:29:37', '2026-04-09 13:09:55'),
(43, 4, 'Chandra', 'chandra@gmail.com', '$2y$10$pIb1Ku3btu5Kfw1cPArZU.bPt3MpZXQ7C/LzJUns9JpaY0CQtiiIS', NULL, 1, '2026-04-23 07:26:44', '2026-04-07 12:59:38', '2026-04-23 07:26:44'),
(45, 5, 'fadhil', 'fadhil@gmail.com', '$2y$10$H0uI2uGh/MvD53lUnogCjuyMs4WI6k6FQmWrAp5a1DgZNmF7Y4ABq', NULL, 1, '2026-04-17 10:43:31', '2026-04-07 13:03:03', '2026-04-17 10:43:31'),
(46, 3, 'andika', 'andika@gmail.com', '$2y$10$WZQlSwC6FZESYgYdOTskZ.psL/sSulL29Jf1xvtLAqCRGODIVWPIq', NULL, 1, NULL, '2026-04-08 16:34:04', '2026-04-09 13:09:34'),
(47, 4, 'aji sodikin', 'aji@gmail.com', '$2y$10$dfA1zJpJSPXn.ny2ywzdpO/SZFiop2ABrW9Zcq3ZDIKQRI94jKg1a', NULL, 1, '2026-04-21 12:48:26', '2026-04-21 12:44:55', '2026-04-21 12:55:23'),
(54, 5, 'rifki', 'rifki@gmail.com', '$2y$10$ybnWfVGnZBBYOuxLK606T.8M6OqlRSK8.SpENkHT4dtQFWj32EkkG', NULL, 1, '2026-04-23 08:49:26', '2026-04-23 08:49:12', '2026-04-23 08:49:26');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_alumni`
--
ALTER TABLE `tb_alumni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelamar` (`id_pelamar`),
  ADD KEY `id_angkatan` (`id_angkatan`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `tb_angkatan`
--
ALTER TABLE `tb_angkatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_berkas`
--
ALTER TABLE `tb_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelamar` (`id_pelamar`);

--
-- Indeks untuk tabel `tb_berkas_lamaran`
--
ALTER TABLE `tb_berkas_lamaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_berkas_lamaran_id_lamaran_foreign` (`id_lamaran`),
  ADD KEY `tb_berkas_lamaran_id_jenis_berkas_foreign` (`id_jenis_berkas`);

--
-- Indeks untuk tabel `tb_identitas_sekolah`
--
ALTER TABLE `tb_identitas_sekolah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_jenis_berkas`
--
ALTER TABLE `tb_jenis_berkas`
  ADD PRIMARY KEY (`id_jenis_berkas`),
  ADD UNIQUE KEY `slug_berkas` (`slug_berkas`);

--
-- Indeks untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_kerjasama`
--
ALTER TABLE `tb_kerjasama`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_lamaran`
--
ALTER TABLE `tb_lamaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelamar` (`id_pelamar`),
  ADD KEY `id_lowongan` (`id_lowongan`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `tb_lamaran_status`
--
ALTER TABLE `tb_lamaran_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lamaran` (`id_lamaran`),
  ADD KEY `diubah_oleh` (`diubah_oleh`);

--
-- Indeks untuk tabel `tb_lowongan`
--
ALTER TABLE `tb_lowongan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perusahaan` (`id_perusahaan`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `tb_lowongan_jurusan`
--
ALTER TABLE `tb_lowongan_jurusan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lowongan` (`id_lowongan`),
  ADD KEY `id_jurusan` (`id_jurusan`);

--
-- Indeks untuk tabel `tb_mou`
--
ALTER TABLE `tb_mou`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_perusahaan` (`id_perusahaan`),
  ADD KEY `id_kerjasama` (`id_kerjasama`),
  ADD KEY `created_by` (`created_by`);

--
-- Indeks untuk tabel `tb_pelamar`
--
ALTER TABLE `tb_pelamar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_id` (`account_id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tb_perusahaan`
--
ALTER TABLE `tb_perusahaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tb_riwayat_kerja`
--
ALTER TABLE `tb_riwayat_kerja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pelamar` (`id_pelamar`);

--
-- Indeks untuk tabel `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_syarat_berkas`
--
ALTER TABLE `tb_syarat_berkas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tb_syarat_berkas_id_lowongan_foreign` (`id_lowongan`),
  ADD KEY `tb_syarat_berkas_id_jenis_berkas_foreign` (`id_jenis_berkas`);

--
-- Indeks untuk tabel `tb_tracer_alumni`
--
ALTER TABLE `tb_tracer_alumni`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_alumni` (`id_alumni`),
  ADD KEY `id_aktivitas` (`id_aktivitas`),
  ADD KEY `diverifikasi_oleh` (`diverifikasi_oleh`),
  ADD KEY `disetujui_oleh` (`disetujui_oleh`);

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_alumni`
--
ALTER TABLE `tb_alumni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_angkatan`
--
ALTER TABLE `tb_angkatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_berkas`
--
ALTER TABLE `tb_berkas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_berkas_lamaran`
--
ALTER TABLE `tb_berkas_lamaran`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tb_identitas_sekolah`
--
ALTER TABLE `tb_identitas_sekolah`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_jenis_berkas`
--
ALTER TABLE `tb_jenis_berkas`
  MODIFY `id_jenis_berkas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_jurusan`
--
ALTER TABLE `tb_jurusan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_kerjasama`
--
ALTER TABLE `tb_kerjasama`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_lamaran`
--
ALTER TABLE `tb_lamaran`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_lamaran_status`
--
ALTER TABLE `tb_lamaran_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lowongan`
--
ALTER TABLE `tb_lowongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_lowongan_jurusan`
--
ALTER TABLE `tb_lowongan_jurusan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tb_mou`
--
ALTER TABLE `tb_mou`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_pelamar`
--
ALTER TABLE `tb_pelamar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tb_perusahaan`
--
ALTER TABLE `tb_perusahaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_riwayat_kerja`
--
ALTER TABLE `tb_riwayat_kerja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_syarat_berkas`
--
ALTER TABLE `tb_syarat_berkas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_tracer_alumni`
--
ALTER TABLE `tb_tracer_alumni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD CONSTRAINT `tb_admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_alumni`
--
ALTER TABLE `tb_alumni`
  ADD CONSTRAINT `tb_alumni_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_alumni_ibfk_2` FOREIGN KEY (`id_angkatan`) REFERENCES `tb_angkatan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_alumni_ibfk_3` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_berkas`
--
ALTER TABLE `tb_berkas`
  ADD CONSTRAINT `tb_berkas_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_berkas_lamaran`
--
ALTER TABLE `tb_berkas_lamaran`
  ADD CONSTRAINT `tb_berkas_lamaran_id_jenis_berkas_foreign` FOREIGN KEY (`id_jenis_berkas`) REFERENCES `tb_jenis_berkas` (`id_jenis_berkas`),
  ADD CONSTRAINT `tb_berkas_lamaran_id_lamaran_foreign` FOREIGN KEY (`id_lamaran`) REFERENCES `tb_lamaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_lamaran`
--
ALTER TABLE `tb_lamaran`
  ADD CONSTRAINT `tb_lamaran_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_lamaran_ibfk_2` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_lamaran_ibfk_3` FOREIGN KEY (`dibuat_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_lamaran_status`
--
ALTER TABLE `tb_lamaran_status`
  ADD CONSTRAINT `tb_lamaran_status_ibfk_1` FOREIGN KEY (`id_lamaran`) REFERENCES `tb_lamaran` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_lamaran_status_ibfk_2` FOREIGN KEY (`diubah_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_lowongan`
--
ALTER TABLE `tb_lowongan`
  ADD CONSTRAINT `tb_lowongan_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `tb_perusahaan` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_lowongan_ibfk_2` FOREIGN KEY (`dibuat_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_lowongan_jurusan`
--
ALTER TABLE `tb_lowongan_jurusan`
  ADD CONSTRAINT `tb_lowongan_jurusan_ibfk_1` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_lowongan_jurusan_ibfk_2` FOREIGN KEY (`id_jurusan`) REFERENCES `tb_jurusan` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_mou`
--
ALTER TABLE `tb_mou`
  ADD CONSTRAINT `tb_mou_ibfk_1` FOREIGN KEY (`id_perusahaan`) REFERENCES `tb_perusahaan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_mou_ibfk_2` FOREIGN KEY (`id_kerjasama`) REFERENCES `tb_kerjasama` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_mou_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pelamar`
--
ALTER TABLE `tb_pelamar`
  ADD CONSTRAINT `tb_pelamar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_perusahaan`
--
ALTER TABLE `tb_perusahaan`
  ADD CONSTRAINT `tb_perusahaan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_riwayat_kerja`
--
ALTER TABLE `tb_riwayat_kerja`
  ADD CONSTRAINT `tb_riwayat_kerja_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_syarat_berkas`
--
ALTER TABLE `tb_syarat_berkas`
  ADD CONSTRAINT `tb_syarat_berkas_id_jenis_berkas_foreign` FOREIGN KEY (`id_jenis_berkas`) REFERENCES `tb_jenis_berkas` (`id_jenis_berkas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_syarat_berkas_id_lowongan_foreign` FOREIGN KEY (`id_lowongan`) REFERENCES `tb_lowongan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_tracer_alumni`
--
ALTER TABLE `tb_tracer_alumni`
  ADD CONSTRAINT `tb_tracer_alumni_ibfk_1` FOREIGN KEY (`id_alumni`) REFERENCES `tb_alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_tracer_alumni_ibfk_2` FOREIGN KEY (`id_aktivitas`) REFERENCES `tb_aktivitas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_tracer_alumni_ibfk_3` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_tracer_alumni_ibfk_4` FOREIGN KEY (`disetujui_oleh`) REFERENCES `tb_users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `tb_users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `tb_roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
