<div class="row">
    <div class="col-md-12">
        <div style="margin-bottom: 15px;" class="text-right">
            <a href="<?php echo $tambah; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Tambah User Persetujuan</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped yessearch">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Tipe Persetujuan</th>
                            <th>Status Notifikasi</th>
                            <th>Terdaftar Pada</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($users as $u): ?>
                        <tr>
                            <td class="text-center"><?php echo $no++; ?></td>
                            <td><strong><?php echo $u['nama_user']; ?></strong></td>
                            <td><?php echo $u['email_user']; ?></td>
                            <td><?php echo !empty($u['nama_jabatan']) ? $u['nama_jabatan'] : '-'; ?></td>
                            <td>
                                <span class="badge bg-purple"><?php echo strtoupper($u['tipe']); ?></span>
                            </td>
                            <td>
                                <?php if ($u['aktif'] == 1): ?>
                                    <span class="label label-success"><i class="fa fa-check"></i> Aktif Menerima</span>
                                <?php else: ?>
                                    <span class="label label-danger"><i class="fa fa-times"></i> Non-Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo date('d-m-Y H:i', strtotime($u['created_at'])); ?></td>
                            <td class="text-center">
                                <a href="<?php echo BASEURL . 'Persetujuanuser/toggle/' . $u['id']; ?>" class="btn btn-default btn-xs" title="Toggle Status Aktif">
                                    <i class="fa <?php echo ($u['aktif'] == 1) ? 'fa-eye-slash text-warning' : 'fa-eye text-success'; ?>"></i>
                                </a>
                                <a href="<?php echo BASEURL . 'Persetujuanuser/edit/' . $u['id']; ?>" class="btn btn-warning btn-xs" title="Edit">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a href="<?php echo BASEURL . 'Persetujuanuser/delete/' . $u['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini dari daftar persetujuan?')" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
