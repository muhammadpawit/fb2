<form method="post" action="<?php echo $update; ?>" id="update">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <h1>Forboys Production</h1>
                    <h6>Alamat</h6>
                    <address class="line-h-24">
                    JL.Z NO 1, Kel. Sukabumi Selatan, Kec Kebon Jeruk Kampung Baru, Jakarta Barat
                    </address>
                    <h3><strong>Faktur No. </strong><?php echo $barang[0]['faktur_no'] ?></h3>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <table style="font-size: 23pt;outline-style: solid;" cellpadding="3">
                                    <tr>
                                        <td colspan="2"><strong>Jakarta</strong>, <input type="text" name="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d',strtotime($barang[0]['created_date'])) ?>"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">Kepada Yth</td>
                                    </tr>
                                    <tr>
                                        <td>Tuan/Toko</td>
                                        <td>: <?php echo $barang[0]['nama_penerima']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tujuan</td>
                                        <td>: <?php echo $barang[0]['tujuan_item']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>NAMA PO</td>
                                        <td>: <?php echo $project['nama_po'].$project['kode_po']; ?></td>
                                    </tr>
                                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                    <div class="table-responsive">

                                <table class="table mt-4">

                                    <thead>

                                    <tr><th>#</th>

                                        <th>Nama Barang</th>
                                        <th>Ukuran</th>

                                        <th>Jumlah </th>
                                        <th>Satuan</th>

                                        <th>Harga Pcs</th>

                                        <th class="text-right">Total</th>

                                        <th>Jml Per Dz</th>

                                    </tr>

                                    </thead>

                                    <tbody>

                                        <?php $totals = 0;$total = 0; ?>

                                <?php $no=1; foreach ($barang as $key => $item): ?>

                                    <tr>

                                        <td><?php echo $no; ?></td>

                                        <td>

                                            <b><?php echo $item['nama_item_keluar'] ?></b> 

                                        </td>

                                        <td>

                                            <b><?php echo $item['ukuran_item_keluar'] ?> </b> 

                                        </td>

                                        <td>
                                            <input type="number" class="form-control" name="prods[<?php echo $no?>][jumlah_item_keluar]" value="<?php echo $item['jumlah_item_keluar'] ?>">

                                        </td>

                                        <td><?php echo $item['satuan_jumlah_keluar'] ?></td>

                                        <td>
                                            <input type="hidden" class="form-control" name="prods[<?php echo $no?>][id_item_keluar]" value="<?php echo $item['id_item_keluar']?>">
                                            <input type="number" class="form-control" name="prods[<?php echo $no?>][harga_item]" value="<?php echo $item['harga_item']?>">
                                        </td>

                                        <?php 

                                        $totals += $item['jumlah_item_keluar'] * $item['harga_item'];
                                        $total = $item['jumlah_item_keluar'] * $item['harga_item'];

                                         ?>

                                        <td class="text-right"><?php echo number_format($total) ?></td>

                                        <td>
                                            <input type="number" class="form-control" name="prods[<?php echo $no?>][jumlah_item_perlusin]" value="<?php echo $item['jumlah_item_perlusin'] ?>">

                                        </td>
                                        
                                    </tr>
                                    <?php $no++;?>
                                <?php endforeach ?>

                                    
                                    <tr>
                                        <td colspan="6" align="center"><b>Total</b></td>
                                        <td align="right"><b><?php echo number_format($totals) ?></b></td>
                                    </tr>
                                    </tbody>

                                </table>

                            </div>      
            </div>
        </div>
    </div>
</form>
<form id="upload" method="post" action="<?php echo $lampiran?>" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <input type="hidden" name="kode_po" value="<?php echo $project['kode_po'] ?>">
                <label>Tanggal Kirim</label>
                <input type="text" name="tglkirim" class="form-control datepicker" value="<?php echo !empty($l)?$l['tglkirim']:date('Y-m-d'); ?>" readonly>
            </div>
            <div class="form-group">
                <label>Lampiran</label><br>
                <?php if(empty($l['foto'])){?>
                <input type="file" name="lampiran" class="form-control"/>
                <?php }else{ ?>
                <img src="<?php echo BASEURL?>assets/lampiran/<?php echo $l['foto']?>" height="300px">
                <?php } ?>
            </div>
            <?php if(empty($l['foto'])){?>
            <div class="form-group">
                <button type="submit" class="btn btn-info btn-sm full">Upload</button>
            </div>
            <?php } ?>
        </div>
    </div>
</form>
<div class="row no-print">
    <div class="col-md-4">
        <div class="form-group">
            <?php if(aksesedit()==1){?>
                <a onclick="update()" style="width: 100% !important;" class="btn btn-success waves-effect waves-light text-white"><i class="fa fa-save m-r-5"></i> Update</a>
            <?php }else{ ?>
                <button onclick="window.reload()" style="width: 100% !important;" class="btn btn-success waves-effect waves-light text-white" disabled><i class="fa fa-save m-r-5"></i> Silahkan melakukan otorisasi</button>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a href="<?php echo $cetak ?>" target="_blank" style="width: 100% !important;" class="btn btn-primary waves-effect waves-light"></i> Cetak</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a href="<?php echo BASEURL.'Gudang/pengeluaranbahan'?>" style="width: 100% !important;" class="btn btn-danger waves-effect waves-light"></i> Kembali</a>
        </div>
    </div>
</div>
<script type="text/javascript">
    function update(){
        $("#update").submit();
    }
</script>