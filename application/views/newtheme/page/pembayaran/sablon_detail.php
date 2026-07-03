<div class="row">
	<div class="col-md-12 text-right">
		<a href="<?php echo isset($kembali) ? $kembali : BASEURL.'Pembayaran/sablon' ?>" class="btn btn-info btn-sm text-white">Kembali</a>
		<a href="?&excel=1" class="btn btn-success btn-sm text-white"><i class="fa fa-file-excel"></i> Excel</a>
		<a href="?&pdf=1" target="_blank" class="btn btn-danger btn-sm text-white"><i class="fa fa-file-pdf"></i> PDF</a>
	</div>
</div>
<br>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Pembayaran</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td width="30%">Nama CMT</td>
                        <td>: <?php echo $cm['cmt_name'] ?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>: <?php echo format_tanggal($tanggal1) ?> s/d <?php echo format_tanggal($tanggal2) ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Bayar</td>
                        <td>: <?php echo format_tanggal($detail['tanggal_bayar']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Pendapatan</label>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama PO</th>
                    <th>DZ</th>
                    <th>PCS</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $n=1; foreach($pendapatan as $p){ ?>
                <tr>
                    <td><?php echo $n++ ?></td>
                    <td><?php echo $p['kode_po'] ?></td>
                    <td><?php echo number_format($p['dz'], 2) ?></td>
                    <td><?php echo number_format($p['pcs']) ?></td>
                    <td><?php echo number_format($p['harga']) ?></td>
                    <td><?php echo number_format($p['total']) ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <label>Pengeluaran</label>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cat & Afdruk</th>
                    <th>Harian</th>
                    <th>Borongan</th>
                    <th>Lain-lain</th>
                    <th>Listrik</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $n=1; foreach($pengeluaran as $p){ ?>
                <tr>
                    <td><?php echo $n++ ?></td>
                    <td><?php echo number_format($p['belanjacat']) ?></td>
                    <td><?php echo number_format($p['upahtukang_harian']) ?></td>
                    <td><?php echo number_format($p['upahtukang_borongan']) ?></td>
                    <td><?php echo number_format($p['biayalain']) ?></td>
                    <td><?php echo number_format($p['tokenlistrik']) ?></td>
                    <td><?php echo number_format($p['total']) ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <label>Ringkasan Provit</label>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pendapatan</th>
                    <th>Pengeluaran</th>
                    <th>Sewa</th>
                    <th>Provit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo number_format($total_pendapatan) ?></td>
                    <td><?php echo number_format($total_pengeluaran) ?></td>
                    <td><?php echo number_format($sewa) ?></td>
                    <td><?php echo number_format($total_pendapatan - $total_pengeluaran - $sewa) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <label>Potongan Klaim / Kasbon</label>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Type</th>
                    <th>Keterangan</th>
                    <th>Potongan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($claim as $c){ ?>
                <tr>
                    <td><?php echo $c['tanggal'] ?></td>
                    <td><?php echo $c['type'] ?></td>
                    <td><?php echo $c['keterangan'] ?></td>
                    <td><?php echo number_format($c['nominal_potong']) ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">Total Klaim</td>
                    <td><b><?php echo number_format($totalclaim) ?></b></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <label>Komisi & Total Pembayaran</label>
        <table class="table table-bordered">
            <tr>
                <td width="50%">Total Upah Tukang Harian & Borongan</td>
                <td><b><?php echo number_format($total_tukang_borongan) ?></b></td>
            </tr>
            <tr>
                <td>Total Diterima Komisi</td>
                <td><b><?php echo number_format($tjml) ?></b></td>
            </tr>
            <tr>
                <td>Potongan Klaim</td>
                <td style="color:red"><b>- <?php echo number_format($totalclaim) ?></b></td>
            </tr>
            <tr>
                <td>Potongan Pinjaman</td>
                <td style="color:red"><b>- <?php echo number_format(isset($detail['potongan_pinjaman']) ? $detail['potongan_pinjaman'] : 0) ?></b></td>
            </tr>
            <tr style="background-color: #f2f2f2; font-size: 18px;">
                <td><strong>TOTAL DITERIMA KESELURUHAN</strong></td>
                <td><strong>Rp <?php echo number_format($total_tukang_borongan + $tjml - $totalclaim - (isset($detail['potongan_pinjaman']) ? $detail['potongan_pinjaman'] : 0)) ?></strong></td>
            </tr>
        </table>
    </div>
</div>
