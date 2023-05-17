<style type="text/css">

    .table tr,.table td, .table tr th {

       // border: 1px solid black;

    }

    

</style>

<!-- Start Page content -->

<div class="content">

    <div class="container-fluid">



        <div class="row">

            <div class="col-md-12">

                <div class="card-box">

                    <div class="clearfix">

                        <div class="text-center">

                            <h4 class="m-0">FORM PENGAJUAN HARIAN <?php if ($parent['kategori'] == 1) {

                                   echo "SABLON";

                                } else if($parent['kategori'] == 2) { echo "BORDIR"; } else if($parent['kategori'] == 3) {echo "KONVEKSI";}?> FORBOYS</h4>

                        </div>

                    </div>


                    <?php if($parent['status']==0){?>
                         <div class="alert alert-danger alert-dismissible">
                            <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                            <h4><i class="icon fa fa-ban"></i> Warning!</h4>
                                Pengajuan ini belum disetujui
                        </div>
                       <!--  <div class="alert alert-danger">
                            <h1>Pengajuan ini belum disetujui</h1>
                        </div> -->
                    <?php } ?>

                    <form method="post" action="<?php echo $edit?>">
                        <input type="hidden" name="id" value="<?php echo $parent['id']?>">
                        <?php if(isset($editacc)){?>
                        <input type="hidden" name="editacc" value="<?php echo $parent['id']?>">
                        <?php } ?>
                    <div class="row">

                        <div class="col-6">

                            <div class="pull-left mt-3">

                                <table class="table nosearch" width="200" border="2" cellpadding="5">

                                    <tr>

                                        <td><b>Hari</b></td>

                                        <td><b>TANGGAL</b></td>

                                    </tr>

                                    <tr>

                                        <td><b><?php $hari=date('l',strtotime($parent['tanggal'])); echo hari($hari); ?></b></td>

                                        <td><b><input type="text" name="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d',strtotime($parent['tanggal'])) ?>"></b></td>

                                    </tr>

                                </table>

                            </div>



                        </div><!-- end col -->

                        

                    </div>
                    
                    <!-- end row -->



                    <div class="row">

                        <div class="col-md-12">

                            <div class="table-responsive">

                                <table class="table mt-4" >

                                    <thead>

                                        <tr>

                                            <th>Hapus</th>
                                            <th>NO.</th>

                                            <th>NAMA AJUAN</th>

                                            <th width="100">JUMLAH </th>

                                            <th>SATUAN</th>

                                            <th width="135">HARGA SATUAN (Rp)</th>

                                            <!-- <th width="125">TOTAL</th> -->

                                            <th>TIPE PEMBAYARAN</th>

                                            <th>NAMA SUPPLIER</th>

                                            <th>KETERANGAN</th>

                                            <th>SPV</th>

                                            <th>
                                                <button type="button" name="add" class="btn btn-success btn-sm itemajaun" onclick="itemajaun()"><i class="fa fa-plus"></i></button>
                                            </th>
                                        </tr>

                                    </thead>

                                    <tbody id="itemajaun">

                                    <?php $i=0;$total = 0;$no=1;$totalCash=0;$totalTF=0; ?>

                                    <?php foreach ($item as $key => $tem): ?>

                                        <tr>

                                            <td>
                                                <select name="products[<?php echo $i?>][hapus]">
                                                    <option value="0">Tidak</option>
                                                    <option value="1">Ya</option>
                                                </select>
                                            </td>

                                            <td><?php echo $no++; ?></td>

                                            <td>
                                                <input type="text" name="products[<?php echo $i?>][nama_item]" value="<?php echo $tem['nama_item'] ?>" class="form-control">
                                            </td>
                                            <input type="hidden" name="products[<?php echo $i?>][id]" value="<?php echo $tem['id'] ?>" class="form-control">
                                            <td><input type="text" name="products[<?php echo $i?>][jumlah]" value="<?php echo $tem['jumlah'] ?>" class="form-control"></td>

                                            <td><input type="text" name="products[<?php echo $i?>][satuan]" value="<?php echo $tem['satuan'] ?>" class="form-control"></td>

                                            <td width="135"><input type="text" name="products[<?php echo $i?>][harga]" class="form-control" value="<?php echo $tem['harga'] ?>"></td>

                                            <?php if ($tem['pembayaran'] == 2){ 

                                                $totalTF+=$tem['jumlah'] * $tem['harga'];

                                            } else { 

                                                $totalCash+=$tem['jumlah'] * $tem['harga'];

                                            } ?>

                                            <!-- <td width="125"><?php //echo number_format($tem['jumlah'] * $tem['harga']) ;?></td> -->

                                            <td>
                                                <select name="products[<?php echo $i?>][pembayaran]" class="form-control pembayaran" required>
                                                    <option value="">Pilih</option>
                                                    <option value="1" <?php echo $tem['pembayaran']==1?'selected':'';?>>Cash</option>
                                                    <option value="2" <?php echo $tem['pembayaran']==2?'selected':'';?>>Transfer</option>
                                                </select>
                                            </td>

                                            <td><input type="text" name="products[<?php echo $i?>][supplier]" class="form-control" value="<?php echo $tem['supplier']; ?>"></td>

                                            <td>
                                                <textarea name="products[<?php echo $i?>][keterangan]" class="form-control"><?php echo $tem['keterangan']; ?></textarea>
                                                <!-- <input type="text" name="products[<?php echo $i?>][keterangan]" class="form-control" value="<?php echo $tem['keterangan']; ?>"></td> -->
                                            <td><?php echo $tem['komentar']; ?></td>

                                        </tr>
                                        <?php $i++?>
                                    <?php endforeach ?>
                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>
                </form>
                    <div class="row">

                        <div class="col-6">

                            <div class="float-left">

                                <table width="200" class="text-center" border="2">

                                    <tr>

                                        <td>CASH</td>

                                        <td>Rp <?php echo number_format($totalCash) ?></td>

                                    </tr>

                                    <tr>

                                        <td>TRANSFER</td>

                                        <td>Rp <?php echo number_format($totalTF) ?></td>

                                    </tr>

                                </table>

                            </div>

                            <div class="clearfix"></div>

                        </div>
                        <br>
                        <div class="col-6">

                            <div class="clearfix pt-5">

                                <div class="float-right">

                                    <table width="400" border="2" class="text-center">

                                        <tr>

                                            <th>Menyetujui</th>

                                            <th>Di Buat oleh:</th>

                                        </tr>

                                        <tr>

                                            <td><b>SPV</b></td>

                                            <td><b>ADM Gudang</b></td>

                                        </tr>

                                        <tr>

                                            <td>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( Muchlas)

                                            </td>

                                            <td>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                <br>

                                                ( <?php echo strtoupper($adminkeu)?> )

                                            </td>

                                        </tr>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="hidden-print mt-4 mb-4 no-print">

                        <div class="text-right">
                            <?php if($parent['status']==0 OR $parent['status']==3){?>
                            <button onclick="save()" class="btn btn-info waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Simpan</button>
                            <?php }?>

                            <?php if(isset($editacc)){?>
                                <button onclick="save()" class="btn btn-info waves-effect waves-light"><i class="fa fa-print m-r-5"></i> Simpan</button>
                            <?php } ?>
                            <a href="<?php echo BASEURL.'Gudang/pengajuan';?>" class="btn btn-danger waves-effect waves-light">Kembali</a>

                        </div>

                    </div>

                </div>



            </div>



        </div>

        <!-- end row -->



    </div> <!-- container -->



</div> <!-- content -->

<script type="text/javascript">
    function save(){
        var pembayaran=$(".pembayaran").val();
        if(pembayaran==''){
            alert("Pembayaran harus diisi");
            return false
        }

        $("form").submit();
    }

    var i='<?php echo count($item)?>';
    function itemajaun(){
        
        var html='';
        html+='<tr>';
        html+='<td></td>';
        html+='<td><input type="hidden" value="0" class="form-control" name="products['+i+'][hapus]" required></td>';
        //html+='<td></td>';
        html+='<td><select type="text" data-dropup-auto="false" data-size="5" class="form-control brg" data-live-search="true" data-title="pilih item" name="products['+i+'][nama_item]" required><option value="">Pilih Barang / Item</option><?php foreach ($products as $key => $item) { ?><option value="<?php echo $item['nama'] ?>" data-item="<?php echo $item['product_id'] ?>"><?php echo $item['nama'] ?></option><?php } ?></select></td>';
        html += '<td><input type="number" class="form-control jumlah" step=0.01 name="products['+i+'][jumlah]" onblur="updatetotal('+i+')" required></td>';
        html += '<td><input type="text" value="-" class="form-control" name="products['+i+'][satuan]"></td>';
        html += '<td><input type="number" class="form-control harga" name="products['+i+'][harga]" onblur="updatetotal('+i+')" value="0"></td>';        
        html += '<td><select name="products['+i+'][pembayaran]" class="form-control" required><option value="-"></option><option value="1">Cash</option><option value="2">Transfer</option></select></td>';
        html += '<td><input type="text" value="-" class="form-control" name="products['+i+'][supplier]"></td>';
        html+='<td><input type="text" value="-" class="form-control" name="products['+i+'][keterangan]"></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $('#itemajaun').after(html);
        i++;
        //$(".brg").selectpicker('refresh');
        $(".brg").select2();
        $(document).on('change', '.brg', function(e){
            var dataItem = $(this).find(':selected').data('item');
            var dai = $(this).closest('tr');
            var jumlahItem = $('#piecesPo').val();
            $.get( "<?php echo BASEURL.'gudang/cariproduct' ?>", { id: dataItem } )
              .done(function( data ) {
                var obj = JSON.parse(data);
                console.log(obj);
                dai.find(".harga").val(obj.price);
            });
        });
    }

</script>