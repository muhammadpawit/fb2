<form method="post" action="<?php echo $update; ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <h2>Rincian Pemakaian Bahan <?php echo $project['kode_po']?></h2>
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

                                        <th>Bahan U/</th>

                                        <th>Ukuran</th>

                                        <th>Jumlah / Satuan</th>

                                        <th>Harga Pcs</th>

                                        <th class="text-right">Total</th>

                                    </tr></thead>

                                    <tbody>

                                        <?php $totals = 0;$total = 0; ?>

                                <?php $no=1; foreach ($barang as $key => $item): ?>

                                    <tr>

                                        <td><?php echo $no; ?></td>

                                        <td>

                                            <b><?php echo $item['nama_item_keluar'] ?></b> 

                                        </td>

                                        <td>
                                            <select name="prods[<?php echo $no?>][bahan_kategori]" class="form-control">
                                                <option value="UTAMA" <?php echo $item['bahan_kategori']=="UTAMA"?'selected':''; ?>>UTAMA</option>
                                                <option value="CELANA" <?php echo $item['bahan_kategori']=="CELANA"?'selected':''; ?>>CELANA</option>
                                                <option value="KAINKANTONG" <?php echo $item['bahan_kategori']=="KAINKANTONG"?'selected':''; ?>>KAIN KANTONG</option>
                                                <option value="VARIASI" <?php echo $item['bahan_kategori']=="VARIASI"?'selected':''; ?>>VARIASI</option>
                                            </select>

                                        </td>

                                        <td>

                                            <b><?php echo $item['ukuran_item_keluar'] ?> <?php echo $item['satuan_item_keluar'] ?></b> 

                                        </td>

                                        <td><?php echo $item['jumlah_item_keluar'] ?> <?php echo $item['satuan_jumlah_keluar'] ?></td>

                                        <td>
                                            <input type="hidden" class="form-control" name="prods[<?php echo $no?>][id_item_keluar]" value="<?php echo $item['id_item_keluar']?>">
                                            <input type="number" class="form-control" name="prods[<?php echo $no?>][harga_item]" value="<?php echo $item['harga_item']?>">
                                            <input type="hidden" class="form-control" name="kode_po" value="<?php echo $project['kode_po']?>">
                                        </td>

                                        <?php 

                                        $totals += $item['jumlah_item_keluar'] * $item['harga_item'];
                                        $total = $item['jumlah_item_keluar'] * $item['harga_item'];

                                         ?>

                                        <td class="text-right"><?php echo number_format($total) ?></td>

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
            <a href="javascript:window.print()" style="width: 100% !important;" class="btn btn-primary waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Print</a>
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
        $("form").submit();
    }
</script>