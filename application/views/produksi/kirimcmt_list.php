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
  </div>
</div>
<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Awal</label>
      <input type="text" name="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label>Tanggal Akhir</label>
      <input type="text" name="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>No.SJ</label>
      <select name="sj" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($nosj as $c){?>
          <option value="<?php echo $c['id']?>"  <?php echo $c['id']==$sj?'selected':'';?>><?php echo strtoupper($c['nosj'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label>Nama CMT</label>
      <select name="cmt" class="form-control select2bs4" data-live-search="true">
        <option value="*">Semua</option>
        <?php foreach($listcmt as $c){?>
          <option value="<?php echo $c['id_cmt']?>" <?php echo $c['id_cmt']==$cmt?'selected':'';?>><?php echo strtolower($c['cmt_name'])?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <label>Aksi</label><br>
    <button class="btn btn-info btn-sm" onclick="filterwithcmt()">Filter</button>
    <a href="<?php echo $tambah ?>" class="btn btn-info btn-sm">Tambah</a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>No.SJ</th>
                          <th>Tanggal</th>
                          <th>Nama CMT</th>
                          <th>Quantity</th>
                          <th>PO</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $no=1; ?>
                        <?php foreach($products as $p){?>
                          <?php foreach($p['dets'] as $d){?>
                            <?php 
                              if(isset($sablon)){
                                $po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$d['idpo']));
                              } else {
                                $po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=>$d['kode_po']));
                              } 
                            ?>
                          <tr>
                            <td><?php echo $no++?></td>
                            <td><?php echo $p['nosj']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo $p['namacmt']?></td>
                            <td><?php echo $d['jumlah_pcs']?></td>
                            <td><?php echo $po['kode_po']?></td>
                            <td><?php echo $p['status']?></td>
                            <td class="right"><?php foreach ($p['action'] as $action) { ?>
                            <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                            <?php } ?></td>
                          </tr>
                          <?php } ?>
                        <?php } ?>
                      </tbody>
                   </table>
  </div>
</div>