<?php
$namafile='Laporan_Inputan_Mesin_Bordir_'.time();
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=".$namafile.".xls");
?>

<table border="1" style="width: 100%;border-collapse: collapse;">
                        <thead>
                        <tr>
                            <th>Nama Operator</th>
                            <th>Mandor</th>
                            <th>No Mesin</th>
                            <th>Nama Po</th>
                            <th>Tanggal Masuk</th>
                            <th>Posisi Bordir</th>
                            <th>Size</th>
                            <th>Stich</th>
                            <th>Qty</th>
                            <th>Total Stich</th>
                            <th>Perkalian</th>
                            <th>Tarif</th>
                            <!-- <th>Selisih</th> -->
                            <th>Kepala</th>
                            <th>Persen</th>
                            <th>Gaji</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($bordir)){?>
                        <?php foreach ($bordir as $bod): ?>
                        <tr>
                            <td><?php echo $bod['operator'] ?></td>
                            <td><?php echo $bod['mandor'] ?></td>
                            <td><?php echo $bod['mesin'] ?></td>
                            <td><?php echo $bod['nama_po'] ?></td>
                            <td><?php echo $bod['created_date'] ?></td>
                            <td><?php echo $bod['bagian_bordir'] ?></td>
                            <td><?php echo $bod['size'] ?></td>
                            <td><?php echo $bod['stich'] ?></td>
                            <td><?php echo $bod['jumlah_naik_mesin'] ?></td>
                            <td><?php echo ($bod['total_stich']) ?></td>
                            <td><?php echo ($bod['perkalian_tarif']) ?></td>
                            <td><?php echo ($bod['total_tarif']) ?></td>
                            <!-- <td><?php echo ($bod['hitung']) ?></td> -->
                            <td><?php echo ($bod['kepala']) ?></td>
                            <td><?php echo ($bod['persen']) ?></td>
                            <td><?php echo ($bod['gaji']) ?></td>
                            <td class="right">
                                <?php foreach ($bod['action'] as $action) { ?>
                                    <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        <?php } ?>
                        </tbody>
                    </table>