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
        Pending PO : <?php echo $popending?>
    </div>
    <div class="col-md-12">
       <div class="alert" style="background-color: #eb4034 !important;color: white;text-align:center !important;font-size:20px" class="text-center">
           Warning  Stok Barang !!!
       </div>
       <table class="table table-bordered table-hover yessearch">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Stok Terkini </th>
                    <th>Total Pengiriman PO </th>
                    <th>Rata-rata Dz</th>
                    <th>Total Pcs</th>
                    <th>Total Keseluruhan</th>
                    <th>Satuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <?php $no=1;?>
            <?php foreach($warning_atas as $req){?>
                <?php  $minimal_order=$req['keseluruhan']; //  ?>
            <?php //if($req['quantity'] < $minimal_order){ ?>
            <tr style="background-color:<?php echo ($req['quantity'] <= 5 ) ? 'red' : (($req['quantity'] < $minimal_order) ? '#e2ff85' : ''); ?>">
                <td><?php echo $no?></td>    
                <td><?php echo $req['nama']?></td>      
                <td><?php echo number_format($req['quantity'])?></td>
                <td><?php echo number_format($req['variabel_pengirimanpo'])?></td>
                <td><?php echo number_format($req['dz'])?></td>
                <td><?php echo number_format($req['pcs']) ?></td>
                <td><?php echo number_format($req['keseluruhan']) ?></td>
                <td><?php echo $req['satuan']?></td>
                <td>
                    <?php if($req['quantity'] < $minimal_order){ ?>
                        <span class="text-danger">Wajib Order</span>
                    <?php }else{ ?>
                        <?php if($req['quantity']==0){ ?>
                            <span>Stok Habis</span>
                        <?php }else{ ?>
                            <span>Stok Masih Mencukupi</span>
                        <?php } ?>
                    <?php } ?>
                </td> 
            </tr>
            <?php $no++;?>
            <?php } ?>
            <?php //} ?>
        </table>

        <table class="table table-bordered table-hover yessearch">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Stok Terkini </th>
                    <th>Order Terakhir </th>
                    <th>Wajib Order Kembali (20%)</th>
                    <th>Satuan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <?php $no=1;?>
            <?php foreach($menipis as $req){?>
                <?php  $minimal_order=($req['minstok']*0.2); //  ?>
            <?php //if($req['quantity'] < $minimal_order){ ?>
            <tr style="background-color:<?php echo ($req['quantity'] <= 5 ) ? 'red' : (($req['quantity'] < $minimal_order) ? '#e2ff85' : ''); ?>">
                <td><?php echo $no?></td>    
                <td><?php echo $req['nama']?></td>      
                <td><?php echo number_format($req['quantity'])?></td>
                <td><?php echo number_format($req['minstok'])?></td>
                <td><?php echo number_format($minimal_order) ?></td>
                <td><?php echo $req['satuan']?></td>
                <td>
                    <?php if($req['quantity'] < $minimal_order){ ?>
                        <span class="text-danger">Wajib Order</span>
                    <?php }else{ ?>
                        <?php if($req['quantity']==0){ ?>
                            <span>Stok Habis</span>
                        <?php }else{ ?>
                            <span>Stok Masih Mencukupi</span>
                        <?php } ?>
                    <?php } ?>
                </td> 
            </tr>
            <?php $no++;?>
            <?php } ?>
            <?php //} ?>
        </table>
    </div>
</div>