<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CloneDb extends CI_Controller {

	public function __construct(){
		parent::__construct();
		// Hanya bisa diakses via CLI untuk keamanan
		// Uncomment baris di bawah jika ingin membatasi akses hanya dari CLI
		// if (!$this->input->is_cli_request()) {
		// 	show_error('Akses hanya diizinkan melalui CLI', 403);
		// }
	}

	/**
	 * Clone semua data dari database sumber ke database lokal
	 * 
	 * Cara penggunaan via browser:
	 *   http://domain.com/CloneDb/clone_db
	 * 
	 * Cara penggunaan via CLI:
	 *   php index.php CloneDb clone_db
	 * 
	 * Konfigurasi database sumber ada di method _get_source_config()
	 */
	public function clone_db(){
		// Set time limit dan memory limit
		set_time_limit(0);
		ini_set('memory_limit', '1024M');

		// Koneksi database sumber (remote server)
		$source_config = $this->_get_source_config();
		$source_db = $this->load->database($source_config, TRUE);

		if (!$source_db->conn_id) {
			$this->_log("ERROR: Gagal konek ke database sumber!");
			return;
		}

		// Database lokal (default)
		$local_db = $this->db;
		// Disable db_debug agar error tidak menghentikan script
		$local_db->db_debug = FALSE;

		$this->_log("=== MULAI CLONE DATABASE ===");
		$this->_log("Sumber: {$source_config['hostname']} / {$source_config['database']}");
		$this->_log("Tujuan: localhost / " . $this->db->database);
		$this->_log("Waktu mulai: " . date('Y-m-d H:i:s'));
		$this->_log("-----------------------------------");

		// Ambil semua tabel dari database sumber
		$tables = $source_db->list_tables();

		if (empty($tables)) {
			$this->_log("ERROR: Tidak ada tabel ditemukan di database sumber!");
			$source_db->close();
			return;
		}

		$this->_log("Total tabel ditemukan: " . count($tables));
		$this->_log("-----------------------------------");

		// Disable foreign key checks agar tidak error saat truncate
		$local_db->query('SET FOREIGN_KEY_CHECKS = 0');

		$success_count = 0;
		$error_count = 0;
		$skip_count = 0;
		$total_rows = 0;

		foreach ($tables as $table) {
			$this->_log("Memproses tabel: {$table}");

			try {
				// Skip tabel dengan nama bermasalah (mengandung titik di akhir, spasi, dll)
				if (preg_match('/[\.\s]$/', $table)) {
					$this->_log("  -> SKIP: Nama tabel '{$table}' mengandung karakter bermasalah");
					$skip_count++;
					continue;
				}

				// Cek apakah tabel ada di database lokal
				if (!$local_db->table_exists($table)) {
					$this->_log("  -> SKIP: Tabel '{$table}' tidak ada di database lokal");
					$skip_count++;
					continue;
				}

				// Hitung jumlah data di sumber menggunakan raw query
				$count_query = $source_db->query("SELECT COUNT(*) as cnt FROM `{$table}`");
				if (!$count_query) {
					$this->_log("  -> ERROR: Gagal menghitung data tabel '{$table}', SKIP");
					$error_count++;
					continue;
				}
				$count = (int) $count_query->row()->cnt;
				$count_query->free_result();
				$this->_log("  -> Jumlah data sumber: {$count} rows");

				// Truncate tabel lokal
				$local_db->query("TRUNCATE TABLE `{$table}`");
				$this->_log("  -> Tabel lokal di-truncate");

				if ($count == 0) {
					$this->_log("  -> Tidak ada data untuk di-clone");
					$success_count++;
					continue;
				}

				// Clone data per batch (500 rows) untuk hemat memori
				$batch_size = 500;
				$offset = 0;
				$inserted = 0;
				$batch_error = false;

				while ($offset < $count) {
					$query = $source_db->query("SELECT * FROM `{$table}` LIMIT {$batch_size} OFFSET {$offset}");
					if (!$query) {
						$this->_log("  -> ERROR: Gagal baca data batch offset {$offset}");
						$batch_error = true;
						break;
					}
					$rows = $query->result_array();

					if (!empty($rows)) {
						// Build raw INSERT query untuk menghindari masalah nama tabel
						$columns = array_keys($rows[0]);
						$col_str = '`' . implode('`, `', $columns) . '`';
						$values_arr = [];
						foreach ($rows as $row) {
							$vals = [];
							foreach ($row as $val) {
								$vals[] = $val === null ? 'NULL' : $local_db->escape($val);
							}
							$values_arr[] = '(' . implode(',', $vals) . ')';
						}
						$insert_sql = "INSERT INTO `{$table}` ({$col_str}) VALUES " . implode(',', $values_arr);
						$result = $local_db->query($insert_sql);
						if (!$result) {
							$this->_log("  -> ERROR: Gagal insert batch offset {$offset}");
							$batch_error = true;
							break;
						}
						$inserted += count($rows);
					}

					$query->free_result();
					unset($rows, $values_arr);
					$offset += $batch_size;
				}

				if ($batch_error) {
					$error_count++;
					$this->_log("  -> PARTIAL: {$inserted} rows berhasil sebelum error");
				} else {
					$success_count++;
					$this->_log("  -> SUKSES: {$inserted} rows berhasil di-clone");
				}
				$total_rows += $inserted;


			} catch (\Throwable $e) {
				$this->_log("  -> ERROR: " . $e->getMessage());
				$error_count++;
			}
		}

		// Enable kembali foreign key checks
		$local_db->query('SET FOREIGN_KEY_CHECKS = 1');

		// Tutup koneksi sumber
		$source_db->close();

		$this->_log("-----------------------------------");
		$this->_log("=== CLONE DATABASE SELESAI ===");
		$this->_log("Tabel sukses : {$success_count}");
		$this->_log("Tabel skip   : {$skip_count}");
		$this->_log("Tabel error  : {$error_count}");
		$this->_log("Total rows   : {$total_rows}");
		$this->_log("Waktu selesai: " . date('Y-m-d H:i:s'));
	}

	/**
	 * Konfigurasi database sumber (remote server)
	 * Ubah sesuai dengan koneksi server sumber
	 */
	private function _get_source_config(){
		return array(
			'dsn'      => '',
			'hostname' => 'forboysproduction.com',       // Ganti dengan IP/hostname server sumber
			'username' => 'forboysp_2223',        // Ganti dengan username database sumber
			'password' => '65%$$F8rboysP',        // Ganti dengan password database sumber
			'database' => 'forboysp_2425',   // Ganti dengan nama database sumber
			'dbdriver' => 'mysqli',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => FALSE,
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt'  => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => FALSE
		);
	}

	/**
	 * Helper untuk menampilkan log
	 */
	private function _log($message){
		if ($this->input->is_cli_request()) {
			echo $message . PHP_EOL;
		} else {
			echo $message . "<br>";
		}
		if (ob_get_level() > 0) {
			ob_flush();
		}
		flush();
	}
}
