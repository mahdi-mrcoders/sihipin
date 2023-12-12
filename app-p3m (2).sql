-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 11 Des 2023 pada 23.58
-- Versi server: 8.0.30
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app-p3m`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `auths`
--

CREATE TABLE `auths` (
  `id_pengguna` int UNSIGNED NOT NULL,
  `email_dosen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `auths`
--

INSERT INTO `auths` (`id_pengguna`, `email_dosen`, `username`, `password`, `level`, `created_at`, `updated_at`) VALUES
(1, 'andrinofiar@poltek-kampar.ac.id', 'Andri Nofiar. AM, S.Kom., M.Kom', 'e10adc3949ba59abbe56e057f20f883e', '1', '2023-12-11 18:33:03', '2023-12-11 18:33:03'),
(2, 'fitri@poltek-kampar.ac.id', 'Fitri, S.T., M.Sc.', '6f6931c2fb2015b5abb48d0c4d5db302', '3', '2023-12-11 11:56:05', '2023-12-11 11:56:05'),
(3, 'ridwan@poltek-kampar.ac.id', 'Muhammad Ridwan, ST., MT', 'e564651c529eb4f666ebb2ec04578d65', '2', '2023-12-11 11:56:16', '2023-12-11 11:56:16'),
(4, 'ade@poltek-kampar.ac.id', 'Ade Kurniawan, S.Kom.', 'a98373cf4abb4668951d84af9cbe36e0', '2', '2023-12-11 11:56:30', '2023-12-11 11:56:30'),
(5, 'fenty@poltek-kampar.ac.id', 'Fenty Kurnia Oktorina,ST., M.Sc.', '24a0227d12e18c97232935fb6ce91b7b', '3', '2023-12-11 13:31:48', '2023-12-11 13:31:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_golongan_pangkats`
--

CREATE TABLE `data_golongan_pangkats` (
  `id` int UNSIGNED NOT NULL,
  `nama_pangkat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_golongan_pangkats`
--

INSERT INTO `data_golongan_pangkats` (`id`, `nama_pangkat`, `created_at`, `updated_at`) VALUES
(1, 'Penata Muda, III/a', '2023-12-04 03:41:58', '2023-12-04 09:26:05'),
(6, 'Penata Muda Tk. I, III/b', '2023-12-04 09:25:19', '2023-12-04 09:26:20'),
(7, 'Penata, III/c', '2023-12-04 09:26:36', '2023-12-04 09:26:36'),
(8, 'Penata Tk.I, III/d', '2023-12-04 09:26:52', '2023-12-04 09:26:52'),
(9, 'Pembina, IV/a', '2023-12-04 09:27:11', '2023-12-04 09:27:11'),
(10, 'Pembina Tk. I, IV/b', '2023-12-04 09:27:25', '2023-12-04 09:27:25'),
(11, 'Pembina Utama Muda, IV/c', '2023-12-04 09:27:40', '2023-12-04 09:27:40'),
(12, 'Pembina Utama Madya, IV/d', '2023-12-04 09:27:55', '2023-12-04 09:27:55'),
(13, 'Pembina Utama, IV/e', '2023-12-04 09:28:08', '2023-12-04 09:28:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_informasis`
--

CREATE TABLE `data_informasis` (
  `id` int UNSIGNED NOT NULL,
  `informasi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_informasis`
--

INSERT INTO `data_informasis` (`id`, `informasi`, `created_at`, `updated_at`) VALUES
(1, '<h1 style=\"text-align: center;\">Informasi Terkini</h1>\n<table style=\"border-collapse: collapse; width: 100%; height: 134px; border-color: #000000; border-style: solid; margin-left: auto; margin-right: auto;\" border=\"2\" cellspacing=\"2\" cellpadding=\"3\">\n<tbody>\n<tr>\n<td style=\"width: 32.3521%;\">No</td>\n<td style=\"width: 32.3521%;\">Detail</td>\n<td style=\"width: 32.3532%;\">Jadwal</td>\n</tr>\n<tr>\n<td style=\"width: 32.3521%;\">1</td>\n<td style=\"width: 32.3521%;\">Upload Proposal</td>\n<td style=\"width: 32.3532%;\">12 Desember - 25 Desember 2023</td>\n</tr>\n<tr>\n<td style=\"width: 32.3521%;\">2</td>\n<td style=\"width: 32.3521%;\">Seminar Proposal</td>\n<td style=\"width: 32.3532%;\">27 Desember - 1 Januari 2024</td>\n</tr>\n</tbody>\n</table>', '2023-12-11 16:29:38', '2023-12-11 16:51:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_jabfungs`
--

CREATE TABLE `data_jabfungs` (
  `id` int UNSIGNED NOT NULL,
  `nama_jabfung` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_jabfungs`
--

INSERT INTO `data_jabfungs` (`id`, `nama_jabfung`, `created_at`, `updated_at`) VALUES
(1, 'Asisten Ahli (AA)', NULL, '2023-12-04 09:23:11'),
(3, 'Lektor (L)', '2023-12-04 09:23:20', '2023-12-04 09:23:20'),
(4, 'Lektor Kepala (LK)', '2023-12-04 09:23:28', '2023-12-04 09:23:28'),
(5, 'Profesor (Prof)', '2023-12-04 09:23:36', '2023-12-04 09:23:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_jenis_laporans`
--

CREATE TABLE `data_jenis_laporans` (
  `id` int UNSIGNED NOT NULL,
  `jenis_laporan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_jenis_laporans`
--

INSERT INTO `data_jenis_laporans` (`id`, `jenis_laporan`, `start`, `end`, `created_at`, `updated_at`) VALUES
(1, 'Progress', '2023-12-06 19:07:00', '2023-12-09 19:07:00', '2023-12-02 12:07:51', '2023-12-05 12:25:58'),
(2, 'laporan 75', '2023-12-02 19:07:51', '2023-12-16 19:07:51', '2023-12-02 12:08:54', '2023-12-02 12:08:54'),
(3, 'Laporan Akhir', '2023-12-02 19:08:54', '2023-12-23 19:08:54', '2023-12-02 12:08:54', '2023-12-02 12:08:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_periodes`
--

CREATE TABLE `data_periodes` (
  `id` int UNSIGNED NOT NULL,
  `nama_periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_periode` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `data_periodes`
--

INSERT INTO `data_periodes` (`id`, `nama_periode`, `periode`, `status_periode`, `created_at`, `updated_at`) VALUES
(1, 'Periode 1', '2023', 'Y', '2023-12-11 11:46:58', '2023-12-11 11:47:02'),
(2, 'Periode 2', '2023', 'N', '2023-12-11 12:58:53', '2023-12-11 12:58:53'),
(3, 'Periode 1', '2024', 'N', '2023-12-11 12:59:04', '2023-12-11 12:59:04'),
(4, 'Periode 2', '2024', 'N', '2023-12-11 12:59:13', '2023-12-11 12:59:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosens`
--

CREATE TABLE `dosens` (
  `id` int UNSIGNED NOT NULL,
  `nrp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nidn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_fungsional` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat_golongan` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dosens`
--

INSERT INTO `dosens` (`id`, `nrp`, `nidn`, `nama`, `no_hp`, `prodi`, `jabatan_fungsional`, `pangkat_golongan`, `email`, `foto`, `created_at`, `updated_at`) VALUES
(1, '111019084', '111019084', 'Andri Nofiar. AM, S.Kom., M.Kom', '-', 'TIF', 'Asisten Ahli (AA)', 'Penata Muda, III/a', 'andrinofiar@poltek-kampar.ac.id', NULL, '2023-12-11 18:11:30', '2023-12-11 11:34:15'),
(2, '110306007', '110306007', 'Fitri, S.T., M.Sc.', '98', 'TIF', 'Asisten Ahli (AA)', 'Penata Muda, III/a', 'fitri@poltek-kampar.ac.id', NULL, '2023-12-11 11:54:34', '2023-12-11 11:54:34'),
(3, '110907026', '110907026', 'Muhammad Ridwan, ST., MT', '9999', 'TIF', 'Asisten Ahli (AA)', 'Penata Muda Tk. I, III/b', 'ridwan@poltek-kampar.ac.id', NULL, '2023-12-11 11:55:09', '2023-12-11 11:55:09'),
(4, '110809041', '110809041', 'Ade Kurniawan, S.Kom.', '99999', 'TIF', 'Asisten Ahli (AA)', 'Penata Muda, III/a', 'ade@poltek-kampar.ac.id', NULL, '2023-12-11 11:55:46', '2023-12-11 11:55:46'),
(5, '110306006', '110306006', 'Fenty Kurnia Oktorina,ST., M.Sc.', '9', 'TIF', 'Asisten Ahli (AA)', 'Penata Muda, III/a', 'fenty@poltek-kampar.ac.id', NULL, '2023-12-11 13:31:35', '2023-12-11 13:31:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_submited_skemas`
--

CREATE TABLE `jadwal_submited_skemas` (
  `id` int UNSIGNED NOT NULL,
  `id_periode` int NOT NULL,
  `id_skema` int NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `hapus` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jadwal_submited_skemas`
--

INSERT INTO `jadwal_submited_skemas` (`id`, `id_periode`, `id_skema`, `start`, `end`, `hapus`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-12-12 00:00:00', '2023-12-16 00:00:00', 0, '2023-12-11 11:59:12', '2023-12-11 11:59:12'),
(2, 1, 2, '2023-12-19 00:00:00', '2023-12-23 00:00:00', 0, '2023-12-11 11:59:12', '2023-12-11 11:59:12'),
(3, 1, 3, '2023-12-23 00:00:00', '2023-12-30 00:00:00', 0, '2023-12-11 11:59:12', '2023-12-11 11:59:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `media_files`
--

CREATE TABLE `media_files` (
  `id` int UNSIGNED NOT NULL,
  `nama_data` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `media_files`
--

INSERT INTO `media_files` (`id`, `nama_data`, `file`, `created_at`, `updated_at`) VALUES
(4, 'Buku Panduan a', 'New-Buku Pedoman P3M Polkam 2023 edisi ke-3 rev. 1.pdf', '2023-12-11 15:50:39', '2023-12-11 15:52:34');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_11_14_182359_create_penelitianpkms_kontraks_table', 1),
(3, '2023_11_14_211323_create_penelitianpkms_reviewers_table', 3),
(4, '2023_11_15_193750_skema', 4),
(5, '2023_11_15_194827_create_penilaian_kriterias_table', 5),
(6, '2023_11_15_194846_create_penilaian_indikators_table', 6),
(7, '2023_11_20_185301_create_penilaian_reviewers_table', 7),
(8, '2023_11_20_191158_create_penilaian_reviewer_kriterias_table', 8),
(9, '2023_11_20_191222_create_penilaian_reviewer_penolakans_table', 9),
(10, '2023_11_30_104134_create_data_periodes_table', 10),
(11, '2023_12_02_091215_create_data_jenis_laporans_table', 11),
(12, '2023_11_14_184203_create_penelitianpkms_laporanprogres_table', 12),
(13, '2014_10_12_000000_create_users_table', 13),
(14, '2014_10_12_100000_create_password_resets_table', 13),
(15, '2019_08_19_000000_create_failed_jobs_table', 13),
(16, '2023_12_02_192223_create_jadwal_submited_skemas_table', 13),
(17, '2023_12_04_101038_create_data_golongan_pangkats_table', 14),
(18, '2023_12_04_095531_create_data_jabfungs_table', 15),
(19, '2023_12_11_212514_create_media_files_table', 16),
(21, '2023_12_11_231855_create_data_informasis_table', 17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penelitianpkms_anggota`
--

CREATE TABLE `penelitianpkms_anggota` (
  `id` int UNSIGNED NOT NULL,
  `id_pengajuan` int NOT NULL,
  `nama_anggota` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penelitianpkms_informasi`
--

CREATE TABLE `penelitianpkms_informasi` (
  `id` int UNSIGNED NOT NULL,
  `id_pengajuan` int NOT NULL,
  `judul_penelitian` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `bidang_ilmu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nrp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nidn` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pangkat_golongan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan_fungsional` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_studi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_kantor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `faks_kantor` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_rumah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lokasi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jangka_waktu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penelitianpkms_kontraks`
--

CREATE TABLE `penelitianpkms_kontraks` (
  `id` int UNSIGNED NOT NULL,
  `id_pengajuan` int NOT NULL,
  `no_kontrak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pihak_satu` date DEFAULT NULL,
  `pihak_dua` date DEFAULT NULL,
  `mengetahui` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penelitianpkms_laporanprogres`
--

CREATE TABLE `penelitianpkms_laporanprogres` (
  `id` int UNSIGNED NOT NULL,
  `id_pengajuan` int NOT NULL,
  `id_jenis_progress` int NOT NULL,
  `file_progress` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validasi` enum('No Upload','prosess','Terima','Tolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'No Upload',
  `steps` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penelitianpkms_pengajuans`
--

CREATE TABLE `penelitianpkms_pengajuans` (
  `id` int UNSIGNED NOT NULL,
  `id_periode` int NOT NULL,
  `id_dosen` int NOT NULL,
  `id_skema` int NOT NULL,
  `file_proposal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_presentasi` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pengajuan` enum('Prosess','In Review','Tolak','Terima') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Prosess',
  `status_pemenang` enum('Pemenang','Tolak','In Review') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penelitianpkms_reviewers`
--

CREATE TABLE `penelitianpkms_reviewers` (
  `id` int UNSIGNED NOT NULL,
  `id_pengajuan` int NOT NULL,
  `id_dosen` int NOT NULL,
  `nama_reviewer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_indikators`
--

CREATE TABLE `penilaian_indikators` (
  `id` int UNSIGNED NOT NULL,
  `id_kriteria` int NOT NULL,
  `indikator_penilaian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bobot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan_tolak` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penilaian_indikators`
--

INSERT INTO `penilaian_indikators` (`id`, `id_kriteria`, `indikator_penilaian`, `bobot`, `alasan_tolak`, `created_at`, `updated_at`) VALUES
(1, 1, 'a.Kemampuan Presentasi dan Penguasaan Materi', '10', 'a.	Tidak mampu mempresentasikan usulan proposal penelitian dan tidak menguasai materi', NULL, NULL),
(2, 2, 'b.Ketajaman latar belakang, rumusan masalah, tujuan dan manfaat penelitian', '10', 'b.	Penjabaran latar belakang dan perumusan masalah lemah, tujuan dan manfaat tidak jelas ', NULL, NULL),
(3, 2, 'c.Tinjauan Pustaka merujuk pada penelitian 3 Tahun terakhir untuk program Studi TIF dan 5 Tahun Terakhir untuk program studi lainnya', '10', 'c.	Semua rujukan/referensi yang digunakan bukan dari penelitian terbaru (7 tahun ke atas) ', NULL, NULL),
(4, 2, 'd.Peta Jalan (Road Maps) 5 Tahun Kedepan sejalan dengan topik penelitian', '10', 'd.	Peta jalan (road maps) ketua penelitian tidak memiliki relasi/kesesuaian dengan topik penelitian dan tidak sejalanan/berhubungan dari tahun ke tahun', NULL, NULL),
(5, 3, 'e.Ketepatan metode yang digunakan', '10', 'e.	Metode yang digunakan tidak sesuai dengan topik penelitian dan alur proses yang dijalaskan tidak sesuai dengan topik penelitian yang dilakukan', NULL, NULL),
(6, 3, 'f.Kemutakhiran metode yang digunakan ', '10', 'f.	Metode yang digunakan bukan metode yang termuktakhir, ditunjukkan dari rujukan/referensi yang digunakan', NULL, NULL),
(7, 4, 'g.Publikasi Penelitian', '10', 'g.	Rencana publikasi penelitian yang diajukan pada usulan penelitian tidak memenuhi syarat minimal publikasi hibah internal penelitian', NULL, NULL),
(8, 5, 'i.Kelayakan bidang ilmu ketua peneliti dengan topik penelitian', '5', 'i.	Bidang ilmu ketua peneliti tidak sesuai dengan topik penelitian', NULL, NULL),
(9, 5, 'j.Relevansi topik penelitian dengan penelitian sebelumnya dari ketua dan anggota penelitian', '5', 'j.	Tidak relevan topik penelitian dengan penelitian yang pernah dilakukan oleh ketua dan anggota peneliti', NULL, NULL),
(10, 6, 'k.Kelayakan topik penelitian dengan jadwal yang direncanakan', '5', 'k.	Rencana jadwal penelitian kurang ditinjau kesesuaiannya dengan penelitian yang akan dilakukan', NULL, NULL),
(11, 6, 'l.Kesesuaian rencana anggaran biaya', '5', 'l.	Rencana anggaran biaya terlalu tinggi dan tidak terperinci', NULL, NULL),
(12, 6, 'm.Kesesuaian format usulan', '5', 'm.	Usulan proposal penelitian yang diajukan tidak sesuai dengan format usulan/template yang disediakan oleh P3M', NULL, NULL),
(13, 4, 'h.Produk yang dihasilkan/ Informasi/ Desain baru ', '5', 'h.	Produk yang dihasilkan/informasi/desain baru tidak jelas', NULL, NULL),
(14, 7, 'a.Kemampuan Presentasi dan Penguasaan Materi', '10', 'a.	Tidak mampu mempresentasikan usulan proposal penelitian dan tidak menguasai materi', NULL, NULL),
(15, 8, 'b.Ketajaman analisis situasi', '10', 'b.	Penjabaran/penjelasan nalisis situasi mitra lemah ', NULL, NULL),
(16, 8, 'c.Ketajaman Penjelasan Permasalahan yang dialami oleh mitra', '10', 'c.	Perumusan masalah yang dihadapi mitra lemah, tidak berdasarkan permasalahan yang   dihadapi oleh mitra', NULL, NULL),
(17, 8, 'd.Kejelasan solusi yang ditawarkan', '10', 'd.	Solusi yang ditawarkan tidak menjawab permasalahan yang dihadapi mitra atau tidak jelas', NULL, NULL),
(18, 9, 'e.Target yang diajukan jelas dan realistis', '10', 'e.	Target yang diajukan tidak jelas dan tidak realistis dan tidak sejalan dengan solusi yang ditawarkan', NULL, NULL),
(19, 9, 'f.Publikasi PkM ', '10', 'f.	Publikasi/luaran yang diajukan tidak memenuhi syarat minimal publikasi Hibah Internal PkM Politeknik Kampar', NULL, NULL),
(20, 10, 'g.Ketepatan metode yang digunakan', '10', 'g.	Metode yang digunakan tidak sesuai dengan topik PkM dan alur proses yang dilakukan tidak sesuai dengan topik PkM', NULL, NULL),
(21, 10, 'h.Kemutakhiran metode yang digunakan ', '5', 'h.	Metode yang digunakan tidak mutakhir, hal ini dapat dilihat dari referensi yang digunakan', NULL, NULL),
(22, 11, 'i.Kelayakan bidang ilmu ketua PkM dengan Topik PkM', '5', 'i.	Bidang ilmu ketua peneliti tidak sesuai dengan topik PkM', NULL, NULL),
(23, 11, 'j.Relevansi topik PkM dengan penelitian/PkM sebelumnya dari ketua dan anggota penelitian', '5', 'j.	Tidak relevan topik PkM dengan penelitian/PkM yang pernah dilakukan oleh ketua dan anggota peneliti', NULL, NULL),
(24, 12, 'k.Kelayakan topik PkM dengan jadwal yang direncanakan', '5', 'k.	Rencana jadwal PkM kurang ditinjau kesesuaiannya dengan Pelaksanaan PkM yang akan dilakukan', NULL, NULL),
(25, 12, 'l.Kesesuaian rencana anggaran biaya', '5', 'l.	Rencana anggaran biaya terlalu tinggi dan tidak terperinci', NULL, NULL),
(26, 12, 'm.Kesesuaian format usulan', '5', 'm.	Usulan proposal PkM yang diajukan tidak sesuai dengan format usulan/template yang disediakan oleh P3M', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_kriterias`
--

CREATE TABLE `penilaian_kriterias` (
  `id` int NOT NULL,
  `nama_kriteria` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_program` enum('P-PKM','P-PL') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penilaian_kriterias`
--

INSERT INTO `penilaian_kriterias` (`id`, `nama_kriteria`, `kode_program`, `created_at`, `updated_at`) VALUES
(1, 'Presentasi Usulan Penelitian', 'P-PL', NULL, NULL),
(2, 'Masalah yang diteliti', 'P-PL', NULL, NULL),
(3, 'Metode Penelitian', 'P-PL', NULL, NULL),
(4, 'Potensi Tercapainya Luaran ', 'P-PL', NULL, NULL),
(5, 'Personalia Peneliti ', 'P-PL', NULL, NULL),
(6, 'Kelayakan Sumber Daya', 'P-PL', NULL, NULL),
(7, 'Presentasi Usulan PkM', 'P-PKM', NULL, NULL),
(8, 'Kondisi Mitra', 'P-PKM', NULL, NULL),
(9, 'Target dan Luaran', 'P-PKM', NULL, NULL),
(10, 'Metode Pelaksanaan', 'P-PKM', NULL, NULL),
(11, 'Kelayakan TIM Pengusul', 'P-PKM', NULL, NULL),
(12, 'Kelayakan Sumber Daya', 'P-PKM', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_reviewers`
--

CREATE TABLE `penilaian_reviewers` (
  `id` int UNSIGNED NOT NULL,
  `id_reviewer` int NOT NULL,
  `id_pengajuan` int NOT NULL,
  `id_dosen_reviewer` int NOT NULL,
  `catatan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_nilai` int NOT NULL,
  `hasil_review` int NOT NULL COMMENT '1:terima 2:terima/revisi 3:tolak',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_reviewer_kriterias`
--

CREATE TABLE `penilaian_reviewer_kriterias` (
  `id` int UNSIGNED NOT NULL,
  `id_penilaian_review` int NOT NULL,
  `id_pengajuan` int NOT NULL,
  `id_dosen_review` int NOT NULL,
  `id_indikator` int NOT NULL,
  `skor` int NOT NULL,
  `bobot_x_skor` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian_reviewer_penolakans`
--

CREATE TABLE `penilaian_reviewer_penolakans` (
  `id` int UNSIGNED NOT NULL,
  `id_penilaian_review` int NOT NULL,
  `id_pengajuan` int NOT NULL,
  `id_dosen_review` int NOT NULL,
  `id_indikator` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `skemas`
--

CREATE TABLE `skemas` (
  `id` int UNSIGNED NOT NULL,
  `kode_program` enum('P-PKM','P-PL') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_skema` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_skema` int NOT NULL,
  `ketua_jabfung` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jumlah_anggota` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `skemas`
--

INSERT INTO `skemas` (`id`, `kode_program`, `nama_skema`, `status_skema`, `ketua_jabfung`, `jumlah_anggota`, `created_at`, `updated_at`) VALUES
(1, 'P-PL', 'Penelitian Dasar', 1, 'Asisten Ahli (AA)', 3, '2023-11-09 21:01:26', '2023-12-11 11:04:56'),
(2, 'P-PL', 'Penilitan Pemula', 1, 'Asisten Ahli (AA)', 3, '2023-11-09 21:01:26', '2023-12-11 11:05:03'),
(3, 'P-PKM', 'Pengabdian Kepada Masyarakat', 1, 'Asisten Ahli (AA)', 9, '2023-11-09 21:01:26', '2023-12-11 11:05:11'),
(4, 'P-PL', 'asdfasd', 0, 'Asisten Ahli (AA)', 2, '2023-11-09 14:54:25', '2023-12-11 11:05:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `syarats`
--

CREATE TABLE `syarats` (
  `id` int NOT NULL,
  `id_skema` int DEFAULT NULL,
  `persyaratan` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `syarats`
--

INSERT INTO `syarats` (`id`, `id_skema`, `persyaratan`, `created_at`, `updated_at`) VALUES
(1, 1, 'testase', NULL, '2023-12-11 11:04:56'),
(2, 1, 'adfasdf', NULL, '2023-12-11 11:04:56'),
(5, 1, 'adsfasd', NULL, '2023-12-11 11:04:56'),
(6, 1, 'sdfa34wawf34', NULL, '2023-12-11 11:04:56'),
(7, 2, '34524aw', NULL, '2023-12-11 11:05:03'),
(8, 2, '34523452', NULL, '2023-12-11 11:05:03'),
(9, 3, 'sdfasd', NULL, '2023-12-11 11:05:11'),
(10, 3, 'sdfasd', NULL, '2023-12-11 11:05:11'),
(11, 4, 's4325rd', NULL, '2023-12-11 11:05:18'),
(12, 4, 'tesstt', NULL, '2023-12-11 11:05:18');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_pengguna`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_pengguna` (
`email` varchar(255)
,`id` int unsigned
,`id_pengguna` int unsigned
,`level` varchar(255)
,`nama` varchar(255)
,`nidn` varchar(255)
,`nrp` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_pengguna`
--
DROP TABLE IF EXISTS `v_pengguna`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pengguna`  AS SELECT `a`.`id` AS `id`, `a`.`nrp` AS `nrp`, `a`.`nidn` AS `nidn`, `a`.`email` AS `email`, `a`.`nama` AS `nama`, `b`.`id_pengguna` AS `id_pengguna`, `b`.`level` AS `level` FROM (`dosens` `a` left join `auths` `b` on((`a`.`email` = `b`.`email_dosen`))) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auths`
--
ALTER TABLE `auths`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indeks untuk tabel `data_golongan_pangkats`
--
ALTER TABLE `data_golongan_pangkats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_informasis`
--
ALTER TABLE `data_informasis`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_jabfungs`
--
ALTER TABLE `data_jabfungs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_jenis_laporans`
--
ALTER TABLE `data_jenis_laporans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_periodes`
--
ALTER TABLE `data_periodes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal_submited_skemas`
--
ALTER TABLE `jadwal_submited_skemas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penelitianpkms_anggota`
--
ALTER TABLE `penelitianpkms_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penelitianpkms_informasi`
--
ALTER TABLE `penelitianpkms_informasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penelitianpkms_kontraks`
--
ALTER TABLE `penelitianpkms_kontraks`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penelitianpkms_laporanprogres`
--
ALTER TABLE `penelitianpkms_laporanprogres`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penelitianpkms_pengajuans`
--
ALTER TABLE `penelitianpkms_pengajuans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penelitianpkms_reviewers`
--
ALTER TABLE `penelitianpkms_reviewers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penilaian_indikators`
--
ALTER TABLE `penilaian_indikators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indeks untuk tabel `penilaian_kriterias`
--
ALTER TABLE `penilaian_kriterias`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penilaian_reviewers`
--
ALTER TABLE `penilaian_reviewers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penilaian_reviewer_kriterias`
--
ALTER TABLE `penilaian_reviewer_kriterias`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `penilaian_reviewer_penolakans`
--
ALTER TABLE `penilaian_reviewer_penolakans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `skemas`
--
ALTER TABLE `skemas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `syarats`
--
ALTER TABLE `syarats`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auths`
--
ALTER TABLE `auths`
  MODIFY `id_pengguna` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `data_golongan_pangkats`
--
ALTER TABLE `data_golongan_pangkats`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `data_informasis`
--
ALTER TABLE `data_informasis`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `data_jabfungs`
--
ALTER TABLE `data_jabfungs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `data_jenis_laporans`
--
ALTER TABLE `data_jenis_laporans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `data_periodes`
--
ALTER TABLE `data_periodes`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `dosens`
--
ALTER TABLE `dosens`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jadwal_submited_skemas`
--
ALTER TABLE `jadwal_submited_skemas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `media_files`
--
ALTER TABLE `media_files`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `penelitianpkms_anggota`
--
ALTER TABLE `penelitianpkms_anggota`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penelitianpkms_informasi`
--
ALTER TABLE `penelitianpkms_informasi`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penelitianpkms_kontraks`
--
ALTER TABLE `penelitianpkms_kontraks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penelitianpkms_laporanprogres`
--
ALTER TABLE `penelitianpkms_laporanprogres`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penelitianpkms_pengajuans`
--
ALTER TABLE `penelitianpkms_pengajuans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penelitianpkms_reviewers`
--
ALTER TABLE `penelitianpkms_reviewers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penilaian_indikators`
--
ALTER TABLE `penilaian_indikators`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `penilaian_kriterias`
--
ALTER TABLE `penilaian_kriterias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `penilaian_reviewers`
--
ALTER TABLE `penilaian_reviewers`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penilaian_reviewer_kriterias`
--
ALTER TABLE `penilaian_reviewer_kriterias`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `penilaian_reviewer_penolakans`
--
ALTER TABLE `penilaian_reviewer_penolakans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `skemas`
--
ALTER TABLE `skemas`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `syarats`
--
ALTER TABLE `syarats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `penilaian_indikators`
--
ALTER TABLE `penilaian_indikators`
  ADD CONSTRAINT `penilaian_indikators_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `penilaian_kriterias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
