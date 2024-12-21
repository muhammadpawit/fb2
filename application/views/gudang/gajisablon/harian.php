<div class="row no-print">
	<div class="col-md-4">
		<div class="form-group">
			<label>Nama Karyawan</label>
			<select name="id_karyawan_harian" id="id_karyawan_harian" class="select2bs4 kar" required>
				<option value="*"></option>
				<?php foreach($kar as $k){ ?>
					<option value="<?php echo $k['id']?>" data-item="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtergaji()">Filter</button>
			<button onclick="window.print()" class="btn btn-info btn-sm">Print</button>
			<button onclick="excelwithtgl()" class="btn btn-info btn-sm">Excel</button>
			 <a class="btn btn-info btn-sm" href="<?php echo $tambah ?>">Tambah</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<table class="table table-bordered nosearch">
				<thead>
					<tr>
						<th>No</th>
						<th>Periode</th>
						<th>Nama</th>
						<th>Senin</th>
						<th>Selasa</th>
						<th>Rabu</th>
						<th>Kamis</th>
						<th>Jumát</th>
						<th>Sabtu</th>
						<th>Total</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;$total=0;?>
					<?php foreach($prods as $k){?>
						<tr>
							<td><?php echo $no++?></td>
							<td><?php echo $k['periode'] ?></td>
							<td><?php echo $k['nama'] ?></td>
							<td><?php echo ($k['senin']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['selasa']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['rabu']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['kamis']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['jumat']*$k['gajiperhari']) ?></td>
							<td><?php echo ($k['sabtu']*$k['gajiperhari']) ?></td>
							<td><?php echo number_format(($k['senin']*$k['gajiperhari']) + ($k['selasa']*$k['gajiperhari']) + ($k['rabu']*$k['gajiperhari']) + ($k['kamis']*$k['gajiperhari']) + ($k['jumat']*$k['gajiperhari']) + ($k['sabtu']*$k['gajiperhari']))?></td>
							<td>
								<a href="<?php echo BASEURL?>Gajisablon/hapusharian/<?php echo $k['id']?>" class="btn btn-xs btn-danger" onclick="return confirm('Apakah yakin akn menghapus data ini ?')"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						<?php 
							$total+=(($k['senin']*$k['gajiperhari']) + ($k['selasa']*$k['gajiperhari']) + ($k['rabu']*$k['gajiperhari']) + ($k['kamis']*$k['gajiperhari']) + ($k['jumat']*$k['gajiperhari']) + ($k['sabtu']*$k['gajiperhari']));
						?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="9"><b>Total</b></td>
						<td>
							<b><?php echo number_format($total) ?></b>
						</td>
					</tr>
				</tfoot>
			</table>		
		</div>
	</div>
</div>
<script>

function filtergaji(){
    var url='?';
    var id_karyawan_harian =$("#id_karyawan_harian").val();
    var tanggal2 =$("#tanggal2").val();
    if(id_karyawan_harian){
      url+='&id_karyawan_harian='+id_karyawan_harian;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }
    location =url;
  }

</script>