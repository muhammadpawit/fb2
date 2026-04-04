    .loading-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        min-height: 300px;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border-radius: 6px;
    }
    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin-bottom: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .loading-text {
        font-weight: bold;
        color: #3498db;
    }
</style>

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
            <button type="button" class="btn btn-sm btn-info btn-add-modal"><i class="fa fa-plus"></i> Tambah</button>
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
                                        <button type="button" class="btn btn-warning btn-sm btn-susulan" data-id="<?php echo $sat['kode_po'] ?>"><i class="fa fa-pencil"> Susulan</i></button>
                                    <?php } ?>
                                    <?php if(aksesedit()==1){?>
                                        <?php if(!empty($sat['rincianSetor'])){ ?>
                                            <button type="button" class="btn btn-info btn-sm btn-edit" data-id="<?php echo $sat['id'] ?>"><i class="fa fa-pencil"> Edit</i></button>
                                        <?php } ?>
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
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalDetailLabel">Detail Rincian Setor</h4>
            </div>
            <div class="modal-body">
                <div id="detail-content"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalEditLabel">Edit Rincian Setor</h4>
            </div>
            <div class="modal-body">
                <div id="edit-content"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalAddLabel">Tambah Rincian Setor Celana</h4>
            </div>
            <div class="modal-body">
                <div id="add-content"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Susulan -->
<div class="modal fade" id="modal-susulan" tabindex="-1" role="dialog" aria-labelledby="modalSusulanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="loading-overlay">
                <div class="spinner"></div>
                <span class="loading-text">Sedang memuat data...</span>
            </div>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="modalSusulanLabel">Setoran Susulan Celana</h4>
            </div>
            <div class="modal-body">
                <div id="susulan-content"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-detail').on('click', function() {
            var id = $(this).data('id');
            $('#modal-detail').modal('show');
            $('#modal-detail .loading-overlay').css('display', 'flex');
            
            $.ajax({
                url: '<?php echo BASEURL . "Finishing/detail_setoran_celana/" ?>' + id,
                type: 'GET',
                success: function(response) {
                    $('#modal-detail .loading-overlay').hide();
                    $('#detail-content').html(response);
                },
                error: function() {
                    $('#modal-detail .loading-overlay').hide();
                    $('#detail-content').html('<p class="text-center text-danger">Terjadi kesalahan saat memuat data.</p>');
                }
            });
        });

        $('.btn-edit').on('click', function() {
            var id = $(this).data('id');
            $('#modal-edit').modal('show');
            $('#modal-edit .loading-overlay').css('display', 'flex');
            
            $.ajax({
                url: '<?php echo BASEURL . "Finishing/edit_setoran_celana/" ?>' + id,
                type: 'GET',
                success: function(response) {
                    $('#modal-edit .loading-overlay').hide();
                    $('#edit-content').html(response);
                },
                error: function() {
                    $('#modal-edit .loading-overlay').hide();
                    $('#edit-content').html('<p class="text-center text-danger">Terjadi kesalahan saat memuat data.</p>');
                }
            });
        });

        $('.btn-add-modal').on('click', function() {
            $('#modal-add').modal('show');
            $('#modal-add .loading-overlay').css('display', 'flex');
            
            $.ajax({
                url: '<?php echo BASEURL . "Finishing/celana_add_modal" ?>',
                type: 'GET',
                success: function(response) {
                    $('#modal-add .loading-overlay').hide();
                    $('#add-content').html(response);
                },
                error: function() {
                    $('#modal-add .loading-overlay').hide();
                    $('#add-content').html('<p class="text-center text-danger">Terjadi kesalahan saat memuat data.</p>');
                }
            });
        });

        $('.btn-susulan').on('click', function() {
            var id = $(this).data('id');
            $('#modal-susulan').modal('show');
            $('#modal-susulan .loading-overlay').css('display', 'flex');
            
            $.ajax({
                url: '<?php echo BASEURL . "Finishing/editsetoran_susulan_celana_modal/" ?>' + id,
                type: 'GET',
                success: function(response) {
                    $('#modal-susulan .loading-overlay').hide();
                    $('#susulan-content').html(response);
                },
                error: function() {
                    $('#modal-susulan .loading-overlay').hide();
                    $('#susulan-content').html('<p class="text-center text-danger">Terjadi kesalahan saat memuat data.</p>');
                }
            });
        });

        // Tampilkan loader saat form disubmit
        $(document).on('submit', 'form', function() {
            $(this).closest('.modal-content').find('.loading-overlay').css('display', 'flex');
        });
    });
</script>