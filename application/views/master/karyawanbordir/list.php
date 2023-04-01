<div class="row">
	<div class="col-md-12">
		<p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                    </p>  
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table" id="datatable">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>No.Telp</th>
								<th>TglMasuk</th>
								<th>Gaji Harian</th>
								<th>Gaji Mingguan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($karyawan as $k){?>
								<tr>
									<td><?php echo $n++?></td>
									<td><?php echo strtolower($k['nama_karyawan_bordir'])?></td>
									<td><?php echo strtolower($k['no_telp'])?></td>
									<td><?php echo !empty($k['tgl_masuk'])?date('d F Y',strtotime($k['tgl_masuk'])):''?></td>
									<td><?php echo number_format($k['karyawan_gaji_weekday'],2)?></td>
									<td><?php echo number_format($k['karyawan_gaji_weekend'],2)?></td>
									<td>
										<a href="<?php echo BASEURL.'Masterdata/karyawanbordirhapus/'.$k['id_master_karyawan_bordir'];?>" class="badge bg-red">Hapus</a>
										<a href="<?php echo BASEURL.'Masterdata/karyawanbordiredit/'.$k['id_master_karyawan_bordir'];?>" class="badge bg-green">Edit</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
		</div>
	</div>
</div>