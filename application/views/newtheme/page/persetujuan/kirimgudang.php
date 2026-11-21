<div class="row">
    <div class="col-md-12">
        <div style="margin-bottom: 20px;">
            <div class="row">
                <div class="col-md-6 col-xs-12" style="margin-bottom: 10px;">
                    <a href="<?php echo BASEURL . 'Finishing/pengirimangudang'; ?>" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali ke Pengiriman Gudang</a>
                    <?php if (isset($can_manage_user) && $can_manage_user): ?>
                        <a href="<?php echo BASEURL . 'Persetujuanuser'; ?>" class="btn btn-info btn-sm"><i class="fa fa-users"></i> Atur User Persetujuan</a>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 col-xs-12">
                    <form action="<?php echo BASEURL . 'Persetujuanuser/kirimgudang'; ?>" method="GET" class="form-inline text-right">
                        <div class="input-group" style="width: 100%; max-width: 320px;">
                            <input type="text" name="nofaktur" class="form-control input-sm" placeholder="Cari Nomor Faktur..." value="<?php echo htmlspecialchars($nofaktur); ?>">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Cari</button>
                                <?php if (!empty($nofaktur)): ?>
                                    <a href="<?php echo BASEURL . 'Persetujuanuser/kirimgudang'; ?>" class="btn btn-default btn-sm" title="Reset Pencarian"><i class="fa fa-times"></i></a>
                                <?php endif; ?>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php if (!empty($nofaktur)): ?>
            <p class="text-muted"><i class="fa fa-filter"></i> Menampilkan hasil pencarian nomor faktur: <strong>"<?php echo htmlspecialchars($nofaktur); ?>"</strong></p>
        <?php endif; ?>

        <?php if (empty($list)): ?>
            <div class="alert alert-info" style="margin-top: 15px;">
                <i class="fa fa-info-circle"></i> <?php echo !empty($nofaktur) ? 'Tidak ditemukan surat jalan dengan nomor faktur "' . htmlspecialchars($nofaktur) . '" yang berstatus belum disetujui.' : '<strong>Hebat!</strong> Tidak ada surat jalan kirim gudang yang menunggu persetujuan saat ini.'; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning" style="margin-bottom: 20px;">
                <i class="fa fa-info-circle"></i> Terdapat <strong><?php echo count($list); ?></strong> Surat Jalan Kirim Gudang yang belum disetujui. Silakan periksa rincian PO, jumlah potongan, setoran, dan klik tombol <strong>Setujui</strong> di bawah masing-masing dokumen.
            </div>

            <?php foreach ($list as $doc): ?>
                <?php $f = $doc['faktur']; ?>
                <div class="box box-warning box-solid" style="margin-bottom: 25px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                    <div class="box-header with-border" style="background-color: #f39c12; color: #fff;">
                        <h4 class="box-title" style="font-size: 16px; font-weight: bold;">
                            <i class="fa fa-file-text-o"></i> No. Faktur: <?php echo $f['nofaktur']; ?>
                        </h4>
                        <div class="box-tools pull-right">
                            <span class="label label-danger" style="font-size: 12px; margin-right: 5px;">STATUS: MENUNGGU PERSETUJUAN</span>
                            <span class="badge bg-black"><i class="fa fa-calendar"></i> <?php echo date('d-m-Y', strtotime($f['tanggal_kirim'])); ?></span>
                        </div>
                    </div>
                    <div class="box-body">
                        <!-- Info Header Dokumen -->
                        <div class="row" style="margin-bottom: 10px; padding: 10px 0; background-color: #fafafa; border-radius: 4px; border: 1px solid #eee;">
                            <div class="col-md-4">
                                <strong>Penerima:</strong> <?php echo !empty($f['nama_penerima']) ? $f['nama_penerima'] : '-'; ?><br>
                                <strong>Tujuan:</strong> <?php echo !empty($f['tujuan']) ? $f['tujuan'] : '-'; ?>
                            </div>
                            <div class="col-md-4">
                                <strong>Total Item PO:</strong> <?php echo count($doc['items']); ?> PO<br>
                                <strong>Total Pcs Kirim:</strong> <span class="badge bg-green" style="font-size: 13px;"><?php echo number_format($doc['total_pcs']); ?> Pcs</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="<?php echo BASEURL . 'Notakirim/detail/' . $f['nofaktur']; ?>" target="_blank" class="btn btn-default btn-xs">
                                    <i class="fa fa-eye"></i> Lihat Preview Nota
                                </a>
                            </div>
                        </div>

                        <!-- Tabel Rincian PO -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" style="margin-bottom: 0;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th>Nama PO</th>
                                        <th>Artikel</th>
                                        <th class="text-center" style="background-color: #e8f4f8;">Hasil Potongan (Pcs)</th>
                                        <th class="text-center" style="background-color: #eaf2f8;">Kirim Jahit (Pcs)</th>
                                        <th class="text-center" style="background-color: #fcf3cf;">Setoran CMT (Pcs)</th>
                                        <th class="text-center" style="background-color: #d4efdf;">Kirim Gudang (Pcs)</th>
                                        <th>Keterangan / Rincian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach ($doc['items'] as $it): ?>
                                        <?php 
                                        $po_name = !empty($it['item']['po_kode']) ? $it['item']['po_kode'] : (!empty($it['item']['nama_po']) ? $it['item']['nama_po'] : $it['item']['kode_po']);
                                        $artikel = !empty($it['item']['artikel_po']) ? $it['item']['artikel_po'] : (!empty($it['item']['kode_artikel']) ? $it['item']['kode_artikel'] : '-');
                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td>
                                                <strong style="color: #2c3e50; font-size: 14px;"><?php echo strtoupper($po_name); ?></strong>
                                                <?php if (!empty($it['cmt']['nama_cmt'])): ?>
                                                    <br><small class="text-muted"><i class="fa fa-user"></i> CMT: <?php echo $it['cmt']['nama_cmt']; ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo $artikel; ?></td>
                                            <td class="text-center" style="font-size: 13px; font-weight: bold; background-color: #f7fafc;">
                                                <?php echo number_format($it['potongan']); ?> Pcs
                                            </td>
                                            <td class="text-center" style="font-size: 13px; font-weight: bold; background-color: #f4f8fb;">
                                                <?php echo number_format($it['kirim_jahit']); ?> Pcs
                                            </td>
                                            <td class="text-center" style="font-size: 13px; font-weight: bold; background-color: #fefcf7;">
                                                <?php echo number_format($it['setoran']); ?> Pcs
                                            </td>
                                            <td class="text-center" style="font-size: 13px; font-weight: bold; color: #27ae60; background-color: #f5fbf8;">
                                                <?php echo number_format($it['item']['jumlah_piece_diterima']); ?> Pcs
                                            </td>
                                            <td>
                                                <?php if (!empty($it['item']['keterangan'])): ?>
                                                    <span class="badge bg-gray"><?php echo $it['item']['keterangan']; ?></span><br>
                                                <?php endif; ?>
                                                <?php if (!empty($it['rincian_size'])): ?>
                                                    <small class="text-muted">
                                                        <?php 
                                                        $r_arr = [];
                                                        foreach ($it['rincian_size'] as $rs) {
                                                            $r_arr[] = $rs['rincian_size'] . ": " . $rs['rincian_lusin'] . "dz " . $rs['rincian_piece'] . "pcs";
                                                        }
                                                        echo implode(" | ", $r_arr);
                                                        ?>
                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot style="background-color: #eee; font-weight: bold;">
                                    <tr>
                                        <td colspan="3" class="text-right">TOTAL :</td>
                                        <td class="text-center"><?php echo number_format($doc['total_potongan']); ?> Pcs</td>
                                        <td class="text-center"><?php echo number_format($doc['total_kirim_jahit']); ?> Pcs</td>
                                        <td class="text-center"><?php echo number_format($doc['total_setor']); ?> Pcs</td>
                                        <td class="text-center" style="color: #27ae60;"><?php echo number_format($doc['total_pcs']); ?> Pcs</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- Box Footer: Button Setujui di bawahnya -->
                    <div class="box-footer text-right" style="background-color: #f9f9f9; border-top: 1px solid #eee; padding: 12px 15px;">
                        <?php if ($is_approver): ?>
                            <a href="<?php echo BASEURL . 'Persetujuanuser/approve_action/' . $f['nofaktur'] . '/ditolak'; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Apakah Anda yakin ingin MENOLAK surat jalan nomor faktur <?php echo $f['nofaktur']; ?>?')">
                                <i class="fa fa-times"></i> Tolak Surat Jalan
                            </a>
                            <a href="<?php echo BASEURL . 'Persetujuanuser/approve_action/' . $f['nofaktur'] . '/disetujui'; ?>" 
                               class="btn btn-success btn-lg" 
                               style="font-weight: bold; margin-left: 10px; padding: 8px 25px;"
                               onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI surat jalan nomor faktur <?php echo $f['nofaktur']; ?>?')">
                                <i class="fa fa-check"></i> Setujui Surat Jalan
                            </a>
                        <?php else: ?>
                            <span class="text-muted"><i class="fa fa-lock"></i> Anda tidak memiliki hak akses untuk menyetujui surat jalan ini.</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
