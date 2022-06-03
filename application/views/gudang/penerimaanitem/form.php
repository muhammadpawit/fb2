<h4 class="header-title">Tambah Penerimaan</h4>
<div class="sub-header text-right">
                            <span class="pull-right text-white"><a onclick="simpan()" class="btn btn-primary">Simpan</a> <a href="<?php echo BASEURL.'gudang/penerimaanitem'?>" class="btn btn-danger">Batal</a> </span>
                        </div>
                        <div class="table-responsive">
                            <form method="post" class="form-group" action="<?php echo $action?>">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                    <label>Tanggal (Tahun-bulan-tanggal) Contoh : 2021-01-01</label>&nbsp;
                                    <input type="text" autocomplete="off" id="tanggal" name="tanggal" class="form-control datepicker" required>
                                </div>
                                <div class="form-group">
                                    <label>No.Nota / Surat Jalan</label>
                                    <input type="text" id="nosj" name="nosj" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" id="keterangan" name="keterangan" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama Supplier</label>
                                    <select name="supplier" id="supplier" class="form-control select2bs4" data-live-search="true" required>
                                        <option value=""></option>
                                        <?php if($supplier){ ?>
                                        <?php foreach($supplier as $s){ ?>
                                            <option value="<?php echo $s['id']?>"><?php echo $s['nama']?></option>
                                        <?php } ?>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Penerimaan</label>
                                    <select name="jenis" id="jenis" class="form-control select2bs4" data-live-search="true"  required="required">
                                        <option value="">Pilih</option>
                                        <option value="1">Bahan</option>
                                        <option value="2">Alat-alat Bordir</option>
                                        <option value="3">Alat-alat Konveksi</option>
                                        <option value="4">Sablon</option>
                                        <option value="5">Penyesuaian Stok Awal</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Rincian Barang</label><br>
                                    &nbsp;<a onclick="additem()" class="btn btn-success text-white"><i class="fa fa-plus"></i></a>
                                </div>
                                    </div>
                                </div>
                                <table class="table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Warna</th>
                                            <th>Quantity.Satuan</th>
                                            <th>Satuan</th>
                                            <th>Jumlah Qty</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <?php $i=0?>
                                    <tbody id="item-list">
                                        
                                    </tbody>
                                </table>
                            </form>
                        </div>
<script type="text/javascript">
    function simpan(){
        var tanggal=$("#tanggal").val();
        if(tanggal==''){
            alert("Tanggal harus diisi");
            return false;
        }

        var nosj=$("#nosj").val();
        if(nosj==''){
            alert("Nota harus diisi");
            return false;
        }

        var supplier=$("#supplier").val();
        if(supplier==''){
            alert("Nama supplier harus dipilih");
            return false;
        }
        $("form").submit();
    }
    var i=0;
    <?php if(isset($barang)){?>
    function additem(){
        
        var html='';
        html+='<tr>';
        html+='<td><input type="hidden" class="idpersediaan" name="products['+i+'][id_persediaan]"/><select type="text" data-dropup-auto="false" data-size="5" class="form-control select2bs4" data-live-search="true" data-title="pilih item" name="products['+i+'][nama]" required><option value="">Pilih Barang / Item</option><?php foreach ($barang as $key => $item) { ?><option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>"><?php echo $item['nama_item'] ?></option><?php } ?></select></td>';
         html += '<td><span class="warna"></span></td>';
        html += '<td><input type="number" value="0" class="form-control ukuran" step=0.01 name="products['+i+'][ukuran]" onblur="updatetotal('+i+')"></td>';
        html += '<td><input type="text" class="form-control satuanukuran" name="products['+i+'][satuanukuran]"></td>';
        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="products['+i+'][jumlah]" onblur="updatetotal('+i+')"></td>';
        html += '<td><input type="text" class="form-control satuanJml" name="products['+i+'][satuanJml]"></td>';
        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" onblur="updatetotal('+i+')" required></td>';
        html+='<td><span class="total-'+i+'"></span></td>'
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $('#item-list').append(html);
        i++;
        //$('.select2bs4').select2();
        $(".select2bs4").selectpicker('refresh');
        $(document).on('change', '.select2bs4', function(e){
            var dataItem = $(this).find(':selected').data('item');
            var dai = $(this).closest('tr');
            var jumlahItem = $('#piecesPo').val();
            $.get( "<?php echo BASEURL.'gudang/itemkeluarSearchId' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                dai.find(".warna").html(obj.warna_item);
                dai.find(".ukuran").html(obj.ukuran_item);
                //dai.find(".satuanUkran").html(obj.satuan_ukuran_item);
                dai.find(".satuanukuran").val(obj.satuan_ukuran_item);
                dai.find(".jumlah").val(obj.jumlah_item);
                dai.find(".satuanJml").val(obj.satuan_jumlah_item);
                dai.find(".id").val(obj.id_persediaan);
                dai.find(".harga").val(obj.harga_item);
                dai.find(".idpersediaan").val(obj.id_persediaan);
            });
        });
    }

  <?php } ?>

    function updatetotal(k){
        var jenis=$("#jenis").val();
        console.log(jenis);
        total=0;
        grand=0;
            if(i > 0){
                j=0;
                while(j < i){
                    ukuran=$("input[name='products["+k+"][ukuran]']").val();
                    jumlah=$("input[name='products["+k+"][jumlah]']").val();
                    harga=$("input[name='products["+k+"][harga]']").val();
                    if(jenis==1){
                        total =(Number(ukuran)*Number(harga));
                    }else{
                        total =(Number(jumlah)*Number(harga));
                    }
                    $(".total-"+k).html(total.toLocaleString("fi-FI"));
                    j++;
                }
            }        
    }

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>                        