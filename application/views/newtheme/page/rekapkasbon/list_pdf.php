<style>
	body {
		font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
		background-color: whitesmoke;
	}

	.header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 12px;
            font-weight: normal;
        }
        .separator {
            width: 100%;
            height: 2px;
            background: #000;
            margin: 10px 0;
        }


	.details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
			font-size: 13.5px;
        }
        .details-table th, .details-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .details-table th {
            background-color: #f9f9f9;
            width: 30%;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
</style>
<div class="header">
            <h1>Forboys Production</h1>
            <h2>Rekap Kasbon Karyawan</h2>
        </div>
        <div class="separator"></div>
		<table class="details-table">
			<thead>
			  <tr align="center">
			  	<th rowspan="2">No.</th>
			    <th rowspan="2">Nama</th>
			    <th rowspan="2">Bagian</th>
			    <th rowspan="2">Tanggal Masuk</th>
			    <th rowspan="2">Gaji/Bulan</th>
			    <th colspan="<?php echo !empty($tgl)?count($tgl):1?>">Kasbon Mingguan (Rp)</th>
			    <th rowspan="2">Sisa Pinjaman</th>
			    <th rowspan="2">Pinjaman baru</th>
			    <th rowspan="2">Sisa Gaji</th>
			    <th rowspan="2">Keterangan</th>
			  </tr>
			  <tr align="center">
			  	<?php if(!empty($tgl)){?>
			  		<?php foreach($tgl as $t){?>
			  			<th><?php echo date('d/m/Y',strtotime($t['tanggal'])) ?></th>
			  		<?php } ?>
			  	<?php }else{ ?>
			  	<?php } ?>
			    
			  </tr>
			</thead>
			<tbody>
			<?php foreach($kar as $k){?>
			  <tr>
			    <td><?php echo $k['no']?></td>
			    <td><?php echo strtoupper($k['nama'])?></td>
			    <td><?php echo $k['bagian']?></td>
			    <td><?php echo $k['tgl']?><br><small>(<?php echo $k['lama']?>)</small></td>
			    <td><?php echo number_format($k['gaji'])?></td>
			    <?php if(!empty($tgl)){?>
			  		<?php foreach($tgl as $t){?>
			  			<td align="center"><?php echo number_format($this->KasbonModel->getkasbon($k['id'],$t['tanggal'])); ?></td>
			  		<?php } ?>
			  	<?php }else{ ?>
			  		<td align="center">-</td>
			  	<?php } ?>
			    <td>0</td> <!-- sisa pinjaman -->
			    <td><?php echo number_format($k['pinjaman'])?></td> <!-- pinjaman baru -->
			    <td><?php echo number_format($k['gaji']-$k['kasbon'])?></td>
			    <td>ket</td>
			  </tr>
			 <?php } ?>
			</tbody>
		</table>