<p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-success alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                    </p>  
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title">Tambah Master Persediaan</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action?>">
                        <div class="row">
                          <div class="col-12">
                            <div class="form-group">
                              <label>Nama Item</label>
                              <input type="text" name="nama" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                              <label>Warna</label>
                              <input type="text" name="warna_item" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Ukuran Item</label>
                              <input type="text" name="ukuran_item" class="form-control">
                            </div>
                            <div class="form-group">
                              <label>Satuan Ukuran Item</label>
                              <select name="satuan_ukuran_item" class="form-control select2bs4" data-live-search="true">
                                <option value="">Pilih</option>
                                <?php foreach($satuan as $st){?>
                                  <option value="<?php echo $st['kode_satuan_barang'] ?>"><?php echo $st['nama_satuan_barang']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Satuan</label>
                              <select name="satuan" class="form-control select2bs4" data-live-search="true">
                                <option value="">Pilih</option>
                                <?php foreach($satuan as $st){?>
                                  <option value="<?php echo $st['kode_satuan_barang'] ?>"><?php echo $st['nama_satuan_barang']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Jenis Barang</label>
                              <select name="jenis" class="form-control select2bs4" data-live-search="true">
                                <option value="0">Pilih</option>
                                <option value="1">Konveksi</option>
                                <option value="2">Bordir</option>
                                <option value="3">Sablon</option>
                                <option value="4">Bahan</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Kategori Barang</label>
                              <select name="kategori" class="form-control select2bs4" data-live-search="true">
                                <option value="">Pilih</option>
                                <option value="1">Hangtag</option>
                                <option value="2">Slip</option>
                                <option value="3">Kerah</option>
                                <option value="4">Kancing</option>
                                <option value="5">Kancing</option>
                                <option value="6">Barang Bordir</option>
                                <option value="7">Resleting</option>
                                <option value="8">Resleting Kantong</option>
                                <option value="9">Pita</option>
                                <option value="10">Sleting</option>
                                <option value="11">Gesper</option>
                                <option value="12">Spandek</option>
                                <option value="13">ATK</option>
                                <option value="14">Benang Konveksi</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Supplier</label>
                              <select name="supplier" class="form-control select2bs4" data-live-search="true">
                                <option value="">Pilih</option>
                                <?php foreach($supplier as $st){?>
                                  <option value="<?php echo $st['id'] ?>"><?php echo $st['nama']?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Minimal Stok</label>
                              <input type="text" name="minstok" value="10" class="form-control">
                            </div>
                            <div class="form-group">
                              <!-- <label>Resiko</label> -->
                              <input type="hidden" name="resiko" value="0" class="form-control">
                            </div>
                            <div class="form-group">
                              <button type="submit" class="btn btn-info">Simpan</button>
                              <a class="btn btn-danger text-white" data-dismiss="modal">Batal</a>
                            </div>
                          </div>
                        </div>
                      </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>     
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Nama Persediaan</label>
      <input type="text" name="product_id" value="<?php echo isset($_GET['product_id'])?$_GET['product_id']:'';?>" class="form-control" id="product_id">
    </div>
  </div>
  <div class="col-md-3">
  	<label>Jenis</label>
  	<select name="jeniss" class="form-control select2bs4" data-live-search="true">
  		<option value="*">Semua</option>
  		<option value="1">Konveksi</option>
  		<option value="2">Bordir</option>
  		<option value="3">Sablon</option>
  		<option value="4">Bahan</option>
  	</select>
  </div>
  <div class="col-md-3">
    <label>Kategori Barang</label>
        <select name="kategoris" class="form-control select2bs4" data-live-search="true">
          <option value="*">Pilih</option>
          <option value="1">Hangtag</option>
          <option value="2">Slip</option>
          <option value="3">Kerah</option>
          <option value="4">Kancing</option>
          <option value="5">Kancing</option>
          <option value="6">Barang Bordir</option>
          <option value="7">Resleting</option>
          <option value="8">Resleting Kantong</option>
          <option value="9">Pita</option>
          <option value="10">Sleting</option>
          <option value="11">Gesper</option>
          <option value="12">Spandek</option>
          <option value="13">ATK</option>
          <option value="14">Benang Konveksi</option>
        </select>
  </div>
  <div class="col-md-3">
    <label>Aksi</label><br>
    <button class="btn btn-info btn-sm text-white" onclick="filter()">Filter</button>
    <a href="<?php echo $pdf?>" class="btn btn-info btn-sm text-white" target="_blank">Cetak</a>
    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Gambar</th>
                  <th>Supplier</th>
                  <th>Jenis</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Quantity</th>
                  <th>Minstok</th>
                  <th>Harga HPP</th>
                  <th>Harga Beli</th>
                  <th></th>
                </tr>
              </thead>          
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                        <tr style="background-color: <?php echo $p['color']?>">
                          <td><?php echo $i++?></td>
                          <td>
                            <?php if(!empty($p['foto'])){?>
                              <img src="<?php echo BASEURL.'uploads/persediaan/'.$p['foto'] ?>" height="100" >
                            <?php } ?>
                          </td>
                          <td><?php echo $p['supplier']?></td>
                          <td><?php echo $p['jenis']?></td>
                          <td><?php echo $p['kodebarang']?></td>
                          <td><?php echo $p['nama']?></td>
                          <td><?php echo $p['ukuran_item'].' '.$p['satuan_ukuran_item']?></td>
                          <td><?php echo $p['quantity'].' '.$p['satuanqty']?></td>
                          <td align="right"><?php echo $p['minstok']?></td>
                          <td align="right"><?php echo $p['price']?></td>
                          <td align="right"><?php echo $p['harga_beli']?></td>
                          <td class="right"><?php foreach ($p['action'] as $action) { ?>
                           <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                          <?php } ?></td>
                        </tr>
                        <?php } ?>
                <?php }?>
              </tbody>
            </table>
  </div>
  <div class="col-md-12">
    <?php 
        //echo $this->pagination->create_links();
    ?>
  </div>
</div>
<script type="text/javascript">
  function filter(){
    var url='?';
    var product_id=$("#product_id").val();
    if(product_id!="*"){
      url+='&product_id='+product_id;
    }
    var filter_status = $('select[name=\'jeniss\']').val();

		if (filter_status != '*') {
			url += '&jenis=' + encodeURIComponent(filter_status);
		}

    var kategori = $('select[name=\'kategoris\']').val();

    if (kategori != '*') {
      url += '&kategori=' + encodeURIComponent(kategori);
    }


    location=url;
  }
</script>