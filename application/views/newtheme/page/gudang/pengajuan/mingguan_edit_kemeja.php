<form method="post" action="<?php echo $action ?>">
  <input type="hidden" name="id" value="<?php echo $k['id']?>">
  <input type="hidden" name="tanggal" value="<?php echo $k['tanggal']?>">
  <input type="hidden" name="jenis" value="<?php echo $k['jenis']?>">
  <div class="row">
      <div class="col-md-12">
        <table class="table table-bordered">
          <tr>
            <td colspan="10" align="center"><b>Kebutuhan <?php echo $k['kebutuhan']?></b></td>
          </tr>
          <tr>
            <td colspan="10" align="center"><b><input name="keterangan" value="<?php echo $k['keterangan2']?>" class="form-control"></b></td>
          </tr>
          <tr>
            <td colspan="10">Tanggal : <?php echo date('d-m-Y',strtotime($k['tanggal']))?></td>
          </tr>
          <tr>
            <!-- <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>No</b></td> -->
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Nama PO</b></td>
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Rincian PO</b></td>
            <td colspan="2" style="vertical-align: middle;text-align: center;"><b>Jumlah PO</b></td>
            <td colspan="3" style="vertical-align: middle;text-align: center;"><b>Ajuan </b></td>
            <td rowspan="2" style="vertical-align: middle;text-align: center;"><b>Ket</b></td>
          </tr>
          <tr>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">PCS</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">DZ</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">Kebutuhan</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">Stok</td>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">Ajuan</td>
          </tr>
          <?php $i=0;$pcs=0;$dz=0;?>
          <?php foreach($kd as $d){?>
            <tr>
              <!-- <td></td> -->
              <td>
                <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $d['id']?>">
                <input type="text" name="products[<?php echo $i?>][kode_po]" value="<?php echo $d['kode_po']?>">
              </td>
              <td>
                <input type="text" name="products[<?php echo $i?>][jumlah_po]" size="5" value="<?php echo $d['jumlah_po']?>">
              </td>
              <td>
                <textarea name="products[<?php echo $i?>][rincian_po]"><?php echo $d['rincian_po']?></textarea>
              </td>
              <td>
                <input type="text" name="products[<?php echo $i?>][jml_pcs]" size="5" value="<?php echo ($d['jml_pcs'])?>">
              </td>
              <td>
                <input type="text" name="products[<?php echo $i?>][jml_dz]" size="5" value="<?php echo ($d['jml_dz'])?>">
              </td>
              <td valign="middle" style="vertical-align: middle !important;text-align: center !important;"><?php echo ($d['jumlah_po']*$d['jml_pcs'])?></td>
              <?php if(0==$i){?>
              <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['stok']?></td>
              <td valign="middle" rowspan="<?php echo count($kd)?>" style="vertical-align: middle !important;text-align: center !important;"><?php echo $k['jml_ajuan']?> .</td>
              <?php } ?>
              <td>
                <textarea name="products[<?php echo $i ?>][keterangan]"><?php echo ($d['keterangan'])?></textarea>
              </td>
            </tr>
            <?php $i++?>
            <?php 
              $pcs+=$d['jml_pcs'];
              $dz+=$d['jml_dz'];
            ?>
          <?php } ?>
            <tr style="background-color: #ffe0fb">
              <td colspan="3"><b>Total</b></td>
              <td><b><?php echo $pcs?></b></td>
              <td><b><?php echo $dz?></b></td>
              <td align="center"><b><?php echo $k['ajuan_kebutuhan']?></b></td>
              <td><b><?php //echo $k['stok']?></b></td>
              <td><b><?php //echo $k['jml_ajuan']?></b></td>
              <td></td>
            <tr>
              <td colspan="10" align="right"><b>Registered by Forboys Production System</b></td>
            </tr>
        </table>
      </div>
  </div>
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        <label>Stok</label>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <input type="text" name="stok" value="<?php echo $k['stok']?>" class="form-control">
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label>Stok SKB</label>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <input type="text" name="stok_skb" value="<?php echo $k['stok']?>" class="form-control">
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
              <caption>Tambahan</caption>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Nama PO</th>
                    <th>Jumlah PO</th>
                    <th>Rincian PO</th>
                    <th>Jml Pcs</th>
                    <th>Jml Dz</th>
                    <th>Keterangan</th>
                    <th align="right"><a onclick="tambah()" class="btn btn-info btn-sm text-white"><i class="fa fa-plus"></i></a></th>
                  </tr>
                </thead>
                <tbody id="listajuan">
                  
                </tbody>
              </table>
            </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <button class="btn btn-success btn-sm full">Simpan</button>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <a href="<?php echo $cancel ?>" class="btn btn-danger btn-sm full">Batal</a>
      </div>
    </div>
  </div>
</form>

<script type="text/javascript">
  var i='<?php echo $i ?>';
  function tambah() {
    var html='<tr>';
        html+='<td><input type="text" name="products['+i+'][kode_po]" class="form-control" required="required" value="-"></td>';
        html+='<td><input type="text" name="products['+i+'][jumlah_po]" class="form-control" required="required" value="0"></td>';
        html+='<td><textarea cols="50" rows="5" name="products['+i+'][rincian_po]" class="form-control" required="required"></textarea></td>';
        html+='<td><input type="text" name="products['+i+'][jml_pcs]" class="form-control" required="required" value="0"></td>';
        html+='<td><input type="text" name="products['+i+'][jml_dz]" class="form-control" required="required" value="-"></td>';
        html+='<td><textarea cols="50" rows="5" name="products['+i+'][keterangan]" class="form-control" required="required"></textarea></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $("#listajuan").append(html);
        $(".select2bs4").selectpicker('refresh');
        i++;
  }

  $(document).on('click', '.remove', function(){

        $(this).closest('tr').remove();

    });

</script>