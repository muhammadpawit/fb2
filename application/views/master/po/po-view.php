<div class="row">

  <div class="col-md-12">

    <?php if ($this->session->flashdata('msg')) { ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

            <span aria-hidden="true">×</span>

        </button>

        <?php echo $this->session->flashdata('msg'); ?> 

    </div>

    <?php } ?>

         <?php if ($this->session->flashdata('gagal')) { ?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

      <button type="button" class="close" data-dismiss="alert" aria-label="Close">

          <span aria-hidden="true">×</span>

        </button>

    <?php echo $this->session->flashdata('gagal'); ?> 

    </div>

    <?php } ?>

  </div>

</div>
<div class="row">
    <div class="col-md-12 text-right">
        <a href="<?php echo BASEURL.'masterdata/namapoTambah' ?>" class="btn btn-info btn-sm text-white">Tambah</a>
    </div>
</div><br>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered yessearch">
                        <thead>
                        <tr>
                            <th>Nama PO</th>
                            <th>Type</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($satuan as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['nama_jenis_po'] ?></td>
                                <td><?php echo $sat['idjenis']==1?'Kemeja':'Kaos' ?></td>
                                <th>
                                    <!--<a href="<?php echo BASEURL.'master/namapoEdit/'.$sat['id_jenis_po'] ?>" class="btn btn-custom"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo BASEURL.'master/deletePoKode/'.$sat['id_jenis_po'] ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>-->
                                </th>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
    </div>
</div>