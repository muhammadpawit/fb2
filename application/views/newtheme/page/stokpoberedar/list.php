<div class="row">
    <div class="col-md-12 text-center">
        <h3 style="text-decoration: underline;">STOK PO KAOS YANG BEREDAR</h3>
    </div>
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
                                <?php $total= $this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],$l['id']); ?>
                                <td>
                                <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" 
                                    href="javascript:void(0);" onclick="detailKirim('<?php echo $j['id_jenis_po'] ?>','<?php echo $l['id'] ?>','<?php echo $l['lokasi'] ?>')">
                                        <?php echo $total ?>
                                    </a>
                                </td>
                                <?php $total=($this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],$l['id'])) ?>
                            <?php } ?>
                            <td><b><?php echo $this->ReportModel->getJumlahJenisPoCmtGrupLokasi($l['id'],2); ?></b></td>
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
                                <td><b><?php echo $this->ReportModel->pendingPo('kaos'); ?></b></td>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>KLO</td>
                                <?php foreach($jenis as $j){ ?>
                                    <?php $po=$j['id_jenis_po']; ?>
                                    <?php $total=($this->ReportModel->KLOPo($j['id_jenis_po'])) ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $po ?>','KLO')">
                                        <?php echo $this->ReportModel->KLOPo($j['id_jenis_po']); ?>
                                        </a>
                                    </td>
                                    
                                <?php } ?>
                                <td><b><?php echo $this->ReportModel->KLOPo(null); ?></b></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr style="background-color: yellow;">
                        <td colspan="2"><b><center>Total</center></b></td>
                        <?php $allkaos=0;?>
                        <?php foreach($jenis as $j){ ?>
                            <td><b><?php echo ($this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON') + $this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR') +  $this->ReportModel->pendingPo($j['id_jenis_po']) + $this->ReportModel->KLOPo($j['id_jenis_po']) + $this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],null)) // +  ?></b></td>
                            <?php $allkaos+=(($this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON') + $this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR') +  $this->ReportModel->pendingPo($j['id_jenis_po']) + $this->ReportModel->KLOPo($j['id_jenis_po']) + $this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],null)));?>
                        <?php } ?>
                        <td align="left">
                            <b>
                                <?php echo $allkaos; ?>
                            </b>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 text-center">
        <h3 style="text-decoration: underline;">STOK PO KEMEJA YANG BEREDAR</h3>
    </div>
    <div class="col-md-12">
        <div class="form-group table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Cabang</th>
                        <th colspan="<?php echo count($jenis_kemeja) ?>"><center>Nama PO</center></th>
                        <th rowspan="2" width="10%">Dikirim Ke Pusat</th>
                        <th rowspan="2" width="10%"><center>Jumlah</center></th>
                    </tr>
                    <tr>
                        <?php foreach($jenis_kemeja as $j){ ?>
                            <td><?php echo $j['nama_jenis_po']?></td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1;$total=0;$perjalanan=0;$alljumlah=0;?>
                    <?php foreach($lokasi as $l){ ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $l['lokasi'];?></td>
                            <?php foreach($jenis_kemeja as $j){ ?>
                                <?php $total= $this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],$l['id']); ?>
                                <td>
                                <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" 
                                    href="javascript:void(0);" onclick="detailKirim('<?php echo $j['id_jenis_po'] ?>','<?php echo $l['id'] ?>','<?php echo $l['lokasi'] ?>')">
                                        <?php 
                                            echo $this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],$l['id']);
                                         ?>
                                    </a>
                                </td>
                                <?php $total=($this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],$l['id'])) ?>
                            <?php } ?>
                            <td align="center">
                                
                                    <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detailberedar('<?php echo $l['id'] ?>','DETAIL')">
                                        <?php echo $this->ReportModel->BeredarPoPerjalanan($l['id'],'total'); ?>
                                    </a>
                                <?php
                                    $perjalanan+=($this->ReportModel->BeredarPoPerjalanan($l['id'],'total'));
                                ?>
                            </td>
                            <td align="center">
                                <?php $alljumlah+=(($this->ReportModel->getJumlahJenisPoCmtGrupLokasi($l['id'],1) + $this->ReportModel->BeredarPoPerjalanan($l['id'],'total') )); ?>
                                <b><?php echo ($this->ReportModel->getJumlahJenisPoCmtGrupLokasi($l['id'],1) + $this->ReportModel->BeredarPoPerjalanan($l['id'],'total') ); ?></b>
                            </td>
                        </tr>
                        <?php if(!empty($l['details'])){ ?>
                            <tr>
                                <td align="right">&bull;</td>
                                <td>Sablon</td>
                                <?php $kemeja_sablon=0;$kemeja_bordir=0;$kemeja_pending=0;?>
                                <?php foreach($jenis_kemeja as $j){ ?>
                                    <?php $total=($this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON')) ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $j['id_jenis_po'] ?>','SABLON')">
                                            <?php echo $this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON'); ?>
                                        </a>
                                    </td>
                                    <?php $kemeja_sablon+=($this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON'));?>
                                <?php } ?>
                                <td></td>
                                <td align="center"><b><?php echo $kemeja_sablon ?></b></td>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>Bordir</td>
                                <?php foreach($jenis_kemeja as $j){ ?>
                                    <?php 
                                        $total=($this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR'));
                                        $kemeja_bordir+=($this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR'));
                                    ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $j['id_jenis_po'] ?>','BORDIR')">
                                            <?php echo $this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR'); ?>
                                        </a>
                                    </td>
                                    
                                <?php } ?>
                                <td></td>
                                <td align="center"><b><?php echo $kemeja_bordir ?></b></td>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>Pending</td>
                                <?php foreach($jenis_kemeja as $j){ ?>
                                    <?php $po=$j['id_jenis_po']; ?>
                                    <?php 
                                        $total=($this->ReportModel->pendingPo($j['id_jenis_po']));
                                        $kemeja_pending+=($this->ReportModel->pendingPo($j['id_jenis_po']));
                                    ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $po ?>','PENDING')">
                                        <?php echo $this->ReportModel->pendingPo($j['id_jenis_po']); ?>
                                        </a>
                                    </td>
                                    
                                <?php } ?>
                                <td></td>
                                <td align="center"><b><?php echo $kemeja_pending ?></b></td>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>Finishing</td>
                                <?php $tofinish=0;?>
                                <?php foreach($jenis_kemeja as $j){ ?>
                                    <?php $po=$j['id_jenis_po']; ?>
                                    <?php 
                                        $total=($this->ReportModel->pendingPo($j['id_jenis_po']));
                                        // $tofinish+=($this->ReportModel->pendingPo($j['id_jenis_po']));
                                        $tofinish+=0;
                                    ?>
                                    <td>
                                        <a class="<?php echo $total > 0 ?'text-success':'text-danger';?>" href="javascript:void(0);" onclick="detail('<?php echo $po ?>','PENDING')">
                                        <?php //echo $this->ReportModel->pendingPo($j['id_jenis_po']); ?>0
                                        </a>
                                    </td>
                                    
                                <?php } ?>
                                <td></td>
                                <td align="center"><b><?php echo $tofinish ?></b></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr style="background-color: yellow;">
                        <td colspan="2"><b><center>Total</center></b></td>
                        <?php foreach($jenis_kemeja as $j){ ?>
                            <td align="center"><b><?php echo ($this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON') + $this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR') +  $this->ReportModel->pendingPo($j['id_jenis_po']) + $this->ReportModel->getJumlahJenisPoCmtGrup($j['id_jenis_po'],null)) // +  ?></b></td>
                        <?php } ?>
                        <td align="center">
                            <b><?php echo $perjalanan ?></b>
                        </td>
                        <td align="center">
                            <b><?php echo $alljumlah ?></b>
                        </td>
                    </tr>
                </tfoot>
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
                span += `<div class="badge bg-green" style="background-color: #00a65a !important;
  height: 50px;
  margin: 2em;
  line-height: 40px;
  text-align: center;
  vertical-align: middle;
  display: inline-block;
  width: 100px;">${i + 1}. ${obj[i].kode_po}</div>&nbsp;`; // Ganti dengan nama properti sesuai objek Anda
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

    function detailKirim(po, proses,lokasi){
        $('#myModal').modal('show');
        $.ajax({
            url: '<?php echo BASEURL?>Stokpoberedar/detailKirim', // Ganti dengan URL server dan endpoint yang sesuai
            type: 'POST',
            data: { id: po, proses:proses },
            success: function(response) {
             const obj = JSON.parse(response);
             var span='<div>';
            // Menampilkan detail data dalam modal
            $('.modal-title').html(lokasi);
            
            for (let i = 0; i < obj.length; i++) {
                // Mengakses properti objek dan menambahkannya ke span
                span += `<div class="badge bg-green" style="background-color: #00a65a !important;
  height: 50px;
  margin: 2em;
  line-height: 40px;
  text-align: center;
  vertical-align: middle;
  display: inline-block;
  width: 100px;">${i + 1}. ${obj[i].kode_po}</div>&nbsp;`; // Ganti dengan nama properti sesuai objek Anda
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

    function detailberedar(po, proses,lokasi='Sedang Di Kirim Ke Pusat'){
        $('#myModal').modal('show');
        $.ajax({
            url: '<?php echo BASEURL?>Stokpoberedar/detailberedar', // Ganti dengan URL server dan endpoint yang sesuai
            type: 'POST',
            data: { id: po, proses:proses },
            success: function(response) {
             const obj = JSON.parse(response);
             var span='<div>';
            // Menampilkan detail data dalam modal
            $('.modal-title').html(lokasi);
            
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