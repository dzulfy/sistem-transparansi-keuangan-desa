-- database/keuangandesa.sql

CREATE DATABASE IF NOT EXISTS keuangandesa;
USE keuangandesa;

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','bendahara','kepala_desa') NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `anggaran` (
  `id_anggaran` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kegiatan` varchar(150) NOT NULL,
  `jumlah_anggaran` decimal(15,2) NOT NULL,
  `tanggal` date NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` enum('PENDING', 'APPROVED', 'REJECTED') DEFAULT 'PENDING',
  PRIMARY KEY (`id_anggaran`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `anggaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `realisasi` (
  `id_realisasi` int(11) NOT NULL AUTO_INCREMENT,
  `jumlah_realisasi` decimal(15,2) NOT NULL,
  `tanggal` date NOT NULL,
  `id_anggaran` int(11) NOT NULL,
  `status` enum('PENDING', 'APPROVED', 'REJECTED') DEFAULT 'PENDING',
  PRIMARY KEY (`id_realisasi`),
  KEY `id_anggaran` (`id_anggaran`),
  CONSTRAINT `realisasi_ibfk_1` FOREIGN KEY (`id_anggaran`) REFERENCES `anggaran` (`id_anggaran`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `log_aktivitas` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `aktivitas` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_log`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL AUTO_INCREMENT,
  `periode` varchar(50) NOT NULL,
  `total_anggaran` decimal(15,2) NOT NULL,
  `total_realisasi` decimal(15,2) NOT NULL,
  `status` enum('DRAFT', 'AUDITED') DEFAULT 'DRAFT',
  PRIMARY KEY (`id_laporan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Data (Passwords are 'password123' hashed with bcrypt)
-- password_hash('password123', PASSWORD_BCRYPT) => $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Admin System', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
(2, 'Bendahara Desa', 'bendahara', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bendahara'),
(3, 'Bapak Kepala Desa', 'kepala_desa', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kepala_desa');

INSERT INTO `anggaran` (`id_anggaran`, `nama_kegiatan`, `jumlah_anggaran`, `tanggal`, `id_user`, `status`) VALUES
(1, 'Pembangunan Jembatan', 250000000.00, '2024-01-10', 1, 'APPROVED'),
(2, 'Renovasi Kantor Desa', 75000000.00, '2024-02-15', 1, 'PENDING');

INSERT INTO `realisasi` (`id_realisasi`, `jumlah_realisasi`, `tanggal`, `id_anggaran`, `status`) VALUES
(1, 50000000.00, '2024-01-20', 1, 'PENDING');

INSERT INTO `laporan` (`id_laporan`, `periode`, `total_anggaran`, `total_realisasi`, `status`) VALUES
(1, 'Januari - Maret 2024', 1250000000.00, 845320000.00, 'AUDITED'),
(2, 'Oktober - Desember 2023', 2100000000.00, 2088450000.00, 'AUDITED');
