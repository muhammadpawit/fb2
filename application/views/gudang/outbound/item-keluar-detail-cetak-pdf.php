<html>
	<head>
	<title><?php echo $title ?></title>
	</head>
	<body>
		<div class="title">
			<center>
				<h3>Surat Jalan Alat PO CMT<br>
				Nomor : <?php echo $barang[0]['faktur_no'] ?>
				</h3>
			</center>
		</div>
		<div class="subtitle">
			<table>
				<tr>
					<td>Kepada Yth</td>
					<td>:</td>
					<td><?php echo ucwords(strtolower($barang[0]['nama_penerima']))?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?php echo ucwords(strtolower($barang[0]['tujuan_item'])) ?></td>
				</tr>
			</table>
		</div>
		<div class="body">
			<table border="1" style="border-collapse: collapse;width: 100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<th>Qty</th>
						<th>Satuan</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1;$total=0;?>
					<?php foreach($barang as $key => $item){?>
						<tr>
							<td align="center"><?php echo $no++;?></td>
							<td><?php echo $item['nama_item_keluar'] ?></td>
							<td align="center"><?php echo $item['jumlah_item_keluar'] ?></td>
							<td align="center"><?php echo $item['satuan_jumlah_keluar'] ?></td>
						</tr>
						<?php $total+=($item['jumlah_item_keluar']); ?>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="2" align="center"><strong>Total</strong></td>
						<td align="center"><strong><?php echo $total ?></strong></td>
						<td></td>
					</tr>
				</tfoot>
			</table>
			<div class="ttd">
				<table>
					<tr>
						<td colspan="6">Jakarta, <?php echo format_tanggal($barang[0]['created_date']) ?> </td>
					</tr>
					<tr align="center">
						<td colspan="2">Security,</td>
						<td colspan="2"><?php if(!empty($alat)){ ?> Kepala Cabang <?php }else{ ?> Mandor Finishing <?php } ?></td>
						<td colspan="2"><?php if(!empty($alat)){ ?> Admin SKB <?php }else{ ?> Admin Gudang <?php } ?></td>
					</tr>
					<tr align="center">
						<td colspan="2">
							<br><br><br><br><br><br>
							(__________________)
						</td>
						<td colspan="2">
							<br><br><br><br><br><br>
							(<b style="padding:0px 25pt 0px 25pt;font-weight:0 !important">Kandar</b>)
						</td>
						<td colspan="2">
							<br><br><br><br><br><br>
							(<b style="padding:0px 25pt 0px 25pt;font-weight:0 !important">Ifah</b>)
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="registered">
        <i>Registered by Forboys Production System <?php echo format_tanggal_jam(date('d-m-Y H:i:s')); ?></i>
    </div>
	</body>
</html>