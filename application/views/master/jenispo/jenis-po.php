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

    <div class="col-md-4">

        <div class="form-group">

            <a href="<?php echo $tambah?>" class="btn btn-info btn-sm text-white">Tambah</a>

        </div>

    </div>

</div>
<div class="row">
    <div class="col-md-12">
         <table class="table table-bordered yessearch">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jenis PO</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $no=1;?>
                                <?php foreach ($jenis as $key => $jen): ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo strtolower($jen['nama_jenis_kaos']) ?></td>
                                <td></td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
    </div>
</div>