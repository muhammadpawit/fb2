<div class="row">
  <div class="col-md-12">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
  </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <button class="btn btn-info btn-sm text-white" data-toggle="modal" data-target="#modal_add">Tambah</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered yessearch">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Tanggal</th>
                    <th>Nama Supplier</th>
                    <th>Jumlah (Rp)</th>
					<th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                <?php foreach($products as $p){?>
                    <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $p['tanggal']?></td>
                        <td><?php echo $p['namasupplier']?></td>
                        <td><?php echo number_format($p['jumlah'])?></td>
						<td><?php echo $p['keterangan']?></td>
                        <!-- <td>
                            <button class="btn btn-xs btn-primary btn-detail" data-id="<?php echo $p['id']?>">Detail</button>
                            <button class="btn btn-xs btn-warning btn-edit" data-id="<?php echo $p['id']?>">Edit</button>
                            <button class="btn btn-xs btn-danger btn-delete" data-id="<?php echo $p['id']?>">Delete</button>
                        </td> -->
						
						 <td class="right">
							<?php foreach ($p['action'] as $action) { ?>
                            <a href="javascript:void(0)" data-id="<?php echo $p['id']?>" style="background-color: <?php echo $action['bg']; ?>" class="badge waves-light waves-effect btn btn-xs btn-primary btn-<?php echo $action['text']; ?>"><?php echo $action['text']; ?></a>&nbsp;&nbsp;
                            <?php } ?>
						</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_addLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_addLabel">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_add">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="namasupplier">Nama Supplier</label>
                        <select name="namasupplier" id="namasupplier" class="form-control select2bs4" data-live-search="true" style="width: 100%;" required>
                            <option value="">Pilih Supplier</option>
                            <?php foreach($supplier as $st){ ?>
                                <option value="<?php echo $st['id'] ?>"><?php echo $st['nama']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label>Untuk Pembayaran</label>
                        <select name="penerimaan_item_id[]" id="penerimaan_item_id" multiple class="form-control select2bs4" style="width: 100%;">
                            <option value="">Pilih Pembayaran (Pilih Supplier terlebih dahulu)</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="jumlah">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Nominal Giro (Rp)</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_editLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit">
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="form-group">
                        <label for="edit_tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_supplier_id">Nama Supplier</label>
                        <select name="supplier_id" id="edit_supplier_id" class="form-control select2bs4" required>
                            <option value="">Pilih Supplier</option>
                            <?php foreach($supplier as $st){ ?>
                                <option value="<?php echo $st['id'] ?>"><?php echo $st['nama']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="edit_penerimaan_item_id">Untuk Pembayaran</label>
                        <select name="penerimaan_item_id" id="edit_penerimaan_item_id" class="form-control select2bs4">
                            <option value="">Pilih Pembayaran</option>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="edit_keterangan">Keterangan</label>
                        <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_jumlah">Jumlah (Rp)</label>
                        <input type="number" class="form-control" id="edit_jumlah" name="jumlah" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modal_detailLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_detailLabel">Detail Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <td id="detail_tanggal"></td>
                    </tr>
                    <tr>
                        <th>Nama Supplier</th>
                        <td id="detail_namasupplier"></td>
                    </tr>
                    <!-- <tr>
                        <th>Untuk Pembayaran</th>
                        <td id="detail_pembayaran"></td>
                    </tr> -->
                    <tr>
                        <th>Keterangan</th>
                        <td id="detail_keterangan"></td>
                    </tr>
                    <tr>
                        <th>Jumlah (Rp)</th>
                        <td id="detail_jumlah"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="modal_deleteLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_deleteLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this record?
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    // Load penerimaan items when supplier is selected (Add Modal)
	// Inisialisasi select2 dengan multiple
	$('#penerimaan_item_id').select2({
		theme: 'bootstrap4',
		placeholder: "Pilih Pembayaran",
		allowClear: true
	});

	// Load penerimaan items ketika supplier dipilih
	$('#namasupplier').change(function() {
		var supplier_id = $(this).val();
		if(supplier_id) {
			$('#penerimaan_item_id').html('<option value="">Loading...</option>');
			
			$.ajax({
				url: '<?php echo BASEURL ?>Historygiro/get_penerimaan_items/' + supplier_id,
				type: 'GET',
				dataType: 'json',
				success: function(response) {
					if(response.status) {
						var options = '<option value="">Pilih Pembayaran</option>';
						$.each(response.data, function(key, value) {
							options += '<option value="'+value.id+'">'+value.text+'</option>';
						});
						$('#penerimaan_item_id').html(options);
					} else {
						$('#penerimaan_item_id').html('<option value="">Tidak ada data pembayaran</option>');
					}
				},
				error: function() {
					$('#penerimaan_item_id').html('<option value="">Error loading data</option>');
				}
			});
		} else {
			$('#penerimaan_item_id').html('<option value="">Pilih Supplier terlebih dahulu</option>').val(null).trigger('change');
		}
	});

    // Add data
    $('#form_add').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo BASEURL ?>Historygiro/save',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status) {
                    $('#modal_add').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Get data for edit
    $('.btn-edit').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?php echo site_url('yourcontroller/edit/')?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#edit_id').val(response.id);
                $('#edit_tanggal').val(response.tanggal);
                $('#edit_supplier_id').val(response.supplier_id).trigger('change');
                $('#edit_keterangan').val(response.keterangan);
                $('#edit_jumlah').val(response.jumlah);
                
                // Load penerimaan items for edit modal
                if(response.supplier_id) {
                    $('#edit_penerimaan_item_id').html('<option value="">Loading...</option>');
                    $.ajax({
                        url: '<?php echo site_url('yourcontroller/get_penerimaan_items/')?>' + response.supplier_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(res) {
                            var options = '<option value="">Pilih Pembayaran</option>';
                            $.each(res, function(key, value) {
                                var selected = (value.id == response.penerimaan_item_id) ? 'selected' : '';
                                options += '<option value="'+value.id+'" '+selected+'>'+value.text+'</option>';
                            });
                            $('#edit_penerimaan_item_id').html(options);
                            $('#modal_edit').modal('show');
                        }
                    });
                } else {
                    $('#edit_penerimaan_item_id').html('<option value="">Pilih Supplier terlebih dahulu</option>');
                    $('#modal_edit').modal('show');
                }
            }
        });
    });

    // Update data
    $('#form_edit').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?php echo site_url('yourcontroller/update')?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if(response.status) {
                    $('#modal_edit').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Get data for detail
    $('.btn-detail').click(function() {
        var id = $(this).data('id');
		
        $.ajax({
            url: '<?php echo BASEURL.'Historygiro/detail/' ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#detail_tanggal').text(response.tanggal);
                $('#detail_namasupplier').text(response.namasupplier);
                $('#detail_pembayaran').text(response.pembayaran);
                $('#detail_keterangan').text(response.keterangan);
                $('#detail_jumlah').text('Rp ' + response.nominal.toLocaleString());
                $('#modal_detail').modal('show');
            }
        });
    });

    // Delete confirmation
    $('.btn-delete').click(function() {
        var id = $(this).data('id');
        $('#delete_id').val(id);
        $('#modal_delete').modal('show');
    });

    // Confirm delete
    $('#btn-confirm-delete').click(function() {
        var id = $('#delete_id').val();
        $.ajax({
            url: '<?php echo site_url('yourcontroller/delete/')?>' + id,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if(response.status) {
                    $('#modal_delete').modal('hide');
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });
});
</script>