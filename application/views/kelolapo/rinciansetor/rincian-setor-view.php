<div class="row">
     <div class="col-md-12">
         <table class="table table-bordered yessearch">
                        <thead>
                        <tr>
                            <th>NAMA PO</th>
                            <th>NAMA CMT & KAT CMT</th>
                            <th>PROGRESS</th>
                            <th>STATUS</th>
                            <th>Qty (Pcs)</th>
                            <th>CREATED</th>
                            <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php foreach ($rincian as $key => $sat): ?>
                            <tr style="<?php echo (empty($sat['rincianSetor'])?"background:#bb6c5a;":"") ?>">
                                <td><?php echo $sat['kode_po'] ?></td>
                                <td><?php echo $sat['nama_cmt'].' ('.$sat['kategori_cmt'].')' ?></td>
                                <td><?php echo $sat['progress'] ?></td>
                                <td><?php echo (empty($sat['rincianSetor'])?"BELUM":"SUDAH") ?></td>
                                <td><?php echo $sat['qty_tot_pcs'] ?></td>
                                <td><?php echo $sat['created_date'] ?></td>
                                <td>
                                    <a href="<?php echo BASEURL.'finishing/produksikaoscmt/'.$sat['kode_po'] ?>" class="btn btn-warning text-white"><i class="fa fa-pencil">Proses</i></a>

                                    <?php if(aksesedit()==1){?>
                                        <a href="<?php echo BASEURL.'finishing/editsetoran/'.$sat['kode_po'] ?>" class="btn btn-dark text-white"><i class="fa fa-pencil">Edit</i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
     </div>
</div>