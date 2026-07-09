<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// $route['default_controller'] = 'login';
$route['default_controller'] = 'auth';
// $route['default_controller'] = 'auth/login';
// $route['auth/callback'] = 'auth/callback';
// $route['auth/logout'] = 'auth/logout';
$route['404_override'] = 'Dash/notfound';
$route['Ajuanalatalat/(:num)'] = 'Ajuanalatalat/index/$1';
$route['Accounting/coa'] = 'Bukubesar/coa';
$route['Accounting/coa_add'] = 'Bukubesar/coa_add';
$route['Accounting/coa_save'] = 'Bukubesar/coa_save';
$route['Accounting/coa_edit/(:any)'] = 'Bukubesar/coa_edit/$1';
$route['Accounting/coa_update'] = 'Bukubesar/coa_update';
$route['Accounting/coa_delete/(:any)'] = 'Bukubesar/coa_delete/$1';
$route['Accounting/jurnal'] = 'Bukubesar/jurnalumum';
$route['Accounting/laporan_laba_rugi'] = 'Pelaporankeuangan/laba_rugi';
$route['Accounting/laporan_neraca'] = 'Pelaporankeuangan/neraca';
$route['Accounting/saldo_awal'] = 'Bukubesar/saldoawal';
$route['Accounting/saldo_awal_save'] = 'Bukubesar/saldoawal_save';
$route['Accounting/aset_tetap'] = 'Aset/daftar_aset';
$route['Accounting/kas_transaksi'] = 'Manajemenkasbank/masuk_keluar';
$route['Accounting/pembelian'] = 'Utangusaha/invoice';
$route['translate_uri_dashes'] = FALSE;
