<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card-box table-responsive">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="text" name="tanggal1" id="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Action</label><br>
                                <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
                                <button onclick="excel()" class="btn btn-info btn-sm">Excel</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card-tools">
                        
                    </div> -->
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kode Artikel</th>
                            <th>Nama PO</th>
                            <th>Kuantitas Kirim (pcs)</th>
                            <th>Kuantitas Kirim (dz)</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $total=0;$totaldz=0;?>
                            <?php foreach ($notarincian as $key => $sat): ?>
                            <tr>
                                <td><?php echo date('d-m-Y',strtotime($sat['tanggal_kirim'])); ?></td>
                                <td><?php echo strtoupper($sat['kode_artikel']) ?></td>
                                <td><?php echo strtoupper($sat['kodepo']) ?></td>
                                <td><?php echo $sat['jumlah_piece_diterima']?></td>
                                <td><?php echo ($sat['jumlah_piece_diterima']/12)?></td>
                                <td><?php echo number_format($sat['harga_satuan']) ?></td>
                                <td><?php echo number_format($sat['harga_satuan']*$sat['jumlah_piece_diterima']) ?></td>
                            </tr>
                            <?php $total+=($sat['jumlah_piece_diterima']);?>
                            <?php $totaldz+=($sat['jumlah_piece_diterima']/12);?>
                            <?php endforeach ?>
                        </tbody>
                        <tr>
                            <td colspan="3"><b>Total</b></td>
                            <td>
                                <b><?php echo number_format($total) ?></b>
                            </td>
                            <td>
                            <b><?php echo number_format($totaldz) ?></b>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div> <!-- end row -->

    </div>
</div>
<script type="text/javascript">
    function filter(){
        url ='?';
        var tanggal1=$("#tanggal1").val();
        var tanggal2=$("#tanggal2").val();

        if(tanggal1){
            url+='&tanggal1='+tanggal1;
        }

        if(tanggal2){
            url+='&tanggal2='+tanggal2;
        }

        location = url;
    }

     function excel(){
        url ='?&excel=1';
        var tanggal1=$("#tanggal1").val();
        var tanggal2=$("#tanggal2").val();

        if(tanggal1){
            url+='&tanggal1='+tanggal1;
        }

        if(tanggal2){
            url+='&tanggal2='+tanggal2;
        }

        location = url;
    }
</script>