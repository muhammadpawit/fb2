<form method="post" action="<?php echo $update ?>">
    <input type="hidden" name="id" value="<?php echo $detail['id'] ?>"/>
    <input type="hidden" name="cmt" value="<?php echo $detail['idcmt'] ?>"/>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            Nama CMT <label><?php echo $namacmt;?></label><br>
            Tanggal/periode : <label><?php echo date('d F Y',strtotime($detail['tanggal'])); ?></label><br>
            Trip ke : <label><?php echo $detail['tripke'] ?></label>
        </div>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
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
                        <td>
                            <input type="text" name="products[<?php echo $n?>][keterangan]" value="<?php echo strtolower($p['keterangan'])?>" class="form-control"></td>
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
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Pengembalian Bangke</b></td>
                    <td align="center"><b><?php echo $detail['pengembalian_bangke']?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Bangke</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_bangke'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Alat</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_alat'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Mesin</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_mesin'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Vermak</b></td>
                    <td align="center"><b><?php echo number_format($detail['potongan_vermak'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Biaya Transport Antar & Penjemputan Po</td>
                    <td align="center"><b><?php echo number_format($detail['biaya_transport']-$detail['potongan_transport'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Potongan Pinjaman/Claim</td>
                    <td align="center"><b><?php echo number_format($detail['potongan_lainnya'])?></b></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="9" align="center"><b>Total Yang diterima</b></td>
                    <td align="center">
                        <b>
                            <?php if($detail['potongan_transport']==0){?>
                                <?php echo number_format($detail['total']+$detail['potongan_transport']) ?>
                            <?php }else{ ?>
                                <?php echo number_format($detail['total']) ?>
                            <?php } ?>
                        </b>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
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
                    <th>Ket</th>
                </tr>
            </thead>
            <tbody>
                <?php $number=1;?>
                <?php foreach(globaldaftarharga() as $r){?>
                    <tr>
                        <td><?php echo $number++?></td>
                        <td><?php echo $r['namapo']?></td>
                        <td><?php echo number_format($r['hargalama'])?></td>
                        <td><?php echo number_format($r['hargabaru'])?></td>
                        <td><?php echo $r['keterangan']?></td>
                    </tr>
                <?php } ?>
                <?php foreach($harga as $r){?>
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
    <br><br>
    <?php if(!empty($bangke)){?>
    <div class="col-md-6">
        <label>Potongan Bangke</label>
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
                <?php foreach($bangke as $b){?>
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
    <?php } ?>
    <?php if(!empty($alat)){?>
    <div class="col-md-6">
        <label>Potongan Alat</label>
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
                        <td><?php echo $b['qty']?></td>
                        <td><?php echo number_format($b['harga'])?></td>
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
    <?php } ?>
    <?php if(!empty($mesin)){?>
    <div class="col-md-6">
        <label>Potongan Mesin</label>
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
                <?php foreach($mesin as $b){?>
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
    <?php } ?>
    <?php if(!empty($vermak)){?>
    <div class="col-md-6">
        <label>Potongan Vermak</label>
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
                <?php foreach($vermak as $b){?>
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
    <?php } ?>
    <?php if(!empty($kembalianbangke)){?>
    <div class="col-md-6">
        <label>Pengembalian Bangke</label>
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
    <?php } ?>
</div>
<br>
<div class="row">
     <div class="col-md-4">
        <div class="form-group">
            <a href="<?php echo BASEURL.'Pembayaran/cmtjahit';?>" class="btn btn-danger btn-sm full">Kembali</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <button class="btn btn-success btn-sm full">Update</button>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a href="<?php echo BASEURL.'Pembayaran/cmtjahitdetail/'.$detail['id'].'?&excel=1&id='.$detail['id'];?>" class="btn btn-info btn-sm full">Excel</a>
        </div>
    </div>
</div>
</form>
<style type="text/css">
    .full{
        width: 100% !important;
    }
</style>