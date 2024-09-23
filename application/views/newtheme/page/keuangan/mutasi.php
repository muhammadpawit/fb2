<div class="row">
            <div class="col-md-3">
              <label>Tanggal Awal</label>
              <input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
            </div>
            <div class="col-md-3">
              <label>Tanggal Akhir</label>
              <input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
            </div>
            <div class="col-md-3">
              <label>Bagian</label>
              <select name="cat" id="cat" class="form-control select2bs4">
                <option value="*">Semua</option>
                <option value="0" <?php echo $cat=='0'?'selected':'';?>>Default</option>
                <option value="1" <?php echo $cat==1?'selected':'';?>>Konveksi</option>
                <option value="2" <?php echo $cat==2?'selected':'';?>>Bordir</option>
              <option value="3" <?php echo $cat==3?'selected':'';?>>Sablon</option>
              </select>
            </div>
            <div class="col-md-3">
              <label>Action</label><br>
              <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
              <button onclick="excel()" class="btn btn-info btn-sm">Excel</button>
              <a href="<?php echo $kembali?>" class="btn btn-sm btn-info btn-sm">Kembali</a>
            </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th width="100">Tanggal</th>
                  <th>Divisi</th>
                  <th>Keterangan</th>
                  <th>Saldomasuk</th>
                  <th>Saldokeluar</th>
                  <th>Sisa</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1?>
                <?php foreach($mutasi as $m){?>
                  <tr>
                    <td><?php echo $no++?></td>
                    <td><?php echo date('d-m-Y',strtotime($m['tanggal'])) ?></td>
                    <td>
                      <?php 
                        if($m['bagian']==1){
                          echo "Konveksi";
                        }else if($m['bagian']==2){
                          echo "Bordir";
                        }else if($m['bagian']==3){
                          echo "Sablon";
                        }else{
                          echo "Default";
                        }
                      ?>
                    </td>
                    <td><?php echo $m['keterangan']?></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo number_format($m['saldomasuk'])?></p></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo number_format($m['saldokeluar'])?></p></td>
                    <td><span style="float: left">Rp.</span><p style="text-align: right !important;width: 150px;float: right;"><?php echo number_format($m['saldo'])?></p></td>
                    <td>
                      <?php if(aksesedit()==1){?>
                        <a href="javascript:void(0)" class="btn btn-xs btn-warning btn-edit" data-id="<?php echo $m['id']?>">Edit</a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Detail Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Konten rincian data akan dimasukkan di sini -->
        <p id="modalContent">Loading...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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


  $(document).ready(function() {
    // Ketika tombol Edit diklik
    $('.btn-edit').on('click', function() {
      var id = $(this).data('id');
      
      // Mengubah konten modal saat tombol diklik
      $('#modalContent').html('Loading data for ID: ' + id);

      // Memanggil AJAX untuk mendapatkan detail data (gunakan URL API Anda)
      $.ajax({
        url: '<?php echo BASEURL?>Keuangan/getmutasi', // Ganti dengan URL untuk mengambil detail data
        type: 'GET',
        data: { id: id },
        success: function(response) {
          // Tampilkan data yang diterima ke modal
          $('#modalContent').html(response);
        },
        error: function() {
          $('#modalContent').html('Failed to load data.');
        }
      });

      // Menampilkan modal
      $('#detailModal').modal('show');
    });
  });

</script>  