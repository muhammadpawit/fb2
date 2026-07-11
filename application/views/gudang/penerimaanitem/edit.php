<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $results['id'] ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Terima</label>
                        <input type="text" autocomplete="off" id="tanggal" name="tanggal" value="<?php echo $results['tanggal'] ?>" class="form-control datepicker" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Hari Ini</label>
                        <span class="form-control"><?php echo hari(date('l')).' , '.date('d F Y')?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Penerimaan</label>
                        <select name="jenis" id="jenis" class="form-control select2bs4" data-live-search="true"  required="required">
                            <option value="">Pilih</option>
                            <option value="1" <?php echo $results['jenis']==1 ? 'selected' : '' ?>>Bahan</option>
                            <option value="2" <?php echo $results['jenis']==2 ? 'selected' : '' ?>>Alat-alat Bordir</option>
                            <option value="3" <?php echo $results['jenis']==3 ? 'selected' : '' ?>>Alat-alat Konveksi</option>
                            <option value="4" <?php echo $results['jenis']==4 ? 'selected' : '' ?>>Sablon</option>
                            <option value="5" <?php echo $results['jenis']==5 ? 'selected' : '' ?>>Penyesuaian Stok Awal</option>
                            <option value="6" <?php echo $results['jenis']==6 ? 'selected' : '' ?>>Penyesuaian Stok</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                         <label>Nama Supplier</label>
                        <select name="supplier" id="supplier" class="form-control select2bs4" data-live-search="true" required>
                            <option value=""></option>
                            <?php if($supplier){ ?>
                                <?php foreach($supplier as $s){ ?>
                                    <option value="<?php echo $s['id']?>" <?php echo $results['supplier']==$s['id'] ? 'selected' : '' ?>><?php echo $s['nama']?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" value="<?php echo $results['keterangan'] ?>" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nota Penerimaan / Nota Surat</label>
                        <input type="text" id="nosj" name="nosj" value="<?php echo $results['nosj'] ?>" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipe Pembayaran</label>
                        <select name="tipepembayaran" id="tipepembayaran" class="form-control select2bs4" data-live-search="true"  required="required">
                            <option value="">Pilih</option>
                            <option value="Cash" <?php echo $results['tipepembayaran']=='Cash' ? 'selected' : '' ?>>Cash</option>
                            <option value="Transfer" <?php echo $results['tipepembayaran']=='Transfer' ? 'selected' : '' ?>>Transfer</option>
                            <option value="Tempo" <?php echo $results['tipepembayaran']=='Tempo' ? 'selected' : '' ?>>Tempo</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Upload Foto Surat Jalan / Dokumen Pendukung Lainnya</label>
                        <input type="file" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
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
                                <th>Keterangan</th>
                                <th><a onclick="additem()" class="btn btn-success text-white"><i class="fa fa-plus"></i></a></th>
                            </tr>
                        </thead>
                        <tbody id="item-list">
                            <?php $i=0; ?>
                            <?php foreach($products as $p) { ?>
                            <tr>
                                <td>
                                    <input type="hidden" class="idpersediaan" name="products[<?php echo $i; ?>][id_persediaan]" value="<?php echo $p['id_persediaan']; ?>"/>
                                    <select type="text" data-dropup-auto="false" data-size="5" class="form-control select2bs4" data-live-search="true" data-title="pilih item" name="products[<?php echo $i; ?>][nama]" required>
                                        <option value="">Pilih Barang / Item</option>
                                        <?php foreach ($barang as $key => $item) { ?>
                                            <option value="<?php echo $item['nama_item'] ?>" data-item="<?php echo $item['id_persediaan'] ?>" <?php echo $p['id_persediaan']==$item['id_persediaan'] ? 'selected' : '' ?>><?php echo $item['nama_item'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td><span class="warna"></span></td>
                                <td><input type="number" class="form-control ukuran" step=0.01 name="products[<?php echo $i; ?>][ukuran]" value="<?php echo $p['ukuran']; ?>" onblur="updatetotal(<?php echo $i; ?>)"></td>
                                <td><input type="text" class="form-control satuanukuran" name="products[<?php echo $i; ?>][satuanukuran]" value="<?php echo $p['satuanukuran']; ?>"></td>
                                <td><input type="number" class="form-control jumlah" step=0.01 name="products[<?php echo $i; ?>][jumlah]" value="<?php echo $p['jumlah']; ?>" onblur="updatetotal(<?php echo $i; ?>)"></td>
                                <td><input type="text" class="form-control satuanJml" name="products[<?php echo $i; ?>][satuanJml]" value="<?php echo $p['satuanJml']; ?>"></td>
                                <td><input type="number" class="form-control harga" name="products[<?php echo $i; ?>][harga]" value="<?php echo $p['harga']; ?>" readonly></td>
                                <td><span class="total-<?php echo $i; ?>"></span></td>
                                <td><input type="text" class="form-control" name="products[<?php echo $i; ?>][keterangan]" value="<?php echo $p['keterangan']; ?>" onblur="updatetotal(<?php echo $i; ?>)" required></td>
                                <td><i class="fa fa-trash remove"></i></td>
                            </tr>
                            <script>
                                setTimeout(function(){
                                    updatetotal(<?php echo $i; ?>);
                                }, 500);
                            </script>
                            <?php $i++; } ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                     <a onclick="simpan()" class="btn btn-primary full">Simpan Perubahan</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <a href="<?php echo BASEURL.'gudang/penerimaanitem'?>" class="btn btn-danger full">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    
    var i = <?php echo $i; ?>;
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
        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" readonly></td>';
        html+='<td><span class="total-'+i+'"></span></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]" onblur="updatetotal('+i+')" required></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $('#item-list').append(html);
        i++;
        $('.select2bs4').select2();
        
        $(document).on('change', '.select2bs4', function(e){
            var dataItem = $(this).find(':selected').data('item');
            var dai = $(this).closest('tr');
            $.get( "<?php echo BASEURL.'gudang/itemSearchPenerimaan' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                dai.find(".warna").html(obj.warna_item);
                dai.find(".ukuran").html(obj.ukuran_item);
                dai.find(".satuanukuran").val(obj.satuan_ukuran_item);
                dai.find(".jumlah").val(0);
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
        total=0;
        if(i > 0){
            var target_ukuran = $("input[name='products["+k+"][ukuran]']").val();
            var target_jumlah = $("input[name='products["+k+"][jumlah]']").val();
            var target_harga = $("input[name='products["+k+"][harga]']").val();
            if(jenis==1){
                total =(Number(target_ukuran)*Number(target_harga));
            }else{
                total =(Number(target_jumlah)*Number(target_harga));
            }
            $(".total-"+k).html(total.toLocaleString("fi-FI"));
        }        
    }

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>
