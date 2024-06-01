<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      <label>Kode PO</label>
      <select name="kode_po" class="form-control autopoi">
        
      </select>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Aksi</label><br>
      <button class="btn btn-info btn-sm" onclick="filterwithpo()">Filter</button>
      <span class="pull-right"><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button></span>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table table-bordered yessearch">
      <thead>
        <tr>
          <th>No</th>
          <th>Kode PO</th>
          <th>Dz</th>
          <th>Pcs</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($prods as $p){?>
          <tr>
            <td><?php echo $p['no']?></td>
            <td><?php echo $p['kode_po']?></td>
            <td><?php echo number_format($p['dz'],2)?></td>
            <td><?php echo $p['pcs']?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>