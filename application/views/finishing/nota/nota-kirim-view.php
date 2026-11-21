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
                                <select name="kode_po" id="kode_po" class="form-control autopoid" data-live-search="true">
                                    <option value="">Pilih PO</option>
                                    <?php if(!empty($kode_po)){ ?>
                                        <option value="<?php echo $kode_po; ?>" selected><?php echo $kode_po; ?></option>
                                    <?php } ?>
                                </select>
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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($notarincian as $key => $sat): ?>
                                        <?php 
                                        $po = $this->GlobalModel->getDataRow('produksi_po',array('id_produksi_po'=> $sat['kode_po'])); 
                                        $nama_po = !empty($po['kode_po']) ? $po['kode_po'] : (!empty($sat['nama_po']) ? $sat['nama_po'] : $sat['kode_po']);
                                        $status = !empty($sat['status']) ? strtolower($sat['status']) : 'dibuat';
                                        ?>
                                    <tr>
                                        <td><?php echo date('d-m-Y',strtotime($sat['tanggal_kirim'])); ?></td>
                                        <td><?php echo $sat['nofaktur'] ?></td>
                                        <td><?php echo strtoupper($nama_po) ?></td>
                                        <td><?php echo $sat['jumlah_piece_diterima']?></td>
                                        <td><?php echo strtolower($sat['tujuan']) ?></td>
                                        <td>
                                            <?php if ($status == 'disetujui'): ?>
                                                <span class="label label-success"><i class="fa fa-check"></i> Disetujui</span>
                                            <?php elseif ($status == 'ditolak'): ?>
                                                <span class="label label-danger"><i class="fa fa-times"></i> Ditolak</span>
                                            <?php else: ?>
                                                <span class="label label-warning"><i class="fa fa-clock"></i> Dibuat</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($status == 'disetujui'): ?>
                                                <a href="<?php echo BASEURL.'Notakirim/detail/'.$sat['nofaktur'] ?>" class="btn btn-info btn-xs">Cetak</a>
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
                                            <?php else: ?>
                                                <a href="<?php echo BASEURL.'Notakirim/detail/'.$sat['nofaktur'] ?>" class="btn btn-default btn-xs" title="Lihat Dokumen"><i class="fa fa-eye"></i> Lihat</a>
                                                <span class="label label-default" style="display:inline-block; margin-top:2px; font-size:11px;" title="Dokumen belum disetujui, tidak bisa dicetak"><i class="fa fa-lock"></i> Menunggu Persetujuan</span>
                                            <?php endif; ?>

                                            <?php if(isset($is_approver) && $is_approver): ?>
                                                <div class="btn-group" style="margin-left: 2px;">
                                                    <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Ubah Status <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="<?php echo BASEURL.'Finishing/approve_kirimgudang/'.$sat['nofaktur'].'/disetujui' ?>" onclick="return confirm('Setujui dokumen ini?')"><i class="fa fa-check text-success"></i> Disetujui</a></li>
                                                        <li><a href="<?php echo BASEURL.'Finishing/approve_kirimgudang/'.$sat['nofaktur'].'/ditolak' ?>" onclick="return confirm('Tolak dokumen ini?')"><i class="fa fa-times text-danger"></i> Ditolak</a></li>
                                                        <li><a href="<?php echo BASEURL.'Finishing/approve_kirimgudang/'.$sat['nofaktur'].'/dibuat' ?>" onclick="return confirm('Kembalikan ke status Dibuat?')"><i class="fa fa-undo text-warning"></i> Dibuat</a></li>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>

                                            <a href="<?php echo BASEURL.'finishing/edit_tanggal/'.$sat['id_finishing_kirim_gudang'] ?>" class="btn btn-success btn-xs text-white">Edit Tanggal</a>
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