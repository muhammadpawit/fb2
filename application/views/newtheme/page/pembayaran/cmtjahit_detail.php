<style>
    .box {
        margin-bottom: 20px;
    }

    .table th {
        vertical-align: middle !important;
        text-align: center;
    }

    .form-control {
        border-radius: 4px;
    }

</style>
<form method="post" action="<?php echo $update ?>">
    <input type="hidden" name="id" value="<?php echo $detail['id'] ?>"/>
    <input type="hidden" name="cmt" value="<?php echo $detail['idcmt'] ?>"/>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informasi Pembayaran CMT</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <b>Nama CMT</b><br>
                        <?php echo $namacmt; ?>
                    </div>
                    <div class="col-md-4">
                        <b>Periode</b><br>
                        <?php echo formatTanggalIndo($detail['tanggal']); ?>
                    </div>
                    <div class="col-md-4">
                        <b>Trip Ke</b><br>
                        <?php echo $detail['tripke']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header">
                <b>Keterangan</b>
            </div>
            <div class="box-body">
                <textarea class="form-control" name="keterangan" rows="2"
                    placeholder="Tambahkan keterangan pembayaran..."><?php echo $detail['keterangan']; ?></textarea>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Perhitungan PO</h3>
            </div>
            <div class="box-body table-responsive">
                <!-- TABLE ANDA TIDAK BERUBAH -->
                 <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead style="background-color: #5796ba;color: white;">
                            <tr>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">No</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Rincian PO</th>
                                <th colspan="2" style="vertical-align : middle;text-align:center;">Potongan PO</th>
                                <th colspan="2" style="vertical-align : middle;text-align:center;">Jumlah PO</th>
                                <th colspan="2" style="vertical-align : middle;text-align:center;">Jumlah Setor PO</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Pot Transport</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Harga/Dz (Rp)</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Total (Rp)</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Keterangan</th>
                            </tr>
                            <tr style="vertical-align : middle;text-align:center;">
                                <td>Dz</td>
                                <td>Pcs</td>
                                <td>Dz</td>
                                <td>Pcs</td>
                                <td>Dz</td>
                                <td>Pcs</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $n=1;$jmlpodz=0;$jmlpopcs=0;$jmldz=0;$jmlpcs=0;$total=0;$potongan=0;?>
                            <?php foreach($products as $p){?>
                                <?php
                                    $potongan+=($p['potongan']);
                                    $jmlpodz+=($p['jumlah_po_dz']);
                                    $jmlpopcs+=($p['jumlah_po_pcs']);
                                    $jmldz+=($p['jumlah_dz']);
                                    $jmlpcs+=($p['jumlah_pcs']);
                                    //$total+=($p['jumlah_dz']*$p['harga']);
                                    $total+=($p['total']-$p['potpertama']);
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $n?>
                                        <input type="hidden" name="products[<?php echo $n?>][id]" value="<?php echo $p['id'] ?>"/>
                                    </td>
                                    <td><?php echo strtoupper($p['kode_po'])?></td>
                                    <td align="center"><?php echo number_format(($p['potongan']/12),2)?></td>
                                    <td align="center"><?php echo $p['potongan']?></td>
                                    <td align="center"><?php echo number_format($p['jumlah_po_dz'],2)?></td>
                                    <td align="center"><?php echo $p['jumlah_po_pcs']?></td>
                                    <td align="center"><?php echo number_format($p['jumlah_dz'],2)?></td>
                                    <td align="center">
                                        <input type="text" name="products[<?php echo $n?>][jumlah_pcs]" value="<?php echo $p['jumlah_pcs'] ?>" class="form-control">
                                        <input type="hidden" name="products[<?php echo $n?>][harga]" value="<?php echo $p['harga'] ?>" class="form-control">
                                    </td>
                                    <td align="center"><?php echo ($p['trans']==1)?'Ya':'Tidak';?></td>
                                    <td align="center"><?php echo number_format($p['harga'])?></td>
                                    <td align="center">
                                        <input type="text" name="products[<?php echo $n?>][total]" value="<?php echo ($p['total']-$p['potpertama'])?>" class="form-control">
                                    </td>
                                    <td style="background-color: <?php echo strtolower($p['keterangan'])=='pembayaran 80 %' ? 'yellow':'#5cfaa1' ?>;">
                                        <input type="hidden" name="products[<?php echo $n?>][keterangan]" value="<?php echo strtolower($p['keterangan'])?>" class="form-control">
                                        <?php echo strtolower($p['keterangan'])?>
                                    </td>
                                </tr>
                                <?php $n++;?>
                            <?php }?>
                                <?php for($j=0;$j<1;$j++){?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            <tr>
                                <td colspan="2" align="center"><b>Total</b></td>
                                <td align="center"><b><?php echo number_format(($potongan/12),2)?></b></td>
                                <td align="center"><b><?php echo $potongan?></b></td>
                                <td align="center"><b><?php echo $jmlpodz?></b></td>
                                <td align="center"><b><?php echo $jmlpopcs?></b></td>
                                <td align="center"><b><?php echo $jmldz?></b></td>
                                <td align="center"><b><?php echo $jmlpcs?></b></td>
                                <td></td>
                                <td align="center"><b><?php echo number_format($total)?></b></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="box box-warning">
            <div class="box-header"><b>Potongan & Biaya</b></div>
            <div class="box-body">
                <div class="form-group">
                    <label>Pengembalian Bangke</label>
                    <input type="number" class="form-control" name="pengembalian_bangke"
                        value="<?php echo $detail['pengembalian_bangke']; ?>">
                </div>

                <div class="form-group">
                    <label>Potongan Bangke</label>
                    <input type="number" class="form-control" name="potongan_bangke"
                        value="<?php echo $detail['potongan_bangke']; ?>">
                </div>

                <div class="form-group">
                    <label>Potongan Alat</label>
                    <input type="number" class="form-control" name="potongan_alat"
                        value="<?php echo $detail['potongan_alat']; ?>">
                </div>

                <div class="form-group">
                    <label>Potongan Mesin</label>
                    <input type="number" class="form-control" name="potongan_mesin"
                        value="<?php echo $detail['potongan_mesin']; ?>">
                </div>

                <div class="form-group">
                    <label>Potongan Permak</label>
                    <input type="number" class="form-control" name="potongan_vermak"
                        value="<?php echo $detail['potongan_vermak']; ?>">
                </div>

                <div class="form-group">
                    <label>Biaya Transport Antar & Penjemputan PO</label>
                    <input type="number" class="form-control" name="biaya_transport"
                        value="<?php echo ($detail['biaya_transport']-$detail['potongan_transport'])?>">
                </div>

                <div class="form-group">
                    <label>Potongan Pinjaman / Claim</label>
                    <input type="number" class="form-control" name="potongan_lainnya"
                        value="<?php echo $detail['potongan_lainnya']; ?>">
                </div>

                <div class="form-group">
                    <label>Total Tambahan Lainnya</label>
                    <input type="number" class="form-control" name="tambahan_lainnya"
                        value="<?php echo $detail['tambahan_lainnya']; ?>">
                </div>

                <!-- tambahkan biaya lain dst -->


                <!-- dst, konsep tetap -->
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header">
                <b>Total Diterima</b>
            </div>
            <div class="box-body text-center">
                <h2 class="text-green">
                    Rp <?php if($detail['potongan_transport']==0){?>
                                            <?php echo number_format($detail['total']+$detail['potongan_transport']) ?>
                                        <?php }else{ ?>
                                            <?php echo number_format($detail['total']) ?>
                                        <?php } ?>
                </h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?php if($lokasi==3){ ?>

        <?php }else{ ?>
        <table style="background-color: #ffba75;width: 100%;border:1px solid black" cellpadding="5">
            <thead>
                <tr>
                    <th valign="top">Ketentuan CMT :</th>
                    <th>
                        <table border="1" style="border-collapse: collapse;" cellpadding="3">
                            <tr align="center">
                                <td>Jumlah Dz</td>
                                <td>Harga (Rp)</td>
                            </tr>
                            <?php foreach(table('harga_transport') as $h){?>
                                <tr>
                                    <td><?php echo $h['keterangan']?></td>
                                    <td align="right"><?php echo $h['harga']?></td>
                                </tr>
                            <?php } ?>

                        </table>
                    </th>
                </tr>
            </thead>
        </table>
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                
            </div>
            <div class="col-md-6">
                <table style="width: 100%;border:1px solid black" cellpadding="5">
                    <thead>
                        <tr style="background-color: #adffc5;width: 100%;border:1px solid black">
                            <td colspan="5" align="center">Daftar Harga <?php echo $namacmt?></td>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Nama PO</th>
                            <th>Harga Lama/Dz</th>
                            <th>Harga Baru/Dz</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $number=1;?>
                        <?php foreach(globaldaftarharga($lokasi) as $r){?>
                            <tr>
                                <td><?php echo $number++?></td>
                                <td><?php echo $r['namapo']?></td>
                                <td><?php echo number_format($r['hargalama'])?></td>
                                <td><?php echo number_format($r['hargabaru'])?></td>
                                <td><?php echo $r['keterangan']?></td>
                            </tr>
                        <?php } ?>
                        <?php foreach((array)$harga as $r){?>
                            <tr>
                                <td><?php echo $number++?></td>
                                <td><?php echo $r['namapo']?></td>
                                <td><?php echo number_format($r['hargalama'])?></td>
                                <td><?php echo number_format($r['hargabaru'])?></td>
                                <td><?php echo $r['keterangan']?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                 <table style="background-color: white;width: 100%;border:1px solid black" cellpadding="5">
                    <tr>
                        <td align="center"><b>Potongan Klaim / Bangke</b></td>
                    </tr>
                    <tr>
                        <td>Potongan tidak ada bangke Rp.50.000/pcs</td>
                    </tr>
                    <tr>
                        <td>Potongan bangke tidak komplit Rp.25.000/pcs</td>
                    </tr>
                    <tr>
                        <td>Setelan (tidak ada bangke) Rp.40.000/pcs</td>
                    </tr>
                    <tr>
                        <td>Setelan (tidak komplit) Rp.20.000/pcs</td>
                    </tr>
                    <tr>
                        <td>BS dimasukan packingan Rp.100.000/pcs</td>
                    </tr>
                </table>
            </div>
        </div>
       
    </div>
</div>
<?php if(!empty($bangke)){?>
<div class="box box-default">
    <div class="box-header">
        <b>Potongan Bangke</b>
    </div>
    <div class="box-body table-responsive">
        <!-- tabel -->
         <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan/Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;$bang=0;?>
                <?php foreach((array)$bangke as $b){?>
                    <tr>
                        <td><?php echo $nomor++?></td>
                        <td><?php echo strtoupper($b['kode_po'])?></td>
                        <td><?php echo $b['qty']?></td>
                        <td><?php echo number_format($b['harga'])?></td>
                        <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                        <td><?php echo strtolower($b['keterangan'])?></td>
                    </tr>
                    <?php $bang+=($b['qty']*$b['harga']);?>
                <?php } ?>
                <?php for($j=1;$j<=5;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td><b><?php echo number_format($bang)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
<?php if(!empty($alat)){?>
<div class="box box-default">
    <div class="box-header">
        <b>Potongan Alat</b>
    </div>
    <div class="box-body table-responsive">
        <!-- tabel -->
         <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Rincian</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;$al=0;?>
                <?php foreach($alat as $b){?>
                    <tr>
                        <td><?php echo $nomor++?></td>
                        <td><?php echo strtoupper($b['rincian'])?></td>
                        <td>
                            <input name="alat[<?php echo $b['id']?>][id]" type="hidden" value="<?php echo $b['id']?>">
                            <input name="alat[<?php echo $b['id']?>][qty]" type="number" value="<?php echo $b['qty']?>"></td>
                        <td><input name="alat[<?php echo $b['id']?>][harga]" type="number" value="<?php echo $b['harga']?>"></td>
                        <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                        <td><?php echo strtolower($b['keterangan'])?></td>
                    </tr>
                    <?php $al+=($b['qty']*$b['harga']);?>
                <?php } ?>
                <?php for($j=1;$j<=5;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td><b><?php echo number_format($al)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
<?php if(!empty($mesin)){?>
<div class="box box-default">
    <div class="box-header">
        <b>Potongan Mesin</b>
    </div>
    <div class="box-body table-responsive">
        <!-- tabel -->
         <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Rincian</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;$am=0;?>
                <?php foreach((array)$mesin as $b){?>
                    <tr>
                        <td><?php echo $nomor++?></td>
                        <td><?php echo strtoupper($b['rincian'])?></td>
                        <td><?php echo $b['qty']?></td>
                        <td><?php echo number_format($b['harga'])?></td>
                        <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                        <td><?php echo strtolower($b['keterangan'])?></td>
                    </tr>
                    <?php $am+=($b['qty']*$b['harga']);?>
                <?php } ?>
                <?php for($j=1;$j<=5;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td><b><?php echo number_format($am)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
<?php if(!empty($vermak)){?>
<div class="box box-default">
    <div class="box-header">
        <b>Potongan Vermak</b>
    </div>
    <div class="box-body table-responsive">
        <!-- tabel -->
         <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Rincian</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;$av=0;?>
                <?php foreach((array)$vermak as $b){?>
                    <tr>
                        <td><?php echo $nomor++?></td>
                        <td><?php echo strtoupper($b['rincian'])?></td>
                        <td><?php echo $b['qty']?></td>
                        <td><?php echo number_format($b['harga'])?></td>
                        <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                        <td><?php echo strtolower($b['keterangan'])?></td>
                    </tr>
                    <?php $av+=($b['qty']*$b['harga']);?>
                <?php } ?>
                <?php for($j=1;$j<=5;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td><b><?php echo number_format($av)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
<?php if(!empty($kembalianbangke)){?>
<div class="box box-default">
    <div class="box-header">
        <b>Kembalian Bangke</b>
    </div>
    <div class="box-body table-responsive">
        <!-- tabel -->
         <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan/Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1;$kb=0;?>
                <?php foreach($kembalianbangke as $b){?>
                    <tr>
                        <td><?php echo $nomor++?></td>
                        <td><?php echo strtoupper($b['kode_po'])?></td>
                        <td><?php echo $b['qty']?></td>
                        <td><?php echo number_format($b['harga'])?></td>
                        <td><?php echo number_format($b['qty']*$b['harga'])?></td>
                        <td><?php echo strtolower($b['keterangan'])?></td>
                    </tr>
                    <?php $kb+=($b['qty']*$b['harga']);?>
                <?php } ?>
                <?php for($j=1;$j<=5;$j++){?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                <tr>
                    <td colspan="4" align="center">Total</td>
                    <td><b><?php echo number_format($kb)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php } ?>
<div class="row">
    <div class="col-md-4">
        <a href="<?php echo BASEURL.'Pembayaran/cmtjahit';?>"
           class="btn btn-danger btn-block">
            ← Kembali
        </a>
    </div>
    <div class="col-md-4">
        <button class="btn btn-success btn-block">
            💾 Update Data
        </button>
    </div>
    <div class="col-md-4">
        <a href="<?php echo BASEURL.'Pembayaran/cmtjahitdetail/'.$detail['id'].'?pdf=1&id='.$detail['id'];?>"
           target="_blank" class="btn btn-info btn-block">
            🧾 Cetak PDF
        </a>
    </div>
</div>

</form>