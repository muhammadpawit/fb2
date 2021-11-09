<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Persediaan_Stok.xls");
?>

					<table border="1" style="width: 100%;border-collapse: collapse;">
						<thead>
                        <tr>
                            <th>Nama barang</th>
                            <th>Warna</th>
                            <th>Ukuran</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($persediaan as $key => $sat): ?>
                            <tr>
                                <td><?php echo strtolower($sat['nama_item']) ?></td>
                                <td><button style="background-color: <?php echo $sat['warna_item'] ?>" class="btn"></button></td>
                                <td>
                                	<?php echo strtolower($sat['warna_item']) ?>
                                </td>
                                <td><?php echo strtolower($sat['ukuran_item']) ?>
                                </td>
                                <td><?php echo strtolower($sat['satuan_ukuran_item']) ?></td>
                                <td><?php echo strtolower($sat['jumlah_item']) ?> <?php echo strtolower($sat['satuan_jumlah_item']) ?></td>
                                <td><?php echo ($sat['harga_item']) ?></td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>