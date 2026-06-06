<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file-text-o mr-2"></i> Form Input Gaji Sablon Borongan</h3>
            </div>
            <form action="<?php echo $action ?>" method="POST">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input type="text" name="tanggal" class="form-control datepicker" value="<?php echo date('Y-m-d')?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Pilih CMT</label>
                                <select name="idcmt" class="select2bs4 form-control" required>
                                    <option value="">Pilih CMT</option>
                                    <?php foreach($cmt as $k){ ?>
                                        <option value="<?php echo $k['id_cmt']?>" data-item="<?php echo $k['id_cmt']?>"><?php echo $k['cmt_name']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Pilih Karyawan</label>
                                <select name="id_karyawan_harian" class="select2bs4 kar form-control" required>
                                    <option value="">Pilih Karyawan</option>
                                    <?php foreach($kar as $k){ ?>
                                        <option value="<?php echo $k['id']?>" data-item="<?php echo $k['id']?>"><?php echo $k['nama']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12">
                            <table class="table table-bordered table-striped" id="item_table3">
                                <thead>
                                    <tr class="bg-info">
                                        <th width="30%">Kode PO</th>
                                        <th>Gambar</th>
                                        <th>Model</th>
                                        <th width="10%">Lusin</th>
                                        <th width="10%">Putaran</th>
                                        <th width="15%">Harga</th>
                                        <th width="5%" class="text-center"><button type="button" name="add" class="btn btn-success btn-sm add3"><i class="fa fa-plus"></i></button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" onclick="return confirm('Apakah data yang diisi sudah benar?')" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <a href="<?php echo $cancel ?>" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    var i=0;
    $(document).on('click', '.add3', function(){
        var html = '';
        html += '<tr>';
        html += '<td>';
        html += '<select class="form-control selectpicker" name="prods['+i+'][kodepo]" data-live-search="true" data-size="5" required>';
        <?php foreach ($po as $key => $value): ?>
        html += '<option value="<?php echo $value['id_produksi_po'] ?>"><?php echo $value['kode_po'] ?></option>';
        <?php endforeach ?>
        html += '</select>';
        html += '</td>';
        html += '<td><input type="text" class="form-control" name="prods['+i+'][gambar]" required ></td>';
        html += '<td><input type="text" class="form-control" name="prods['+i+'][model]"  ></td>';
        html += '<td><input type="text" name="prods['+i+'][lusin]" class="form-control" ></td>';
        html += '<td><input type="text" class="form-control" name="prods['+i+'][putaran]"></td>';
        html += '<td><input type="text" class="form-control" name="prods['+i+'][harga]" required></td>';
        html += '<td class="text-center"><button type="button" name="btnRemove" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button></td></tr>';
        i++;
        $('#item_table3 tbody').append(html);
        $('.selectpicker').selectpicker('refresh');
    });

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
});
</script>