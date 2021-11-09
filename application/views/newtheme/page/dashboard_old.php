<style>
       .container{
        height: 100%;
        align-content: center;
       }

       .image_outer_container{
        margin-top: auto;
        margin-bottom: 5px;
        border-radius: 50%;
        position: relative;
       }

       .image_inner_container{
        border-radius: 50%;
        padding: 5px;
        background: #833ab4; 
        background: -webkit-linear-gradient(to bottom, #fcb045, #fd1d1d, #833ab4); 
        background: linear-gradient(to bottom, #fcb045, #fd1d1d, #833ab4);
        text-align:center;
       }
       .image_inner_container img{
        height: 152px;
        width: 152px;
        border-radius: 50%;
        border: 5px solid white;
       }

       .image_outer_container .green_icon{
         background-color: #4cd137;
         position: absolute;
         right: 30px;
         bottom: 10px;
         height: 30px;
         width: 30px;
         border:5px solid white;
         border-radius: 50%;
       }
</style>

<?php //if(!empty($request) & callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){?>
<?php if(!empty($request)){?>
<div class="row">
    <div class="col-md-7">
       <div class="alert" style="background-color: #3D6AA2 !important;color: white">
           Form Request Otorisasi User
       </div>
        <table class="table table-bordered nosearch">
            <?php foreach($request as $req){?>
            <tr>
                <td><?php echo $req['no']?></td>    
                <td><?php echo $req['tanggal']?></td>    
                <td><?php echo $req['nama']?></td>
                <td><?php echo $req['keterangan']?></td>
                <td>
                    <?php if(callSessUser('id_user')=='10' OR callSessUser('id_user')=='11'){?>
                    <a href="<?php echo $req['setujui']?>" class="btn btn-success btn-xs text-white">Proses</a>
                    <?php }?>
                </td>    
            </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php } ?>
<?php //if(callSessUser('nama_user')=='Pawit'){?>
<div class="row">
    <div class="col-md-12">
        <div class="card" style="background-color: #2a9d8f;color: white">
          <div class="card-header">
            <div class="card-title" style="float:none !important;text-align: center;">
              Monitoring Produksi
            </div>
          </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="alert" style="background-color: #3D6AA2 !important;color: white">Laporan Potongan</div>
        <label>Bulan : <?php echo $bulanberjalan ?></label>
        <table class="table table-bordered">
            <thead>
                    <tr>
                        <th>No</th>
                        <th>Produksi</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>PCS</th>
                    </tr>
                </thead>
            <tbody>
                <?php $pdz=0;$pcs=0;$jmlpo=0;?>
                <?php foreach($potbulanan as $rp){?>
                    <tr>
                        <td><?php echo $rp['no']?></td>
                        <td><?php echo $rp['type']?></td>
                        <td><?php echo $rp['jmlpo']?></td>
                        <td><?php echo number_format($rp['pdz'])?></td>
                        <td><?php echo number_format($rp['ppcs'])?></td>
                    </tr>
                <?php $pdz+=($rp['pdz']);$pcs+=($rp['ppcs']);$jmlpo+=($rp['jmlpo'])?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($jmlpo)?></b></td>
                    <td><b><?php echo number_format($pdz)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                </tr>
            </tbody>
        </table>
    </div>
    
<?php //} ?>
<?php //if(callSessUser('nama_user')=='Pawitx'){?>
<div class="col-md-12">
        <div class="card" style="background-color: #2a9d5d;color: white">
          <div class="card-header">
            <div class="card-title" style="float:none !important;text-align: center;">
              <a href="<?php echo BASEURL.'dash/monitoring_progress';?>" class="text-white">Tampilkan Proses Produksi Keseluruhan</a>
            </div>
          </div>
        </div>
    </div>
<?php //} ?>
<div class="row">
    <?php //if(callSessUser('nama_user')=='Pawit'){?>
    <div class="col-md-7 col-sm-12">
        <div class="card" style="background-color: #0F4B66;color: white">
          <div class="card-header">
            <div class="card-title">
              Rekapan
            </div>
          </div>
        </div>
        <div class="table-responsive">
        <?php //if(callSessUser('nama_user')=='Pawit'){?>
        	 <div class="alert" style="background-color: #3D6AA2 !important;color: white">Kirim & Setor CMT Jahit Mingguan</div>
        	 <label>Periode : <?php echo $tanggals1?> - <?php echo $tanggals2?></label>
	        <table class="table table-bordered">
	            <thead>
	                    <tr>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
	                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
	                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
	                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Keterangan</th>
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
	                <?php $jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
	                <?php foreach($rekapmingguan as $r){?>
	                <tr>
	                    <td><?php echo $r['no']?></td>
	                    <td><?php echo $r['type']?></td>
	                    <td><?php echo number_format($r['countkirim'])?></td>
	                    <td><?php echo number_format($r['qtykirimdz'])?></td>
	                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
	                    <td><?php echo number_format($r['countsetor'])?></td>
	                    <td><?php echo number_format($r['qtysetordz'])?></td>
	                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
	                    <td><?php //echo $r['keterangan']?></td>
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
	                    <td><b><?php echo number_format($jmlpo1)?></b></td>
	                    <td><b><?php echo number_format($dz1)?></b></td>
	                    <td><b><?php echo number_format($pcs1)?></b></td>
	                    <td><b><?php echo number_format($jmlpo2)?></b></td>
	                    <td><b><?php echo number_format($dz2)?></b></td>
	                    <td><b><?php echo number_format($pcs2)?></b></td>
	                    <td></td>
	                </tr>
	            </tbody>
	        </table>
        <?php //} ?>
        <div class="alert" style="background-color: #3D6AA2 !important;color: white">Kirim & Setor CMT</div>
        <table class="table table-bordered">
            <thead>
                    <tr>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">No</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Nama PO</th>
                        <th colspan="3" style="text-align: center;">Kirim CMT</th>
                        <th colspan="3" style="text-align: center;vertical-align: middle;">Setor CMT</th>
                        <th rowspan="3" style="text-align: center;vertical-align: middle;">Keterangan</th>
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
                <?php $jmlpo1=0;$jmlpo2=0;$dz1=0;$dz2=0;$pcs1=0;$pcs2=0; ?>
                <?php foreach($rekap as $r){?>
                <tr>
                    <td><?php echo $r['no']?></td>
                    <td><?php echo $r['type']?></td>
                    <td><?php echo number_format($r['countkirim'])?></td>
                    <td><?php echo number_format($r['qtykirimdz'])?></td>
                    <td><?php echo number_format($r['qtykirimpcs'])?></td>
                    <td><?php echo number_format($r['countsetor'])?></td>
                    <td><?php echo number_format($r['qtysetordz'])?></td>
                    <td><?php echo number_format($r['qtysetorpcs'])?></td>
                    <td><?php //echo $r['keterangan']?></td>
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
                    <td><b><?php echo number_format($jmlpo1)?></b></td>
                    <td><b><?php echo number_format($dz1)?></b></td>
                    <td><b><?php echo number_format($pcs1)?></b></td>
                    <td><b><?php echo number_format($jmlpo2)?></b></td>
                    <td><b><?php echo number_format($dz2)?></b></td>
                    <td><b><?php echo number_format($pcs2)?></b></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <div class="alert" style="background-color: #3D6AA2 !important;color: white">Potongan Minggu Ini</div>
        <label>Periode : <?php echo $tanggal1?> - <?php echo $tanggal2?></label>
        <table class="table table-bordered">
            <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis PO</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>PCS</th>
                    </tr>
                </thead>
            <tbody>
                <?php $pdz=0;$pcs=0;$jmlpo=0;?>
                <?php foreach($potmingguan as $rp){?>
                    <tr>
                        <td><?php echo $rp['no']?></td>
                        <td><?php echo $rp['type']?></td>
                        <td><?php echo $rp['jmlpo']?></td>
                        <td><?php echo number_format($rp['pdz'])?></td>
                        <td><?php echo number_format($rp['ppcs'])?></td>
                    </tr>
                <?php $pdz+=($rp['pdz']);$pcs+=($rp['ppcs']);$jmlpo+=($rp['jmlpo'])?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($jmlpo)?></b></td>
                    <td><b><?php echo number_format($pdz)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                </tr>
            </tbody>
        </table>

        <div class="alert" style="background-color: #3D6AA2 !important;color: white">Potongan Keseluruhan</div>
        <table class="table table-bordered">
            <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis PO</th>
                        <th>Jml PO</th>
                        <th>Dz</th>
                        <th>PCS</th>
                    </tr>
                </thead>
            <tbody>
                <?php $pdz=0;$pcs=0;$jmlpo=0;?>
                <?php foreach($rekappotongan as $rp){?>
                    <tr>
                        <td><?php echo $rp['no']?></td>
                        <td><?php echo $rp['type']?></td>
                        <td><?php echo $rp['jmlpo']?></td>
                        <td><?php echo number_format($rp['pdz'])?></td>
                        <td><?php echo number_format($rp['ppcs'])?></td>
                    </tr>
                <?php $pdz+=($rp['pdz']);$pcs+=($rp['ppcs']);$jmlpo+=($rp['jmlpo'])?>
                <?php } ?>
                <tr>
                    <td colspan="2"><b>Total</b></td>
                    <td><b><?php echo number_format($jmlpo)?></b></td>
                    <td><b><?php echo number_format($pdz)?></b></td>
                    <td><b><?php echo number_format($pcs)?></b></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
    <div style="margin-top: 10px"></div>
    <div class="col-md-5 col-sm-12">
        <?php //if(callSessUser('nama_user')=='Pawit'){?>
        <div class="card" style="background-color: #0F4B66;color: white">
          <div class="card-header">
            <div class="card-title">
              User/Admin yang login hari ini
            </div>
          </div>
        </div>
        <table class="table table-bordered nosearch">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Waktu Login Awal</th>
                    <th>Waktu Logout Terakhir</th>
                    <th>Jml Otorisasi</th>
                </tr>
            </thead>
            <tbody>
                <?php $ln=1?>
                <?php foreach($log as $l){?>
                    <tr>
                        <th><?php echo $ln?></th>
                        <th><?php echo ($ln)==1?'<sup><img src="https://upload.wikimedia.org/wikipedia/commons/9/99/Star_icon_stylized.svg" height="10"></sup>':'<sup><img src="http://simpleicon.com/wp-content/uploads/star.png" height="10"></sup>'?>&nbsp;<?php echo $l['nama']?></th>
                        <th><?php echo date('H:i:s',strtotime($l['login']))?></th>
                        <th><?php echo $l['logout']==null?'':date('H:i:s',strtotime($l['logout']))?></th>
                        <th><?php echo $l['oto']?></th>
                    </tr>
                <?php $ln++; } ?>
            </tbody>
        </table>
        <?php //} ?>
        <div class="card" style="background-color: #0F4B66;color: white">
          <div class="card-header">
            <div class="card-title">
              Laporan Kirim Gudang
            </div>
          </div>
        </div>
        <table class="table table-bordered" id="tableseacrhfalse">
            <thead>
                <tr style="text-align: center;vertical-align: middle !important;">
                    <th>No.</th>
                    <th>Nama PO</th>
                    <th>Jumlah Potong (pcs)</th>
                    <th>Kirim Gudang (pcs)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($allpo as $p){?>
                    <tr>
                        <td><?php echo $p['no']?></td>
                        <td><?php echo $p['namapo']?></td>
                        <td align="center"><?php echo $p['potong']?></td>
                        <td align="center"><?php echo $p['kirimgudang']?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>  
    </div>
<?php //} ?>
</div>
<div class="row">
  <div class="col-md-12">
    <div id="container" style="width:100%; height:400px;"></div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div id="kirimgudang" style="width:100%; height:400px;"></div>
  </div>
</div>
<?php if(myself()['nama_user']=="Pawitx"){?>
<!-- Modal -->
<div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Foto Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
            <form method="post" action="<?php echo base_url()?>Dash/upload" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <input type="file" name="gambar" title="Pilih file gambar anda" class="form-control" required accept="image/*">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="submit" class="btn btn-info btn-sm" value="upload"/>
                        </div>
                    </div>
                </div>
            </form>

      </div>
      <div class="modal-footer">
        <small class="text-red">Pop Up ini akan menghilang ketika anda sudah mengupload foto profile akun anda</small>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
        $('#tableseacrhfalse').dataTable( {
          "lengthChange": false,
          "searching":false,
        });      
    });

  Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Potongan'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories: <?php echo $bulan?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Potongan (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [

    <?php foreach($po as $p){?>
      {
       name:'<?php echo $p['namapo']?>',
         data: [<?php echo implode(",", $p['lusin']) ?>]
     },
     <?php } ?>
    ]
  });

  Highcharts.chart('kirimgudang', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Kirim Gudang'
    },
    subtitle: {
        text: 'www.forboysproduction.com'
    },
    xAxis: {
        categories: <?php echo $bulan?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Kirim (dz)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} dz</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [

    <?php foreach($getPOKirimGudang as $p){?>
      {
       name:'<?php echo $p['namapo']?>',
         data: [<?php echo implode(",", $p['lusin']) ?>]
     },
     <?php } ?>
    ]
  });

  $('#upload').modal({backdrop: 'static', keyboard: false}) ;
  $('#upload').modal('show');

</script>