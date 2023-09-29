<div class="row">
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Awal</label>
			<input type="text" name="tanggal1" id="tanggal1" value="<?php echo $tanggal1?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Tanggal Akhir</label>
			<input type="text" name="tanggal2" id="tanggal2" value="<?php echo $tanggal2?>" class="form-control">
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<label>Aksi</label><br>
			<button class="btn btn-info btn-sm" onclick="filtertglonly()">Filter</button>
		</div>
	</div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="text-center">
                <h4 style="text-decoration: underline;">Resume Monitoring Produksi</h4>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="badge bg-green">Updated <?php echo date('d/m/Y', strtotime($tanggal2)) ?></label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group table-responsive">
            <table class="table table-bordered table-hovered">
                <thead style="font-weight:bold; text-align:center">
                    <tr>
                        <td rowspan="2">No</td>
                        <td rowspan="2">Jenis PO</td>
                        <td colspan="3">Potongan</td>
                        <td colspan="3">Kirim CMT</td>
                        <td colspan="3">Setor CMT</td>
                        <td colspan="3">Kirim Gudang</td>
                        <td colspan="3">PO Beredar</td>
                    </tr>
                    <tr>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                        <td>PO</td>
                        <td>Dz</td>
                        <td>Pcs</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total1=0;
                        $total2=0;
                        $total3=0;
                        $total4=0;
                        $total5=0;
                        $total6=0;
                        $total7=0;
                        $total8=0;
                        $total9=0;
                        $total10=0;
                        $total11=0;
                        $total12=0;
                        $total13=0;
                        $total14=0;
                        $total15=0;
                    ?>
                    <?php foreach($prods as $p){ ?>
                        <tr>
                            <td align="center"><?php echo $p['no']?></td>
                            <td><?php echo $p['type']?></td>
                            <td><?php echo number_format($p['jml_potongan'])?></td>
                            <td><?php echo number_format($p['pcs_potongan']/12,2)?></td>
                            <td><?php echo number_format($p['pcs_potongan'])?></td>
                            <td><?php echo number_format($p['jml_kirim'])?></td>
                            <td><?php echo number_format($p['pcs_kirim']/12,2)?></td>
                            <td><?php echo number_format($p['pcs_kirim'])?></td>
                            <td><?php echo number_format($p['jml_setor'])?></td>
                            <td><?php echo number_format($p['pcs_setor']/12,2)?></td>
                            <td><?php echo number_format($p['pcs_setor'])?></td>
                            <td><?php echo number_format($p['jml_kirim_gudang'])?></td>
                            <td><?php echo number_format($p['pcs_kirim_gudang']/12,2)?></td>
                            <td><?php echo number_format($p['pcs_kirim_gudang'])?></td>
                            <td><?php echo number_format($p['jml_potongan']-$p['jml_kirim_gudang'])?></td>
                            <td><?php echo number_format(($p['pcs_potongan']/12) - ($p['pcs_kirim_gudang']/12),2)?></td>
                            <td><?php echo number_format($p['pcs_potongan']-$p['pcs_kirim_gudang'])?></td>
                        </tr>
                        <?php
                            $total1+=($p['jml_potongan']);
                            $total2+=($p['pcs_potongan']/12);
                            $total3+=($p['pcs_potongan']);
                            $total4+=($p['jml_kirim']);
                            $total5+=($p['pcs_kirim']/12);
                            $total6+=($p['pcs_kirim']);
                            $total7+=($p['jml_setor']);
                            $total8+=($p['pcs_setor']/12);
                            $total9+=($p['pcs_setor']);
                            $total10+=($p['jml_kirim_gudang']);
                            $total11+=($p['pcs_kirim_gudang']/12);
                            $total12+=($p['pcs_kirim_gudang']);
                            $total13+=($p['jml_potongan']-$p['jml_kirim_gudang']);
                            $total14+=(($p['pcs_potongan']/12) - ($p['pcs_kirim_gudang']/12));
                            $total15+=($p['pcs_potongan']-$p['pcs_kirim_gudang']);
                        ?>
                    <?php } ?>
                        <tr style="background-color: #e9bceb;">
                            <td colspan="2"><b>Total</b></td>
                            <td><b><?php echo number_format($total1)?></b></td>
                            <td><b><?php echo number_format($total2)?></b></td>
                            <td><b><?php echo number_format($total3)?></b></td>
                            <td><b><?php echo number_format($total4)?></b></td>
                            <td><b><?php echo number_format($total5)?></b></td>
                            <td><b><?php echo number_format($total6)?></b></td>
                            <td><b><?php echo number_format($total7)?></b></td>
                            <td><b><?php echo number_format($total8)?></b></td>
                            <td><b><?php echo number_format($total9)?></b></td>
                            <td><b><?php echo number_format($total10)?></b></td>
                            <td><b><?php echo number_format($total11)?></b></td>
                            <td><b><?php echo number_format($total12)?></b></td>
                            <td><b><?php echo number_format($total13)?></b></td>
                            <td><b><?php echo number_format($total14)?></b></td>
                            <td><b><?php echo number_format($total15)?></b></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>