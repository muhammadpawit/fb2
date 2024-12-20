                <p class="text-muted font-14 m-b-30">
                    <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                       <?php } ?>
                </p>
<div class="row">
    <div class="col-md-2">
        <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="text" name="tanggal1" id="tanggal1" class="form-control" value="<?php echo $tanggal1?>">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="text" name="tanggal2" id="tanggal2" class="form-control" value="<?php echo $tanggal2?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama Cmt</label><br>
            <select name="cmt" id="cmt" class="form-control select2bs4" data-live-search="true">
                <option value="*">Semua</option>
                <?php foreach($cmt as $c){?>
                    <option value="<?php echo $c['id_cmt']?>" <?php echo $cmtf==$c['id_cmt']?'selected':'';?>><?php echo strtolower($c['cmt_name'])?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Lokasi Cmt</label><br>
            <select name="lokasicmt" id="lokasicmt" class="form-control select2bs4">
                <option value="*">Semua</option>
                <option value="1" <?php echo $lokasi==1?'selected':'';?>>Serang</option>
                <option value="2" <?php echo $lokasi==2?'selected':'';?>>Jawa</option>
                <option value="3" <?php echo $lokasi==3?'selected':'';?>>Sukabumi</option>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <label>Action</label><br>
        <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
        <!-- <button class="btn btn-info btn-sm" onclick="excel()">Excel</button> -->
        <button class="btn btn-info btn-sm" onclick="tambah()">Tambah</button>
        <?php if(isset($lokasi)) {?>
            <?php if($lokasi==3){ ?>
                <button class="btn btn-info btn-sm" onclick="rekap()">Rekap Per PO</button>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="col-md-12">
            <table class="" border="1" style="border-collapse: collapse;width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama CMT</th>
                    <th>Kode PO</th>
                    <th>Total Tagihan</th>
                    <th>Pelunasan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($products)){?>
                    <?php foreach($products as $p){?>
                        <tr>
                            <td><?php echo $p['no']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo $p['nama']?></td>
                            <td><?php echo ($p['kode_po'])?></td>
                            <td><?php echo number_format($p['tagihan']-$p['potongan_alat'], 0, ".", ".");?></td>
                            <td>
                                <?php if(!empty($p['pelunasan']) || $p['ket'] == 'Pembayaran 100 %'){ ?>
                                    <span class="badge bg-green">Lunas</span>
                                <?php }else{ ?>
                                    <span class="badge bg-warning"><?php echo $p['ket'] ?></span>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="<?php echo $p['detail']?>" class="btn btn-success btn-xs text-white">Detail</a>
                                <?php if($menghapus==1){?>
                                    <a href="<?php echo $p['hapus']?>" onclick="return confirm('Apakah yakin ini akan dihapus ?') " class="btn btn-danger btn-xs text-white">Hapus</a>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php }else{ ?>
                <tr>
                    <td colspan="8">Data tidak ditemukan</td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    

    function filter(){
        var tanggal1=$("#tanggal1").val();
        var tanggal2=$("#tanggal2").val();
        var cmt=$("#cmt").val();
        var lokasicmt=$("#lokasicmt").val();
        var url='?';
        if(tanggal1){
            url+='&tanggal1='+tanggal1;
        }
        if(tanggal2){
            url+='&tanggal2='+tanggal2;
        }
        if(cmt!="*"){
            url+='&cmt='+cmt;
        }
        if(lokasicmt!="*"){
            url+='&lokasicmt='+lokasicmt;
        }
        location=url;
    }

    function excel(){
        var tanggal1=$("#tanggal1").val();
        var tanggal2=$("#tanggal2").val();
        var cmt=$("#cmt").val();
        var lokasicmt=$("#lokasicmt").val();
        var url='?&excel=1';
        if(tanggal1){
            url+='&tanggal1='+tanggal1;
        }
        if(tanggal2){
            url+='&tanggal2='+tanggal2;
        }
        if(cmt!="*"){
            url+='&cmt='+cmt;
        }
        if(lokasicmt!="*"){
            url+='&lokasicmt='+lokasicmt;
        }
        location=url;
    }

    function rekap(){
        var tanggal1=$("#tanggal1").val();
        var tanggal2=$("#tanggal2").val();
        var cmt=$("#cmt").val();
        var lokasicmt=$("#lokasicmt").val();
        var url='?&rekap=1';
        if(tanggal1){
            url+='&tanggal1='+tanggal1;
        }
        if(tanggal2){
            url+='&tanggal2='+tanggal2;
        }
        if(cmt!="*"){
            url+='&cmt='+cmt;
        }
        if(lokasicmt!="*"){
            url+='&lokasicmt='+lokasicmt;
        }
        location=url;
    }

    function tambah(){
        var url='<?php echo $tambah?>';
        location=url;
    }
</script>