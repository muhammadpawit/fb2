<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="<?php echo BASEURL.'Finishing/rinciansetorcelanacmt' ?>" method="get">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kode PO</label>
                                <input type="text" name="kode_po" class="form-control" value="<?php echo isset($kode_po)?$kode_po:'' ?>" placeholder="Search Kode PO...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>&nbsp;</label><br>
                                <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                                <a href="<?php echo BASEURL.'Finishing/rinciansetorcelanacmt' ?>" class="btn btn-sm btn-danger">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
                                        <button type="button" class="btn btn-success btn-sm btn-detail" data-id="<?php echo $sat['id'] ?>"><i class="fa fa-eye"> Detail</i></button>
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

<!-- Modal Detail -->
<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalDetailLabel">Detail Rincian Setor</h4>
            </div>
            <div class="modal-body">
                <div id="detail-content">
                    <p class="text-center">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-detail').on('click', function() {
            var id = $(this).data('id');
            $('#modal-detail').modal('show');
            $('#detail-content').html('<p class="text-center">Loading...</p>');
            
            $.ajax({
                url: '<?php echo BASEURL . "Finishing/detail_setoran_celana/" ?>' + id,
                type: 'GET',
                success: function(response) {
                    $('#detail-content').html(response);
                },
                error: function() {
                    $('#detail-content').html('<p class="text-center text-danger">Terjadi kesalahan saat memuat data.</p>');
                }
            });
        });
    });
</script>