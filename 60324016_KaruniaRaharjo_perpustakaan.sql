-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2026 at 05:22 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `kode_anggota` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `tanggal_daftar` date NOT NULL,
  `status` enum('Aktif','Nonaktif') DEFAULT 'Aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `kode_anggota`, `nama`, `email`, `telepon`, `alamat`, `tanggal_lahir`, `jenis_kelamin`, `pekerjaan`, `tanggal_daftar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AGT-001', 'Budi Santoso', 'budi.santoso@email.com', '081234567890', 'Jl. Merdeka No. 10, Jakarta', '1995-05-15', 'Laki-laki', 'Mahasiswa', '2024-01-10', 'Aktif', '2026-04-21 01:30:39', '2026-04-21 01:30:39'),
(2, 'AGT-002', 'Siti Nurhaliza', 'siti.nur@email.com', '081234567891', 'Jl. Sudirman No. 25, Bandung', '1998-08-20', 'Perempuan', 'Pegawai', '2024-01-15', 'Aktif', '2026-04-21 01:30:39', '2026-04-21 01:30:39'),
(3, 'AGT-003', 'Ahmad Dhani', 'ahmad.dhani@email.com', '081234567892', 'Jl. Gatot Subroto No. 5, Surabaya', '1992-03-10', 'Laki-laki', 'Pegawai', '2024-02-01', 'Aktif', '2026-04-21 01:30:39', '2026-04-21 01:30:39'),
(4, 'AGT-004', 'Dewi Lestari', 'dewi.lestari@email.com', '081234567893', 'Jl. Ahmad Yani No. 30, Yogyakarta', '2000-12-05', 'Perempuan', 'Mahasiswa', '2024-02-10', 'Aktif', '2026-04-21 01:30:39', '2026-04-21 01:30:39'),
(5, 'AGT-005', 'Rizky Febian', 'rizky.feb@email.com', '081234567894', 'Jl. Diponegoro No. 15, Semarang', '1997-07-18', 'Laki-laki', 'Pelajar', '2024-02-15', 'Nonaktif', '2026-04-21 01:30:39', '2026-04-21 01:30:39');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `pengarang` varchar(100) NOT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul`, `id_kategori`, `pengarang`, `id_penerbit`, `tahun_terbit`, `isbn`, `harga`, `stok`, `deskripsi`, `created_at`, `updated_at`, `is_deleted`) VALUES
(1, 'BK-001', 'Pemrograman PHP untuk Pemula', 1, 'Budi Raharjo', 1, 2023, '978-602-1234-56-1', '98175.00', 20, 'Buku panduan PHP terbaru edisi revisi', '2026-04-21 01:14:20', '2026-04-21 03:19:56', 0),
(2, 'BK-002', 'Mastering MySQL Database', 2, 'Andi Nugroho', 2, 2022, '978-602-1234-56-2', '104500.00', 5, 'Panduan komprehensif administrasi dan optimasi MySQL', '2026-04-21 01:14:20', '2026-04-21 03:19:56', 0),
(3, 'BK-003', 'Laravel Framework Advanced', 1, 'Siti Aminah', 3, 2024, '978-602-1234-56-3', '131250.00', 13, 'Teknik advanced development dengan Laravel framework', '2026-04-21 01:14:20', '2026-04-21 03:19:56', 0),
(4, 'BK-004', 'Web Design Principles', 3, 'Dedi Santoso', 4, 2023, '978-602-1234-56-4', '93500.00', 15, 'Prinsip dan best practice dalam desain web modern', '2026-04-21 01:14:20', '2026-04-21 03:19:56', 0),
(6, 'BK-006', 'PHP Web Services', 1, 'Budi Raharjo', 1, 2024, '978-602-1234-56-6', '94500.00', 17, 'Membangun RESTful API dengan PHP', '2026-04-21 01:14:20', '2026-04-21 03:19:56', 0),
(7, 'BK-007', 'PostgreSQL Advanced', 2, 'Ahmad Yani', 5, 2024, '978-602-1234-56-7', '115000.00', 7, 'Teknik advanced PostgreSQL untuk enterprise', '2026-04-21 01:14:20', '2026-04-21 03:19:56', 0),
(9, 'BK-008', 'JavaScript Modern', 3, 'Siti Aminah', 2, 2023, NULL, '80000.00', 5, NULL, '2026-04-21 01:28:08', '2026-04-21 03:19:56', 1),
(10, 'BK-009', 'React Native Development', 4, 'Ahmad Yani', 4, 2024, NULL, '141750.00', 10, NULL, '2026-04-21 01:28:08', '2026-04-21 03:19:56', 0),
(11, 'BK-010', 'Node.js untuk Backend', 2, 'Rama Wijaya', 2, 2024, '978-602-1234-56-10', '120000.00', 12, 'Pengembangan backend modern dengan Node.js', '2026-04-21 03:19:56', '2026-04-21 03:19:56', 0),
(12, 'BK-011', 'MongoDB Praktis', 3, 'Tari Puspita', 3, 2023, '978-602-1234-56-11', '98000.00', 10, 'Panduan implementasi MongoDB', '2026-04-21 03:19:56', '2026-04-21 03:19:56', 0),
(13, 'BK-012', 'UI/UX untuk Developer', 3, 'Dian Lestari', 3, 2024, '978-602-1234-56-12', '110000.00', 8, 'Konsep UI/UX praktis untuk programmer', '2026-04-21 03:19:56', '2026-04-21 03:19:56', 0),
(14, 'BK-013', 'Flutter Clean Architecture', 4, 'Fajar Hidayat', 4, 2025, '978-602-1234-56-13', '135000.00', 9, 'Arsitektur aplikasi Flutter yang scalable', '2026-04-21 03:19:56', '2026-04-21 03:19:56', 0),
(15, 'BK-014', 'Cloud Computing Dasar', 5, 'Nadia Putri', 5, 2024, '978-602-1234-56-14', '125000.00', 11, 'Pengenalan cloud computing untuk pemula', '2026-04-21 03:19:56', '2026-04-21 03:19:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_buku`
--

CREATE TABLE `kategori_buku` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_buku`
--

INSERT INTO `kategori_buku` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`) VALUES
(1, 'Pemrograman', 'Buku pemrograman dan pengembangan software', '2026-04-21 03:19:56'),
(2, 'Database', 'Buku basis data dan administrasi database', '2026-04-21 03:19:56'),
(3, 'Web Design', 'Buku desain UI/UX dan front-end', '2026-04-21 03:19:56'),
(4, 'Mobile Development', 'Buku pengembangan aplikasi mobile', '2026-04-21 03:19:56'),
(5, 'Teknologi Umum', 'Buku teknologi informasi umum', '2026-04-21 03:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `nama_penerbit`, `alamat`, `telepon`, `email`, `created_at`) VALUES
(1, 'Informatika Press', 'Jl. Teknologi No. 1, Jakarta', '0215551001', 'info@informatikapress.co.id', '2026-04-21 03:19:56'),
(2, 'Nusantara Media', 'Jl. Merdeka No. 22, Bandung', '0225551002', 'halo@nusantaramedia.co.id', '2026-04-21 03:19:56'),
(3, 'Digital Cendekia', 'Jl. Sudirman No. 88, Surabaya', '0315551003', 'cs@digitalcendekia.co.id', '2026-04-21 03:19:56'),
(4, 'Andalan Ilmu', 'Jl. Ahmad Yani No. 45, Yogyakarta', '02745551004', 'admin@andalanilmu.co.id', '2026-04-21 03:19:56'),
(5, 'Techno Pustaka', 'Jl. Diponegoro No. 17, Semarang', '0245551005', 'kontak@technopustaka.co.id', '2026-04-21 03:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `tanggal_harus_kembali` date NOT NULL,
  `status` enum('Dipinjam','Dikembalikan','Terlambat') DEFAULT 'Dipinjam',
  `denda` decimal(10,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_buku`, `id_anggota`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_harus_kembali`, `status`, `denda`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2024-02-01', NULL, '2024-02-08', 'Dipinjam', '0.00', '2026-04-21 01:31:50', '2026-04-21 01:31:50'),
(2, 2, 2, '2024-02-03', NULL, '2024-02-10', 'Dipinjam', '0.00', '2026-04-21 01:31:50', '2026-04-21 01:31:50'),
(3, 3, 1, '2024-01-25', NULL, '2024-02-01', 'Dikembalikan', '0.00', '2026-04-21 01:31:50', '2026-04-21 01:31:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `kode_anggota` (`kode_anggota`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`),
  ADD KEY `id_kategori` (`id_kategori`,`id_penerbit`),
  ADD KEY `id_penerbit` (`id_penerbit`);

--
-- Indexes for table `kategori_buku`
--
ALTER TABLE `kategori_buku`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `kategori_buku`
--
ALTER TABLE `kategori_buku`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_buku` (`id_kategori`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
