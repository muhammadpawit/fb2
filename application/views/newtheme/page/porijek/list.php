<div class="row">
  <div class="col-md-6">
    <div class="form-group">
        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Tambah</button>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="form-group">
        <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode PO</th>
                <th>Jumlah (Pcs)</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($prods as $p){ ?>
                <tr>
                  <td><?php echo $no++;?></td>
                  <td><?php echo $p['kode_po']?></td>
                  <td><?php echo $p['pcs']?></td>
                  <td><?php echo $p['keterangan']?></td>
                </tr>
              <?php } ?>
              <tr>
                <td colspan="2"><b>Total</b></td>
                <td><b><?php echo $total['total'] ?></b></td>
                <td></td>
              </tr>
            </tbody>
        </table>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Baru</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?php echo $action ?>">
          <div class="row">
            <div class="col-md-12">
              <label>Kode PO</label>
              <select name="kode_po" id="kode_po" class="form-control select2bs4 autopoid" style="width: 100%">
                
              </select>
            </div>
            <div class="col-md-12">
              <label>Jumlah Pcs</label>
              <input type="text" name="pcs" class="form-control" value="0">
            </div>
            <div class="col-md-12">
              <label>Keterangan</label>
              <textarea name="keterangan" class="form-control" required></textarea>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <br>
              <button type="submit" class="btn btn-success full btn-sm">Simpan</button>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group"><br>
              <button type="button" class="btn btn-default btn-sm full" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>

  </div>
</div>
