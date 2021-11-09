<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=KirimSetorCMT_".strtoupper($products['cmt_name']).".xls");
?>
<h3>Laporan Kirim Setor CMT</h3>
<div class="row">
	<div class="col-md-12">
		<div class="card" style="background-color: #0F4B66;color: black">
          <div class="card-header">
            <div class="card-title">
              <h3>Stok <?php echo strtolower($products['cmt_name'])?></h3>
            </div>
          </div>
        </div>
	</div>
	<div class="col-md-12 table-responsive">
		<table class="table table-bordered" border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th>PO</th>
					<?php foreach($jenis as $j){?>
					<th><?php echo $j['nama_jenis_po']?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
					<tr>
						<td>Rincian</td>
						<?php foreach($prods as $p){?>
						<td><?php echo $p['rincian']?></td>
						<?php } ?>
					</tr>
			</tbody>
			<tfoot>
				<tr>
					<td>Jumlah PO</td>
					<?php foreach($prods as $p){?>
					<td><?php echo $p['jmlpo']?></td>
					<?php } ?>
				</tr>
				<tr>
					<td>Total Pcs</td>
					<?php foreach($prods as $p){?>
					<td><?php echo $p['pcspo']?></td>
					<?php } ?>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
</br>
<div class="row">
	<div class="col-md-12">
		<div class="card" style="background-color: #0F4B66;color: black">
          <div class="card-header">
            <div class="card-title">
              <h3>Setor <?php echo strtolower($products['cmt_name'])?></h3>
            </div>
          </div>
        </div>
	</div>
	<div class="col-md-12 table-responsive">
		<table class="table table-bordered" border="1" style="width: 100%;border-collapse: collapse;">
			<thead>
				<tr>
					<th>PO</th>
					<?php foreach($jenis as $j){?>
					<th><?php echo $j['nama_jenis_po']?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
					<tr>
						<td>Rincian</td>
						<?php foreach($setors as $p){?>
						<td><?php echo $p['rincian']?></td>
						<?php } ?>
					</tr>
			</tbody>
			<tfoot>
				<tr>
					<td>Jumlah PO</td>
					<?php foreach($setors as $p){?>
					<td><?php echo $p['jmlpo']?></td>
					<?php } ?>
				</tr>
				<tr>
					<td>Total Pcs</td>
					<?php foreach($setors as $p){?>
					<td><?php echo $p['pcspo']?></td>
					<?php } ?>
				</tr>
			</tfoot>
		</table>
	</div>
</div>