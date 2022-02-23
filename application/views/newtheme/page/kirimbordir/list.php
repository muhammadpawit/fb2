<div class="row">
  <div class="col-md-12">
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
  </div>
</div>
<div class="row">
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Nama PO</label>
      <select name="kode_po" id="kode_po" class="form-control autopo" data-live-search="true">
        <option value="*">Pilih</option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Action</label><br>
        <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
        <a href="<?php echo $tambah?>" class="btn btn-info btn-sm">Tambah</a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
     <table class="table table-bordered nosearch">
                        <thead>

                        <tr>

                            <th>NAMA PO</th>

                            <th>NAMA CMT & KAT CMT</th>

                            <th>PROGRESS</th>

                            <th>Nomor SJ</th>

                            <th>Qty (Pcs)</th>

                            <th>CREATED</th>

                            <th>ACTION</th>

                        </tr>

                        </thead>

                        <tbody>

                                <?php foreach ($kelola as $key => $sat): ?>

                            <tr>

                                <td><?php echo $sat['nama_po'] ?><?php echo $sat['kode_po'] ?></td>

                                <td><?php echo $sat['nama_cmt'].' ('.$sat['kategori_cmt'].')' ?></td>

                                <td><?php echo $sat['progress'] ?></td>
                                <td>
                                  <?php if($sat['progress']=="KIRIM"){?>
                                    <a target="_blank" href="<?php echo BASEURL?>Kelolapo/kirimcmtview/<?php echo $sat['kode_nota_cmt'] ?>"><?php echo $sat['kode_nota_cmt'] ?></a>
                                  <?php } ?>

                                  <?php if($sat['progress']=="SETOR"){?>
                                    <a target="_blank" href="<?php echo BASEURL?>Setorancmt/kirimcmtview/<?php echo $sat['kode_nota_cmt'] ?>"><?php echo $sat['kode_nota_cmt'] ?></a>
                                  <?php } ?>
                                  
                                </td>

                                <td><?php echo $sat['qty_tot_pcs'] ?></td>

                                <td><?php echo $sat['create_date'] ?></td>

                                <td>
                                    <?php if(akseshapus()==1){?>
                                      <a href="<?php echo BASEURL.'kelolapo/kirimsetorhapus/'.$sat['kode_po'].'/'.$sat['id_kelolapo_kirim_setor'] ?>" class="btn btn-sm btn-danger text-white"> <i class="dripicons-browser-upload"></i> Hapus</a>
                                    <?php } ?>
                                </td>

                            </tr>

                                <?php endforeach ?>

                        </tbody>

                    </table>
  </div>
</div>
<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#kode_po").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&kode_po='+nomesin;
    }

    location=url;
  }

   function excel(){
    var url='?cetak=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&nomesin='+nomesin;
    }

    location=url;
  }
</script>