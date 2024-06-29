            <form class="form-group" method="post" action="<?php echo $action?>">
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" name="tanggal" class="form-control datelockback" value="<?php echo date('Y-m-d',strtotime($d['tanggal']))?>">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Mandor</label>
                   <input type="text" name="mandor" class="form-control" value="<?php echo $d['mandor']?>" required>
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                    <label>Shift</label>
                    <select name="shift" class="form-select select2bs4" id="shift">
                        <option value="">Pilih</option>
                        <option value="Pagi" <?php echo $d['shift'] == 'Pagi' ? 'selected':'';?>>Pagi</option>
                        <option value="Malam" <?php echo $d['shift'] == 'Malam' ? 'selected':'';?>>Malam</option>
                    </select>
                  </div>
                </div>
                <div class="col-6">
                  <!-- <div class="form-group">
                    <label>Bagian</label>
                    <textarea class="form-control" name="gudang" required>Pusat</textarea>
                  </div> -->
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                    <table class="table table-bordered" id="addbahankeluars">
                      <thead>
                      <tr>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Jumlah Ajuan</th>
                        <th>Kebutuhan</th>
                        <th>Keterangan</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php foreach($dt as $b){ ?>
                          <?php $barang = $this->GlobalModel->getDataRow('gudang_persediaan_item',array('id_persediaan'=>$b['id_persediaan'],'hapus'=>0)); ?>
                          <tr>
                            <td><?php echo $barang['nama_item']?></td>
                            <td><?php echo $b['stock']?></td>
                            <td><?php echo $b['ajuan']?></td>
                            <td><?php echo $b['kebutuhan']?></td>
                            <td><?php echo $b['keterangan']?></td>
                          </tr>

                        <?php } ?>
                      </tbody>
                    </table>                  
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <!-- <button type="submit" class="btn btn-success text-white">Simpan</button> -->
                      <a href="<?php echo $batal?>" class="btn btn-danger text-white">Kembali</a>
                      <?php if($d['status']==1){ ?>
                        <a href="<?php echo $print?>" target="_blank" class="btn btn-primary text-white">Print</a>
                      <?php }else{ ?>
                        <a href="javascript:void(0)" onclick="return alert('menunggu validasi admin gudang');return false;" class="btn btn-primary text-white">Print</a>
                      <?php } ?>
                    </div>
                </div>
              </div>
            </form>

            <script type="text/javascript">
$(document).ready(function(){
    var i=0;
    $(document).on('click', '.addbahankeluars', function(){
        var html = '';
        html += '<tr>';
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="products['+i+'][idpersediaan]" ><input type="hidden" class="form-control harga" name="products['+i+'][harga]" ></td>';
        html += '<td><select type="text" class="form-control barang select2bs4" name="products['+i+'][nama]" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
        html += '<td><input type="hidden" class="form-control stok" name="products['+i+'][stok_saatini]"><input type="number" class="form-control stok" name="products['+i+'][stok]" disabled></td>';
        html += '<td><input type="number" class="form-control jumlah_ajuan" name="products['+i+'][jumlah]" ></td>';
        html += '<td><select class="form-control satuanJml" name="products['+i+'][satuan]" readonly><?php foreach ($satuan as $key => $satt): ?><option value="<?php echo $satt['kode_satuan_barang'] ?>"><?php echo $satt['kode_satuan_barang'] ?></option><?php endforeach ?></select></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]"></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        i++;
        $('#addbahankeluars').append(html);
         //$('.selectpicker').selectpicker('refresh');
        $('.barang').select2();
        //$('.barang').select2({
          //theme: 'bootstrap4'
        //});
     });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.barang', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'gudang/itemkeluarSearchId' ?>", { id: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".stok").val(obj.quantity);
            // dai.find(".jumlah").val(obj.quantity);
            dai.find(".satuanJml").val(obj.satuan_jumlah_item);
            dai.find(".id").val(obj.id_persediaan);
            dai.find(".harga").val(obj.harga_item);
            // dai.find(".jumlah").attr('max',obj.jumlah_item);
        });
    });
});
 </script>                  