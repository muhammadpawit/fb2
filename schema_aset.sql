-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: forboysp_2425
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `acc_aset_tetap`
--

DROP TABLE IF EXISTS `acc_aset_tetap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acc_aset_tetap` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_aset` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `kode_aset` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tgl_perolehan` date NOT NULL,
  `harga_perolehan` decimal(15,2) NOT NULL,
  `masa_manfaat` int DEFAULT NULL COMMENT 'Dalam Bulan',
  `residu` decimal(15,2) DEFAULT '0.00',
  `id_akun_aset` int NOT NULL,
  `id_akun_akum_susut` int NOT NULL,
  `id_akun_beban_susut` int NOT NULL,
  `metode` enum('STRAIGHT_LINE','DOUBLE_DECLINING') COLLATE utf8mb4_general_ci DEFAULT 'STRAIGHT_LINE',
  `status` enum('AKTIF','DIJUAL','DIHAPUS') COLLATE utf8mb4_general_ci DEFAULT 'AKTIF',
  `hapus` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_aset` (`kode_aset`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acc_aset_penyusutan`
--

DROP TABLE IF EXISTS `acc_aset_penyusutan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acc_aset_penyusutan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_aset` int NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `id_jurnal` int DEFAULT NULL COMMENT 'Relasi ke acc_jurnal',
  `keterangan` text COLLATE utf8mb4_general_ci,
  `hapus` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_aset` (`id_aset`),
  CONSTRAINT `acc_aset_penyusutan_ibfk_1` FOREIGN KEY (`id_aset`) REFERENCES `acc_aset` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `acc_aset_disposal`
--

DROP TABLE IF EXISTS `acc_aset_disposal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `acc_aset_disposal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_aset` int NOT NULL,
  `tanggal` date NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL DEFAULT '0.00',
  `nilai_buku` decimal(15,2) NOT NULL DEFAULT '0.00',
  `laba_rugi` decimal(15,2) NOT NULL DEFAULT '0.00',
  `id_jurnal` int DEFAULT NULL COMMENT 'Relasi ke acc_jurnal',
  `keterangan` text COLLATE utf8mb4_general_ci,
  `hapus` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_aset` (`id_aset`),
  CONSTRAINT `acc_aset_disposal_ibfk_1` FOREIGN KEY (`id_aset`) REFERENCES `acc_aset` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-09 14:34:06
