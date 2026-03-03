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
			<h3>Monitoring Kirim Gudang</h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="alert" style="background-color: #3D6AA2 !important;color: white">Update <?php echo date('d F Y')?></div>
		<table class="table table-bordered">
            <thead>
                    <tr style="text-align: center;vertical-align: bottom;">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>Pcs</th>
                        <th>Total</th>
                    </tr>
                </thead>
            <tbody>
            	<?php $warna='#05fc37'; $nom=1;$adjpo=0;$adjdz=0;$adjpcs=0;$adjtotal=0;?>
            	<?php foreach($adjustment as $r){?>
					
            		<tr>
	                    <td><?php echo $nom++?></td>
	                    <td><?php echo $r['nama']?></td>
	                    <td>
							<a href="#" class="small-box-footer lihat-detail" data-id="<?php echo $r['id']?>">
								<?php echo number_format($r['po'])?>
							</a>
						</td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                </tr>
	                <?php

	                	$adjpo+=($r['po']);
	                	$adjdz+=($r['dz']);
	                	$adjpcs+=($r['pcs']);
	                	$adjtotal+=($r['total']);
	                ?>
                <?php } ?>

                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekap as $r){?>
					<?php if($r['po'] > 0){ ?>
                <tr>
                    <td><?php echo $nom?></td>
                    <td>
							<a href="#" class="small-box-footer lihat-detail" data-id="<?php echo $r['id']?>">
								<?php echo  $r['type']?>
							</a>
						</td>
                    <td><?php echo number_format($r['po'])?></td>
                    <td><?php echo number_format($r['dz'],2)?></td>
                    <td><?php echo number_format($r['pcs'])?></td>
                    <td><?php echo number_format($r['total'])?></td>
                </tr>
				<?php $nom++;?>
				<?php } ?>
                <?php
                    $po+=($r['po']);
                    $dz+=($r['dz']);
                    $pcs+=($r['pcs']);
                    $total+=($r['total']);
                ?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($adjpo+$po)?></b></td>
                    <td><b><?php echo number_format($adjdz+$dz,2)?></b></td>
                    <td><b><?php echo number_format($adjpcs+$pcs)?></b></td>
                    <td><b><?php echo number_format($adjtotal+$total)?></b></td>
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
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Total</th>
	                        <th>Harga HPP (Dz)</th>
	                        <th>Harga HPP (Pcs)</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0;$nokemeja=1; ?>
	                <?php foreach($rekapkemeja as $r){?>
						<?php 
							$color='';
							if($r['po']>0){
								$color=$warna;
							}
						?>
					<?php if($r['po'] > 0){ ?>
	                <tr style="background-color: <?php echo $color ?>;">
	                    <td><?php echo $nokemeja++ ?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['po'])?></td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                    <td><?php echo number_format($r['hppdz'],2)?></td>
	                    <td><?php echo number_format($r['hpppcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $po+=($r['po']);
	                    $dz+=($r['dz']);
	                    $pcs+=($r['pcs']);
	                    $total+=($r['total']);
	                    $pcs1+=($r['hppdz']);
	                    $pcs2+=($r['hpppcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($po)?></b></td>
	                    <td><b><?php echo number_format($dz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                    <td><b><?php echo number_format($total)?></b></td>
	                    <td><b><?php echo number_format($pcs1,2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                </tr>
	            </tbody>
	        </table>
		</div>
		<div class="form-group">
			<div class="alert" style="background-color: #3D6AA2 !important;color: white;text-align: center;">Celana</div>
			<table class="table table-bordered">
	            <thead>
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Total</th>
	                        <th>Harga HPP (Dz)</th>
	                        <th>Harga HPP (Pcs)</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0;$nocelana=1; ?>
	                <?php foreach($rekapcelana as $r){?>
						<?php 
							$color='';
							if($r['po']>0){
								$color=$warna;
							}
						?>
					<?php if($r['po'] > 0){ ?>
	                <tr style="background-color: <?php echo $color ?>;">
	                    <td><?php echo $nocelana++?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['po'])?></td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                    <td><?php echo number_format($r['hppdz'],2)?></td>
	                    <td><?php echo number_format($r['hpppcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $po+=($r['po']);
	                    $dz+=($r['dz']);
	                    $pcs+=($r['pcs']);
	                    $total+=($r['total']);
	                    $pcs1+=($r['hppdz']);
	                    $pcs2+=($r['hpppcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($po)?></b></td>
	                    <td><b><?php echo number_format($dz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                    <td><b><?php echo number_format($total)?></b></td>
	                    <td><b><?php echo number_format($pcs1,2)?></b></td>
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
	                    <tr style="text-align: center;vertical-align: bottom;">
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Jml PO</th>
	                        <th>Dz</th>
	                        <th>Pcs</th>
	                        <th>Total</th>
	                        <th>Harga HPP (Dz)</th>
	                        <th>Harga HPP (Pcs)</th>
	                    </tr>
	                </thead>
	            <tbody>
	                <?php $po=0;$dz=0;$pcs=0;$total=0;$pcs1=0;$pcs2=0;$nokaos=1; ?>
	                <?php foreach($rekapkaos as $r){?>
						<?php 
							$color='';
							if($r['po']>0){
								$color=$warna;
							}
						?>
					<?php if($r['po'] > 0){ ?>
	                <tr style="background-color: <?php echo $color ?>;">
	                    <td><?php echo $nokaos++ ?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['po'])?></td>
	                    <td><?php echo number_format($r['dz'],2)?></td>
	                    <td><?php echo number_format($r['pcs'])?></td>
	                    <td><?php echo number_format($r['total'])?></td>
	                    <td><?php echo number_format($r['hppdz'],2)?></td>
	                    <td><?php echo number_format($r['hpppcs'])?></td>
	                </tr>
					<?php } ?>
	                <?php
	                    $po+=($r['po']);
	                    $dz+=($r['dz']);
	                    $pcs+=($r['pcs']);
	                    $total+=($r['total']);
	                    $pcs1+=($r['hppdz']);
	                    $pcs2+=($r['hpppcs']);
	                ?>
	                <?php } ?>
	                <tr>
	                    <td colspan="2"><b>Total</b></td>
	                    <td><b><?php echo number_format($po)?></b></td>
	                    <td><b><?php echo number_format($dz,2)?></b></td>
	                    <td><b><?php echo number_format($pcs)?></b></td>
	                    <td><b><?php echo number_format($total)?></b></td>
	                    <td><b><?php echo number_format($pcs1,2)?></b></td>
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
			<button class="btn btn-primary btn-sm" onclick="printpdf()"><i class="fa fa-file-pdf-o"></i> Print PDF</button>
			<button class="btn btn-success btn-sm" onclick="excelwithtgl()"><i class="fa fa-file-excel-o"></i> Excel</button>
		</div>
	</div>
</div>

<!-- Modal PDF -->
<div class="modal fade" id="modal-pdf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 90%; max-width: 1200px;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Preview PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe id="iframe-pdf" src="" style="width: 100%; height: 600px; border: none;"></iframe>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).on("click", ".lihat-detail", function(e) {
    e.preventDefault();

    $("#detailContent").html("Loading...");
    $("#detailModal").modal("show");

    let id = $(this).attr("data-id");

    	$.ajax({
            url: "<?php echo BASEURL ?>Monitoring/kirimgudangjson",   
            type: "GET",
            dataType: "json",
			data:{
				id:id,
				tanggal1:'<?php echo $tanggal1?>',
				tanggal2:'<?php echo $tanggal2?>',
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

function printpdf() {
    var tanggal1 = $("#tanggal1").val();
    var tanggal2 = $("#tanggal2").val();
    var url = "<?php echo BASEURL ?>Monitoring/kirimgudang?pdf=true&tanggal1=" + tanggal1 + "&tanggal2=" + tanggal2;
    $("#iframe-pdf").attr("src", url);
    $("#modal-pdf").modal("show");
}
</script>