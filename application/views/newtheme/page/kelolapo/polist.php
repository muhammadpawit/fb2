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
      <select class="form-control select2bs4" name="kode_po" id="kode_po" data-live-search="true">
        <option value="*">Semua</option>
        <?php if(!empty($namaPO)){ ?>
          <?php foreach($namaPO as $p){ ?>
            <option value="<?php echo $p['id_produksi_po']?>" <?php echo (isset($kode_po) && ($kode_po==$p['id_produksi_po'] || $kode_po==$p['kode_po'])) ? 'selected' : '';?>><?php echo $p['kode_po']?></option>
          <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="col-md-5">
    <label>Nama PO</label>
    <select name="jenis_po" id="jenis_po" class="form-control select2bs4" data-live-search="true">
      <option value="*">Semua</option>
      <?php if(!empty($jenis)){ ?>
        <?php foreach($jenis as $j){?>
          <option value="<?php echo $j['nama_jenis_po']?>" <?php echo (isset($jenis_po) && $jenis_po==$j['nama_jenis_po']) ? 'selected' : '';?>><?php echo $j['nama_jenis_po']?></option>
        <?php } ?>
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
    <table class="table table-bordered yessearch">
              <thead>
                <tr>
                  <th>FOTO</th>
                  <th>TANGGAL</th>
                  <th>KODE ARTIKEL</th>
                  <th>NAMA PO</th>
                  <th>KODE PO</th>
                  <th>JENIS PO</th>
                  <th>KETERANGAN PO</th>
                  <th>STATUS</th>
                  <th>ACTION</th>                 
                </tr>
              </thead>
              <tbody>
                <?php foreach ($po as $key => $sat): ?>
                            <tr>
                                <td>
                                  <?php if(!empty($sat['gambar1'])){ ?>
                                    <button type="button" class="btn btn-xs btn-primary btn-lihat-gambar"
                                            data-kode="<?php echo $sat['kode_po'] ?>"
                                            data-nama="<?php echo $sat['nama_po'] ?>"
                                            data-img1="<?php echo BASEURL.$sat['gambar1'] ?>"
                                            data-img2="<?php echo !empty($sat['gambar2']) ? BASEURL.$sat['gambar2'] : '' ?>">
                                      <i class="fa fa-image"></i> Lihat Foto
                                    </button>
                                  <?php } else { ?>
                                    <span class="text-muted"><i class="fa fa-minus"></i></span>
                                  <?php } ?>
                                </td>
                                <td><?php echo $sat['tanggal'] ?></td>
                                <td><?php echo $sat['kode_artikel'] ?></td>
                                <td><?php echo $sat['nama_po'] ?></td>
                                <td><?php echo $sat['kode_po'] ?></td>
                                <td><?php echo $sat['jenis_po'] ?></td>
                                <td><?php echo $sat['keterangan'] ?? ''?></td>
                                <td>
                                    <span class="badge badge-primary"><?php echo $sat['nama_progress'] ?></span>
                                </td>
                                <td class="right"><?php foreach ($sat['action'] as $action) { ?>
                                           <a href="<?php echo $action['href']; ?>" class="badge <?php echo $action['bg'] ?? ''?> badge-info waves-light waves-effect"><?php echo $action['text']; ?></a>&nbsp;&nbsp;
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
<!-- Modal Detail Gambar PO -->
<div class="modal fade" id="modalGambarPO" tabindex="-1" role="dialog" aria-labelledby="modalGambarPOLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="modalGambarPOLabel"><i class="fa fa-image"></i> Foto PO: <span id="modalPoTitle"></span></h4>
      </div>
      <div class="modal-body text-center">
        <div class="row">
          <div class="col-md-12" id="boxGambar1">
            <label>Gambar 1</label>
            <img id="modalImg1" src="" class="img-responsive img-thumbnail" style="max-height: 380px; margin: 0 auto; display: block;" alt="Foto PO">
          </div>
          <div class="col-md-12" id="boxGambar2" style="margin-top: 15px; display: none;">
            <label>Gambar 2</label>
            <img id="modalImg2" src="" class="img-responsive img-thumbnail" style="max-height: 380px; margin: 0 auto; display: block;" alt="Foto PO 2">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function () {
    $('.select2bs4').select2();
  });

  $(document).on('click', '.btn-lihat-gambar', function() {
    var kode = $(this).data('kode');
    var nama = $(this).data('nama');
    var img1 = $(this).data('img1');
    var img2 = $(this).data('img2');

    $('#modalPoTitle').text(kode + ' (' + nama + ')');
    $('#modalImg1').attr('src', img1);

    if (img2 && img2.trim() !== '') {
      $('#modalImg2').attr('src', img2);
      $('#boxGambar2').show();
    } else {
      $('#modalImg2').attr('src', '');
      $('#boxGambar2').hide();
    }

    $('#modalGambarPO').modal('show');
  });

  function filter(){
    var po=$("#kode_po").val();
    var jenispo=$("#jenis_po").val();
    url="?";
    if(po && po!='*'){
      url+="&kode_po="+po;
    }
    if(jenispo && jenispo!='*'){
      url+="&jenis_po="+jenispo;
    }
    location = url;
  }
</script>