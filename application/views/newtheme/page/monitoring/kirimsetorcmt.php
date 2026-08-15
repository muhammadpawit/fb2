<div class="row no-print">
	<?php $this->load->view('newtheme/page/modaldetail');?>
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
		<div class="text-center">
			<h3>Monitoring Kirim Setor CMT</h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="alert" style="background-color: #3D6AA2 !important;color: white">Update <?php echo date('d F Y')?></div>
		<table class="table table-bordered">
            <thead>
                    <tr>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
                    </tr>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                    </tr>
                </thead>
            <tbody>
            	<?php $adjkirim=0;$adjdz=0;$adjpcs=0;$spo=0;$sdz=0;$spcs=0; ?>
                <?php $nom=1;$jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($adjustment as $r){?>
            		<tr>
	                    <td><?php echo $nom++?></td>
	                    <td><?php echo $r['nama']?></td>
	                    <td><?php echo number_format($r['kirim_po'])?></td>
	                    <td><?php echo number_format($r['kirim_dz'])?></td>
	                    <td><?php echo number_format($r['kirim_pcs'])?></td>
	                    <td><?php echo number_format($r['setor_po'])?></td>
	                    <td><?php echo number_format($r['setor_dz'])?></td>
	                    <td><?php echo number_format($r['setor_pcs'])?></td>
	                </tr>
	                <?php

	                	$adjkirim+=($r['kirim_po']);
	                	$adjdz+=($r['kirim_dz']);
	                	$adjpcs+=($r['kirim_pcs']);
	                	$spo+=($r['setor_po']);
	                	$sdz+=($r['setor_dz']);
	                	$spcs+=($r['setor_pcs']);
	                ?>
                <?php } ?>

                <?php foreach($rekap as $r){?>
                <tr>
                    <td><?php echo $nom++?></td>
                    <td>
							
						<?php echo  $r['type']?>
							
					</td>
                    <td>
						<a href="#" class="small-box-footer lihat-detail" name="kirim" data-id="<?php echo $r['id']?>">
							<?php echo number_format($r['countkirim'])?>
						</a>
					</td>
                    <td><?php echo number_format($r['qtykirimdz'],2)?></td>
                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
                    <td>
						<a href="#" class="small-box-footer lihat-detail" name="setor" data-id="<?php echo $r['id']?>">
						<?php echo number_format($r['countsetor'])?>
						</a>
					</td>
                    <td><?php echo number_format($r['qtysetordz'],2)?></td>
                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
                </tr>
                <?php
                    $jmlpo1+=($r['countkirim']);
                    $jmlpo2+=($r['countsetor']);
                    $dz1+=($r['qtykirimdz']);
                    $dz2+=($r['qtysetordz']);
                    $pcs1+=($r['qtykirimpcs']);
                    $pcs2+=($r['qtysetorpcs']);
                ?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($jmlpo1+$adjkirim)?></b></td>
                    <td><b><?php echo number_format($dz1+$adjdz,2)?></b></td>
                    <td><b><?php echo number_format($pcs1+$adjpcs)?></b></td>
                    <td><b><?php echo number_format($jmlpo2+$spo)?></b></td>
                    <td><b><?php echo number_format($dz2+$sdz,2)?></b></td>
                    <td><b><?php echo number_format($pcs2+$spcs)?></b></td>
                </tr>
            </tbody>
        </table>
	</div>
	<div class="col-md-2"></div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kemeja</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
	                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
	                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Persentase Setoran</th>
	                    </tr>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $no=1;$jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapkemeja as $r){?>
					<?php if($r['countkirim'] > 0 || $r['countsetor'] > 0){ ?>
	                <tr>
	                    <td><?php echo $no++?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['countkirim'])?></td>
	                    <td><?php echo number_format($r['qtykirimdz'])?></td>
	                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
	                    <td><?php echo number_format($r['countsetor'])?></td>
	                    <td><?php echo number_format($r['qtysetordz'],2)?></td>
	                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
	                    <td align="center"><?php echo $r['qtykirimpcs']>0?number_format(($r['qtysetorpcs']/$r['qtykirimpcs']*100),2):0 ?> %</td>
	                </tr>
					<?php } ?>
	                <?php
	                    $jmlpo1+=($r['countkirim']);
	                    $jmlpo2+=($r['countsetor']);
	                    $dz1+=($r['qtykirimdz']);
	                    $dz2+=($r['qtysetordz']);
	                    $pcs1+=($r['qtykirimpcs']);
	                    $pcs2+=($r['qtysetorpcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($jmlpo1)?></b></td>
	                    <td><b><?php echo number_format($dz1)?></b></td>
	                    <td><b><?php echo number_format($pcs1)?></b></td>
	                    <td><b><?php echo number_format($jmlpo2)?></b></td>
	                    <td><b><?php echo number_format($dz2,2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                    <td align="center"><b><?php echo $pcs1>0 ? number_format(($pcs2/$pcs1*100),2) :0 ?> %</b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Celana</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
	                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
	                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
	                    </tr>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $no=1;$jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapcelana as $r){?>
					<?php if($r['countkirim'] > 0 || $r['countsetor'] > 0){ ?>
	                <tr>
	                    <td><?php echo $no++?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['countkirim'])?></td>
	                    <td><?php echo number_format($r['qtykirimdz'])?></td>
	                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
	                    <td><?php echo number_format($r['countsetor'])?></td>
	                    <td><?php echo number_format($r['qtysetordz'])?></td>
	                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $jmlpo1+=($r['countkirim']);
	                    $jmlpo2+=($r['countsetor']);
	                    $dz1+=($r['qtykirimdz']);
	                    $dz2+=($r['qtysetordz']);
	                    $pcs1+=($r['qtykirimpcs']);
	                    $pcs2+=($r['qtysetorpcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($jmlpo1)?></b></td>
	                    <td><b><?php echo number_format($dz1)?></b></td>
	                    <td><b><?php echo number_format($pcs1)?></b></td>
	                    <td><b><?php echo number_format($jmlpo2)?></b></td>
	                    <td><b><?php echo number_format($dz2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Kaos</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
	                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
	                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
	                    </tr>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $no=1;$jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapkaos as $r){?>
					<?php if($r['countkirim'] > 0 || $r['countsetor'] > 0){ ?>
	                <tr>
	                    <td><?php echo $no++?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['countkirim'])?></td>
	                    <td><?php echo number_format($r['qtykirimdz'])?></td>
	                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
	                    <td><?php echo number_format($r['countsetor'])?></td>
	                    <td><?php echo number_format($r['qtysetordz'])?></td>
	                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $jmlpo1+=($r['countkirim']);
	                    $jmlpo2+=($r['countsetor']);
	                    $dz1+=($r['qtykirimdz']);
	                    $dz2+=($r['qtysetordz']);
	                    $pcs1+=($r['qtykirimpcs']);
	                    $pcs2+=($r['qtysetorpcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($jmlpo1)?></b></td>
	                    <td><b><?php echo number_format($dz1)?></b></td>
	                    <td><b><?php echo number_format($pcs1)?></b></td>
	                    <td><b><?php echo number_format($jmlpo2)?></b></td>
	                    <td><b><?php echo number_format($dz2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
	</div>
</div>
<div class="row no-print">
	<div class="col-md-12">
		<div class="form-group">
			<button class="btn btn-info btn-sm" onclick="window.print()">Print</button>
			<button class="btn btn-info btn-sm" onclick="excelwithtgl()">Excel</button>
		</div>
	</div>
</div>
<script>
	$(document).on("click", ".lihat-detail", function(e) {
    e.preventDefault();

    $("#detailContent").html("Loading...");
    $("#detailModal").modal("show");

    let id = $(this).attr("data-id");
	let proses = $(this).attr("name");

    	$.ajax({
            url: "<?php echo BASEURL ?>Monitoring/kirimsetorjson",   
            type: "GET",
            dataType: "json",
			data:{
				id:id,
				tanggal1:'<?php echo $tanggal1?>',
				tanggal2:'<?php echo $tanggal2?>',
				proses:proses,
			},
            success: function(res) {
                if (res.length > 0) {
                    let html = `
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode PO</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                    `;
                    let no=1;
                    res.forEach(row => {
                        html += `
                            <tr>
                                <td>${no}</td>
                                <td>${row.nama_po}</td>
                                <td>${row.creted_date}</td>
                            </tr>
                        `;
                        no++;
                    });

                    html += `</tbody></table>`;
                    $("#detailContent").html(html);
                } else {
                    $("#detailContent").html("<em>Tidak ada data</em>");
                }
            },
            error: function(xhr) {
                $("#detailContent").html("<span class='text-danger'>Gagal memuat data.</span>");
            }
        });

});
</script>