<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <a href="<?php echo $batal;?>" class="btn btn-danger text-white full">Batal</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a onclick="simpan()" class="btn btn-info text-white full">Simpan</a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <a onclick="add()" class="btn btn-success text-white full"><i class="fa fa-plus"></i>&nbsp;Tambah</a>
        </div>
    </div>
</div>
<form method="post" class="form-group" action="<?php echo $action?>">
<div class="row">
    <div class="col-md-12">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Nama Supplier</th>
                                            <th>PIC</th>
                                            <th>Alamat</th>
                                            <th>Nomor Telephone</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <?php $i=0?>
                                    <tbody id="item-list">
                                        
                                    </tbody>
                                </table>
    </div>
</div>
</form>
<script type="text/javascript">
    $(document).ready(function() {

        $('#datatable').DataTable();
      
    } );

    function simpan(){
        $("form").submit();
    }
    var i='<?php echo $i?>';
    function add(){
        
        var html='';
        html+='<tr>';
        html+='<td><input type="text" name="data['+i+'][nama]" class="form-control"/></td>';
        html+='<td><input type="text" name="data['+i+'][pic]" class="form-control"/></td>';
        html+='<td><input type="text" name="data['+i+'][alamat]" class="form-control"/></td>';
        html+='<td><input type="text" name="data['+i+'][telephone]" class="form-control"/></td>';
        html+='<td><i class="fa fa-trash remove"></i></td>';
        html+='</tr>';
        $('#item-list').append(html);
        i++;
    }

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
    });
</script>