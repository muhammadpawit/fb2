-- ==============================================================================
-- SQL MIGRATION / ALTER TABLE SCRIPT (IDEMPOTENT & SAFE TO RUN MULTIPLE TIMES)
-- Fitur: Notifikasi Persetujuan & Status Kirim Gudang Finishing
-- ==============================================================================

-- 1. Tambah kolom `status` pada tabel `finishing_kirim_gudang` jika belum ada
SET @dbname = DATABASE();
SET @tablename = "finishing_kirim_gudang";
SET @columnname = "status";
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE `finishing_kirim_gudang` ADD COLUMN `status` ENUM('dibuat', 'disetujui', 'ditolak') NOT NULL DEFAULT 'dibuat';"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 2. Buat tabel master pengaturan persetujuan user (`persetujuan_user`)
CREATE TABLE IF NOT EXISTS `persetujuan_user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_user` INT(11) NOT NULL,
  `tipe` VARCHAR(100) NOT NULL DEFAULT 'kirimgudang',
  `aktif` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `tipe` (`tipe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Daftarkan user pengelola persetujuan awal (misal user id 7 & 11) jika belum ada
INSERT INTO `persetujuan_user` (`id_user`, `tipe`, `aktif`, `created_at`) 
SELECT 7, 'kirimgudang', 1, NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM `persetujuan_user` WHERE `id_user` = 7 AND `tipe` = 'kirimgudang'
);

INSERT INTO `persetujuan_user` (`id_user`, `tipe`, `aktif`, `created_at`) 
SELECT 11, 'kirimgudang', 1, NOW()
WHERE NOT EXISTS (
    SELECT 1 FROM `persetujuan_user` WHERE `id_user` = 11 AND `tipe` = 'kirimgudang'
);

-- 4. Tambah Menu Navigasi di bawah menu "Persetujuan" (parent_id = 110)
-- 4.1 Halaman Daftar Persetujuan Kirim Gudang (Khusus Review & Setujui)
INSERT INTO `menu` (`nama`, `url`, `parent`, `parent_id`, `sub1`, `sub2`, `sub3`, `icon`, `hapus`, `urutan`) 
SELECT 'Persetujuan Kirim Gudang', 'Persetujuanuser/kirimgudang', 0, 110, 1, 0, 0, 'fas fa-circle', 0, 1
WHERE NOT EXISTS (
    SELECT 1 FROM `menu` WHERE `url` = 'Persetujuanuser/kirimgudang'
);

-- 4.2 Halaman Pengaturan User Penerima Notifikasi Persetujuan (CRUD User)
INSERT INTO `menu` (`nama`, `url`, `parent`, `parent_id`, `sub1`, `sub2`, `sub3`, `icon`, `hapus`, `urutan`) 
SELECT 'Pengaturan Persetujuan User', 'Persetujuanuser', 0, 110, 1, 0, 0, 'fas fa-circle', 0, 5
WHERE NOT EXISTS (
    SELECT 1 FROM `menu` WHERE `url` = 'Persetujuanuser'
);

-- 5. Berikan hak akses menu baru ke user yang memiliki akses menu Persetujuan (id 110) jika belum terdaftar
INSERT INTO `usermenu` (`userid`, `menuid`)
SELECT u.`userid`, m.`id`
FROM `usermenu` u
JOIN `menu` m ON m.`url` = 'Persetujuanuser/kirimgudang'
WHERE u.`menuid` = 110
  AND NOT EXISTS (
    SELECT 1 FROM `usermenu` um WHERE um.`userid` = u.`userid` AND um.`menuid` = m.`id`
  )
GROUP BY u.`userid`, m.`id`;

INSERT INTO `usermenu` (`userid`, `menuid`)
SELECT u.`userid`, m.`id`
FROM `usermenu` u
JOIN `menu` m ON m.`url` = 'Persetujuanuser'
WHERE u.`menuid` = 110
  AND NOT EXISTS (
    SELECT 1 FROM `usermenu` um WHERE um.`userid` = u.`userid` AND um.`menuid` = m.`id`
  )
GROUP BY u.`userid`, m.`id`;
