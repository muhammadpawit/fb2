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
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Nama PO</label>
      <select name="kode_po" id="kode_po" class="form-control autopoid" data-live-search="true">
        <option value="*">Pilih</option>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Nama CMT</label>
      <select name="cmt" id="cmt" class="form-control select2bs4" data-live-search="true">
        <option value="*">Pilih</option>
        <?php foreach($listcmt as $c){ ?>
          <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt?'selected':''?>><?php echo strtoupper($c['cmt_name'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Action</label><br>
      <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
     <table class="table table-bordered" id="empTable">
                        <thead>

                        <tr>

                            <th>NAMA PO</th>

                            <th>NAMA CMT & KAT CMT</th>

                            <th>PROGRESS</th>

                            <th>Nomor SJ</th>

                            <th>Qty (Pcs)</th>

                            <th>Pekerjaan</th>

                            <th>CREATED</th>

                            <th>ACTION</th>

                        </tr>

                        </thead>

                        <tbody>

                                <?php foreach ($kelola as $key => $sat): ?>

                            <tr>

                                <td><?php echo $sat['kode_po'] ?></td>

                                <td><?php echo $sat['nama_cmt'].' ('.$sat['kategori_cmt'].')' ?></td>

                                <td><?php echo $sat['progress'] ?></td>
                                <td>
                                  <?php if($sat['progress']=="KIRIM"){?>
                                      <?php if(strtolower($sat['kategori_cmt'])=="sablon"){?>
                                        <a target="_blank" href="<?php echo BASEURL?>Kelolapo/kirimcmtsablonview/<?php echo $sat['kode_nota_cmt'] ?>"><?php echo $sat['kode_nota_cmt'] ?></a>
                                      <?php }else{ ?>
                                      <a target="_blank" href="<?php echo BASEURL?>Kelolapo/kirimcmtview/<?php echo $sat['kode_nota_cmt'] ?>"><?php echo $sat['kode_nota_cmt'] ?></a>
                                    <?php } ?>
                                  <?php } ?>

                                  <?php if($sat['progress']=="SETOR"){?>
                                    <?php if(strtolower($sat['kategori_cmt'])=="sablon"){?>
                                      <a target="_blank" href="<?php echo BASEURL?>Setoransablon/kirimcmtview/<?php echo $sat['kode_nota_cmt'] ?>"><?php echo $sat['kode_nota_cmt'] ?></a>
                                      <?php }else{ ?>
                                        <a target="_blank" href="<?php echo BASEURL?>Setorancmt/kirimcmtview/<?php echo $sat['kode_nota_cmt'] ?>"><?php echo $sat['kode_nota_cmt'] ?></a>
                                    <?php } ?>
                                    
                                  <?php } ?>
                                  
                                </td>

                                <td><?php echo $sat['qty_tot_pcs'] ?></td>
                                <td><?php echo $sat['pekerjaan'] ?></td>
                                <td><?php echo $sat['create_date'] ?></td>

                                <td>

                                    <!-- <a href="<?php echo BASEURL.'kelolapo/formpengecekandetail/'.$sat['kode_po'].'/'.$sat['id_kelolapo_kirim_setor']; ?>" class="btn btn-sm btn-secondary"> <i class="fi-zoom-in"></i> Detail</a> -->

                                    <!--<a href="<?php echo BASEURL.'kelolapo/kirimsetorcek/'.$sat['kode_po'].'/'.$sat['id_kelolapo_kirim_setor'] ?>" class="btn btn-sm btn-warning text-white"> <i class="dripicons-browser-upload"></i> Proses</a>-->

                                    <?php if(akseshapus()==1){?>

                                      <?php if($sat['progress']=="SETOR"){?>
                                         <a href="<?php echo BASEURL.'kelolapo/kirimsetoredit/'.$sat['idpo'].'/'.$sat['id_kelolapo_kirim_setor'] ?>" class="btn btn-sm btn-success text-white"> <i class="dripicons-browser-upload"></i> Edit</a>
                                         
                                        <a href="<?php echo $sat['editsetor'] ?>" class="btn btn-sm btn-success text-white"> <i class="dripicons-browser-upload"></i> Edit Setoran</a>
                                        <?php }else { ?>
                                            <a href="<?php echo BASEURL.'kelolapo/kirimsetoredit/'.$sat['idpo'].'/'.$sat['id_kelolapo_kirim_setor'] ?>" class="btn btn-sm btn-success text-white"> <i class="dripicons-browser-upload"></i> Edit</a>
                                      <?php } ?>
                                    <a href="<?php echo BASEURL.'kelolapo/kirimsetorhapus/'.$sat['idpo'].'/'.$sat['id_kelolapo_kirim_setor'] ?>" class="btn btn-sm btn-danger text-white"> <i class="dripicons-browser-upload"></i> Hapus</a>
                                    <?php } ?>


                                    <?php //if ($sat['kategori_cmt'] == 'BORDIR'): ?>

                                        <?php //if ($sat['progress'] == 'KIRIM'){ ?>

                                                <!--<a href="<?php echo BASEURL.'bordir/harianmesinbordirnaik/'.$sat['kode_po'] ?>" disabled class="btn btn-sm btn-info">BORDIR</a>

                                                <a href="<?php echo BASEURL.'bordir/harianbuangbenang/'.$sat['kode_po'] ?>" disabled class="btn btn-sm btn-info">BENANG</a>-->

                                        <?php //} ?>

                                    <?php //endif ?>

                                </td>

                            </tr>

                                <?php endforeach ?>

                        </tbody>

                    </table>
  </div>
</div>
<?php $this->view('newtheme/layout/table-button');?>
<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#kode_po").val();
     var cmt=$("#cmt").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&kode_po='+nomesin;
    }

    if(cmt!="*"){
      url+='&cmt='+cmt;
    }

    location=url;
  }

   function excel(){
    var url='?cetak=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#nomesin").val();
    var cmt=$("#cmt").val();

    if(cmt!="*"){
      url+='&cmt='+cmt;
    }

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