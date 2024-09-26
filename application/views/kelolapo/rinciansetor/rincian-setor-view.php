<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Cari PO</label>
            <select name="kode_po" id="kode_po" class="form-control autopoid" data-live-search="true">
                <option value="*">Pilih</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Aksi</label><br>
            <button class="btn btn-primary btn-sm" onclick="filter()">Cari</button>
        </div>
    </div>
</div>
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
                            <tr>
                                <td><?php echo $sat['kode_po'] ?></td>
                                <td><?php echo $sat['nama_cmt'].' ('.$sat['kategori_cmt'].')' ?></td>
                                <td><?php echo $sat['progress'] ?></td>
                                <td style="<?php echo (empty($sat['rincianSetor'])?"background:#94121296;color:white":"background:#17941296;color:white") ?>"><?php echo (empty($sat['rincianSetor'])?"Belum Diproses":"Sudah Diproses") ?></td>
                                <td><?php echo $sat['qty_tot_pcs'] ?></td>
                                <td><?php echo $sat['created_date'] ?></td>
                                <td>
                                    
                                    <?php if(!empty($sat['rincianSetor'])){ ?>
                                    <a href="<?php echo BASEURL.'finishing/editsetoran_susulan/'.$sat['idpo'] ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil">Susulan</i></a>
                                    <?php }else{ ?>
                                        <a href="<?php echo BASEURL.'finishing/produksikaoscmt/'.$sat['idpo'].'/'.$sat['idpo'].'/'.$sat['id_kelolapo_kirim_setor'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil">Proses</i></a>
                                    <?php } ?>
                                    <?php if(aksesedit()==1){?>
                                        <a href="<?php echo BASEURL.'finishing/editsetoran/'.$sat['idpo'] ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil">Edit</i></a>
                                    <?php }else{ ?>
                                        <!-- <a href="<?php echo BASEURL.'finishing/editsetoran/'.$sat['idpo'] ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil">Susulan</i></a> -->
                                    <?php } ?>

                                    <?php if(akseshapus()==1){?>
                                        <?php $cek=$this->GlobalModel->getData('kelolapo_rincian_setor_cmt',array('idpo'=>$sat['idpo']));?>
                                        <?php if(!empty($cek)){ ?>
                                            <a href="<?php echo BASEURL.'finishing/editsetoran_hapus/'.$sat['idpo'] ?>" onclick="return confirm('Apakah yakin akan mereset data ini ? Seluruh data penerimaan akan terhapus') " class="btn btn-danger btn-sm"><i class="fa fa-trash">Reset</i></a>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
     </div>
</div>
<script type="text/javascript">
  function filter(){
    var url='?';
    var tanggal1=$("#tanggal1").val();
    var tanggal2=$("#tanggal2").val();
    var nomesin=$("#kode_po").val();
     var cmt=$("#cmt").val();

    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }

    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    if(nomesin!="*"){
      url+='&kode_po='+nomesin;
    }

    if(cmt!="*"){
      url+='&cmt='+cmt;
    }

    location=url;
  }
</script>