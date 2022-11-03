<div class="row">
  <div class="col-md-12">
    <div class="form-group">
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
</div>
<div class="row">
      <div class="col-md-3">
          <label>Tanggal Awal</label>
          <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
      </div>
                <div class="col-md-3">
                  <label>Tanggal Awal</label>
                  <input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
                </div>
                <div class="col-md-3">
                    <label>Divisi / Cabang</label>
                    <select name="cat" id="cat" class="form-control select2bs4">
                        <option value="*">Semua</option>
                        <option value="3" <?php echo $cat==3?'selected':'';?>>Konveksi</option>
                        <option value="2" <?php echo $cat==2?'selected':'';?>>Bordir</option>
                        <option value="1" <?php echo $cat==1?'selected':'';?>>Sablon</option>
                         <option value="4" <?php echo $cat==4?'selected':'';?>>Sukabumi</option>
                    </select>
                </div>
                <div class="col-md-3">
                  <label>Action</label><br>
                  <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
                  <span><a href="<?php echo $tambah?>" class="btn btn-sm btn-info">Tambah</a></span>
                  <button onclick="excel()" class="btn btn-info btn-sm">Excel</button>
                </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <div class="table-responsive">
              <table class="table table-bordered nosearch">

                        <thead>

                        <tr>


                            <th>Tanggal</th>

                            <th>Divisi / Cabang</th>

                            <th>Cash</th>

                            <th>Transfer</th>

                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Status</th>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Waktu dibuat</th>

                        </tr>

                        </thead>

                        <tbody>

                                <?php foreach ($harian as $key => $us): ?>

                            <tr>


                                <td><?php echo date('d F Y',strtotime($us['tanggal'])) ?></td>

                                <td><?php if ($us['kategori'] == 1) {

                                   echo "Sablon";

                                } else if($us['kategori'] == 2) { echo "Bordir"; } else if($us['kategori'] == 3) {echo "Konveksi";}
                                else if($us['kategori'] == 4) {echo "Sukabumi";}?></td>

                                <td><?php echo number_format($us['cash'])?></td>
                                <td><?php echo number_format($us['transfer'])?></td>
                                <td><?php echo number_format($us['cash']+$us['transfer'])?></td>
                                <td>
                                  <?php echo strtolower($us['keterangan'])?>
                                </td>
                                <td>

                                <?php 
                                    if($us['status']==0){
                                        echo '<span class="badge bg-primary text-white">Diajukan</span>';
                                    }else if($us['status']==1){
                                        echo '<span class="badge bg-success text-white">Disetujui</span>';
                                    }else if($us['status']==3){
                                        echo '<span class="badge bg-danger text-white">Revisi</span>';
                                    }else{
                                        echo '<span class="badge bg-danger text-white">Ditolak</span>';
                                    }

                                ?>        

                                </td>

                                <td>
                                    <a href="<?php echo BASEURL.'Gudang/pengajuancetak/'.$us['id']; ?>" class="btn btn-warning btn-lg text-white">Lihat</a>
                                </td>
                                <td>
                                  <?php if($us['status']==1 && aksesedit()==1){?>
                                    <a href="<?php echo BASEURL.'Gudang/ajuanedit/'.$us['id']; ?>?&acc=true" class="btn btn-dark btn-lg text-white">Edit</a>
                                    <?php }?>
                                </td>
                                <td>
                                  <?php if($us['status']==0 OR $us['status']==3){?>
                                      <a href="<?php echo BASEURL.'Gudang/ajuanedit/'.$us['id']; ?>" class="btn btn-dark btn-lg text-white">Edit</a>
                                    <?php } ?>
                                </td>                                
                                <td>
                                  <?php if($setujui==1 && $us['status']==0){?>
                                      <a href="<?php echo BASEURL.'Gudang/setujuiajuan/'.$us['id']; ?>" class="btn btn-success btn-lg text-white">Setujui</a>
                                    <?php } ?>
                                </td>
                                <td>
                                  <?php if($setujui==1 && $us['status']==0){?>
                                      <a href="<?php echo BASEURL.'Gudang/pengajuandetail/'.$us['id']; ?>" class="btn btn-success btn-lg text-white">Komentar</a>
                                    <?php } ?>
                                </td>
                                <td>
                                  <?php if(akseshapus()==1 && $us['status']==0){?>
                                      <a href="<?php echo BASEURL.'Gudang/ajuanhapus/'.$us['id']; ?>" class="btn btn-danger btn-lg text-white">Hapus</a>
                                    <?php } ?>
                                </td>
                                <td><?php echo $us['dibuat']==null?'':date('d/m/Y H:i:s',strtotime($us['dibuat'])) ?></td>

                            </tr>

                                <?php endforeach ?>

                        </tbody>

                    </table>
            </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var cat=$("#cat").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(cat!="*"){
        url+='&cat='+cat;
    }

    location=url;
  }

  function excel(){
    var url='?excel=1';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var cat=$("#cat").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(cat!="*"){
        url+='&cat='+cat;
    }

    location=url;
  }
</script>    