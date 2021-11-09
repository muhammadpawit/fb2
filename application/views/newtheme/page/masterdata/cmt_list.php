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
  <div class="col-md-12">
    <span class="text-right"><a href="<?php echo $tambah?>" class="btn btn-sm btn-info"><i class="fa fa-plus"></i> Tambah</a></span>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered" id="datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nama</th>
                  <th>Jenis PO</th>
                  <th>Telephone</th>
                  <th>Alamat</th>
                  <th>Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php if($products){?>
                  <?php foreach($products as $p){?>
                    <tr>
                      <td><?php echo $n++?></td>
                      <td><?php echo strtolower($p['cmt_name'])?></td>
                      <td>
                        <?php
                          if($p['jenis_po']==1){
                            echo "Kaos";
                          }else if($p['jenis_po']==2){
                            echo "Kemeja";
                          }else if($p['jenis_po']==3){
                            echo "Kaos dan Kemeja";
                          }else if($p['jenis_po']==4){
                            echo "Celana";
                          }else{
                            echo "belum di pilih";
                          }

                        ?>
                      </td>
                      <td><?php echo strtolower($p['telephone'])?></td>
                      <td><?php echo strtolower($p['alamat'])?></td>
                      <td><?php echo strtolower($p['keterangan'])?></td>
                      <td>
                        <?php if($p['cmt_job_desk']=='JAHIT'){?>
                           <a href="<?php echo BASEURL.'Masterdata/daftarhargacmt'.'/'.$p['id_cmt'];?>" class="btn btn-success btn-xs">Daftar Harga</a>

                           <a href="<?php echo BASEURL.'Masterdata/ongkoshpp'.'/'.$p['id_cmt'];?>" class="btn btn-success btn-xs">Ongkos HPP</a>
                        <?PHP  } ?>
                        <?php if($edit==1){?>
                         
                          <a href="<?php echo BASEURL.'Masterdata/cmtedit'.'/'.$p['id_cmt'];?>" class="btn btn-info btn-xs">Edit</a>
                          <a href="<?php echo BASEURL.'Masterdata/cmthapus'.'/'.$p['id_cmt'];?>" class="btn btn-danger btn-xs">Hapus</a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php }?>
                <?php }?>
              </tbody>
            </table>
  </div>
</div>