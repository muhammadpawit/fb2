<div class="row">
    <div class="col-md-4">
    <label>Jenis</label>
    <select name="jenis" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <option value="1">Konveksi</option>
        <option value="2">Bordir</option>
        <option value="3">Sablon</option>
        <option value="4">Bahan</option>
    </select>
  </div>
   <div class="col-md-4">
    <label>Kategori Barang</label>
        <select name="kategori" class="form-control select2bs4" data-live-search="true">
          <option value="*">Pilih</option>
          <option value="1" >Hangtag</option>
          <option value="2" >Slip</option>
          <option value="3" >Kerah</option>
          <option value="4" >Kancing</option>
          <option value="5" >Kancing</option>
          <option value="6" >Barang Bordir</option>
          <option value="7" >Resleting</option>
          <option value="8" >Resleting Kantong</option>
          <option value="9" >Pita</option>
          <option value="10" >Sleting</option>
          <option value="11" >Gesper</option>
          <option value="12" >Spandek</option>
          <option value="13" >ATK</option>
        </select>
  </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Aksi</label><br>
            <a onclick="filter()" class="btn btn-info btn-sm text-white">Filter</a>
            <a href="<?php echo $excel?>" class="btn btn-info btn-sm text-white">Excel</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table id="datatable" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Nama barang</th>
                            <th>Warna</th>
                            <th>Ukuran Satuan</th>
                            <th>Jumlah Satuan</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($persediaan as $key => $sat): ?>
                            <tr>
                                <td><?php echo strtolower($sat['nama_item']) ?></td>
                                <td><button style="background-color: <?php echo $sat['warna_item'] ?>" class="btn"></button> <?php echo strtolower($sat['warna_item']) ?></td>
                                <td><?php echo strtolower($sat['ukuran_item']) ?>
                                    <?php echo strtolower($sat['satuan_ukuran_item']) ?>
                                </td>
                                <td><?php echo strtolower($sat['jumlah_item']) ?> <?php echo strtolower($sat['satuan_jumlah_item']) ?></td>
                                <td><?php echo number_format($sat['harga_item']) ?></td>
                                <td>
                                    <a href="<?php echo BASEURL.'Gudang/kartustok/'.$sat['id_persediaan'] ?>" class="btn btn-info btn-xs text-white"> Kartustok</a>

                                    <a href="<?php echo BASEURL.'Gudang/nolin/'.$sat['id_persediaan'] ?>"  onclick="confirm('Apakah yakin ?')" class="btn btn-warning btn-xs text-white"> Kosongkan</a>

                                    <?php if(akseshapus()==1){?>
                                    <a href="<?php echo BASEURL.'Gudang/persediaanhapus/'.$sat['id_persediaan'] ?>" class="btn btn-danger btn-xs text-white"> Hapus</a>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
    </div>
</div>
<script type="text/javascript">
    function excel(){
        location='?&excel=1';
    }
</script>
<script type="text/javascript">
  function filter(){
    var url='?';
    var filter_status = $('select[name=\'jenis\']').val();

        if (filter_status != '*') {
            url += '&jenis=' + encodeURIComponent(filter_status);
        }

        var kategori = $('select[name=\'kategori\']').val();

    if (kategori != '*') {
      url += '&kategori=' + encodeURIComponent(kategori);
    }
    location=url;
  }
</script>