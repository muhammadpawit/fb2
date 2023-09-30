<div class="row">
    <div class="col-md-12">
        <div class="form-group text-right">
            <a href="<?php echo $tambah ?>" class="btn btn-sm btn-info">Tambah</a>
        </div>
    </div>
</div>
<div class="row">
     <div class="col-md-12">
         <table class="table table-bordered yessearch">
                        <thead>
                        <tr>
                            <th>NAMA PO</th>
                            <th>NAMA CMT</th>
                            <th>REFERENSI PO</th>
                            <th>STATUS</th>
                            <th>Qty (Pcs)</th>
                            <th>CREATED</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($rincian as $key => $sat): ?>
                            <tr>
                                <td><?php echo $sat['kode_po'] ?></td>
                                <td><?php echo $sat['nama_cmt'] ?></td>
                                <td><?php echo $sat['refpo'] ?></td>
                                <td style="<?php echo (empty($sat['rincianSetor'])?"background:#94121296;color:white":"background:#17941296;color:white") ?>"><?php echo (empty($sat['rincianSetor'])?"Belum Diproses":"Sudah Diproses") ?></td>
                                <td><?php echo $sat['qty_tot_pcs'] ?></td>
                                <td><?php echo $sat['created_date'] ?></td>
                                <td>
                                    <?php if(empty($sat['rincianSetor'])){ ?>
                                        <a href="<?php echo BASEURL.'finishing/produksikaoscmt_celana/'.$sat['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil">Proses</i></a>
                                    <?php }else{ ?>
                                        <a href="<?php echo BASEURL.'finishing/editsetoran_susulan_celana/'.$sat['kode_po'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil">Susulan</i></a>
                                    <?php } ?>
                                    <?php if(aksesedit()==1){?>
                                        <!-- <a href="<?php echo BASEURL.'finishing/editsetoran/'.$sat['kode_po'] ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil">Edit</i></a> -->
                                    <?php } ?>

                                    <?php if(akseshapus()==1){?>
                                        <?php $cek=$this->GlobalModel->getData('kelolapo_rincian_setor_cmt_celana',array('kode_po LIKE '=>$sat['kode_po'].'-'.$sat['id_cmt'].'%'));?>
                                        <?php if(!empty($cek)){ ?>
                                            <?php //echo json_encode($sat['rincianSetor']['kode_po']) ?>
                                            <a href="<?php echo BASEURL.'finishing/editsetoran_hapus_celana/'.$sat['rincianSetor']['kode_po'] ?>" onclick="return confirm('Apakah yakin akan mereset data ini ? Seluruh data penerimaan akan terhapus') " class="btn btn-danger btn-sm"><i class="fa fa-trash">Reset</i></a>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
     </div>
</div>