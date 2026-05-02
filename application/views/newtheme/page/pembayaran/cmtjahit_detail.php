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

    /* Page Loader Styling */
    #page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999999;
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(3px);
    }

    .loader-content {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        text-align: center;
    }

    .spinner-custom {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #00a65a;
        border-radius: 50%;
        animation: spin-loader 1s linear infinite;
        margin-bottom: 15px;
        display: inline-block;
    }

    @keyframes spin-loader {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<!-- Full Page Loader -->
<div id="page-loader">
    <div class="loader-content">
        <div class="spinner-custom"></div>
        <div style="font-weight: bold; color: #333; font-size: 16px;">Sedang Menyimpan Data...</div>
        <div style="color: #777; font-size: 12px; margin-top: 5px;">Mohon jangan tutup halaman ini.</div>
    </div>
</div>
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
                <div class="pull-right">
                    <button type="button" class="btn btn-sm btn-info" onclick="koreksiSemuaTotal()" title="Koreksi Semua (Dz * Harga)">
                        <i class="fa fa-refresh"></i> Koreksi Total Pembayaran
                    </button>
                </div>
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
                                    <td align="center"><span class="row-dz"><?php echo number_format($p['jumlah_dz'], 2)?></span></td>
                                    <td align="center">
                                        <input type="text" name="products[<?php echo $n?>][jumlah_pcs]" value="<?php echo $p['jumlah_pcs'] ?>" class="form-control jumlah-pcs-input">
                                        <input type="hidden" name="products[<?php echo $n?>][harga]" value="<?php echo $p['harga'] ?>" class="form-control">
                                    </td>
                                    <td align="center"><?php echo ($p['trans']==1)?'Ya':'Tidak';?></td>
                                    <td align="center"><?php echo number_format($p['harga'])?></td>
                                    <td align="center">
                                        <input type="text" name="products[<?php echo $n?>][total]" 
                                            value="<?php echo number_format($p['total']-$p['potpertama'], 2, '.', '')?>" 
                                            class="form-control total-item"
                                            data-dz="<?php echo number_format($p['jumlah_dz'], 2, '.', '') ?>"
                                            data-harga="<?php echo $p['harga'] ?>">
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
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                <?php } ?>
                            <tr>
                                <td colspan="2" align="center"><b>Total</b></td>
                                <td align="center"><b><?php echo number_format(($potongan/12),2)?></b></td>
                                <td align="center"><b><?php echo $potongan?></b></td>
                                <td align="center"><b><?php echo number_format($jmlpodz, 2)?></b></td>
                                <td align="center"><b><?php echo $jmlpopcs?></b></td>
                                <td align="center"><b><span id="footer-total-dz"><?php echo number_format($jmldz, 2)?></span></b></td>
                                <td align="center"><b><span id="footer-total-pcs"><?php echo $jmlpcs?></span></b></td>
                                <td></td>
                                <td></td>
                                <td align="center"><b><span id="footer-total-bayar"><?php echo number_format($total, 2)?></span></b></td>
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
        <!-- Persistent Bottom Bar -->
        <div id="sticky-pembayaran-bar" style="position: fixed; bottom: 0; left: 0; width: 100%; height: 80px; background: #222d32; color: white; border-top: 4px solid #00a65a; z-index: 999999; display: flex; align-items: center; justify-content: space-between; padding: 0 40px; box-shadow: 0 -10px 30px rgba(0,0,0,0.5);">
            <div style="display: flex; align-items: center;">
                <div style="background: rgba(0,166,90,0.2); padding: 10px; border-radius: 8px; margin-right: 20px; border: 1px solid #00a65a;">
                    <i class="fa fa-money fa-2x" style="color: #00ff87;"></i>
                </div>
                <div>
                    <div style="font-size: 11px; text-transform: uppercase; color: #aaa; letter-spacing: 1px; font-weight: bold;">Estimasi Total Pembayaran Ke-CMT</div>
                    <div style="font-size: 32px; font-weight: 800; color: #fff; line-height: 1;" id="grand-total-sticky">Rp 0</div>
                </div>
            </div>
            <div style="display: flex; gap: 15px;">
                <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="btn btn-default" style="background: #333; color: #eee; border: 1px solid #444;">
                    <i class="fa fa-arrow-up"></i> Top
                </button>
                <button type="button" onclick="jQuery('form').submit()" class="btn btn-success btn-lg" style="font-weight: 800; padding: 12px 40px; background: #00a65a; border: none; box-shadow: 0 4px 15px rgba(0,166,90,0.4);">
                    <i class="fa fa-save"></i> SIMPAN PERUBAHAN
                </button>
            </div>
        </div>

        <div class="box box-success">
            <div class="box-header">
                <b>Total Dibayarkan Ke-CMT</b>
            </div>
            <div class="box-body text-center">
                <h2 class="text-green" id="grand-total-display" style="font-weight: 800; font-size: 36px;">
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
        <button type="button" onclick="showPdfModal('<?php echo BASEURL.'Pembayaran/cmtjahitdetail/'.$detail['id'].'?pdf=1&id='.$detail['id'];?>', 'Cetak Pembayaran CMT')" class="btn btn-info btn-block">
            🧾 Cetak PDF
        </button>
    </div>
</div>

</form>
<script>
    function koreksiSemuaTotal() {
        var btn = $('button[onclick="koreksiSemuaTotal()"]');
        var icon = btn.find('i');
        
        // Start animation
        btn.prop('disabled', true);
        btn.addClass('btn-warning').removeClass('btn-info');
        icon.addClass('fa-spin');
        btn.contents().last()[0].textContent = ' Memproses...';

        // Artificial delay to show animation (800ms)
        setTimeout(function() {
            $('.total-item').each(function() {
                var dz = parseFloat($(this).data('dz')).toFixed(2);
                var harga = $(this).data('harga');
                var result = parseFloat(dz) * parseFloat(harga);
                $(this).val(result.toFixed(2));
            });

            // Reset button state
            btn.prop('disabled', false);
            btn.addClass('btn-info').removeClass('btn-warning');
            icon.removeClass('fa-spin');
            btn.contents().last()[0].textContent = ' Koreksi Total Pembayaran';

            // Show success feedback with a nice animation if using AdminLTE (Toastr/SweetAlert usually available)
            // Fallback to simple alert if not
            alert('Sukses! Semua telah dikoreksi otomatis.');
            updateAllCalculations();
        }, 800);
    }

    $(document).ready(function() {
        // Function for clean formatting
        function formatMoney(n) {
            return 'Rp ' + n.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateAllCalculations() {
            var totalPcs = 0;
            var totalDz = 0;
            var totalBayarRow = 0;
            
            jQuery('.jumlah-pcs-input').each(function() {
                var row = jQuery(this).closest('tr');
                var pcs = parseFloat(jQuery(this).val()) || 0;
                var harga = parseFloat(row.find('input[name*="[harga]"]').val()) || 0;
                
                var dz = parseFloat((pcs / 12).toFixed(2));
                row.find('.row-dz').text(dz.toFixed(2));
                
                var totalItem = row.find('.total-item');
                totalItem.data('dz', dz);
                
                var total = dz * harga;
                totalItem.val(total.toFixed(2));
                
                totalPcs += pcs;
                totalDz += dz;
                totalBayarRow += total;
            });
            
            // Update footer totals
            jQuery('#footer-total-pcs').text(totalPcs);
            jQuery('#footer-total-dz').text(totalDz.toFixed(2));
            jQuery('#footer-total-bayar').text(totalBayarRow.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}));

            // Other fields
            var val_bangke_kembali = parseFloat(jQuery('input[name="pengembalian_bangke"]').val()) || 0;
            var val_bangke_pot = parseFloat(jQuery('input[name="potongan_bangke"]').val()) || 0;
            var val_alat_pot = parseFloat(jQuery('input[name="potongan_alat"]').val()) || 0;
            var val_mesin_pot = parseFloat(jQuery('input[name="potongan_mesin"]').val()) || 0;
            var val_vermak_pot = parseFloat(jQuery('input[name="potongan_vermak"]').val()) || 0;
            var val_transport = parseFloat(jQuery('input[name="biaya_transport"]').val()) || 0;
            var val_lain_pot = parseFloat(jQuery('input[name="potongan_lainnya"]').val()) || 0;
            var val_tambahan = parseFloat(jQuery('input[name="tambahan_lainnya"]').val()) || 0;
            
            var grandTotal = totalBayarRow + val_tambahan + val_transport - val_bangke_pot - val_alat_pot - val_mesin_pot - val_vermak_pot - val_lain_pot + val_bangke_kembali;
            
            var formatted = formatMoney(grandTotal);
            jQuery('#grand-total-display').text(formatted);
            jQuery('#grand-total-sticky').text(formatted);
        }

        // Event for Table Inputs
        jQuery(document).on('input change', '.jumlah-pcs-input', function() {
            updateAllCalculations();
        });

        // Event for correction total
        jQuery(document).on('input change', '.total-item', function() {
            updateAllCalculations();
        });

        // Event for Other Inputs
        jQuery(document).on('input change', 'input[name="pengembalian_bangke"], input[name="potongan_bangke"], input[name="potongan_alat"], input[name="potongan_mesin"], input[name="potongan_vermak"], input[name="biaya_transport"], input[name="potongan_lainnya"], input[name="tambahan_lainnya"]', function() {
            updateAllCalculations();
        });

        // Form Submit Loader
        jQuery('form').on('submit', function() {
            jQuery('#page-loader').css('display', 'flex');
            jQuery('button').prop('disabled', true);
            jQuery('.btn-success').html('<i class="fa fa-spinner fa-spin"></i> MEMPROSES...');
        });

        // Finalize initial values
        updateAllCalculations();
    });
</script>