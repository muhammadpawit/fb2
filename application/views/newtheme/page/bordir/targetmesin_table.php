<div class="row">
	<div class="col-md-6">
		<label>Mesin 1,2,5,6,7,8,9,10</label>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Target</th>
					<th>Bonus</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products['mesin1'] as $p){?>
					<tr>
						<td><?php echo $p['target']?></td>
						<td><?php echo $p['bonus']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-6">
		<label>Mesin 3,4</label>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>Target</th>
					<th>Bonus</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($products['mesin2'] as $p){?>
					<tr>
						<td><?php echo $p['target']?></td>
						<td><?php echo $p['bonus']?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>