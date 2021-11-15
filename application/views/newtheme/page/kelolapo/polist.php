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
  <div class="col-md-5">
                <div class="form-group">
                  <label>Kode Po</label>
                  <select class="form-control autopo" name="kode_po" id="kode_po" data-live-search="true">
                    <option value="*">Semua</option>
                  </select>
                </div>
              </div>
              <div class="col-md-5">
                <label>Nama PO</label>
                <select name="jenis_po" id="jenis_po" class="form-control select2bs4" data-live-search="true">
                  <option value="*">Semua</option>
                  <?php foreach($jenis as $j){?>
                    <option value="<?php echo $j['nama_jenis_po']?>"><?php echo $j['nama_jenis_po']?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label>Action</label><br>
                  <button onclick="filter()" class="btn btn-info btn-sm text-white">Filter</button>
                  <a href="<?php echo $tambah ?>" class="btn btn-info btn-sm">Tambah</a>
                </div>
              </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered nosearch">
              <thead>
                <tr>
                  <th>TANGGAL</th>
                  <th>KODE ARTIKEL</th>
                  <th>NAMA PO</th>
                  <th>KODE PO</th>
                  <th>JENIS PO</th>
                  <th>KATEGORI PO</th>
                  <th>STATUS</th>
                  <th>ACTION</th>                 
                </tr>
              </thead>
              <tbody>
                <?php foreach ($po as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['tanggal'] ?></td>
                                <td><?php echo $sat['kode_artikel'] ?></td>
                                <td><?php echo $sat['nama_po'] ?></td>
                                <td><?php echo $sat['kode_po'] ?></td>
                                <td><?php echo $sat['jenis_po'] ?></td>
                                <td><?php echo $sat['kategori']?></td>
                                <td>
                                    <span class="badge badge-primary"><?php echo $sat['nama_progress'] ?></span>
                                </td>
                                <td class="right"><?php foreach ($sat['action'] as $action) { ?>
                                           <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                                          <?php } ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
              </tbody>
            </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <?php //echo $this->pagination->create_links();?>
  </div>
</div>
<script type="text/javascript">
  function filter(){
    var po=$("#kode_po").val();
    var jenispo=$("#jenis_po").val();
    url="?";
    if(po!='*'){
      url+="&kode_po="+po;
    }
    if(jenispo!='*'){
      url+="&jenis_po="+jenispo;
    }
    location = url;
  }
</script>