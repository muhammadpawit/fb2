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

      <label>Tanggal Awal</label>

      <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">

    </div>

  </div>

  <div class="col-md-4">

    <div class="form-group">

      <label>Tanggal Akhir</label>

      <input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">

    </div>

  </div>

  <div class="col-md-4">

    <div class="form-group">

      <label>Aksi</label><br>

      <button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
      <button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>

    </div>

  </div>

</div>

<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
        <thead style="text-align: center;">
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama CMT</th>
            <th colspan="2">Stok Awal Kaos</th>
            <th colspan="2">Stok Awal Kemeja</th>
            <th colspan="2">Kirim Kaos</th>
            <th colspan="2">Kirim Kemeja</th>
            <th colspan="2">Setor Kaos</th>
            <th colspan="2">Setor Kemeja</th>
            <th colspan="2">Stok Akhir Kaos</th>
            <th colspan="2">Stok Akhir Kemeja</th>
          </tr>
          <tr>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
            <th>JML</th>
            <th>DZ</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($products as $p){?>
            <tr>
              <td><?php echo $p['no']?></td>
              <td><?php echo $p['nama']?></td>
              <td><?php echo ($p['stokawalkaosjml'])?></td>
              <td><?php echo $p['stokawalkaosdz']>0?number_format($p['stokawalkaosdz']):'';?></td>
              <td><?php echo ($p['stokawalkemejajml'])?></td>
              <td><?php echo $p['stokawalkemejadz']>0?number_format($p['stokawalkemejadz']):'';?></td>
              <td><?php echo ($p['kirimkaosjml'])?></td>
              <td><?php echo $p['kirimkaosdz']>0?number_format($p['kirimkaosdz']):'';?></td>
              <td><?php echo ($p['kirimkemejajml'])?></td>
              <td><?php echo $p['kirimkemejadz']>0?number_format($p['kirimkemejadz']):'';?></td>
              <td><?php echo ($p['setorkaosjml'])?></td>
              <td><?php echo $p['setorkaosdz']>0?number_format($p['setorkaosdz']):'';?></td>
              <td><?php echo ($p['setorkemejajml'])?></td>
              <td><?php echo $p['setorkemejadz']>0?number_format($p['setorkemejadz']):'';?></td>
              
              <td><?php echo ($p['stokakhirkaosjml'])?></td>
              <td><?php echo $p['stokakhirkaosdz']>0?number_format($p['stokakhirkaosdz']):'';?></td>
              <td><?php echo ($p['stokakhirkemejajml'])?></td>
              <td><?php echo $p['stokakhirkemejadz']>0?number_format($p['stokakhirkemejadz']):'';?></td>
            </tr>
          <?php }?>
        </tbody>
    </table>
  </div>
</div>