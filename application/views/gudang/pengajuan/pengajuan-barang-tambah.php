<style type="text/css">
   
</style>
<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <div class="row">
                        <div class="col-6">
                            <h4 class="header-title m-t-0 m-b-20">Item Keluar</h4>
                        </div>
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                PERHATIKAN FORM ADD ITEM NYA <strong>PADA PENGACUAN DATA NYA</strong> JANGAN ASAL SUBMIT !!!!!!!
                            </div>
                        </div>
                        
                    </div>
                    <hr>
                   <form action="<?php echo BASEURL.'pengajuan/pengajuanitemOnPrint' ?>" method="POST">
                            
                        <div class="row">
                            
                            <table class="table table-bordered" id="item_table">
                                <tr>
                                    <th style="width: 180px;">Nama Barang</th>
                                    <th>Nama PO</th>
                                    <th>PER Po</th>
                                    <th>Kebutuhan</th>
                                    <th>Stok</th>
                                    <th style="width: 120px;">Satuan</th>
                                    <th>Ajuan</th>
                                    <th>Keterangan</th>
                                   
                                    <th><button type="button" name="add" class="btn btn-success btn-sm add"><i class="fa fa-plus"></i></button></th>
                                </tr>
                            </table>
                            <hr>
                        </div>

                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>

                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
 <script src="<?php echo ASSETS ?>js/jscolor.js"></script>
 <script type="text/javascript">
$(document).ready(function(){


    $(document).on('click', '.add', function(){
        var html = '';
        html += '<tr>';
        html += '<td style="display:none;"><input type="hidden" class="form-control id" name="id[]" ></td>';
        html += '<td><select type="text" class="form-control selectpicker" name="namaBarang[]" required><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
    html += '<td><input type="text" class="form-control namaPO" name="namaPO[]" ></td>';
        html += '<td><input type="number" class="form-control perPo" name="perPo[]" ></td>';
    html += '<td><input type="number" class="form-control kebutuhan" name="kebutuhan[]" onkeyup="onKeyUpFunction()"></td>';
        html += '<td><input type="number" class="form-control stok" name="stok[]" required></td>';
    html += '<td><select class="form-control" name="satuanJml[]"><option>PCS</option></select></td>';
        html += '<td><input type="number" class="form-control ajuan" name="ajuan[]" ></td>';
        html += '<td><input type="text" class="form-control keterangan" name="keterangan[]" required></td>';
     
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><span class="fa fa-trash"></span></button></td></tr>';
        $('#item_table').append(html);
     });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
    $(document).on('change', '.selectpicker', function(e){
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'gudang/itemkeluarSearchId' ?>", { id: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            dai.find(".warna").val(obj.warna_item);
            dai.find(".ukuran").val(obj.ukuran_item);
            dai.find(".satuanUkran").val(obj.satuan_ukuran_item);
            dai.find(".stok").val(obj.jumlah_item);
            dai.find(".satuanJml").val(obj.satuan_jumlah_item);
            dai.find(".id").val(obj.id_persediaan);
            dai.find(".jumlah").attr('max',obj.jumlah_item);
            dai.find(".harga").val(obj.harga_item)
        });
    });
});
 </script>