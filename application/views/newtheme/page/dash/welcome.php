<?php if(!empty($reqharga)){?>
<div class="row">
    <div class="col-md-12">
       <div class="alert" style="background-color: #3D6AA2 !important;color: white">
           Request Perubahan Harga
       </div>
        <table class="table table-bordered nosearch">
            <?php foreach($reqharga as $req){?>
            <tr> 
                <td><?php echo $req['tgl']?></td>  
                <td><?php echo $req['oleh']?></td>  
                <td><?php echo $req['alesan']?></td>
                <td>
                    <?php if(callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){?>
                    <a href="<?php echo BASEURL?>Gudang/penerimaanitemdetail_ubahharga/<?php echo $req['id_penerimaan'] ?>" class="btn btn-success btn-xs text-white">Proses</a>
                    <?php }?>
                </td>    
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php } ?>

<?php if(!empty($request)){?>
<div class="row">
    <div class="col-md-12">
       <div class="alert" style="background-color: #3D6AA2 !important;color: white">
           Form Request Otorisasi User
       </div>
        <table class="table table-bordered nosearch">
            <?php foreach($request as $req){?>
            <tr>
                <td><?php echo $req['no']?></td>    
                <td><?php echo $req['tanggal']?></td>    
                <td><?php echo $req['nama']?></td>
                <td><?php echo $req['keterangan']?></td>
                <td>
                    <?php if(callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){?>
                    <a href="<?php echo $req['setujui']?>" class="btn btn-success btn-xs text-white">Proses</a>
                    <?php }?>
                </td>    
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php } ?>

<?php //if(!empty($request) & callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){?>
<div class="row">
    <div class="col-md-12">
       <div class="alert" style="background-color: #eb4034 !important;color: white">
           Warning ! Stok Gudang Menipis dan Habis
       </div>
        <table class="table table-bordered yessearch">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Stok Terkini (Pcs)</th>
                    <th>Order (Pcs)</th>
                    <th>Wajib Order Kembali (20%)</th>
                    <th>Satuan</th>
                </tr>
            </thead>
            <?php $no=1;?>
            <?php foreach($menipis as $req){?>
            <tr>
                <td><?php echo $no?></td>    
                <td><?php echo $req['nama']?></td>      
                <td><?php echo $req['quantity']?></td>
                <td><?php echo $req['minstok']?></td>
                <td></td>
                <td><?php echo $req['satuan']?></td> 
            </tr>
            <?php $no++;?>
            <?php } ?>
        </table>
    </div>
</div>