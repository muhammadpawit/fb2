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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Kode PO</label>
                                <input type="text" name="kode_po" id="kode_po" class="form-control autopo" value="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Action</label><br>
                                <button onclick="filter()" class="btn btn-info btn-sm">Filter</button>
                                <a href="<?php echo BASEURL.'Finishing/kirimgudang' ?>" class="btn btn-info btn-sm text-white"><i class="fa fa-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered yessearch">
                                <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No.Faktur</th>
                                    <th>Nama PO</th>
                                    <th>Kuantitas Kirim (pcs)</th>
                                    <th>Tujuan</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($notarincian as $key => $sat): ?>
                                        <?php $po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=> $sat['kode_po'])); ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y',strtotime($sat['tanggal_kirim'])); ?></td>
                                        <td><?php echo $sat['nofaktur'] ?></td>
                                        <td><?php echo strtoupper($po['kode_po']) ?></td>
                                        <td><?php echo $sat['jumlah_piece_diterima']?></td>
                                        <td><?php echo strtolower($sat['tujuan']) ?></td>
                                        <td>
                                            <a href="<?php echo BASEURL.'Notakirim/detail/'.$sat['nofaktur'] ?>" class="btn btn-info btn-xs">Cetak</a>
                                            <a href="<?php echo BASEURL.'finishing/edit_tanggal/'.$sat['id_finishing_kirim_gudang'] ?>" class="btn btn-success btn-xs text-white">Edit Tanggal</a>

                                            <?php if(substr($sat['kode_po'],0,3)=="HGS"){?>
                                                <a href="<?php echo BASEURL.'Notakirim/detail/'.$sat['nofaktur'] ?>?&hgs=HGS" class="btn btn-info btn-xs">Cetak SJ HGS</a>
                                            <?php } ?>
                                            <?php if(substr($sat['kode_po'],0,3)=="HGO"){?>
                                                <a href="<?php echo BASEURL.'Notakirim/detail/'.$sat['nofaktur'] ?>?&hgs=HGO" class="btn btn-info btn-xs">Cetak SJ HGO</a>
                                            <?php } ?>
                                            <?php if(substr($sat['kode_po'],0,3)=="HGW"){?>
                                                <a href="<?php echo BASEURL.'Notakirim/detail/'.$sat['nofaktur'] ?>?&hgs=HGW" class="btn btn-info btn-xs">Cetak SJ HGW</a>
                                            <?php } ?>
                                            <?php if(substr($sat['kode_po'],0,3)=="SWH"){?>
                                                <a href="<?php echo BASEURL.'Notakirim/detail/'.$sat['nofaktur'] ?>?&hgs=SWH" class="btn btn-info btn-xs">Cetak SJ SWH</a>
                                            <?php } ?>
                                            <?php if(aksesedit()==1){?>
                                                <a href="<?php echo BASEURL.'Notakirim/edit/'.$sat['nofaktur'] ?>" class="btn btn-warning btn-xs text-white">Edit Rincian</a>
                                            <?php } ?>
                                            <?php if(akseshapus()==1){?>
                                                <a href="<?php echo BASEURL.'Finishing/hapuskgudang/'.$sat['id_finishing_kirim_gudang'] ?>" class="btn btn-danger btn-xs text-white">Hapus</a>
                                            <?php } ?>
                                            <a href="<?php echo BASEURL.'Notakirim/kirim_next/'.$sat['idpo'] ?>" class="btn btn-warning btn-xs text-white">Pengiriman Selanjutnya</a>
                                            <a href="<?php echo BASEURL.'Notakirim/edit/'.$sat['nofaktur'] ?>" class="btn btn-warning btn-xs text-white">Edit Keterangan</a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>              
<script type="text/javascript">
    function filter(){
        url ='?';
        var tanggal1=$("#tanggal1").val();
        var tanggal2=$("#tanggal2").val();
        var kode_po=$("#kode_po").val();

        if(tanggal1){
            url+='&tanggal1='+tanggal1;
        }

        if(tanggal2){
            url+='&tanggal2='+tanggal2;
        }

        if(kode_po){
            url+='&kode_po='+kode_po;
        }

        location = url;
    }
</script>