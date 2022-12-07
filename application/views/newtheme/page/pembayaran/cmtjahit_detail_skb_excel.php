 <?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Pemnbayaran_cmt_jahit_detail_po_".date('d F Y',strtotime($prods['tanggal'])).".xls");
?>
<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Baskervville:ital@1&display=swap');
  .registered {
    font-family: 'Baskervville', serif;
  }
</style>

<?php if(!empty($prods)){?>
     <input type="hidden" value="<?php echo $prods['tanggal'] ?>" name="tgl">
<div class="row">
    <div class="form-group">
        <table border="1" style="border-collapse: collapse;width: 100%">
            <tr>
                <td colspan="3"><b>Nama PO : <?php echo strtoupper($kode_po) ?> <input type="hidden" value="<?php echo strtoupper($kode_po) ?>" name="kode_po"></b></td>
                <td colspan="3"><b>Nama CMT : <?php echo GetName_cmt($cmt)?> <input type="hidden" name="id_cmt" value="<?php echo $cmt?>"></b></td>
            </tr>
            <tr align="center">
                <td>Tanggal</td>
                <td>Jumlah (dz)</td>
                <td>Jumlah (pc)</td>
                <td>Harga (pc)</td>
                <td>Nilai PO</td>
                <td>Ket</td>
            </tr>
            <tr align="center">
                <?php if(isset($kirim)){?>
                    <tr align="center">
                        <td><?php echo $kirim['tanggal']?></td>
                        <td><?php echo ($kirim['pcs']/12)?></td>
                        <td><?php echo ($kirim['pcs'])?></td>
                        <td><?php echo ($kirim['cmt_job_price'])?></td>
                        <td><?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12))?></td>
                        <td>-</td>
                    </tr>
                    <input type="hidden" name="po[0][tanggal]" value="<?php echo $kirim['tanggal']?>">
                    <input type="hidden" name="po[0][dz]" value="<?php echo ($kirim['pcs']/12) ?>">
                    <input type="hidden" name="po[0][pcs]" value="<?php echo ($kirim['pcs']) ?>">
                    <input type="hidden" name="po[0][harga]" value="<?php echo ($kirim['cmt_job_price']) ?>">
                    <input type="hidden" name="po[0][nilaipo]" value="<?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12)) ?>">
                <?php } ?>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <label>Setoran PO CMT</label>
        <table border="1" style="border-collapse: collapse;width: 100%">
            <tr>
                <th colspan="2"><center>Masuk</center></th>
                <th colspan="2"><center>Setoran</center></th>
                <th></th>
            </tr>
            <tr align="center">
                <td>Tanggal</td>
                <td>Jumlah (Pc)</td>
                <td>Jumlah (Pc)</td>
                <td>Sisa</td>
                <td>Ket</td>
            </tr>
           
            <?php $allsetor=0;$i=1;?>
            <?php foreach($setor as $s){?>
            <?php $allsetor+=($s['jumlah_pcs_setor']);?>
            <tr align="center">
                <td><input type="hidden" name="setor[<?php echo $i?>][tanggal]" value="<?php echo $s['tanggal']?>"><?php echo $s['tanggal']?></td>
                <td><?php echo $s['jumlah_pcs_kirim']?></td>
                <td><?php echo $s['jumlah_pcs_setor']?></td>
                <td></td>
                <td></td>
            </tr>
            <?php $i++;?>
            <?php } ?>
            <tr align="center">
                <td colspan="3"></td>
                <td><?php echo ($kirim['pcs']-$allsetor)?></td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <label>Pembayaran CMT</label>
        <table border="1" style="border-collapse: collapse;width: 100%">
            <thead>
            <tr>
                <th><center>Tanggal</center></th>
                <th><center>Rincian Setor (pcs)</center></th>
                <th><center>Kredit</center></th>
                <th><center>Saldo</center></th>
                <th><center>Ket</center></th>
                
            </tr>
            </thead>
            <tbody>
                <?php foreach($pmby as $pm){?>
                    <tr align="center">
                        <td><?php echo $pm['tanggal']?></td>
                        <td><?php echo $pm['rincian']?></td>
                        <td><?php echo $pm['kredit']?></td>
                        <td><?php echo $pm['saldo']?></td>
                        <td><?php echo $pm['keterangan']?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="form-group">
        <label>Pembelian Alat-alat</label>
        <table border="1" style="border-collapse: collapse;width: 100%">
            <thead>
                <tr>
                    <th><center>Nama Alat</center></th>
                    <th><center>Jumlah</center></th>
                    <th><center>Harga</center></th>
                    <th><center>Total</center></th>
                    <th><center>Keterangan</center></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($alat as $a){?>
                    <tr align="center">
                        <td><?php echo $a['rincian']?></td>
                        <td><?php echo $a['qty']?></td>
                        <td><?php echo $a['harga']?></td>
                        <td><?php echo ($a['qty']*$a['harga']) ?></td>
                        <td><?php echo $a['keterangan']?></td>
                    </tr>
                <?php } ?>
            </tbody>
            
            <tfoot></tfoot>
        </table>
    </div>
</div>
<?php } ?>