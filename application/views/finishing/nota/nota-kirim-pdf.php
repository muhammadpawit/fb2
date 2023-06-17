<style type="text/css">
  body{text-transform:capitalize;font-size: 12px;font-family: 'Roboto';-webkit-print-color-adjust: exact !important;}
  table{
    font-family: 'Roboto';font-size: 13px !important;width: 100% !important;margin-top: 15px !important;
    border: 1px solid black;border-collapse: collapse;
  }
  .clear{
    clear: both;
  }
  .print{ display:none !important}
  .kiri{
    display: block;
    width: 50%;
    /*border: 1px solid black;*/
    margin-bottom: 40px;
    float: left;
  }
  .logo{
    font-size: 65px;
    float: left;
    display:block;
    font-style: italic;
    
  }
  .slogan{
    font-size: 20px;
    font-style: italic;
    position: relative;
    margin-left: 25%;
    margin-top: 2px;
  }
  .kanan{
    padding: 5px;
    width: 35%;
    border: 1px solid black;
    margin-bottom: 30px;
    float: right;
    margin-top: 10px;
  }
  .yth{
    text-align: center;
    font-weight: bold;
    padding: 20px;
  }
  .judul{
    text-align: center;
    width: 100%;
    font-weight: bold;
    font-size: 22px;
  }
  .nofaktur{
    font-size: 15px;
    width: 50%;
    float: left;
  }
  .susulan{
    font-size: 15px;
    width: 50%;
    float: right;
    /*text-align: right;*/
  }
  .susulan input{
    text-align: right;
    font-size: 18px;
    width: 30%;
  }

  .ttd{
    width: 60%;
    text-align: center;
    text-transform:lowercase !important;
  }

</style>
<div class="kiri">
  <div class="logo">FB</div>
  <div class="slogan">TRUE<br>FORBOYS PRODUCTION</div>
  <div class="clear"></div>
  <div class="alamat">Jl.Z1 No.1 Kampung Baru, Sukabumi Selatan,<br>Kebon Jeruk, Jakarta. HP : 081380401330</div>
</div>
<div class="kanan">
  <div class="kota">
    Jakarta, <?php echo date('d/m/Y') //echo date('d/m/Y',strtotime($gudangfb[0]['tanggal_kirim'] ))?>
  </div>
  <div class="yth">
    Kepada Yth : Gudang FORBOYS<br>H Soleh
  </div>
</div>
<div class="clear"></div>
<div class="judul">
  NOTA KIRIM GUDANG <br>FORBOYS
</div>
<div class="nofaktur">No. Faktur : <strong><?php echo $gudangfb[0]['nofaktur'] ?></strong></div>
<?php if($gudangfb[0]['susulan']==1){?>
<div class="susulan">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Po Susulan <!-- : <input type="checkbox" name="ya" style="text-align: right;">Ya <input type="checkbox" name="ya" style="text-align: right;">Bukan  --></div>
<?php } ?>
<div class="clear"></div>
                          <table class="table mt-4 table-bordered" border="1" cellpadding="5">
                                                    <thead>
                                                    <tr><th>No</th>
                                                        <th>ARTIKEL</th>
                                                        <th>NAMA PO</th>
                                                        <th>RINCIAN PO</th>
                                                        <th>HARGA SATUAN</th>
                                                        <th>JUMLAH</th>
                                                        <th>TOTAL</th>
                                                        <th>KETERANGAN</th>
                                                    </tr></thead>
                                                    <tbody>
                                                        <?php $jumlah = 0;$total=0; ?> 
                                                        <?php foreach ($gudangfb as $key => $gudang): ?>
                                                            <?php
                                                            //$po=$this->GlobalModel->getdataRow('produksi_po','kode_po'=>$gudang['kode_po']);
                                                            ?>
                                                        <tr>
                                                            <td><?php echo $no++?></td>
                                                            <td><?php echo $gudang['artikel_po'] ?></td>
                                                            <td><?php echo $gudang['kode_po'] ?> <?php //echo $gudang['nama_po'] ?></td>
                                                            <td>
                                                                <?php foreach ($dataRinci as $key => $rinci): ?>
                                                                    <?php if ($key == $gudang['kode_po']): ?>
                                                                        <?php foreach ($rinci as $key => $detail): ?>
                                                                        <p><?php echo $detail['rincian_size'] ?> : <?php echo $detail['rincian_lusin'] ?> DZ - <?php echo $detail['rincian_piece'] ?> PC</p>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                                


                                                            </td>
                                                            <td>Rp. <?php echo number_format($gudang['harga_satuan']) ?></td>
                                                            <?php  $jumlah += $gudang['jumlah_piece_diterima'];?>
                                                            <td><?php echo $gudang['jumlah_piece_diterima'] ?></td>
                                                            <td><?php $total += $gudang['harga_satuan'] * $gudang['jumlah_piece_diterima']; echo number_format($gudang['harga_satuan'] * $gudang['jumlah_piece_diterima']) ?></td>
                                                            <td>
                                <?php echo $gudang['keterangan'] ?>
                                                                <?php foreach ($dataRinci as $key => $rinci): ?>
                                                                    <?php if ($key == $gudang['kode_po']): ?>
                                                                        <?php foreach ($rinci as $key => $detail): ?>

                                                                        <p><?php echo $detail['katerangan_gudang_rincian'] ?></p>
                                                                        
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                <?php endforeach ?>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach ?>
                                                        <tr>
                                                            <td colspan="6">G.TOTAL</td>
                                                            <td><?php echo number_format($total) ?></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>


                                            <div class="ttd">
                                              <table class="table table-bordered" border="1">
                                                <tr style="text-align: center;">
                                                    <td width="100px"><b>PIC Gudang</b></td>
                                                    <td width="100px"><b>Adm Finishing</b></td>
                                                    <td width="100px"><b>Driver</b></td>
                                                </tr>
                                                <tr>
                                                    <td valign="bottom" align="center" style="height: 100px">( nama jelas dan ttd )</td>
                                                    <td valign="bottom" align="center" style="height: 100px">( nama jelas dan ttd )</td>
                                                    <td valign="bottom" align="center" style="height: 100px">( nama jelas dan ttd )</td>
                                                </tr>
                                            </table>
                                            </div>                                                