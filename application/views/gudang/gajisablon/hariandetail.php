<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered nosearch">
				<thead>
					<tr>
						<th>Nama</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;?>
					<?php foreach($prods as $k){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $k['periode'] ?></td>
							<td><?php echo $k['nama'] ?></td>
							<td>
								<a href="<?php echo BASEURL?>Gajisablon/hariandetail/<?php echo $k['id']?>" class="btn btn-xs btn-warning">Detail</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>		
		</div>
	</div>
</div>