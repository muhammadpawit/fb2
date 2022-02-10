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
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th class="tg-0lax">No</th>
				    <th class="tg-0lax">Periode</th>
				    <th class="tg-0lax">Pendapatan</th>
				    <th class="tg-0lax">Pengeluaran</th>
				    <th class="tg-0lax">Saldo</th>
				    <th class="tg-0lax">Keterangan</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tg-0lax">1</td>
				    <td rowspan="4">Bordir<br></td>
				    <td align="center" class="tg-0lax"><?php echo number_format($podalam)?></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">PO Dalam</td>
				</tr>
				<tr>
					<td class="tg-0lax">2</td>
				    <td align="center" class="tg-0lax"><?php echo number_format($poluar)?></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">PO Luar</td>
				</tr>
				<tr>
					<td class="tg-0lax">3</td>
				    <td class="tg-0lax"></td>
				    <td align="center" class="tg-0lax"><?php echo number_format($keluar)?></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">Pengeluaran alur kas bordir</td>
				</tr>
				<tr>
					<td class="tg-0lax">4</td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax">Laba Pendapatan Bordir</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td class="tg-0lax" colspan="2" align="center"><h5>Total (Rp)</h5></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax"></td>
				    <td class="tg-0lax" align="center" style="background-color:#dbdb02;"><h5><?php echo number_format(($podalam+$poluar)-$keluar)?></h5></td>
				    <td class="tg-0lax"></td>
				</tr>
				<tr>
					<td colspan="6" align="right"><i class="registered">Registered by Forboys Production System <?php echo date('d-m-Y Y H:i:s'); ?></i></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>