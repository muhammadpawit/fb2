<?php if(!empty($prods)){?>
     <input type="hidden" value="<?php echo $prods['tanggal'] ?>" name="tgl">
<div class="row">
    <div class="form-group">
        <table class="table table-bordered">
            <tr>
                <td colspan="3"><b>Nama PO : <?php echo strtoupper($kode_po) ?> <input type="hidden" value="<?php echo strtoupper($kode_po) ?>" name="kode_po"></b></td>
                <td colspan="3"><b>Nama CMT : <?php echo GetName_cmt($cmt)?> <input type="hidden" name="id_cmt" value="<?php echo $cmt?>"></b></td>
            </tr>
            <tr align="center">
                <td>Tanggal</td>
                <td>Jumlah (dz)</td>
                <td>Jumlah (pc)</td>
                <td>Harga (pc)</td>
                <td>Nilai PO</td>
                <td>Ket</td>
            </tr>
            <tr align="center">
                <?php if(isset($kirim)){?>
                    <tr align="center">
                        <td><?php echo $kirim['tanggal']?></td>
                        <td><?php echo ($kirim['pcs']/12)?></td>
                        <td><?php echo ($kirim['pcs'])?></td>
                        <td><?php echo ($kirim['cmt_job_price'])?></td>
                        <td><?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12))?></td>
                        <td>-</td>
                    </tr>
                    <input type="hidden" name="po[0][tanggal]" value="<?php echo $kirim['tanggal']?>">
                    <input type="hidden" name="po[0][dz]" value="<?php echo ($kirim['pcs']/12) ?>">
                    <input type="hidden" name="po[0][pcs]" value="<?php echo ($kirim['pcs']) ?>">
                    <input type="hidden" name="po[0][harga]" value="<?php echo ($kirim['cmt_job_price']) ?>">
                    <input type="hidden" name="po[0][nilaipo]" value="<?php echo ($kirim['cmt_job_price']*($kirim['pcs']/12)) ?>">
                <?php } ?>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <label>Setoran PO CMT</label>
        <table class="table table-bordered">
            <tr>
                <th colspan="2"><center>Masuk</center></th>
                <th colspan="2"><center>Setoran</center></th>
                <th></th>
            </tr>
            <tr align="center">
                <td>Tanggal</td>
                <td>Jumlah (Pc)</td>
                <td>Jumlah (Pc)</td>
                <td>Sisa</td>
                <td>Ket</td>
            </tr>
           
            <?php $allsetor=0;$i=1;?>
            <?php foreach($setor as $s){?>
            <?php $allsetor+=($s['jumlah_pcs_setor']);?>
            <tr align="center">
                <td><input type="hidden" name="setor[<?php echo $i?>][tanggal]" value="<?php echo $s['tanggal']?>"><?php echo $s['tanggal']?></td>
                <td><?php echo $s['jumlah_pcs_kirim']?></td>
                <td><?php echo $s['jumlah_pcs_setor']?></td>
                <td></td>
                <td></td>
            </tr>
            <?php $i++;?>
            <?php } ?>
            <tr align="center">
                <td colspan="3"></td>
                <td><?php echo ($kirim['pcs']-$allsetor)?></td>
                <td></td>
            </tr>
        </table>
    </div>
    <div class="form-group">
        <label>Pembayaran CMT</label>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th><center>Tanggal</center></th>
                <th><center>Rincian Setor (pcs)</center></th>
                <th><center>Kredit</center></th>
                <th><center>Saldo</center></th>
                <th><center>Ket</center></th>
                
            </tr>
            </thead>
            <tbody>
                <?php foreach($pmby as $pm){?>
                    <tr align="center">
                        <td><?php echo $pm['tanggal']?></td>
                        <td><?php echo $pm['rincian']?></td>
                        <td><?php echo $pm['kredit']?></td>
                        <td><?php echo $pm['saldo']?></td>
                        <td><?php echo $pm['keterangan']?></td>
                    </tr>
                <?php } ?>

                <?php if(!empty($history)){ ?>
                    <input type="hidden" name="pelunasan" value="1" class="form-control">
                    <?php $tothis=0;?>
                    <?php foreach($history as $h){ ?>
                        <input type="hidden" name="idpembayaran" value="<?php echo $h['idpembayaran']?>" class="form-control">
                        <tr align="center">
                            <td><?php echo $h['tanggal_pelunasan']?></td>
                            <td><?php echo $h['rincian_pcs']?></td>
                            <td></td>
                            <td><?php echo $h['nominal']?></td>
                            <td><?php echo $h['keterangan']?></td>
                        </tr>
                        <?php $tothis+=$h['nominal'];?>
                    <?php } ?>

                    <?php 
                    $totalat=0;
                    foreach($alat as $a){
                        $totalat+=($a['qty']*$a['harga']);
                    }
                    ?>
                        
                    <tr align="center">
                        <td>
                            Total Yang Harus Dibayar
                        </td>
                        <td>
                        
                        </td>
                        <td></td>
                        <td>
                            <b><?php echo ($tothis-$totalat) ?></b>
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="form-group">
        <label>Pembelian Alat-alat</label>
        <table class="table table-bordered" id="alat">
            <thead>
                <tr>
                    <th><center>Nama Alat</center></th>
                    <th><center>Jumlah</center></th>
                    <th><center>Harga</center></th>
                    <th><center>Total</center></th>
                    <th><center>Keterangan</center></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($alat as $a){?>
                    <tr align="center">
                        <td><?php echo $a['rincian']?></td>
                        <td><?php echo $a['qty']?></td>
                        <td><?php echo $a['harga']?></td>
                        <td><?php echo ($a['qty']*$a['harga']) ?></td>
                        <td><?php echo $a['keterangan']?></td>
                    </tr>
                <?php } ?>
            </tbody>
            
            <tfoot></tfoot>
        </table>
    </div>
    <div class="col-md-12">
        <!-- <div class="form-group">
            <br>PO Yang Dikerjakan<br>
        </div>
        <table class="table table-bordered" id="tbls">
            <thead>
                <tr>
                    <th>Nama PO</th>
                    <th>Potong Pcs</th>
                    <th>Kirim Pcs</th>
                    <th>Setor Dz</th>
                    <th>Setor Pcs</th>
                    <th>Harga/dz</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Keterangan</th>
                    <th>Potongan Pemb.Pertama</th>
                    <th>Dikenakan transport</th>
                    <th align="right">
                        <a onclick="tambah()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $row=0;?>
            
            <tfoot></tfoot>
        </table> -->
        <!-- Potongan Bangke
        <table class="table table-bordered" id="bangke">
            <thead>
                <tr>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan / Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahbangke()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $bangke=0;?>
            
            <tfoot></tfoot>
        </table> -->
        <!-- Pengembalian Bangke
        <table class="table table-bordered" id="kbangke">
            <thead>
                <tr>
                    <th>Nama PO</th>
                    <th>Jumlah Potongan / Bangke</th>
                    <th>Harga/Pcs</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahkembalianbangke()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $bangke=0;?>
            
            <tfoot></tfoot>
        </table> -->
        <!-- Potongan Alat-alat
        <table class="table table-bordered" id="alat">
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahalat()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $bangke=0;?>
            
            <tfoot></tfoot>
        </table> -->
        <!-- Potongan Mesin
        <table class="table table-bordered" id="mesin">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Jumlah</th>
                    <th>Potongan</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahmesin()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $mesin=0;?>
            
            <tfoot></tfoot>
        </table> -->

        <!-- Potongan Vermak
        <table class="table table-bordered" id="vermak">
            <thead>
                <tr>
                    <th>Rincian</th>
                    <th>Jumlah</th>
                    <th>Potongan</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahvermak()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php $vermak=0;?>
            
            <tfoot></tfoot>
        </table> -->
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <a href="<?php echo BASEURL.'Pembayaran/cmtjahit_skb';?>" style="width: 100% !important" class="btn btn-danger text-white">Batalkan</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button onclick="excelwithtgl()" class="btn btn-info" style="width: 100% !important">Cetak</button>
        </div>
    </div>
</div>
<?php } ?>