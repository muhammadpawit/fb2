<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_".time().".xls");
?>            
<style type="text/css">
  @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>
            <table border="1" cellpadding="5" style="border-collapse: collapse;border-width: 3px;width: 100%">
			<thead class="thead-light">
				<tr>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Nama CMT</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;">Kirim CMT</th>
					<th colspan="3" style="vertical-align: middle;text-align: center;">Setor CMT</th>
					<th rowspan="2" style="vertical-align: middle;text-align: center;">Keterangan</th>
				</tr>
				<tr>
					<th style="vertical-align: middle;text-align: center;">JML PO</th>
					<th style="vertical-align: middle;text-align: center;">Dz</th>
					<th style="vertical-align: middle;text-align: center;">Pcs</th>
					<th style="vertical-align: middle;text-align: center;">JML PO</th>
					<th style="vertical-align: middle;text-align: center;">Dz</th>
					<th style="vertical-align: middle;text-align: center;">Pcs</th>
				</tr>
			</thead>
			<tbody>
				<?php $totalsetor=0;?>
				<?php if($products){?>
					<?php foreach($products as $p){?>
					<tr>
						<td align="left"><?php echo $p['bulan']?></td>
						<td align="center"><?php echo $p['kirimpo']?></td>
						<td align="center"><?php echo ($p['kirimdz'])?></td>
						<td align="center"><?php echo $p['kirimpcs']?></td>
						<td align="center"><?php echo $p['setorjmlpo']?></td>
						<td align="center"><?php echo ($p['setordz'])?></td>
						<td align="center"><?php echo $p['setorpcs']?></td>
						<td></td>
					</tr>
					<?php $totalsetor+=$p['setorjmlpo'];?>
					<?php } ?>
					<tr>
						<td><b>Total</b></td>
						<td align="center"><b><?php echo $kirimpo?></b></td>
                        <td align="center"><b><?php echo ($kirimdz)?></b></td>
                        <td align="center"><b><?php echo ($kirimpcs)?></b></td>
                        <td align="center"><b><?php echo $totalsetor?></b></td>
                        <td align="center"><b><?php echo ($setordz)?></b></td>
                        <td align="center"><b><?php echo ($setorpcs)?></b></td>
					</tr>
				<?php }else{ ?>
					<tr>
						<td colspan="8">Silahkan pilih nama cmt</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	