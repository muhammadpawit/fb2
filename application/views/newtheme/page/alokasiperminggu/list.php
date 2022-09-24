<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <!-- <iframe src="https://docs.google.com/spreadsheets/d/1Il5bKewIi7W6KW0DfBB248Jf3E2H8dCNrHdVD0Kw2g0/edit?usp=sharing" class="full" style="height:800px"></iframe> -->
    </div>
  </div>
</div>
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
            <input type="text" value="<?php echo $tanggal1?>" class="form-control" name="tanggal1">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="text" class="form-control" name="tanggal2" value="<?php echo $tanggal2?>">
        </div>
    </div>
    <div class="col-md-4">
        <label>Aksi</label><br>
        <a onclick="filter()" class="btn btn-info text-white">Filter</a>
        <a onclick="exceldalam()" class="btn btn-info text-white">Excel</a>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="text-center">
			<h5>Alokasi PO</h5>
		</div>
	</div>
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
			  <tr align="center">
			    <th class="tg-0lax" rowspan="2">No</th>
			    <th class="tg-0lax" rowspan="2">Nama CMT</th>
			    <th class="tg-0lax" rowspan="2">Jumlah Katun</th>
			    <th class="tg-0lax" colspan="2">PO Yang Di Setor</th>
			    <th class="tg-0lax" colspan="2">Stok PO CMT</th>
			    <th class="tg-0lax"></th>
			  </tr>
			  <tr align="center">
			    <th class="tg-0lax">O / K</th>
			    <th class="tg-0lax">Jeans</th>
			    <th class="tg-0lax">O / K</th>
			    <th class="tg-0lax">Jeans</th>
			    <th class="tg-0lax"></th>
			  </tr>
			</thead>
			<tbody>
				<?php foreach($serang as $s){?>
					<tr>
						<td></td>
						<td><?php echo $s['nama']?></td>
						<td></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>