 
      <!-- Default box -->
      <div class="card card-info">
        <div class="card-header">
          <h3 class="card-title">Persetujuan Kasbon Karyawan</h3>
        </div>
        <div class="card-body">
          <div class="card-header">
            <label>
              <?php if(!empty($acc['tanggal'])){?>
                <?php echo hari(date('l',strtotime($acc['tanggal'])))?>,&nbsp;<?php echo date('d F Y',strtotime($acc['tanggal']))?>
              <?php }else{ ?>
                  <label class="alert alert-danger">Kasbon belum di acc</label>
              <?php } ?>
            </label>
          </div>
          <div class="table-responsive">
            <form method="post" action="<?php echo $action?>">
              <div class="form-group col-sm-12 col-lg-6">
                  <input type="hidden" id="id" name="id" class="form-control" required="required" value="<?php echo $acc['id']?>">
              </div>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Nama Karyawan</th>
                  <th>Bagian</th>
                  <th>Jumlah Kasbon</th>
                  <th>Jumlah Di ACC</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($detail as $d){?>
                  <tr>
                    <td><input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $d['id']?>"><?php echo $d['tanggal'];?></td>
                    <td><?php echo $d['nama'];?></td>
                    <td><?php echo $d['divisi'];?></td>
                    <td>Rp. <?php echo number_format($d['nominal']);?></td>
                    <td>Rp. <?php echo number_format($d['nominal_acc']);?></td>
                  </tr>
                  <?php $i++?>
                <?php } ?>
                <tr>
                  <td colspan="3" align="center"><label>Total</label></td>
                  <td>Rp.&nbsp;<?php echo number_format($ajuan)?></td>
                  <td>Rp.&nbsp;<?php echo number_format($total)?></td>
                </tr>
              </tbody>
            </table>
            </form>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <a href="<?php echo $kembali;?>" class="btn btn-danger text-white">Kembali</a>
          <a href="<?php echo $excel;?>" class="btn btn-success text-white">Excel</a>
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
<script type="text/javascript">
  $(document).ready(function(){

    $('.select2').select2({
      theme: "classic",
      placeholder: 'Select an option'
    });

    


  });

  function iptgl(){
    var t=$("#tgl").val();
    $(".tgl").html(t);
  }

  function cetak(){
      window.print();
  }

  $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

</script>