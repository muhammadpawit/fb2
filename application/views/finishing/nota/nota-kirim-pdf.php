<html>
  <head>

  </head>
  <body>
    <div class="title">
        <center>
            <h3><?php echo $title ?><br>
            No. Faktur  : <?php echo $gudangfb[0]['nofaktur'] ?>
            </h3>
        </center>
    </div>
    <div class="subtitle">
        <table style="width: 50%;">
            <tr>
                <td>Kepada Yth</td>
                <td>:</td>
                <td><?php echo ucwords(strtolower('Gudang FORBOYS H Soleh'))?></td>
            </tr>
        </table>
    </div>
    <div class="body">
      <table border="1" style="border-collapse: collapse; width: 100%; border-color: #dee2e6 !important; font-size: 9pt !important;" cellpadding="2">
        <thead>
        <tr>
            <th>No</th>
            <th>ARTIKEL</th>
            <th>NAMA PO</th>
            <th>RINCIAN PO</th>
            <th>JUMLAH</th>
            <th>KETERANGAN</th>
        </tr>
        </thead>
        <tbody>
            <?php $jumlah = 0; $no = 1; ?> 
            <?php foreach ($gudangfb as $key => $gudang): ?>
                <?php
                $po = $this->GlobalModel->getdataRow('produksi_po', array('id_produksi_po' => $gudang['kode_po']));
                ?>
            <tr>
                <td style="vertical-align: top; text-align: center;"><?php echo $no++?></td>
                <td style="vertical-align: top;"><?php echo $gudang['artikel_po'] ?></td>
                <td style="vertical-align: top;"><?php echo $po['kode_po'] ?></td>
                <td style="vertical-align: top;">
                    <?php foreach ($dataRinci as $key => $rinci): ?>
                        <?php if ($key == $gudang['kode_po']): ?>
                            <?php foreach ($rinci as $key => $detail): ?>
                            <?php echo $detail['rincian_size'] ?> : <?php echo $detail['rincian_lusin'] ?> DZ - <?php echo $detail['rincian_piece'] ?> PC<br>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </td>
                <?php $jumlah += $gudang['jumlah_piece_diterima']; ?>
                <td style="vertical-align: top; text-align: center;"><?php echo $gudang['jumlah_piece_diterima'] ?></td>
                <td style="vertical-align: top;">
                    <?php echo !empty($gudang['keterangan']) ? $gudang['keterangan'].'<br>' : '' ?>
                    <?php foreach ($dataRinci as $key => $rinci): ?>
                        <?php if ($key == $gudang['kode_po']): ?>
                            <?php foreach ($rinci as $key => $detail): ?>
                            <?php echo !empty($detail['katerangan_gudang_rincian']) ? $detail['katerangan_gudang_rincian'].'<br>' : '' ?>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endforeach ?>
                </td>
            </tr>
            <?php endforeach ?>
            <tr>
                <td colspan="4" style="text-align: right;"><b>TOTAL QTY</b></td>
                <td style="text-align: center;"><b><?php echo number_format($jumlah) ?></b></td>
                <td></td>
            </tr>
        </tbody>
      </table>

      <div class="ttd" style="page-break-inside: avoid; margin-top: 20px;">
        <table class="table table-bordered" border="1" style="border-collapse: collapse; page-break-inside: avoid; width: 100%;">
          <tr>
            <td colspan="5" style="border: none; padding-bottom: 10px;">Jakarta, <?php echo format_tanggal($gudangfb[0]['tanggal_kirim']) ?> </td>
          </tr>
          <tr style="text-align: center; background-color: #f8f9fa;">
            <td width="20%"><b>PIC Gudang Tanah Abang</b></td>
            <td width="20%"><b>PIC Gudang H Sholeh</b></td>
            <td width="20%"><b>Adm Finishing</b></td>
            <td width="20%"><b>Driver</b></td>
            <td width="20%"><b>Security</b></td>
          </tr>
          <tr>
            <td valign="bottom" align="center" style="height: 70px">(....................)</td>
            <td valign="bottom" align="center" style="height: 70px">(....................)</td>
            <td valign="bottom" align="center" style="height: 70px">(....................)</td>
            <td valign="bottom" align="center" style="height: 70px">(....................)</td>
            <td valign="bottom" align="center" style="height: 70px">(....................)</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="registered">
        <i>Registered by Forboys Production System <?php echo format_tanggal_jam(date('d-m-Y H:i:s')); ?></i>
    </div>



                                                
  </body>
</html>