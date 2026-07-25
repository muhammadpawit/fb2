<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Terima</label>
                        <input type="text" autocomplete="off" id="tanggal" name="tanggal" class="form-control datepicker" required>
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
                            <option value="1">Bahan</option>
                            <option value="2">Alat-alat Bordir</option>
                            <option value="3">Alat-alat Konveksi</option>
                            <option value="4">Sablon</option>
                            <option value="5">Penyesuaian Stok Awal</option>
                            <option value="6">Penyesuaian Stok</option>
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
                                    <option value="<?php echo $s['id']?>"><?php echo $s['nama']?></option>
                                <?php } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nota Penerimaan / Nota Surat</label>
                        <input type="text" id="nosj" name="nosj" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipe Pembayaran</label>
                        <select name="tipepembayaran" id="tipepembayaran" class="form-control select2bs4" data-live-search="true"  required="required">
                            <option value="">Pilih</option>
                            <option value="Cash">Cash</option>
                            <option value="Transfer">Transfer</option>
                            <option value="Tempo">Tempo</option>
                            <!-- <option value="4">Sablon</option>
                            <option value="5">Penyesuaian Stok Awal</option>
                            <option value="6">Penyesuaian Stok</option> -->
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Upload Foto Surat Jalan / Dokumen Pendukung Lainnya</label>
                        <input type="file" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png">
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label></label>
                    </div>
                </div> -->
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
                        <?php $i=0?>
                        <tbody id="item-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            </form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                     <a onclick="simpan()" class="btn btn-primary full">Simpan</a>
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

        if($('.idpengajuandetail').length < 1){
            alert("Item penerimaan harus dipilih");
            return false;
        }

        var selectedAjuan = {};
        var hasDuplicate = false;
        $('.idpengajuandetail').each(function(){
            var value = $(this).val();
            if(value == ''){
                alert("Item penerimaan harus dipilih");
                hasDuplicate = true;
                return false;
            }
            if(selectedAjuan[value]){
                alert("Item pengajuan yang sama tidak boleh dipilih lebih dari satu kali");
                hasDuplicate = true;
                return false;
            }
            selectedAjuan[value] = true;
        });
        if(hasDuplicate){
            return false;
        }
        $("form").submit();
    }
    var i=0;
    var ajuanItems = [];

    function escapeHtml(value) {
        return String(value == null ? '' : value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function loadAjuanItems() {
        var supplier = $("#supplier").val();
        ajuanItems = [];
        $('#item-list').html('');

        if (supplier == '') {
            return;
        }

        $.get("<?php echo BASEURL.'gudang/get_pengajuan_harian_penerimaan' ?>", { supplier: supplier })
            .done(function(data) {
                ajuanItems = JSON.parse(data || '[]');
                if (ajuanItems.length < 1) {
                    $('#item-list').html('<tr><td colspan="10" class="text-center">Tidak ada item pengajuan harian yang belum diterima untuk supplier ini</td></tr>');
                }
            });
    }

    $("#supplier").on("change", function() {
        loadAjuanItems();
    });

    function buildAjuanOptions() {
        var options = '<option value="">Pilih Barang / Item</option>';
        $.each(ajuanItems, function(index, item) {
            var tanggal = item.tanggal ? item.tanggal : '-';
            var label = tanggal+' - '+item.nama_item+' ('+item.jumlah+' '+item.satuan+')';
            options += '<option value="'+escapeHtml(item.nama_item)+'" data-index="'+index+'">'+escapeHtml(label)+'</option>';
        });
        return options;
    }

    <?php if(isset($barang)){?>
    function additem(){
        if ($("#supplier").val() == '') {
            alert('Nama supplier harus dipilih');
            return false;
        }

        if (ajuanItems.length < 1) {
            alert('Tidak ada item pengajuan harian yang belum diterima untuk supplier ini');
            return false;
        }
        
        var html='';
        html+='<tr>';
        html+='<td><input type="hidden" class="idpersediaan" name="products['+i+'][id_persediaan]"/><input type="hidden" class="idpengajuandetail" name="products['+i+'][id_pengajuan_detail]"/><select type="text" data-dropup-auto="false" data-size="5" class="form-control select2bs4 ajuan-item" data-live-search="true" data-title="pilih item" name="products['+i+'][nama]" required>'+buildAjuanOptions()+'</select></td>';
         html += '<td><span class="warna"></span></td>';
        html += '<td><input type="number" value="0" class="form-control ukuran" step=0.01 name="products['+i+'][ukuran]" onblur="updatetotal('+i+')"></td>';
        html += '<td><input type="text" class="form-control satuanukuran" name="products['+i+'][satuanukuran]"></td>';
        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="products['+i+'][jumlah]" onblur="updatetotal('+i+')"></td>';
        html += '<td><input type="text" class="form-control satuanJml" name="products['+i+'][satuanJml]"></td>';
        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" onblur="updatetotal('+i+')" required></td>';
        html+='<td><span class="total-'+i+'"></span></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]" onblur="updatetotal('+i+')" required></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $('#item-list').append(html);
        i++;
        $('.select2bs4').select2();
        //$(".select2bs4").selectpicker('refresh');
    }

    $(document).on('change', '.ajuan-item', function(e){
        var selectedIndex = $(this).find(':selected').data('index');
        var obj = ajuanItems[selectedIndex];
        var dai = $(this).closest('tr');

        if (!obj) {
            return;
        }

        dai.find(".warna").html(obj.warna_item || '-');
        dai.find(".ukuran").val(obj.jumlah);
        dai.find(".satuanukuran").val(obj.satuan);
        dai.find(".jumlah").val(obj.jumlah);
        dai.find(".satuanJml").val(obj.satuan);
        dai.find(".harga").val(obj.harga);
        dai.find(".idpersediaan").val(obj.id_persediaan || '');
        dai.find(".idpengajuandetail").val(obj.id);
        dai.find('input[name$="[keterangan]"]').val(obj.keterangan || '-');
        var rowIndex = ($(this).attr('name').match(/products\[(\d+)\]/) || [])[1];
        updatetotal(rowIndex);
    });

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
