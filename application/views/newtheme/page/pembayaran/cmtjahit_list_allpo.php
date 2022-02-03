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
            <label>Nama Cmt</label>
            <select name="cmt" id="cmt" class="form-control select2bs4" data-live-search="true">
                <option value="*">Semua</option>
                <?php foreach($cmt as $c){?>
                    <option value="<?php echo $c['id_cmt']?>" <?php echo $cmtf==$c['id_cmt']?'selected':'';?>><?php echo strtolower($c['cmt_name'])?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Nama PO</label>
            <select name="kode_po" id="kode_po" class="form-control autopo" data-live-search="true">
                <option value="*">Semua</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <label>Action</label><br>
        <button class="btn btn-info btn-sm" onclick="filter()">Filter</button>
        <button class="btn btn-info btn-sm" onclick="excel()">Excel</button>
        <button class="btn btn-info btn-sm" onclick="tambah()">Tambah</button>
    </div>
    <div class="col-md-12">
        <table class="table table-bordered nosearch">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama CMT</th>
                    <th>Nama PO</th>
                    <th>Kirim</th>
                    <th>Harga</th>
                    <th>Total Pembayaran</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($products)){?>
                    <?php foreach($products as $p){?>
                        <tr>
                            <td><?php echo $p['no']?></td>
                            <td><?php echo $p['tanggal']?></td>
                            <td><?php echo $p['nama']?></td>
                            <td><?php echo $p['kode_po']?></td>
                            <td><?php echo $p['kirim']?></td>
                            <td><?php echo $p['harga']?></td>
                            <td><?php echo $p['total']?></td>
                            <td><?php echo $p['keterangan']?></td>
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
        var po=$("#kode_po").val();
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

        if(po!="*"){
            url+='&kode_po='+po;
        }

        location=url;
    }

    function excel(){
        var tanggal1=$("#tanggal1").val();
        var tanggal2=$("#tanggal2").val();
        var cmt=$("#cmt").val();
        var po=$("#kode_po").val();
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

        if(po!="*"){
            url+='&kode_po='+po;
        }
        
        location=url;
    }

    function tambah(){
        var url='<?php echo $tambah?>';
        location=url;
    }
</script>