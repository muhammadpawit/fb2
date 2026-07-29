<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <form action="<?php echo $action ?>" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Pesan</label>
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
                        <label>Jenis Pesanan</label>
                        <select name="jenis" id="jenis" class="form-control select2bs4" data-live-search="true"  required="required">
                            <option value="">Pilih</option>
                            <option value="1">Bahan</option>
                            <option value="2">Alat-alat Bordir</option>
                            <option value="3">Alat-alat Konveksi</option>
                            <option value="4">Sablon</option>
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
                        <label>Nota Pesanan / PO</label>
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
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Upload Dokumen PO / Penawaran</label>
                        <input type="file" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-success btn-sm mb-2" onclick="addRow()">+ Tambah Item</button>
                    <div class="form-group">
                        <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
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
                        <tbody id="item-list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            </form>
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                     <a onclick="simpan()" class="btn btn-primary full text-white">Simpan</a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <a href="<?php echo BASEURL.'Pemesananbahan'?>" class="btn btn-danger full">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var i = 0;
    
    var barangOptions = '<option value="">Pilih Barang</option>';
    <?php if(isset($barang)) { ?>
        <?php foreach($barang as $b){ ?>
            barangOptions += '<option value="<?php echo $b['id_persediaan'] ?>" data-nama="<?php echo htmlspecialchars($b['nama_item']) ?>" data-harga="<?php echo isset($b['harga_item']) ? $b['harga_item'] : 0 ?>"><?php echo htmlspecialchars($b['nama_item']) ?></option>';
        <?php } ?>
    <?php } ?>

    var karyawanOptions = '<option value="">Pilih Karyawan</option>';
    <?php if(isset($karyawan)) { ?>
        <?php foreach($karyawan as $k){ ?>
            karyawanOptions += '<option value="<?php echo $k['id'] ?>" data-nama="<?php echo htmlspecialchars($k['nama']) ?>"><?php echo htmlspecialchars($k['nama']) ?></option>';
        <?php } ?>
    <?php } ?>

    function addRow() {
        var html = '';
        html += '<tr>';
        html += '<td><select class="form-control select2bs4 barang-select" name="products['+i+'][id_persediaan]" required>' + barangOptions + '</select><input type="hidden" class="nama-barang" name="products['+i+'][nama]"></td>';
        html += '<td><input type="number" value="0" class="form-control ukuran" step=0.01 name="products['+i+'][ukuran]" onblur="updatetotal('+i+')"></td>';
        html += '<td><input type="text" class="form-control satuanukuran" name="products['+i+'][satuanukuran]"></td>';
        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="products['+i+'][jumlah]" value="0" onblur="updatetotal('+i+')"></td>';
        html += '<td><input type="text" class="form-control satuanJml" name="products['+i+'][satuanJml]"></td>';
        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" value="0" onblur="updatetotal('+i+')" required></td>';
        html += '<td><span class="total-'+i+'">0</span></td>';
        html += '<td><select class="form-control select2bs4 karyawan-select" name="products['+i+'][id_karaywan]" required>' + karyawanOptions + '</select><input type="hidden" class="nama-karyawan" name="products['+i+'][nama_karyawan]"></td>';
        html += '<td><input type="text" class="form-control" name="products['+i+'][keterangan]"></td>';
        html += '<td><i class="fa fa-trash remove text-danger" style="cursor:pointer;"></i></td>';
        html += '</tr>';
        
        $('#item-list').append(html);
        var newRow = $('#item-list').children('tr').last();
        newRow.find('.select2bs4').select2({
            theme: 'bootstrap4'
        });
        i++;
    }

    $(document).on('change', '.barang-select', function() {
        var selected = $(this).find(':selected');
        var nama = selected.data('nama');
        var harga = selected.data('harga') || 0;
        
        var td = $(this).closest('td');
        td.find('.nama-barang').val(nama || '');
        
        var tr = $(this).closest('tr');
        var hargaInput = tr.find('.harga');
        if(hargaInput.val() == 0 || hargaInput.val() == ''){
            hargaInput.val(harga);
        }
        
        // Cari index row k
        var index = tr.index();
        updatetotal(index);
    });

    $(document).on('change', '.karyawan-select', function() {
        var nama = $(this).find(':selected').data('nama');
        $(this).closest('td').find('.nama-karyawan').val(nama || '');
    });

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

        if($('#item-list tr').length < 1){
            alert("Minimal harus ada satu item yang dipesan");
            return false;
        }

        var validBarang = true;
        $('.barang-select').each(function(){
            if($(this).val() == ''){
                validBarang = false;
                return false;
            }
        });

        if(!validBarang){
            alert("Nama barang wajib dipilih pada semua item!");
            return false;
        }

        $("form").submit();
    }

    function updatetotal(k){
        var jenis=$("#jenis").val();
        var ukuran=$("input[name='products["+k+"][ukuran]']").val();
        var jumlah=$("input[name='products["+k+"][jumlah]']").val();
        var harga=$("input[name='products["+k+"][harga]']").val();
        
        var total = 0;
        if(jenis==1){
            total =(Number(ukuran)*Number(harga));
        }else{
            total =(Number(jumlah)*Number(harga));
        }
        $(".total-"+k).html(total.toLocaleString("fi-FI"));
    }

    $(document).on('change', '#jenis', function(){
        for(var k=0; k<i; k++){
            updatetotal(k);
        }
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>
