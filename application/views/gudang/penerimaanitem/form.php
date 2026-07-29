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
                                <th class="text-center" width="50"><input type="checkbox" id="checkAll" checked></th>
                                <th>Nama Barang</th>
                                <th>Warna</th>
                                <th>Quantity.Satuan</th>
                                <th>Satuan</th>
                                <th>Jumlah Qty</th>
                                <th>Satuan</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Karyawan Validasi</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php $i=0?>
                        <tbody id="item-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <input type="hidden" name="redirect_url" value="<?php echo isset($redirect_url) ? $redirect_url : '' ?>">
            </form>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                     <a onclick="simpan()" class="btn btn-primary full">Simpan</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <a href="<?php echo isset($batal_url) ? $batal_url : BASEURL.'gudang/penerimaanitem' ?>" class="btn btn-danger full">Batal</a>
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

        var tipepembayaran=$("#tipepembayaran").val();
        if(tipepembayaran==''){
            alert("Tipe Pembayaran wajib diisi");
            return false;
        }

        if($('.idpengajuandetail:not(:disabled)').length < 1){
            alert("Item penerimaan harus dipilih minimal satu (centang barang)");
            return false;
        }

        var selectedAjuan = {};
        var hasDuplicate = false;
        $('.idpengajuandetail:not(:disabled)').each(function(){
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

        var validKaryawan = true;
        $('.karyawan-select:not(:disabled)').each(function(){
            if($(this).val() == ''){
                validKaryawan = false;
                return false;
            }
        });

        if(!validKaryawan){
            alert("Karyawan validasi pada list barang wajib dipilih!");
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
        i = 0;

        if (supplier == '') {
            return;
        }

        $.get("<?php echo BASEURL.'gudang/get_pengajuan_harian_penerimaan' ?>", { supplier: supplier })
            .done(function(data) {
                ajuanItems = JSON.parse(data || '[]');
                if (ajuanItems.length < 1) {
                    $('#item-list').html('<tr><td colspan="10" class="text-center">Tidak ada item pengajuan harian yang belum diterima untuk supplier ini</td></tr>');
                } else {
                    $.each(ajuanItems, function(index, obj) {
                        var html='';
                        html+='<tr>';
                        html+='<td class="text-center"><input type="checkbox" class="cek-terima" checked></td>';
                        html+='<td><input type="hidden" class="idpersediaan" name="products['+i+'][id_persediaan]" value="'+(obj.id_persediaan || '')+'"/><input type="hidden" class="idpengajuandetail" name="products['+i+'][id_pengajuan_detail]" value="'+obj.id+'"/><input type="text" class="form-control" name="products['+i+'][nama]" value="'+escapeHtml(obj.nama_item)+'" readonly></td>';
                        html += '<td><span class="warna">'+escapeHtml(obj.warna_item || '-')+'</span></td>';
                        html += '<td><input type="number" value="'+(obj.jumlah || 0)+'" class="form-control ukuran" step=0.01 name="products['+i+'][ukuran]" onblur="updatetotal('+i+')"></td>';
                        html += '<td><input type="text" class="form-control satuanukuran" name="products['+i+'][satuanukuran]" value="'+escapeHtml(obj.satuan || '')+'"></td>';
                        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="products['+i+'][jumlah]" value="'+(obj.jumlah || 0)+'" onblur="updatetotal('+i+')"></td>';
                        html += '<td><input type="text" class="form-control satuanJml" name="products['+i+'][satuanJml]" value="'+escapeHtml(obj.satuan || '')+'"></td>';
                        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" value="'+(obj.harga || 0)+'" onblur="updatetotal('+i+')" required></td>';
                        html+='<td><span class="total-'+i+'"></span></td>';
                        html += '<td><select class="form-control select2bs4 karyawan-select" name="products['+i+'][id_karaywan]" style="width:100%; min-width:150px" required>' + karyawanOptions + '</select><input type="hidden" class="nama-karyawan" name="products['+i+'][nama_karyawan]"></td>';
                        html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]" value="'+escapeHtml(obj.keterangan || '-')+'" onblur="updatetotal('+i+')" required></td>';
                        html+='<td><i class="fa fa-trash remove"></i></td>';
                        html+='</tr>';
                        
                        $('#item-list').append(html);
                        $('.karyawan-select').last().select2();
                        updatetotal(i);
                        
                        if (obj.pembayaran == 1) {
                            $("#tipepembayaran").val("Cash").trigger("change");
                        } else if (obj.pembayaran == 2) {
                            $("#tipepembayaran").val("Transfer").trigger("change");
                        }
                        
                        i++;
                    });
                }
            });
    }

    $("#supplier").on("change", function() {
        loadAjuanItems();
    });

    var karyawanOptions = '<option value="">Pilih Karyawan</option>';
    <?php if(isset($karyawan)) { ?>
        <?php foreach($karyawan as $k){ ?>
            karyawanOptions += '<option value="<?php echo $k['id'] ?>" data-nama="<?php echo htmlspecialchars($k['nama']) ?>"><?php echo htmlspecialchars($k['nama']) ?></option>';
        <?php } ?>
    <?php } ?>

    $(document).on('change', '.karyawan-select', function() {
        var nama = $(this).find(':selected').data('nama');
        $(this).closest('td').find('.nama-karyawan').val(nama || '');
    });

    $(document).on('change', '#checkAll', function() {
        var isChecked = $(this).is(':checked');
        $('.cek-terima').prop('checked', isChecked).trigger('change');
    });

    $(document).on('change', '.cek-terima', function() {
        var tr = $(this).closest('tr');
        var isChecked = $(this).is(':checked');
        
        tr.find('input:not(.cek-terima), select').prop('disabled', !isChecked);
        
        var rowIndex = tr.find('.idpengajuandetail').attr('name').match(/products\[(\d+)\]/);
        if (rowIndex) {
            if (isChecked) {
                updatetotal(rowIndex[1]);
            } else {
                tr.find('.total-'+rowIndex[1]).text('0');
            }
        }
    });

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

    $(document).ready(function() {
        var preselectedSupplier = "<?php echo isset($_GET['supplier']) ? (int)$_GET['supplier'] : '' ?>";
        if(preselectedSupplier) {
            $('#supplier').val(preselectedSupplier).trigger('change');
        }
    });
</script>                        
