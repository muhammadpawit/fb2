<div class="row">
	<div class="col-md-12">
		<div class="card" style="background-color: #0F4B66;color: white">
          <div class="card-header">
            <div class="card-title">
              Stok <?php echo strtolower($products['cmt_name'])?>
            </div>
          </div>
        </div>
	</div>
	<div class="col-md-12 table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>PO</th>
					<?php foreach($prods as $p){?>
						<th><?php echo $p['nama']?></th>
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
		<div class="card" style="background-color: #0F4B66;color: white">
          <div class="card-header">
            <div class="card-title">
              Setor <?php echo strtolower($products['cmt_name'])?>
            </div>
          </div>
        </div>
	</div>
	<div class="col-md-12 table-responsive">
		<table class="table table-bordered" border="1">
			<thead>
				<tr>
					<th>PO</th>
					<?php foreach($setors as $p){?>
						<th><?php echo $p['nama']?></th>
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
<div class="row">
<div class="col-md-12 no-print">
		<br>
		<a href="<?php echo BASEURL.'Stockpo';?>" class="btn btn-danger btn-sm">Kembali</a>
		<a onclick="excel()" class="btn btn-info btn-sm text-white">Excel</a>
	</div>
</div>
<script type="text/javascript">
	function excel(){
		location ='?&excel=1';
	}
</script>