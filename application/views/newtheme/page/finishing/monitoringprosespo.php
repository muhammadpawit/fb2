<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
     	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        	<span aria-hidden="true">×</span>
        </button>
		<?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
		</div>
	</div>
</div>
<div class="row no-print">
	<div class="row">
		
	</div>
	<div class="col-md-12">
            <div class="card card-light card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">QC <span class="badge bg-black"><?php echo count_mdetails(1)?></span> </a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-returs-tab" data-toggle="pill" href="#custom-tabs-one-returs" role="tab" aria-controls="custom-tabs-one-pendings" aria-selected="false">Retur <span class="badge bg-black"><?php echo count_mdetails(12)?></span></a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-home-bordir-tab" data-toggle="pill" href="#custom-tabs-one-home-bordir" role="tab" aria-controls="custom-tabs-one-home-bordir" aria-selected="true">Tambah Bordir <span class="badge bg-black"><?php echo count_mdetails(15)?></span> </a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-tress-tab" data-toggle="pill" href="#custom-tabs-one-tress" role="tab" aria-controls="custom-tabs-one-tress" aria-selected="false">Tress <span class="badge bg-black"><?php echo count_mdetails(16)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Lobang Kancing <span class="badge bg-black"><?php echo count_mdetails(2)?></span></a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-pasangkancing-tab" data-toggle="pill" href="#custom-tabs-one-pasangkancing" role="tab" aria-controls="custom-tabs-one-pasangkancing" aria-selected="false">Pasang Kancing <span class="badge bg-black"><?php echo count_mdetails(17)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Siap Cucian <span class="badge bg-black"><?php echo count_mdetails(3)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Proses Cucian <span class="badge bg-black"><?php echo count_mdetails(4)?></span></a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-siapkirimcmts" role="tab" aria-controls="custom-tabs-one-siapkirimcmts" aria-selected="false">Siap Kirim CMT <span class="badge bg-black"><?php echo count_mdetails(13)?></span></a>
                  </li>
                 <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-sbbs-tab" data-toggle="pill" href="#custom-tabs-one-sbbs" role="tab" aria-controls="custom-tabs-one-sbbs" aria-selected="false">Siap Buang Benang <span class="badge bg-black"><?php echo count_mdetails(5)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-psbbs-tab" data-toggle="pill" href="#custom-tabs-one-psbbs" role="tab" aria-controls="custom-tabs-one-psbbs" aria-selected="false">Proses Buang Benang <span class="badge bg-black"><?php echo count_mdetails(6)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-spackings-tab" data-toggle="pill" href="#custom-tabs-one-spackings" role="tab" aria-controls="custom-tabs-one-spackings" aria-selected="false">Siap Packing <span class="badge bg-black"><?php echo count_mdetails(7)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-ppackings-tab" data-toggle="pill" href="#custom-tabs-one-ppackings" role="tab" aria-controls="custom-tabs-one-ppackings" aria-selected="false">Proses Packing <span class="badge bg-black"><?php echo count_mdetails(8)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-sgudangs-tab" data-toggle="pill" href="#custom-tabs-one-sgudangs" role="tab" aria-controls="custom-tabs-one-sgudangs" aria-selected="false">Siap Kirim Gudang <span class="badge bg-black"><?php echo count_mdetails(9)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-pendings-tab" data-toggle="pill" href="#custom-tabs-one-pendings" role="tab" aria-controls="custom-tabs-one-pendings" aria-selected="false">Pendingan <span class="badge bg-black"><?php echo count_mdetails(10)?></span></a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-samples-tab" data-toggle="pill" href="#custom-tabs-one-samples" role="tab" aria-controls="custom-tabs-one-samples" aria-selected="false">Kirim Sample <span class="badge bg-black"><?php echo count_mdetails(14)?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-selesais-tab" data-toggle="pill" href="#custom-tabs-one-selesais" role="tab" aria-controls="custom-tabs-one-selesais" aria-selected="false">Selesai <span class="badge bg-black"><?php echo count_mdetails(11)?></span></a>
                  </li>
				  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-hapuss-tab" data-toggle="pill" href="#custom-tabs-one-hapuss" role="tab" aria-controls="custom-tabs-one-hapuss" aria-selected="false">Hapus <span class="badge bg-black"><?php echo count_mdetails_hapus()?></span></a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="1">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO di QC</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(1) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                    		
                    	</div>
                    </form>
                  </div>
				  <div class="tab-pane fade" id="custom-tabs-one-home-bordir" role="tabpanel" aria-labelledby="custom-tabs-one-home-bordir-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="15">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO Tambah Bordir</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(15) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                    		
                    	</div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($qc as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="2">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO di Lobang Kancing</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(2) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

				  <div class="tab-pane fade" id="custom-tabs-one-tress" role="tabpanel" aria-labelledby="custom-tabs-one-tress-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="16">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO di Lobang Tress</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(16) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

				  <div class="tab-pane fade" id="custom-tabs-one-pasangkancing" role="tabpanel" aria-labelledby="custom-tabs-one-pasangkancing-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="17">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO di Lobang Tress</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(17) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                     <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($kancing as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="3">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(3) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                     		
                    	</div>
                    </form>
                  </div>
				  <div class="tab-pane fade" id="custom-tabs-one-siapkirimcmts" role="tabpanel" aria-labelledby="custom-tabs-one-siapkirimcmts-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="13">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(13) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div> 
				  <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($siapcucian as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="4">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(4) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-sbbs" role="tabpanel" aria-labelledby="custom-tabs-one-sbbs-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($prosescucian as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="5">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(5) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-psbbs" role="tabpanel" aria-labelledby="custom-tabs-one-psbbs-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($siapbuangbenang as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="6">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(6) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-spackings" role="tabpanel" aria-labelledby="custom-tabs-one-spackings-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($prosesbuangbenang as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="7">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(7) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-ppackings" role="tabpanel" aria-labelledby="custom-tabs-one-ppackings-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($siappacking as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="8">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(8) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-sgudangs" role="tabpanel" aria-labelledby="custom-tabs-one-sgudangs-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="9">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(9) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-pendings" role="tabpanel" aria-labelledby="custom-tabs-one-pendings-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($siapkirimgudang as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="10">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(10) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-returs" role="tabpanel" aria-labelledby="custom-tabs-one-returs-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="12">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(12) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

				  <div class="tab-pane fade" id="custom-tabs-one-samples" role="tabpanel" aria-labelledby="custom-tabs-one-samples-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($po as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="14">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(14) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                  <div class="tab-pane fade" id="custom-tabs-one-selesais" role="tabpanel" aria-labelledby="custom-tabs-one-selesais-tab">
                    <form method="post" action="<?php echo $action; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($pending as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="proses" value="11">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(mdetails(11) as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

				  <div class="tab-pane fade" id="custom-tabs-one-hapuss" role="tabpanel" aria-labelledby="custom-tabs-one-hapuss-tab">
                    <form method="post" action="<?php echo $action_hapus; ?>">
                    	<div class="row">
							<div class="col-md-6">
								<div class="form-group">
		                    		<label>Kode PO</label>
			                    	<select name="prods[][kode_po]" style="width:100% !important;" class="form-control select2bs4" data-live-search="true" multiple="multiple">
			                    		<?php foreach($tarpo as $p){?>
			                    			<option value="<?php echo $p['nama_po']?>-<?php echo $p['kode_po']?>"><?php echo $p['kode_po']?></option>
			                    		<?php } ?>
			                    	</select>
		                    	</div>
		                    	<div class="form-group">
		                    		<input type="hidden" name="hapus" value="1">
		                    		<button class="btn btn-success btn-sm">Simpan</button>
		                    	</div>
							</div>
							<div class="col-md-6">
								<label>Rincian PO</label>
								<div style="height: 200px;overflow: auto">
									<?php foreach(proses_pohapus() as $k){?>
										<span class="badge bg-green"><?php echo $k['kode_po']?></span>
									<?php } ?>
								</div>
							</div>                      		
                    	</div>
                    </form>
                  </div>

                </div>
              </div>
              <!-- /.card -->
            </div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group text-center">
			<label>Monitoring PO<br>Periode : <?php echo date('d F Y',strtotime($tanggal1)) .' - '. date('d F Y',strtotime($tanggal2)); ?><br>Tahun Produksi 2023-2024</label>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>PO Kemeja</label>
			<table class="table table-bordered table striped">
				<thead>
					<tr>
						<th>Jenis PO</th>
						<td>Jumlah PO</td>
						<td>QC</td>
						<td>Tambah Bordir</td>
						<td>LB Kancing</td>
						<td>Siap Cucian</td>
						<td>Proses Cucian</td>
						<td>Siap Buang Benang</td>
						<td>Proses Buang Benang</td>
						<td>Siap Packing</td>
						<td>Proses Packing</td>
						<td>Siap Kirim Gudang</td>
						<td>Pending</td>
						<td>Retur</td>
					</tr>
				</thead>
				<tbody>
					<?php foreach($kemeja as $k){?>
						<?php if($k['jmlpo'] >0){ ?>
							<tr align="center">
								<td><?php echo $k['nama']?></td>
								<td><?php echo $k['jmlpo']?></td>
								<td><?php echo $k['qc']?></td>
								<td><?php echo $k['tambahbordir']?></td>
								<td><?php echo $k['kancing']?></td>
								<td><?php echo $k['siapcucian']?></td>
								<td><?php echo $k['prosescucian']?></td>
								<td><?php echo $k['siapbuangbenang']?></td>
								<td><?php echo $k['prosesbuangbenang']?></td>
								<td><?php echo $k['siappacking']?></td>
								<td><?php echo $k['prosespacking']?></td>
								<td><?php echo $k['siapkirimgudang']?></td>
								<td><?php echo $k['pending']?></td>
								<td><?php echo $k['retur']?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row table-responsive">
	<div class="col-md-12">
		<div class="form-group">
			<label>PO Kaos</label>
			<table class="table table-bordered table striped">
				<thead style="background-color: pink;">
					<tr style="text-align:center;font-weight:bold">
						<th rowspan="2">Jenis PO</th>
						<td rowspan="2">Jumlah PO Setor</td>
						<td rowspan="2">Proses Cek BPO</td>
						<td colspan="4">PO Celana Jeans</td>
						<td rowspan="2">Kirim Sample Toko</td>
						<td rowspan="2">Retur Ke CMT</td>
						<td rowspan="2">Siap Kirim Gudang</td>
						<td rowspan="2">PO Permak</td>
						<td rowspan="2">PO Sudah Kirim Gudang HS</td>
					</tr>
					<tr style="text-align:center;font-weight:bold">
						<td>Siap Masuk Laundry</td>
						<td>Proses Laundry</td>
						<td>Siap Kirim Ke CMT</td>
						<td>Proses Packing Di CMT</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$jmlpo_all=0;
						$qc=0;
						$siapcucian=0;
						$prosescucian=0;
						$siapkirimcmt=0;
						$prosespacking=0;
						$kirimsample=0;
						$retur=0;
						$siapkirimgudang=0;
						$pending=0;
						$selesai=0;
						$jmlpo=0;
					?>
					
					<?php foreach($kaos as $k){?>
						<?php 
							$jmlpo=($k['qc']+$k['siapcucian']+$k['prosescucian']+$k['siapkirimcmt']+$k['prosespacking']+$k['kirimsample']+$k['retur']+$k['siapkirimgudang']+$k['pending']+$k['selesai']);
						?>
						<?php if($jmlpo > 0){ ?>
							<tr align="center">
								<td><?php echo $k['nama']?></td>
								<td><?php echo $jmlpo?></td>
								<td><?php echo $k['qc']?></td>
								<td><?php echo $k['siapcucian']?></td>
								<td><?php echo $k['prosescucian']?></td>
								<td><?php echo $k['siapkirimcmt']?></td>
								<td><?php echo $k['prosespacking']?></td>
								<td><?php echo $k['kirimsample']?></td>
								<td><?php echo $k['retur']?></td>
								<td><?php echo $k['siapkirimgudang']?></td>
								<td><?php echo $k['pending']?></td>
								<td><?php echo $k['selesai']?></td>
							</tr>
							<?php
								$jmlpo_all+=$jmlpo;
								$qc+=($k['qc']);
								$siapcucian+=($k['siapcucian']);
								$prosescucian+=($k['prosescucian']);
								$siapkirimcmt+=($k['siapkirimcmt']);
								$prosespacking+=($k['prosespacking']);
								$kirimsample+=($k['kirimsample']);
								$retur+=($k['retur']);
								$siapkirimgudang+=($k['siapkirimgudang']);
								$pending+=($k['pending']);
								$selesai+=($k['selesai']);
							?>
						<?php } ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr align="center" style="background-color: yellow;">
						<td><b>Total</b></td>
						<td><b><?php echo $jmlpo_all ?></b></td>
						<td><b><?php echo $qc ?></b></td>
						<td><b><?php echo $siapcucian ?></b></td>
						<td><b><?php echo $prosescucian ?></b></td>
						<td><b><?php echo $siapkirimcmt ?></b></td>
						<td><b><?php echo $prosespacking ?></b></td>
						<td><b><?php echo $kirimsample ?></b></td>
						<td><b><?php echo $retur ?></b></td>
						<td><b><?php echo $siapkirimgudang ?></b></td>
						<td><b><?php echo $pending ?></b></td>
						<td><b><?php echo $selesai ?></b></td>
					</tr>
					<tr>
						<td colspan="13">Di Update terakhir 
							<?php if(!empty($log)){ ?>
								<b><?php echo $log['oleh']; ?>, tanggal : <?php echo date('d F Y H:i:s',strtotime($log['tanggal'])); ?></b>
							<?php } ?>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>
<div class="row no-print">
	<div class="col-md-6">
		<div class="form-group">
			<button onclick="window.print()" class="btn btn-info btn-sm full">Print</button>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<button onclick="filtertglonly_excel()" class="btn btn-success btn-sm full">Excel</button>
		</div>
	</div>
</div>