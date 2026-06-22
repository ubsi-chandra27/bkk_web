-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Jun 2026 pada 13.43
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
-- Database: `bkk_tracer`
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
(1, '2026-05-14-000001', 'App\\Database\\Migrations\\CreateTbRoles', 'default', 'App', 1778749092, 1),
(2, '2026-05-14-000002', 'App\\Database\\Migrations\\CreateTbUsers', 'default', 'App', 1778749092, 1),
(3, '2026-05-14-000003', 'App\\Database\\Migrations\\CreateTbAdmin', 'default', 'App', 1778749092, 1),
(4, '2026-05-14-000004', 'App\\Database\\Migrations\\CreateTbAktivitas', 'default', 'App', 1778749092, 1),
(5, '2026-05-14-000005', 'App\\Database\\Migrations\\CreateTbAngkatan', 'default', 'App', 1778749092, 1),
(6, '2026-05-14-000006', 'App\\Database\\Migrations\\CreateTbJurusan', 'default', 'App', 1778749092, 1),
(7, '2026-05-14-000007', 'App\\Database\\Migrations\\CreateTbKerjasama', 'default', 'App', 1778749092, 1),
(8, '2026-05-14-000008', 'App\\Database\\Migrations\\CreateTbJenisBerkas', 'default', 'App', 1778749092, 1),
(9, '2026-05-14-000009', 'App\\Database\\Migrations\\CreateTbIdentitasSekolah', 'default', 'App', 1778749092, 1),
(10, '2026-05-14-000010', 'App\\Database\\Migrations\\CreateTbPerusahaan', 'default', 'App', 1778749092, 1),
(11, '2026-05-14-000011', 'App\\Database\\Migrations\\CreateTbPelamar', 'default', 'App', 1778749092, 1),
(12, '2026-05-14-000012', 'App\\Database\\Migrations\\CreateTbAlumni', 'default', 'App', 1778749093, 1),
(13, '2026-05-14-000013', 'App\\Database\\Migrations\\CreateTbLowongan', 'default', 'App', 1778749093, 1),
(14, '2026-05-14-000014', 'App\\Database\\Migrations\\CreateTbLowonganJurusan', 'default', 'App', 1778749093, 1),
(15, '2026-05-14-000015', 'App\\Database\\Migrations\\CreateTbSyaratBerkas', 'default', 'App', 1778749093, 1),
(16, '2026-05-14-000016', 'App\\Database\\Migrations\\CreateTbLamaran', 'default', 'App', 1778749093, 1),
(17, '2026-05-14-000017', 'App\\Database\\Migrations\\CreateTbLamaranStatus', 'default', 'App', 1778749093, 1),
(18, '2026-05-14-000018', 'App\\Database\\Migrations\\CreateTbBerkas', 'default', 'App', 1778749093, 1),
(19, '2026-05-14-000019', 'App\\Database\\Migrations\\CreateTbBerkasLamaran', 'default', 'App', 1778749093, 1),
(20, '2026-05-14-000020', 'App\\Database\\Migrations\\CreateTbMou', 'default', 'App', 1778749093, 1),
(21, '2026-05-14-000021', 'App\\Database\\Migrations\\CreateTbRiwayatKerja', 'default', 'App', 1778749093, 1),
(22, '2026-05-14-000022', 'App\\Database\\Migrations\\CreateTbTracerAlumni', 'default', 'App', 1778749093, 1),
(23, '2026-05-14-000023', 'App\\Database\\Migrations\\CreateNotifications', 'default', 'App', 1778749093, 1),
(24, '2026-05-15-000001', 'App\\Database\\Migrations\\AddPasswordResetToTbUsers', 'default', 'App', 1778858348, 2),
(25, '2026-05-16-000001', 'App\\Database\\Migrations\\AddEmailVerificationToTbUsers', 'default', 'App', 1778865464, 3),
(26, '2026-05-19-000001', 'App\\Database\\Migrations\\AddNewNotificationTypes', 'default', 'App', 1779160547, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL COMMENT 'Penerima notifikasi - FK ke tb_users.id',
  `sender_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'Pengirim notifikasi - FK ke tb_users.id, null jika dari sistem',
  `type` enum('new_application','status_changed','new_user','tracer_study_submitted') NOT NULL COMMENT 'Kategori notifikasi',
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = belum dibaca, 1 = sudah dibaca',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `sender_id`, `type`, `title`, `message`, `url`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 12, 'new_user', 'Pendaftar Baru', 'Eri Chandra Apriyadi mendaftar sebagai Pelamar Alumni', '/admin/data-pelamar', 0, '2026-05-19 03:31:30', '2026-05-19 03:31:30'),
(2, 2, 12, 'new_user', 'Pendaftar Baru', 'Eri Chandra Apriyadi mendaftar sebagai Pelamar Alumni', '/admin/data-pelamar', 1, '2026-05-19 03:31:30', '2026-05-19 03:38:30'),
(3, 1, 9, 'tracer_study_submitted', 'Tracer Study Baru', 'Afillah AJie Pratama telah mengisi data tracer study', '/admin/data-tracer', 0, '2026-05-29 08:09:13', '2026-05-29 08:09:13'),
(4, 2, 9, 'tracer_study_submitted', 'Tracer Study Baru', 'Afillah AJie Pratama telah mengisi data tracer study', '/admin/data-tracer', 1, '2026-05-29 08:09:13', '2026-05-29 08:10:41'),
(5, 1, 16, 'new_user', 'Pendaftar Baru', 'Bella Shafa mendaftar sebagai Pelamar Alumni', '/admin/data-pelamar', 0, '2026-05-29 14:27:58', '2026-05-29 14:27:58'),
(6, 2, 16, 'new_user', 'Pendaftar Baru', 'Bella Shafa mendaftar sebagai Pelamar Alumni', '/admin/data-pelamar', 0, '2026-05-29 14:27:58', '2026-05-29 14:27:58'),
(7, 1, 16, 'tracer_study_submitted', 'Tracer Study Baru', 'Bella Shafa telah mengisi data tracer study', '/admin/data-tracer', 0, '2026-05-29 14:48:54', '2026-05-29 14:48:54'),
(8, 2, 16, 'tracer_study_submitted', 'Tracer Study Baru', 'Bella Shafa telah mengisi data tracer study', '/admin/data-tracer', 0, '2026-05-29 14:48:54', '2026-05-29 14:48:54');

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
(3, 13, 'L', '', '2000-02-17', '08974567857', '', '1779170396_f4ae73d69ca54d6ebd30.jpg', '2026-05-19 05:49:06', '2026-05-19 05:59:56'),
(4, 14, 'L', '', '2000-02-17', '08974567857', '', NULL, '2026-05-19 05:49:41', '2026-05-19 05:59:43'),
(5, 15, 'L', '', '2000-02-17', '08974567857', '', '1779169823_bbaa9b4be741c3428e90.jpg', '2026-05-19 05:50:23', '2026-05-19 05:59:20');

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
(1, 'Bekerja', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(2, 'Kuliah', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(3, 'Wirausaha', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(4, 'Mencari Kerja', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(5, 'Berencana Kuliah', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24');

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
(2, 2, 5, 4, '123123123', '123123123', '123123123', 0, '2026-05-15 15:40:52', '2026-05-29 08:09:13'),
(3, 5, 1, 3, '123123123', '123123123', '123123123', 0, '2026-05-19 03:31:30', '2026-05-19 03:31:30'),
(4, 6, 1, 2, '123123123', '123123123', '123123123', 0, '2026-05-29 14:27:58', '2026-05-29 14:48:54');

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
(1, '2021', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(2, '2022', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(3, '2023', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(4, '2024', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(5, '2025', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24');

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
(1, 2, 5, 'panduan-skripsi.txt', 'uploads/berkas/1779173526_bce0cc18752b662a7af4.txt', '', '2026-05-19 06:52:06', '2026-05-19 06:52:06'),
(2, 2, 1, 'CV.pdf', 'uploads/berkas/1779173537_d96b303319d65341ab74.pdf', '', '2026-05-19 06:52:17', '2026-05-19 06:52:17');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Identitas sekolah - hanya 1 baris data';

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
(1, 'CV / Resume', 'cv', 'semua', 'Curriculum vitae atau resume pelamar', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(2, 'Surat Lamaran', 'surat_lamaran', 'semua', 'Surat lamaran kerja berdasarkan lowongan', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(3, 'Ijazah', 'ijazah', 'semua', 'Ijazah terakhir', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(4, 'KTP', 'ktp', 'semua', 'Kartu Tanda Penduduk', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(5, 'SKCK', 'skck', 'semua', 'Surat Keterangan Catatan Kepolisian', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(6, 'Portofolio', 'porto', 'semua', 'Portofolio pelamar', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24');

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
(1, 'Teknik Komputer dan Jaringan', 'TKJ', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(2, 'Rekayasa Perangkat Lunak', 'RPL', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(3, 'Multimedia', 'MM', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(4, 'Akuntansi dan Keuangan Lembaga', 'AKL', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24'),
(5, 'Otomatisasi dan Tata Kelola Perkantoran', 'OTKP', 1, '2026-05-14 08:59:24', '2026-05-14 08:59:24');

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
  `status` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos','diterima') NOT NULL DEFAULT 'menunggu_diverifikasi',
  `catatan` text DEFAULT NULL,
  `dibuat_oleh` int(10) UNSIGNED DEFAULT NULL COMMENT 'Otomatis dari sesi login',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Data lamaran kerja pelamar';

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lamaran_status`
--

CREATE TABLE `tb_lamaran_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_lamaran` int(10) UNSIGNED NOT NULL,
  `status_lama` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos','diterima') DEFAULT NULL,
  `status_baru` enum('menunggu_diverifikasi','diproses','lolos_verifikasi','wawancara','tidak_lolos','diterima') NOT NULL,
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
  `gaji` varchar(100) NOT NULL,
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

INSERT INTO `tb_lowongan` (`id`, `id_perusahaan`, `posisi`, `gaji`, `deskripsi_pekerjaan`, `kualifikasi`, `jenis_pekerjaan`, `lokasi_kerja`, `batas_lamaran`, `status`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES
(1, 1, 'Staff IT Support', 'Rp 15.000.000', 'Lorem Ipsum originated from a classical Latin text, De finibus bonorum et malorum by Cicero, written in 45 BC. The first line, \"Lorem ipsum dolor sit amet,\" is derived from section 1.10.32 of this work. It became widely used in the printing industry in the 1500s when an unknown printer scrambled type to create a specimen book, and it has survived through centuries into modern digital typesetting \r\nLorem Ipsum\r\nLorem Ipsum\r\n+1\r\n. Its popularity surged in the 1960s with Letraset sheets and later with desktop publishing software like Aldus PageMaker \r\n', 'Lorem Ipsum originated from a classical Latin text, De finibus bonorum et malorum by Cicero, written in 45 BC. The first line, \"Lorem ipsum dolor sit amet,\" is derived from section 1.10.32 of this work. It became widely used in the printing industry in the 1500s when an unknown printer scrambled type to create a specimen book, and it has survived through centuries into modern digital typesetting \r\nLorem Ipsum\r\nLorem Ipsum\r\n+1\r\n. Its popularity surged in the 1960s with Letraset sheets and later with desktop publishing software like Aldus PageMaker \r\n', 'fulltime', 'Jakarta Selatan', '2026-06-30', 'aktif', 2, '2026-05-19 12:54:08', '2026-05-19 12:54:08'),
(2, 1, 'Cleaning Service', 'Rp 6.000.000', 'Lorem Ipsum originated from a classical Latin text, De finibus bonorum et malorum by Cicero, written in 45 BC. The first line, \"Lorem ipsum dolor sit amet,\" is derived from section 1.10.32 of this work. It became widely used in the printing industry in the 1500s when an unknown printer scrambled type to create a specimen book, and it has survived through centuries into modern digital typesetting \r\nLorem Ipsum\r\nLorem Ipsum\r\n+1\r\n. Its popularity surged in the 1960s with Letraset sheets and later with desktop publishing software like Aldus PageMaker \r\n', 'Lorem Ipsum originated from a classical Latin text, De finibus bonorum et malorum by Cicero, written in 45 BC. The first line, \"Lorem ipsum dolor sit amet,\" is derived from section 1.10.32 of this work. It became widely used in the printing industry in the 1500s when an unknown printer scrambled type to create a specimen book, and it has survived through centuries into modern digital typesetting \r\nLorem Ipsum\r\nLorem Ipsum\r\n+1\r\n. Its popularity surged in the 1960s with Letraset sheets and later with desktop publishing software like Aldus PageMaker \r\n', 'parttime', 'Jakarta Timur', '2026-06-30', 'aktif', 13, '2026-05-19 13:02:10', '2026-05-19 13:02:10');

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
(2, 1, 1, '2026-05-19 12:54:29'),
(3, 2, 1, '2026-05-19 13:02:10'),
(4, 2, 2, '2026-05-19 13:02:10'),
(5, 2, 3, '2026-05-19 13:02:10');

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
(2, 9, 'plm-001', 'alumni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aktif', '2026-05-19 06:50:52', 2, '2026-05-19 06:50:52', '2026-05-15 15:40:52', '2026-05-19 06:50:52'),
(4, 11, 'plm-002', 'umum', '', NULL, '', '', '0000-00-00', '', '', 'aktif', '2026-05-29 14:39:25', 2, '2026-05-29 14:39:25', '2026-05-15 18:00:07', '2026-05-29 14:39:25'),
(5, 12, 'plm-003', 'alumni', '', NULL, '', '', '0000-00-00', '', '', 'menunggu_aktivasi', NULL, NULL, NULL, '2026-05-19 03:31:30', '2026-05-19 03:46:32'),
(6, 16, 'plm-004', 'alumni', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'menunggu_aktivasi', NULL, NULL, NULL, '2026-05-29 14:27:58', '2026-05-29 14:39:42');

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
(1, 13, 'PT Maju Bersama Teknologi', 'Teknologi Informasi', 'Jl. Sudirman No. 12, Kel. Pinangsia', 'Jakarta', '02112345678', 'info@majubersama.co.id', 'https://www.majubersama.co.id', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:59:56'),
(2, 15, 'CV Karya Mandiri Nusantara', 'Konstruksi & Bangunan', 'Jl. Ahmad Yani No. 45, Kel. Merdeka', 'Bandung', '02287654321', 'cs@karyamandiri.id', 'https://www.karyamandiri.id', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:59:20'),
(3, 14, 'PT Sejahtera Abadi Grup', 'Perdagangan & Distribusi', 'Jl. Diponegoro No. 8, Kel. Tegalsari', 'Surabaya', '03198765432', 'contact@sejahteraabadi.com', 'https://www.sejahteraabadi.com', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:59:43'),
(4, NULL, 'PT Global Solusi Digital', 'Teknologi Informasi', 'Jl. Gatot Subroto Kav. 22', 'Semarang', '02411122334', 'hello@globalsolusi.tech', 'https://www.globalsolusi.tech', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:46:48'),
(5, NULL, 'CV Mitra Usaha Bersama', 'Kuliner & F&B', 'Jl. Malioboro No. 77', 'Yogyakarta', '02744556677', 'mub@mitrausaha.id', 'https://www.mitrausaha.id', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:46:48'),
(6, NULL, 'PT Nusantara Energi Prima', 'Energi & Pertambangan', 'Jl. S. Parman No. 100, Kel. Palmerah', 'Jakarta', '02133445566', 'info@nusantaraenergi.co.id', 'https://www.nusantaraenergi.co.id', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:46:48'),
(7, NULL, 'PT Cipta Kreasi Media', 'Media & Periklanan', 'Jl. Raya Darmo No. 56', 'Surabaya', '03177889900', 'halo@ciptakreasi.com', 'https://www.ciptakreasi.com', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:46:48'),
(8, NULL, 'CV Harapan Jaya Logistik', 'Logistik & Ekspedisi', 'Jl. Imam Bonjol No. 33', 'Medan', '06188990011', 'ops@harapanjaya.id', 'https://www.harapanjaya.id', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:46:48'),
(9, NULL, 'PT Artha Kencana Finance', 'Keuangan & Perbankan', 'Jl. Asia Afrika No. 15', 'Bandung', '02255667788', 'info@arthakencana.co.id', 'https://www.arthakencana.co.id', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:46:48'),
(10, NULL, 'PT Bumi Hijau Agrikultur', 'Pertanian & Agribisnis', 'Jl. Pahlawan No. 9, Kel. Klojen', 'Malang', '03411223344', 'admin@bumihijau.co.id', 'https://www.bumihijau.co.id', NULL, 1, '2026-05-19 05:46:48', '2026-05-19 05:46:48');

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
(1, 'Super Admin', '2026-05-14 08:59:23', '2026-05-14 08:59:23'),
(2, 'Admin BKK', '2026-05-14 08:59:23', '2026-05-14 08:59:23'),
(3, 'Admin DUDI', '2026-05-14 08:59:23', '2026-05-14 08:59:23'),
(4, 'Pelamar Alumni', '2026-05-14 08:59:23', '2026-05-14 08:59:23'),
(5, 'Pelamar Umum', '2026-05-14 08:59:23', '2026-05-14 08:59:23');

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
(3, 1, 1, 1),
(4, 2, 1, 1),
(5, 2, 5, 1);

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
(2, 2, 1, 'disetujui', NULL, NULL, 2, '2026-05-29 08:11:15', 'Production', 'PT. NIRAMAS STUDIO', 'Produksi Jelly', 'Tambun', '2021', 0, 'Rp 5.000.000', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-15 15:40:52', '2026-05-29 08:11:15'),
(3, 3, NULL, 'draft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-19 03:31:30', '2026-05-19 03:31:30'),
(5, 4, 1, 'terkirim', NULL, NULL, NULL, NULL, '', '', '', '', '0000', 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-05-29 14:48:54', '2026-05-29 14:48:54');

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
  `reset_token` varchar(64) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `email_token` varchar(64) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Akun login semua aktor';

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id`, `id_role`, `nama`, `email`, `password`, `remember_token`, `reset_token`, `reset_expires`, `email_token`, `email_verified_at`, `is_verified`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', 'admin@gmail.com', '$2y$10$jZ2wv2wYzvbUjhe7EueJUuswqxBtYKyQesOYQXaIvGjgp0csjzhE.', NULL, NULL, NULL, NULL, '2026-05-15 17:17:44', 1, 1, '2026-05-15 15:37:06', '2026-05-14 08:59:23', '2026-05-16 00:17:44'),
(2, 2, 'Admin BKK', 'admin@bkk.test', '$2y$10$8DV2jmaey/cFjenfuUEmZ.74iRVhlg2/0J1n8MF3GLrJ0hRa17cea', NULL, NULL, NULL, NULL, '2026-05-15 17:17:44', 1, 1, '2026-05-29 14:24:56', '2026-05-14 08:59:23', '2026-05-29 14:24:56'),
(9, 4, 'Afillah AJie Pratama', 'afilahpratama@gmail.com', '$2y$10$8b8EAIKlCqqPmR6sSiuRVu/.c/9ueLVo46XmHZTv/.1FfJ4cqobMG', NULL, 'c850c0cadd2a2730ae175c8f19dbb9f4bba6da7ff52b7196ff1ce207b33fb825', '2026-05-15 16:41:06', NULL, '2026-05-15 17:17:44', 1, 1, '2026-05-29 08:03:42', '2026-05-15 15:40:52', '2026-05-29 08:03:42'),
(11, 5, 'Muhammad Fadhil Hilmi', 'muhammadfadhilhilmi3@gmail.com', '$2y$10$HpRuCHpHi6RMD2xnkJX1ouhwrmJO4/Wygo75pUQZd9yB5ZxDE6bk.', NULL, NULL, NULL, NULL, '2026-05-29 14:39:25', 1, 1, NULL, '2026-05-15 18:00:07', '2026-05-29 14:39:25'),
(12, 4, 'Eri Chandra Apriyadi', '19220636@bsi.ac.id', '$2y$10$9rgA4DyYDXUHtP8TrTDk4u.1Innl.ZfHB7SrOO.7KkLzReljbhjwS', NULL, NULL, NULL, NULL, '2026-05-19 03:46:32', 1, 1, NULL, '2026-05-19 03:31:30', '2026-05-19 03:46:32'),
(13, 3, 'Admin DUDI', 'DUDI@gmail.com', '$2y$10$Ker5tXI6B5kd22rx3ncwtO28uTlAoqk9uqTtDAP.q38vnjSo6RIFS', NULL, NULL, NULL, NULL, '2026-05-19 05:59:56', 1, 1, '2026-05-19 06:01:09', '2026-05-19 05:49:06', '2026-05-19 06:01:09'),
(14, 3, 'Admin DUDI 2', 'DUDI2@gmail.com', '$2y$10$HI6hJ4Yg15d/Y4KCsyXfyOrmwf26Pg.GeoFrSMYNywlRm0DyhjHZW', NULL, NULL, NULL, NULL, '2026-05-19 05:59:43', 1, 1, NULL, '2026-05-19 05:49:41', '2026-05-19 05:59:43'),
(15, 3, 'Admin DUDI 3', 'DUDI3@gmail.com', '$2y$10$4pjoWm.pcZ52.//epfer.e/LnY4YE9JPoAoo9DhesHfPl6rpVg7vK', NULL, NULL, NULL, NULL, '2026-05-19 05:59:20', 1, 1, NULL, '2026-05-19 05:50:23', '2026-05-19 05:59:20'),
(16, 4, 'Bella Shafa', 'bellashafazaya@gmail.com', '$2y$10$97FmXF4UpOZPrUkYgvQd..PGntGMtVu4Homwi1Mbwar9MY1GqMBfC', NULL, NULL, NULL, NULL, '2026-05-29 14:39:42', 1, 1, '2026-05-29 14:45:23', '2026-05-29 14:27:58', '2026-05-29 14:45:23');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_sender_id_foreign` (`sender_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `is_read` (`is_read`);

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
  ADD KEY `id_pelamar` (`id_pelamar`),
  ADD KEY `id_jenis_berkas` (`id_jenis_berkas`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_aktivitas`
--
ALTER TABLE `tb_aktivitas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_alumni`
--
ALTER TABLE `tb_alumni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_angkatan`
--
ALTER TABLE `tb_angkatan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_berkas`
--
ALTER TABLE `tb_berkas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_berkas_lamaran`
--
ALTER TABLE `tb_berkas_lamaran`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_kerjasama`
--
ALTER TABLE `tb_kerjasama`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lamaran`
--
ALTER TABLE `tb_lamaran`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lamaran_status`
--
ALTER TABLE `tb_lamaran_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lowongan`
--
ALTER TABLE `tb_lowongan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tb_lowongan_jurusan`
--
ALTER TABLE `tb_lowongan_jurusan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_mou`
--
ALTER TABLE `tb_mou`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_pelamar`
--
ALTER TABLE `tb_pelamar`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_perusahaan`
--
ALTER TABLE `tb_perusahaan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_tracer_alumni`
--
ALTER TABLE `tb_tracer_alumni`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `tb_users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `tb_berkas_ibfk_1` FOREIGN KEY (`id_pelamar`) REFERENCES `tb_pelamar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_berkas_ibfk_2` FOREIGN KEY (`id_jenis_berkas`) REFERENCES `tb_jenis_berkas` (`id_jenis_berkas`) ON UPDATE CASCADE;

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
