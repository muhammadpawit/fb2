<?php
$namafile='Gaji_Bulanan_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }

  .besar {font-size: 14px;}
</style>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-48e7{color:#404040;text-align:center;vertical-align:middle}
.tg .tg-0lax{text-align:left;vertical-align:top}
</style>
<table class="tg" border="1" style="width: 100%;border-collapse: collapse;">
<thead>
<tr>
    <td colspan="20" align="center"><h2>Gaji Karyawan Konveksi</h2></td>
</tr>
  <tr>
    <td class="tg-0lax" rowspan="2">NO</td>
    <td class="tg-0lax" rowspan="2">Nama</td>
    <td class="tg-0lax" rowspan="2">Bagian</td>
    <td class="tg-0lax" rowspan="2">Tgl Masuk</td>
    <td class="tg-0lax" rowspan="2">Masa Kerja (THN)</td>
    <td class="tg-0lax" colspan="3">Rincian Gaji / Bulan (RP)</td>
    <td class="tg-0lax" rowspan="2">Total Kasbon (RP)</td>
    <td class="tg-0lax" colspan="6">Rincian Pinjaman (RP)</td>
    <td class="tg-0lax" colspan="3">Potongan Lain-Lain</td>
    <td class="tg-0lax" rowspan="2">Gaji Yang Diterima (RP)</td>
    <td class="tg-0lax" rowspan="2">Ket</td>
  </tr>
  <tr>
    <td class="tg-0lax">Gaji Kotor (RP)</td>
    <td class="tg-0lax">Gantungan Gaji (RP)</td>
    <td class="tg-0lax">Gaji Besih (RP)</td>
    <td class="tg-48e7">PINJAMAN ( Rp )</td>
    <td class="tg-48e7">POT / BULAN ( Rp )</td>
    <td class="tg-48e7">POT 1</td>
    <td class="tg-48e7">POT 2</td>
    <td class="tg-48e7">SISA PINJAMAN ( Rp )</td>
    <td class="tg-48e7">STATUS</td>
    <td class="tg-48e7">ABSENSI ( Rp )</td>
    <td class="tg-48e7">TERLAMBAT ( Rp )</td>
    <td class="tg-48e7">CLAIM ( Rp )</td>
  </tr>
</thead>
<tbody>
    <?php 
        $gajikotor=0;
        $gantungan_gaji=0;
        $gaji_bersih=0;
        $total_kasbon=0;
        $pinjaman=0;
        $pot_pinjamanperbulan=0;
        $pot1=0;
        $pot2=0;
        $sisa_pinjaman=0;
        $status=0;
        $potongan_absensi=0;
        $potongan_keterlambatan=0;
        $potongan_claim=0;
        $gaji_yangditerima=0;
    ?>
    <?php foreach($gaji as $g){ ?>
    <tr>
        <td><?php echo $g['no']?></td>
        <td><?php echo $g['nama']?></td>
        <td><?php echo $g['divisi']?></td>
        <td><?php echo $g['tglmasuk']?></td>
        <td><?php echo $g['masakerja']?></td>
        <td><?php echo $g['gajikotor']?></td>
        <td><?php echo $g['gantungan_gaji']?></td>
        <td><?php echo $g['gaji_bersih']?></td>
        <td><?php echo $g['total_kasbon']?></td>
        <td><?php echo $g['pinjaman']?></td>
        <td><?php echo $g['pot_pinjamanperbulan']?></td>
        <td><?php echo $g['pot1']?></td>
        <td><?php echo $g['pot2']?></td>
        <td><?php echo $g['sisa_pinjaman']?></td>
        <td><?php echo $g['status']?></td>
        <td><?php echo $g['potongan_absensi']?></td>
        <td><?php echo $g['potongan_keterlambatan']?></td>
        <td><?php echo $g['potongan_claim']?></td>
        <td><?php echo $g['gaji_yangditerima']?></td>
        <td><?php echo $g['keterangan']?></td>
    </tr>
    <?php 
        $gajikotor+=($g['gajikotor']);
        $gantungan_gaji+=($g['gantungan_gaji']);
        $gaji_bersih+=($g['gaji_bersih']);
        $total_kasbon+=($g['total_kasbon']);
        $pinjaman+=($g['pinjaman']);
        $pot_pinjamanperbulan+=($g['pot_pinjamanperbulan']);;
        $pot1+=($g['pot1']);
        $pot2+=($g['pot2']);
        $sisa_pinjaman+=($g['sisa_pinjaman']);
        $potongan_absensi+=($g['potongan_absensi']);
        $potongan_keterlambatan+=($g['potongan_keterlambatan']);
        $potongan_claim+=($g['potongan_claim']);
        $gaji_yangditerima+=($g['gaji_yangditerima']);
    ?>
    <?php } ?>
</tbody>
<tfoot>
    <tr style="text-align: center;background-color:yellow">
        <td colspan="5" align="center"><b>Total (RP)</b></td>
        <td><?php echo $gajikotor ?></td>
        <td><?php echo $gantungan_gaji ?></td>
        <td><?php echo $gaji_bersih ?></td>
        <td><?php echo $total_kasbon ?></td>
        <td><?php echo $pinjaman ?></td>
        <td><?php echo $pot_pinjamanperbulan ?></td>
        <td><?php echo $pot1 ?></td>
        <td><?php echo $pot2 ?></td>
        <td><?php echo $sisa_pinjaman ?></td>
        <td></td>
        <td><?php echo $potongan_absensi ?></td>
        <td><?php echo $potongan_keterlambatan ?></td>
        <td><?php echo $potongan_claim ?></td>
        <td><?php echo $gaji_yangditerima ?></td>
        <td></td>
    </tr>
</tfoot>
</table>