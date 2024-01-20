<div class="row">
    <div class="col-md-12">
        <div class="form-group table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Cabang</th>
                        <th colspan="<?php echo count($jenis) ?>"><center>Nama PO</center></th>
                        <th rowspan="2">Jumlah</th>
                    </tr>
                    <tr>
                        <?php foreach($jenis as $j){ ?>
                            <td><?php echo $j['nama_jenis_po']?></td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1;$total=0;?>
                    <?php foreach($lokasi as $l){ ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $l['lokasi'];?></td>
                            <?php foreach($jenis as $j){ ?>
                                <td><?php echo $this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],$l['id']); ?></td>
                                <?php $total=($this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],$l['id'])) ?>
                            <?php } ?>
                            <td><b><?php echo $this->ReportModel->getJumlahJenisPoCmtGrupLokasi($l['id']); ?></b></td>
                        </tr>
                        <?php if(!empty($l['details'])){ ?>
                            <tr>
                                <td align="right">&bull;</td>
                                <td>Sablon</td>
                                <?php foreach($jenis as $j){ ?>
                                    <?php $total=($this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON')) ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $j['id_jenis_po'] ?>','SABLON')">
                                            <?php echo $this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON'); ?>
                                        </a>
                                    </td>
                                    
                                <?php } ?>
                                <td><b><?php echo $this->ReportModel->BeredarPo(null,'SABLON'); ?></b></td>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>Bordir</td>
                                <?php foreach($jenis as $j){ ?>
                                    <?php $total=($this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR')) ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $j['id_jenis_po'] ?>','BORDIR')">
                                            <?php echo $this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR'); ?>
                                        </a>
                                    </td>
                                    
                                <?php } ?>
                                <td><b><?php echo $this->ReportModel->BeredarPo(null,'BORDIR'); ?></b></td>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>Pending</td>
                                <?php foreach($jenis as $j){ ?>
                                    <?php $po=$j['id_jenis_po']; ?>
                                    <?php $total=($this->ReportModel->pendingPo($j['id_jenis_po'])) ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $po ?>','PENDING')">
                                        <?php echo $this->ReportModel->pendingPo($j['id_jenis_po']); ?>
                                        </a>
                                    </td>
                                    
                                <?php } ?>
                                <td><b><?php echo $this->ReportModel->pendingPo(null); ?></b></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
    function detail(po, proses){
        $('#myModal').modal('show');
        $.ajax({
            url: '<?php echo BASEURL?>Stokpoberedar/detail', // Ganti dengan URL server dan endpoint yang sesuai
            type: 'POST',
            data: { id: po, proses:proses },
            success: function(response) {
             const obj = JSON.parse(response);
             var span='<div>';
            // Menampilkan detail data dalam modal
            $('.modal-title').html(proses);
            
            for (let i = 0; i < obj.length; i++) {
                // Mengakses properti objek dan menambahkannya ke span
                span += `<div class="badge bg-green">${obj[i].kode_po}</div>&nbsp;`; // Ganti dengan nama properti sesuai objek Anda
                }

                span += '</div>';
                $('.modal-body').html(span);
            // Menampilkan modal
            $('#myModal').modal('show');
            },
            error: function(error) {
            console.error('Error:', error);
            }
        });
    }
</script>