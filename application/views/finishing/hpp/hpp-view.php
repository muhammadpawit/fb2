<div class="row">
    <div class="col-md-6">
        <label>Kode PO</label>
        <input type="text" name="kode_po" value="<?php echo $kode_po; ?>" class="form-control">
    </div>
    <div class="col-md-6">
        <label>Aksi</label>
        <button onclick="filterpo()" class="btn btn-info full">Filter</button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered nosearch">
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
<script type="text/javascript">
    function filterpo(){
    url='?';
    
    var filter_date_start = $('input[name=\'tanggal1\']').val();

    if (filter_date_start) {
      url += '&tanggal1=' + encodeURIComponent(filter_date_start);
    }

    var filter_date_end = $('input[name=\'tanggal2\']').val();

    if (filter_date_end) {
      url += '&tanggal2=' + encodeURIComponent(filter_date_end);
    }

    var filter_status = $('input[name=\'kode_po\']').val();

    if (filter_status != '*') {
      url += '&kode_po=' + encodeURIComponent(filter_status);
    }
    location =url;
  }
</script>