<div class="row">
	<div class="col-md-12">
		<table class="table">
			<thead>
				<tr style="text-align: center;">
					<th>Slip Gaji Forboys Production</th>
				</tr>
			</thead>
		</table>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>:</th>
					<th><?php echo date('d-m-Y',strtotime($slip['tanggal']))?></th>
				</tr>
				<tr>
					<th>NIK</th>
					<th>:</th>
					<th><?php echo strtolower($nik) ?></th>
				</tr>
				<tr>
					<th>Nama Karyawan</th>
					<th>:</th>
					<th><?php echo strtolower($nama) ?></th>
				</tr>
				<tr>
					<th>Jabatan</th>
					<th>:</th>
					<th><?php echo strtolower($bagian) ?></th>
				</tr>
				<tr>
					<th>Divisi</th>
					<th>:</th>
					<th><?php echo strtolower($divisi) ?></th>
				</tr>
			</thead>
		</table>
		<br>
		<table class="no-print">
			<thead style="text-align: left;">
				<tr>
					<th width="50%"></th>
					<th width="50%"></th>
				</tr>
				<tr>
					<th height="80" valign="bottom">
						<a href="<?php echo $batal?>" class="btn btn-danger btn-sm text-white">Kembali</a>
						<a href="<?php echo $cetak?>" target="_blank" class="btn btn-default btn-sm text-white">Cetak Slip</a>
					</th>
					<th height="80" valign="bottom"></th>
				</tr>
			</thead>
		</table>
	</div>
	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Gaji Pokok</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['gajipokok']))?></th>
				</tr>
				<tr>
					<th>Gantungan Gaji</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['gantungan_gaji']))?></th>
				</tr>
				<tr>
					<th>Pot.Kasbon</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['potongan_kasbon']))?></th>
				</tr>
				<tr>
					<th>Pot.Pinjaman</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['potongan_pinjaman']))?></th>
				</tr>
				<tr>
					<th>Pot.Klaim</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['potongan_claim']))?></th>
				</tr>
				<tr>
					<th>Pot.Absensi</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['potongan_absensi']))?></th>
				</tr>
				<tr>
					<th>Pot.Terlambat</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['potongan_terlambat']))?></th>
				</tr>
				<tr>
					<th>Total</th>
					<th>:</th>
					<th style="text-align:right"><?php echo number_format(($slip['total']))?></th>
				</tr>
			</thead>
		</table>
		<br>
		<table>
			<thead style="text-align: center;">
				<tr>
					<th width="50%">Karyawan</th>
					<th width="50%">Admin Keuangan</th>
				</tr>
				<tr>
					<th height="80" valign="bottom">(_______________________)</th>
					<th height="80" valign="bottom">(_______________________)</th>
				</tr>
			</thead>
		</table>
	</div>
</div>