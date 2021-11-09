<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered yessearch">
                        <thead>
                        <tr>
                            <th>KODE PO</th>
                            <th>NAMA PO</th>
                            <th>JENIS</th>
                            <th>TANGGAL</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($produk as $key => $po): ?>
                            <tr>
                                <td><?php echo $po['kode_po'] ?></td>
                                <td><?php echo $po['nama_po'] ?></td>
                                <td><?php echo $po['jenis_po'] ?></td>
                                <td><?php echo $po['created_date'] ?></td>
                                <th>
                                    <?php if($po['harga_satuan']>0){?>
                                        <a href="<?php echo BASEURL.'finishing/hppproduksidetail/'.$po['kode_po'] ?>" class="btn btn-success btn-xs text-white" style="width: 100%"><i class="fi-paper">Re-Check</i></a>
                                    <?php }else{?>
                                        <a href="<?php echo BASEURL.'finishing/hppproduksidetail/'.$po['kode_po'] ?>" class="btn btn-warning btn-xs text-white" style="width: 100%"><i class="fi-paper">Cek</i></a>
                                    <?php } ?>
                                </th>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
    </div>
</div>