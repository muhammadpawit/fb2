                <p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                </p>
<form method="post" action="<?php echo $action?>">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">    
            <label>Tanggal</label>
            <input type="text" name="tanggal" value="<?php echo date('Y-m-d')?>" class="form-control" required="required">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Cmt</label>
            <select name="cmt" id="cmt" class="form-control select2bs4 byrcmt" data-live-search="true" required="required">
                <option value="*">Pilih</option>
                <?php foreach($cmt as $c){?>
                    <option value="<?php echo $c['id_cmt']?>"><?php echo strtolower($c['cmt_name'])?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Metode Pengiriman</label>
            <select name="metode" class="form-control">
                <option value="1">Diambil</option>
                <option value="2">Dikirim oleh CMT</option>
            </select>
            <input type="hidden" name="potongan_bangke" class="form-control" value="0">
            <input type="hidden" name="pengembalian_bangke" class="form-control" value="0">
            <input type="hidden" name="biaya_transport" class="form-control" value="0">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Potongan Pinjaman / Potongan Claim</label>
            <input type="number" name="potongan_lainnya" class="form-control" value="0">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Trip Ke-</label>
            <select name="tripke" class="form-control" required>
                <option value="">Pilih</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Keterangan</label>
            <input type="hidden" name="totalbayar" id="totalbayar" class="form-control" value="0" readonly="readonly">
            <input type="text" name="keterangan" class="form-control" value="-">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Potongan Transport</label>
            <select name="pot_transport" id="sub1" class="form-control" data-live-search="true">
                <option value="0">Pilih</option>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <br>PO Yang Dikerjakan<br>
        </div>
        <table class="table table-bordered" id="tbls">
            <thead>
                <tr>
                    <th>Nama PO</th>
                    <th>Potong Pcs</th>
                    <th>Kirim Pcs</th>
                    <th>Setor Dz</th>
                    <th>Setor Pcs</th>
                    <th>Harga/dz</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Keterangan</th>
                    <th>Potongan Pemb.Pertama</th>
                    <th>Dikenakan transport</th>
                    <th align="right">
                        <a onclick="tambah()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $row=0;?>
            
            <tfoot></tfoot>
        </table>
        Potongan Bangke
        <table class="table table-bordered" id="bangke">
            <thead>
                <tr>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan / Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahbangke()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $bangke=0;?>
            
            <tfoot></tfoot>
        </table>
        Pengembalian Bangke
        <table class="table table-bordered" id="kbangke">
            <thead>
                <tr>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan / Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahkembalianbangke()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $bangke=0;?>
            
            <tfoot></tfoot>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <a href="<?php echo BASEURL.'Pembayaran/cmtjahit';?>" style="width: 100% !important" class="btn btn-danger text-white">Batalkan</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button class="btn btn-info" style="width: 100% !important">Simpan</button>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
    var i=<?php echo $row?>;
    var row='<?php echo $row?>';
    
    function tambah(){
        var cmts = $('select[name=\'cmt\']').val();
        if(cmts=="*"){
            alert("Mohon cmt dipilih terlebih dahulu");
            //$(this).closest('tr').remove();
            return false;
        }
        var html='<tbody data-parent="0" id="product-row' + i + '" data="'+i+'"><tr>';
        html += '<td><input type="hidden" class="jumlahDz" name="products['+i+'][jumlah_po_dz]" required ><input type="hidden" class="jumlahPc" name="products['+i+'][jumlah_po_pcs]" required ><select type="text" class="select2bs4 kodepo" name="products['+i+'][kode_po]" data-size="4" data-live-search="true" data-style="btn-success" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html+='<td><input type="text" class="potongan" value="0" name="products['+i+'][potongan]" onblur="updatepcs('+i+')" readonly></td>';
        html+='<td><input type="text" class="kirimpcs" name="products['+i+'][kirimpcs]" onblur="updatepcs('+i+')" readonly ></td>';
        html+='<td><input type="hidden" class="dz" name="products['+i+'][dz]" onblur="updatedz('+i+')" readonly ><input type="text" class="jumlahDz" name="products['+i+'][jumlah_dz]" readonly ></td>';
        html+='<td><input type="text" class="jumlahPc pcs" name="products['+i+'][jumlah_pcs]" onblur="updatepcs('+i+')"  required ></td>';
        html+='<td><input type="text" class="harga" name="products['+i+'][harga]"></td>';
        html+='<td><input type="text" class="total" name="products['+i+'][total]" readonly></td>';
        html+='<td><select name="products['+i+'][percent]" class="pmb" required><option value="">Wajib dipilih</option><option value="1">100%</option><option value="0.8">80%</option><option value="0.7">70%</option><option value="0.5">50%</option><option value="0">0%</option></select></td>';
        html+='<td><input type="text" class="keterangan" name="products['+i+'][keterangan]" value="-" required ></td>';
        html += '<td><select type="text" style="width:200px" class="select2 potpertama" data-id="'+i+'" name="products['+i+'][potpertama]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="0" selected>0</option></td>';
        html += '<td><select type="text" class="select2" data-id="'+i+'" name="products['+i+'][trans]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="1" selected>Ya</option><option value="2">Tidak</option></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html+='</tr><tbody>';
        $("#tbls tfoot").before(html);
        $('.select2bs4').selectpicker('refresh');
        i++;
        
        $(".select2").select2({
            theme:"classic",
        });
        $(".potpertama").select2({
          ajax: {
          url:"<?php echo BASEURL?>Pembayaran/caripembayaran",
            dataType: 'json',
          data: function (params) {
            return {
              po: params.term,
              cmt:cmts,
            };
          },
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          //cache: true
        },
        theme:"classic"
        }).on("select2:select",function(e){
            id=$(this).val();
            //coba=$(this).data('id');
            console.log(id);
        });
    }

    $(document).on('change', '.pmb', function(e){
        var dataItem = $(this).find(':selected').val();
        var dai = $(this).closest('tr');
        var pcs=dai.find(".kirimpcs").val();
        var harga=dai.find(".harga").val();
        var t=dai.find(".total").val();
        var hasil=Number( ((pcs/12)*harga) * dataItem);
        dai.find(".keterangan").val("Pembayaran "+Number(dataItem*100)+" %");
        dai.find(".total").val(hasil);
        /**/
        
    });

    

    var j=0;
    function tambahbangke(){
        var html='<tbody data-parent="0" id="product-row' + j + '" data="'+j+'"><tr>';
        html += '<td><select type="text" class="form-control select2bs4 kodepo" name="bangke['+j+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html+='<td><input type="text" class="form-control" name="bangke['+j+'][qty]" required></td>';
        html+='<td><input type="text" class="form-control" name="bangke['+j+'][harga]" required ></td>';
        html+='<td><input type="text" class="form-control" name="bangke['+j+'][keterangan]" value="-" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html+='</tr><tbody>';
        $("#bangke tfoot").before(html);
        $('.select2bs4').selectpicker('refresh');
        j++;
    }

    var k=0;
    function tambahkembalianbangke(){
        var html='<tbody data-parent="0" id="product-row' + k + '" data="'+k+'"><tr>';
        html += '<td><select type="text" class="form-control select2bs4 kodepo" name="kembalianbangke['+k+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html+='<td><input type="text" class="form-control" name="kembalianbangke['+k+'][qty]" required></td>';
        html+='<td><input type="text" class="form-control" name="kembalianbangke['+k+'][harga]" required ></td>';
        html+='<td><input type="text" class="form-control" name="kembalianbangke['+k+'][keterangan]" value="-" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html+='</tr><tbody>';
        $("#kbangke tfoot").before(html);
        $('.select2bs4').selectpicker('refresh');
        k++;
    }

    

    function update(){
        var h=0;
        $("#totalbayar").val(h);
        grandtotal=0;
        while(h < i){
            var total=$("input[name='products["+h+"][total]']").val();
            grandtotal+=Number(total);
            h++;
        }
        $("#totalbayar").val(grandtotal);
    }

    function updatedz(k){
        total=0;
        grand=0;
            if(i > 0){
                j=0;
                while(j < i){
                    jumlah=$("input[name='products["+k+"][jumlah_dz]']").val();
                    harga=$("input[name='products["+k+"][harga]']").val();
                    total =(Number(jumlah)*Number(harga));
                    $("input[name='products["+k+"][total]']").val(total);
                    $("input[name='products["+k+"][jumlah_pcs]']").val(Math.round(jumlah*12));
                    j++;
                }
            }
            update();     
    }

     function updatepcs(k){
        
        total=0;
        grand=0;
            if(i > 0){
                j=0;
                while(j < i){
                    pcs=$("input[name='products["+k+"][jumlah_pcs]']").val();
                    jumlah=$("input[name='products["+k+"][jumlah_dz]']").val();
                    $("input[name='products["+k+"][jumlah_dz]']").val((pcs/12).toFixed(2));
                    j++;
                }
            }
            //$("#totalbayar").val(grand);
            //update();     
    }

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });

    $(document).on('change', '.kodepo', function(e){
        var cmts = $('select[name=\'cmt\']').val();
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        var jumlahItem = $('#piecesPo').val();
        $.get( "<?php echo BASEURL.'finishing/setorcmtjahit' ?>", { kodepo: dataItem, cmt:cmts } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            if(obj!==null){
                var dz=Math.round(obj.qty_tot_pcs/12);
                var total=Number(obj.cmt_job_price*dz);
                // dai.find(".jumlahPc").val(obj.qty_tot_pcs);
                // dai.find(".jumlahDz").val(dz.toFixed(2));
                dai.find(".dz").val(obj.qty_tot_pcs/12);
                dai.find(".jumlahPc").val(0);
                dai.find(".jumlahDz").val(0);
                dai.find(".harga").val(obj.cmt_job_price);
                //dai.find(".total").val(total);
                dai.find(".total").val(0);
            }else{
                //alert("Kode Po belum disetor");
                //dai.remove();
            }
        });
        $.get( "<?php echo BASEURL.'Json/pmbpotong' ?>", { kodepo: dataItem } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            console.log(obj);
            if(obj!=null){
                dai.find(".potongan").val(obj.potongan);
            }else{
                dai.find(".potongan").val(0);
            }
        });

        $.get( "<?php echo BASEURL.'Json/pmbkirim' ?>", { kodepo: dataItem, cmt:cmts } )
          .done(function( data ) {
            var obj = JSON.parse(data);
            if(obj!==null){
                var total=Number(obj.kirimpcs/12)*Number(obj.harga);
                dai.find(".kirimpcs").val(obj.kirimpcs);
                dai.find(".total").val(total);
            }else{
                dai.find(".kirimpcs").val(0);
            }
        });
    });
</script>