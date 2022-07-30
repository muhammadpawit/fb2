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
    <div class="col-md-2">
        <div class="form-group">
            <label>Tanggal Awal</label>
            <input type="text" value="<?php echo $tanggalMulai?>" class="form-control" name="tanggalMulai">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="text" class="form-control" name="tanggalEnd" value="<?php echo $tanggalEnd?>">
        </div>
    </div>
    <div class="col-3">
        <label>Nama PO</label>
        <select name="namaPo" class="form-control autopo" data-live-search="true">
            <option value="*">Semua</option>
        </select>
    </div>
    <div class="col-3">
        <label>Nama Operator</label>
        <select name="oper" class="form-control select2bs4" data-live-search="true">
            <option value="*">Semua</option>
            <?php foreach($opt as $o){?>
                <option value="<?php echo $o['id_master_karyawan_bordir']?>"><?php echo $o['nama_karyawan_bordir']?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-2">
        <label>Aksi</label><br>
        <a onclick="filter()" class="btn btn-info text-white">Filter</a>
        <a onclick="exceldalam()" class="btn btn-info text-white">Excel</a>
        <a href="<?php echo $tambah?>" class="btn btn-info">Tambah</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
                    <table class="table table-bordered nosearch">
                        <thead>
                        <tr>
                            <th>Nama Operator</th>
                            <th>Mandor</th>
                            <th>No Mesin</th>
                            <th>Nama Po</th>
                            <th>Tanggal Masuk</th>
                            <th>Posisi Bordir</th>
                            <th>Size</th>
                            <th>Stich</th>
                            <th>Qty</th>
                            <th>Total Stich</th>
                            <th>Perkalian</th>
                            <th>Tarif</th>
                            <!-- <th>Selisih</th> -->
                            <th>Kepala</th>
                            <th>Persen</th>
                            <th>Gaji</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($bordir)){?>
                        <?php foreach ($bordir as $bod): ?>
                        <tr>
                            <td><?php echo $bod['operator'] ?></td>
                            <td><?php echo $bod['mandor'] ?></td>
                            <td><?php echo $bod['mesin'] ?></td>
                            <td><?php echo $bod['nama_po'] ?></td>
                            <td><?php echo $bod['created_date'] ?></td>
                            <td><?php echo $bod['bagian_bordir'] ?></td>
                            <td><?php echo $bod['size'] ?></td>
                            <td><?php echo $bod['stich'] ?></td>
                            <td><?php echo $bod['jumlah_naik_mesin'] ?></td>
                            <td><?php echo ($bod['total_stich']) ?></td>
                            <td><?php echo ($bod['perkalian_tarif']) ?></td>
                            <td><?php echo ($bod['total_tarif']) ?></td>
                            <!-- <td><?php echo ($bod['hitung']) ?></td> -->
                            <td><?php echo ($bod['kepala']) ?></td>
                            <td><?php echo ($bod['persen']) ?></td>
                            <td><?php echo ($bod['gaji']) ?></td>
                            <td class="right">
                                <?php foreach ($bod['action'] as $action) { ?>
                                    <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php } ?>
                        </tbody>
                    </table>
    </div>
</div>

<script type="text/javascript">

    function filter(){
        url='<?php echo $url;?>';
        
        var filter_date_start = $('input[name=\'tanggalMulai\']').val();

        if (filter_date_start) {
            url += '&tanggalMulai=' + encodeURIComponent(filter_date_start);
        }

      var filter_date_end = $('input[name=\'tanggalEnd\']').val();

        if (filter_date_end) {
            url += '&tanggalEnd=' + encodeURIComponent(filter_date_end);
        }

    var filter_status = $('select[name=\'namaPo\']').val();

        if (filter_status != '*') {
            url += '&namaPo=' + encodeURIComponent(filter_status);
        }

        var opt = $('select[name=\'oper\']').val();

        if (opt != '*') {
            url += '&oper=' + encodeURIComponent(opt);
        }
        location =url;
        
    }

    function exceldalam(){
        url='<?php echo $url;?>&excel=1';
        
        var filter_date_start = $('input[name=\'tanggalMulai\']').val();

        if (filter_date_start) {
            url += '&tanggalMulai=' + encodeURIComponent(filter_date_start);
        }

      var filter_date_end = $('input[name=\'tanggalEnd\']').val();

        if (filter_date_end) {
            url += '&tanggalEnd=' + encodeURIComponent(filter_date_end);
        }

    var filter_status = $('select[name=\'namaPo\']').val();

        if (filter_status != '*') {
            url += '&namaPo=' + encodeURIComponent(filter_status);
        }

        var opt = $('select[name=\'oper\']').val();

        if (opt != '*') {
            url += '&oper=' + encodeURIComponent(opt);
        }
        location =url;
        
    }
        $(document).ready(function() {
            
            //$('.select2').select2();

            //Buttons examples
            var table = $('#datatable-buttons').DataTable({
                lengthChange: false,
                "searching": false,
                //buttons: ['copy', 'excel', 'pdf']
            });
            table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
        } );

    </script>