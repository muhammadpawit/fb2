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
                                    <td><?php echo $this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON'); ?></td>
                                    <?php $total=($this->ReportModel->BeredarPo($j['id_jenis_po'],'SABLON')) ?>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>Bordir</td>
                                <?php foreach($jenis as $j){ ?>
                                    <td><?php echo $this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR'); ?></td>
                                    <?php $total=($this->ReportModel->BeredarPo($j['id_jenis_po'],'BORDIR')) ?>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td align="right">&bull;</td>  
                                <td>Pending</td>
                                <?php foreach($jenis as $j){ ?>
                                    <td><?php echo $this->ReportModel->pendingPo($j['id_jenis_po']); ?></td>
                                    <?php $total=($this->ReportModel->pendingPo($j['id_jenis_po'])) ?>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>