
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">    
                <label>Tanggal</label>
                <input type="text" name="tanggal" value="<?php echo date('Y-m-d')?>" class="form-control" required="required">
            </div>
        </div>
        <div class="col-md-4">
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
        <div class="col-md-4">
            <div class="form-group">
                <label>Pilih PO</label>
                <select name="kode_po" class="form-control select2bs4 autopo">
                </select>
                <input type="hidden" name="potongan_bangke" class="form-control" value="0">
                <input type="hidden" name="pengembalian_bangke" class="form-control" value="0">
                <input type="hidden" name="biaya_transport" class="form-control" value="0">
            </div>
        </div>
        <div class="col-md-2">
            <label>Aksi</label><br>
            <button class="btn btn-info btn-sm" onclick="tampilkan()">Tampilkan</button>
            <button class="btn btn-danger btn-sm" onclick="reset()">Reset</button>
        </div>
    </div>
<?php if(isset($_GET['kode_po'])){?>
<form method="post" action="<?php echo $action?>">
     <input type="hidden" value="<?php echo $_GET['tanggal'] ?>" name="tgl">
<div class="row">
    <div class="form-group">
        <table class="table table-bordered">
            <tr>
                <td colspan="3"><b>Nama PO : <?php echo strtoupper($kode_po) ?> <input type="hidden" value="<?php echo strtoupper($kode_po) ?>" name="kode_po"></b></td>
                <td colspan="3"><b>Nama CMT : <?php echo GetName_cmt($_GET['cmt'])?> <input type="hidden" name="id_cmt" value="<?php echo $_GET['cmt']?>"></b></td>
            </tr>
            <tr align="center">
                <td>Tanggal</td>
                <td>Jumlah (dz)</td>
                <td>Jumlah (pc)</td>
                <td>Harga (pc)</td>
                <td>Nilai PO</td>
                <td>Ket</td>
            </tr>
            <tr align="center">
                <?php if(isset($kirim)){?>
                    <tr align="center">
                        <td><?php echo $kirim['tanggal']?></td>
                        <td><?php echo ($kirim['pcs']/12)?></td>
                        <td><?php echo ($kirim['pcs'])?></td>
                        <td><?php echo ($kirim['cmt_job_price'])?></td>
                        <td><?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12))?></td>
                        <td>-</td>
                    </tr>
                    <input type="hidden" name="po[0][tanggal]" value="<?php echo $kirim['tanggal']?>">
                    <input type="hidden" name="po[0][dz]" value="<?php echo ($kirim['pcs']/12) ?>">
                    <input type="hidden" name="po[0][pcs]" value="<?php echo ($kirim['pcs']) ?>">
                    <input type="hidden" name="po[0][harga]" value="<?php echo ($kirim['cmt_job_price']) ?>">
                    <input type="hidden" name="po[0][nilaipo]" value="<?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12)) ?>">
                <?php } ?>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <label>Setoran PO CMT</label>
        <table class="table table-bordered">
            <tr>
                <th colspan="2"><center>Masuk</center></th>
                <th colspan="2"><center>Setoran</center></th>
            </tr>
            <tr align="center">
                <td>Tanggal</td>
                <td>Jumlah (Pc)</td>
                <td>Jumlah (Pc)</td>
                <td>Sisa</td>
                <td>Ket</td>
            </tr>
            <tr align="center">
                <td><input type="hidden" name="setor[0][tanggal]" value="<?php echo $kirim['tanggal']?>"><?php echo $kirim['tanggal']?></td>
                <td><input type="hidden" name="setor[0][setor_pcs]" value="0"><input type="hidden" name="setor[0][kirim_pcs]" value="<?php echo $kirim['pcs']?>"><?php echo $kirim['pcs']?></td>
                <td></td>
                <td><?php echo $kirim['pcs']?></td>
                <td>
                   
                </td>
            </tr>
            <?php $allsetor=0;$i=1;?>
            <?php foreach($setor as $s){?>
            <?php $allsetor+=($s['pcs']);?>
            <tr align="center">
                <td><input type="hidden" name="setor[<?php echo $i?>][tanggal]" value="<?php echo $s['tanggal']?>"><?php echo $s['tanggal']?></td>
                <td></td>
                <td><input type="hidden" name="setor[<?php echo $i ?>][kirim_pcs]" value="0"><input type="hidden" name="setor[<?php echo $i?>][setor_pcs]" value="<?php echo $s['pcs']?>"><?php echo $s['pcs']?></td>
                <td></td>
            </tr>
            <?php $i++;?>
            <?php } ?>
            <tr align="center">
                <td colspan="3"></td>
                <td><?php echo ($kirim['pcs']-$allsetor)?></td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <label>Pembayaran CMT</label>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><center>Tanggal</center></th>
                <th><center>Rincian Setor (pcs)</center></th>
                <th><center>Kredit</center></th>
                <th><center>Saldo</center></th>
                <th><center>Ket</center></th>
                <th><center><a onclick="tambahp()" class="btn btn-sm btn-info"><i class="fa fa-plus"></i></a></center></th>
            </tr>
            <tr align="center">
                <td><?php echo $kirim['tanggal']?></td>
                <td>Tagihan</td>
                <td></td>
                <td><input type="hidden" name="tagihan" value="<?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12))?>"><?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12))?></td>
                <td></td>
                <td></td>
            </tr>
            </thead>
            <tbody id="pmby">
                
            </tbody>
        </table>
    </div>
    <div class="form-group">
        <label>Pembelian Alat-alat</label>
        <table class="table table-bordered" id="alat">
            <thead>
                <tr>
                    <th><center>Nama Alat</center></th>
                    <th><center>Jumlah</center></th>
                    <th><center>Harga</center></th>
                    <th><center>Keterangan</center></th>
                    <th align="center">
                        <center><a onclick="tambahalat()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a></center>
                    </th>
                </tr>
            </thead>
            <?php $bangke=0;?>
            
            <tfoot></tfoot>
        </table>
    </div>
    <div class="col-md-12">
        <!-- <div class="form-group">
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
        </table> -->
        <!-- Potongan Bangke
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
        </table> -->
        <!-- Pengembalian Bangke
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
        </table> -->
        <!-- Potongan Alat-alat
        <table class="table table-bordered" id="alat">
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahalat()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $bangke=0;?>
            
            <tfoot></tfoot>
        </table> -->
        <!-- Potongan Mesin
        <table class="table table-bordered" id="mesin">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Potongan</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahmesin()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $mesin=0;?>
            
            <tfoot></tfoot>
        </table> -->

        <!-- Potongan Vermak
        <table class="table table-bordered" id="vermak">
            <thead>
                <tr>
                    <th>Rincian</th>
                    <th>Jumlah</th>
                    <th>Potongan</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahvermak()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $vermak=0;?>
            
            <tfoot></tfoot>
        </table> -->
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <a href="<?php echo BASEURL.'Pembayaran/cmtjahit_skb';?>" style="width: 100% !important" class="btn btn-danger text-white">Batalkan</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button class="btn btn-info" style="width: 100% !important">Simpan</button>
        </div>
    </div>
</div>
</form>
<?php } ?>
<script type="text/javascript">
    function reset(){
        url='?';
        location =url;
    }
    function tampilkan(){
        url='?';
        
        var filter_date_start = $('input[name=\'tanggal\']').val();

        if (filter_date_start) {
          url += '&tanggal=' + encodeURIComponent(filter_date_start);
        }

        var filter_date_end = $('select[name=\'cmt\']').val();

        if (filter_date_end) {
          url += '&cmt=' + encodeURIComponent(filter_date_end);
        }

        var filter_status = $('select[name=\'kode_po\']').val();

        if (filter_status != '*') {
          url += '&kode_po=' + encodeURIComponent(filter_status);
        }
        location =url;
      }
</script>
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
        html += '<td><input type="hidden" class="jumlahDz" name="products['+i+'][jumlah_po_dz]" required ><input type="hidden" class="jumlahPc" name="products['+i+'][jumlah_po_pcs]" required ><select type="text" class="select2 select2bs4 kodepo" name="products['+i+'][kode_po]" data-size="4" data-live-search="true" data-style="btn-success" data-title="Pilih item" required style="width: 150px !important;"><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html+='<td><input type="text" size="4" class="potongan" value="0" name="products['+i+'][potongan]" onblur="updatepcs('+i+')" readonly></td>';
        html+='<td><input type="text" size="4" class="kirimpcs" name="products['+i+'][kirimpcs]" onblur="updatepcs('+i+')" readonly ></td>';
        html+='<td><input type="hidden" class="dz" name="products['+i+'][dz]" onblur="updatedz('+i+')" readonly ><input type="text" size="4" class="jumlahDz" name="products['+i+'][jumlah_dz]" readonly ></td>';
        html+='<td><input type="text" size="4" class="jumlahPc pcs" name="products['+i+'][jumlah_pcs]" onblur="updatepcs('+i+')"  required ></td>';
        html+='<td><input type="text" size="5" class="harga" name="products['+i+'][harga]"></td>';
        html+='<td><input type="text" size="10" class="total" name="products['+i+'][total]" readonly></td>';
        html+='<td><select name="products['+i+'][percent]" class="pmb" required style="width: 50px;"><option value="">Wajib dipilih</option><option value="1">100%</option><option value="0.8">80%</option><option value="0.7">70%</option><option value="0.5">50%</option><option value="0.4">40%</option><option value="0.3">30%</option><option value="0.2">20%</option><option value="0.1">10%</option><option value="0">0%</option></select></td>';
        //html+='<td><input type="text" class="keterangan" name="products['+i+'][keterangan]" value="-" required ></td>';
        html+='<td><textarea class="keterangan" name="products['+i+'][keterangan]" cols="10" rows="5"></textarea></td>';
        html += '<td><span class="pot1"></span><select type="text" style="width:80px" class="select2 potpertama" data-id="'+i+'" name="products['+i+'][potpertama]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="0" selected>0</option></td>';
        html += '<td><select type="text" style="width: 50px;" class="select2" data-id="'+i+'" name="products['+i+'][trans]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="1" selected>Ya</option><option value="2">Tidak</option></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html+='</tr><tbody>';
        $("#tbls tfoot").before(html);
        //$('.select2bs4').selectpicker('refresh');
        i++;
        $('.select2bs4').select2();
        // $(".select2").select2({
        //     theme:"classic",
        // });
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
        //theme:"classic"
        }).on("select2:select",function(e){
            id=$(this).val();
            var s=id.split(",");
            var dai = $(this).closest('tr');
            var t=dai.find(".pot1").html(s[0]+' <br>('+s[2]+')');
            //coba=$(this).data('id');
            console.log(s);
        });
    }

    $(document).on('change', '.pmb', function(e){
        var dataItem = $(this).find(':selected').val();
        var dai = $(this).closest('tr');
        var pcs=dai.find(".pcs").val();
        //alert(pcs);
        var harga=dai.find(".harga").val();
        var t=dai.find(".total").val();
        var hasil=Number( ((pcs/12)*harga) * dataItem);
        dai.find(".keterangan").val("Pembayaran "+Number(dataItem*100)+" %");
        dai.find(".total").val(hasil);
        /**/
        
    });
    

        function ubahcmt() {
            info =window.location.origin;
            console.log(info);
           if(info=='http://localhost'){
            var uri=window.location.origin+'/fb2/Json/';
           }else{
            var uri=window.location.origin+'/Json/';
           }
            var cmts = $('select[name=\'cmt\']').val();
            //alert(cmts);
              $.get(uri+'checkpinjaman?&cmt='+cmts, 
                function(data){   
                  console.log(data);
                  if(data == '' ){
                    $('#potongan_lainnya').val(0);
                    $("input[name=pot_pinjaman][value=" + 2 + "]").prop('checked', true);
                  }else{
                    $('#potongan_lainnya').val(data);
                    $("input[name=pot_pinjaman][value=" + 1 + "]").prop('checked', true);
                  }
                  
              });
        }
    

    

    var j=0;
    function tambahp(){
        var html='<tr data-parent="0" id="product-row' + j + '" data="'+j+'">';
        //html += '<td><select type="text" class="form-control select2bs4 kodepo" name="pmby['+j+'][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html+='<td><input type="text" class="form-control datepicker" name="pmby['+j+'][tgl]" required></td>';
        html+='<td><input type="text" class="form-control rincian ipn-'+j+'" name="pmby['+j+'][rincian]" required></td>';
        html+='<td><input type="text" class="form-control kredit" onblur="saldo('+j+')" name="pmby['+j+'][kredit]" required readonly ></td>';
        html+='<td><input type="text" class="form-control saldo" name="pmby['+j+'][saldo]" value="0" readonly></td>';
        //html+='<td><input type="text" class="form-control" name="pmby['+j+'][keterangan]" value="-" required ></td>';
        html+='<td><select name="pmby['+i+'][percent]" class="pmb" required style="width: 50px;"><option value="">Wajib dipilih</option><option value="0.8">80%</option></select></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html+='</tr>';
        j++;
        $("#pmby").append(html);
        $(".datepicker").datepicker();
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();
    }

    $(document).on('change', '.pmb', function(e){
        var dataItem = $(this).find(':selected').val();
        var dai = $(this).closest('tr');
        var pcs=dai.find(".rincian").val();
        var harga=$("input[name='po[0][harga]']").val();
        var popcs=$("input[name='po[0][pcs]']").val();
        //alert(harga);
        if(pcs<popcs){
            var kredit=Number(harga)*Number(pcs)/12;
            var tagihan=Number(kredit)*dataItem;
        }else{
            kredit=0;
            var tagihan=Number(kredit)*dataItem;
            saldo(0);
        }
        
        dai.find(".kredit").val(kredit);
        dai.find(".saldo").val(tagihan);
        /**/
        
    });

    function saldo(index){
        //alert(index);
        var prev=index-1;
        var tagihan=$("input[name='tagihan']").val();
        var jumlah=$("input[name='pmby["+index+"][kredit]']").val();
        if(index==0){
            var sisa=Number(tagihan)-Number(jumlah);
            $("input[name='pmby["+index+"][saldo]']").val(sisa);
        }else{
            var saldo=$("input[name='pmby["+prev+"][saldo]']").val();
            var sisa=Number(saldo)-Number(jumlah);
            $("input[name='pmby["+index+"][saldo]']").val(sisa);
        }
        
        //alert(jumlah);
    }

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
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();
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
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();
        k++;
    }

    var l=0;
    function tambahalat(){
        var html='<tbody data-parent="0" id="product-row' + l + '" data="'+l+'"><tr>';
        html += '<td><input type="text" class="form-control" name="alat['+l+'][rincian]" required</td>';
        html +='<td><input type="text" class="form-control" name="alat['+l+'][qty]" required></td>';
        html +='<td><input type="text" class="form-control" name="alat['+l+'][harga]" required ></td>';
        html +='<td><input type="text" class="form-control" name="alat['+l+'][keterangan]" value="-" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html +='</tr><tbody>';
        l++;        
        $("#alat tfoot").before(html);
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();

    }

    var m=0;
    function tambahmesin(){
        var html='<tbody data-parent="0" id="product-row' + m + '" data="'+m+'"><tr>';
        html += '<td><input type="text" class="form-control" name="mesin['+m+'][rincian]" required</td>';
        html +='<td><input type="text" class="form-control" name="mesin['+m+'][qty]" required></td>';
        html +='<td><input type="text" class="form-control" name="mesin['+m+'][harga]" required ></td>';
        html +='<td><input type="text" class="form-control" name="mesin['+m+'][keterangan]" value="-" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html +='</tr><tbody>';
        $("#mesin tfoot").before(html);
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();
        m++;
    }

    var v=0;
    function tambahvermak(){
        var html='<tbody data-parent="0" id="product-row' + v + '" data="'+v+'"><tr>';
        html += '<td><input type="text" class="form-control" name="vermak['+v+'][rincian]" required</td>';
        html +='<td><input type="text" class="form-control" name="vermak['+v+'][qty]" required></td>';
        html +='<td><input type="text" class="form-control" name="vermak['+v+'][harga]" required ></td>';
        html +='<td><input type="text" class="form-control" name="vermak['+v+'][keterangan]" value="-" required ></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html +='</tr><tbody>';
        $("#vermak tfoot").before(html);
        //$('.select2bs4').selectpicker('refresh');
        $('.select2bs4').select2();
        v++;
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