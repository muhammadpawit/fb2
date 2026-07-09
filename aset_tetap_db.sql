-- Tabel Master Aset Tetap
CREATE TABLE IF NOT EXISTS `acc_aset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_aset` varchar(50) DEFAULT NULL,
  `nama_aset` varchar(255) NOT NULL,
  `tanggal_perolehan` date NOT NULL,
  `harga_perolehan` decimal(15,2) NOT NULL DEFAULT '0.00',
  `umur_ekonomis` int(11) NOT NULL COMMENT 'Dalam Bulan',
  `nilai_residu` decimal(15,2) NOT NULL DEFAULT '0.00',
  `id_akun_aset` int(11) DEFAULT NULL COMMENT 'ID COA Aset Tetap',
  `id_akun_akumulasi` int(11) DEFAULT NULL COMMENT 'ID COA Akumulasi Penyusutan',
  `id_akun_beban` int(11) DEFAULT NULL COMMENT 'ID COA Beban Penyusutan',
  `metode_penyusutan` enum('Garis Lurus','Saldo Menurun') DEFAULT 'Garis Lurus',
  `status` tinyint(1) DEFAULT '1' COMMENT '1=Aktif, 0=Dilepas/Dijual',
  `hapus` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel Histori Penyusutan Aset
CREATE TABLE IF NOT EXISTS `acc_aset_penyusutan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aset` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `id_jurnal` int(11) DEFAULT NULL COMMENT 'Relasi ke acc_jurnal',
  `keterangan` text,
  `hapus` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_aset` (`id_aset`),
  CONSTRAINT `acc_aset_penyusutan_ibfk_1` FOREIGN KEY (`id_aset`) REFERENCES `acc_aset` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Tabel Pelepasan (Disposal) Aset
CREATE TABLE IF NOT EXISTS `acc_aset_disposal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_aset` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nilai_buku` decimal(15,2) NOT NULL DEFAULT '0.00',
  `laba_rugi` decimal(15,2) NOT NULL DEFAULT '0.00',
  `id_jurnal` int(11) DEFAULT NULL COMMENT 'Relasi ke acc_jurnal',
  `keterangan` text,
  `hapus` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_aset` (`id_aset`),
  CONSTRAINT `acc_aset_disposal_ibfk_1` FOREIGN KEY (`id_aset`) REFERENCES `acc_aset` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
