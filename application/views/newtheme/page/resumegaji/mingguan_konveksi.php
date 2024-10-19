<style>
    thead, th {
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Tanggal Awal</label>
            <input type="text" name="tanggal1" id="tanggal1" class="form-control datepicker" value="<?php echo $tanggal1 ?>" readonly>
        </div>
        <div class="form-group">
            <label for="">Tanggal Awal (Insentif Security)</label>
            <input type="text" name="tanggal11" id="tanggal11" class="form-control datepicker" value="<?php echo $tanggal11 ?>" readonly>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Tanggal Akhir</label>
            <input type="text" name="tanggal2" id="tanggal2" class="form-control datepicker" value="<?php echo $tanggal2 ?>" readonly>
        </div>
        <div class="form-group">
            <label for="">Tanggal Akhir (Insentif Security)</label>
            <input type="text" name="tanggal22" id="tanggal22" class="form-control datepicker" value="<?php echo $tanggal22 ?>" readonly>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Aksi</label><br>
            <button type="button" class="btn btn-sm btn-primary" onclick="fil()">Filter</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <table border="1" style="border-collapse: collapse;width:100%">
                <thead>
                    <tr>
                        <th colspan="4">
                        RESUME GAJI DAN KASBON KARYAWAN KONVEKSI FORBOYS
                        </th>
                    </tr>
                    <tr>
                        <th colspan="4">MINGGUAN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">Periode : <?php echo date('d',strtotime($tanggal1)) ?> - <?php echo date('d F Y',strtotime($tanggal2)) ?></td>
                    </tr>
                    <tr style="text-align: center;font-weight:bold">
                        <td>No</td>
                        <td>Rincian</td>
                        <td>Jumlah</td>
                        <td>Keterangan</td>
                    </tr>
                    <?php $no=1;?>
                    <?php foreach($prods as $p){ ?>
                        <tr>
                            <td align="center"><?php echo $no?></td>
                            <td><?php echo $p['rincian']?></td>
                            <td><?php echo number_format($p['jumlah'])?></td>
                            <td><?php echo $p['ket']?></td>
                        </tr>
                        <?php $no++;?>
                    <?php } ?>
                    <?php foreach($timpotong as $t){ ?>
                        <tr>
                            <td align="center"><?php echo $no++?></td>
                            <td><?php echo $t['nama']?></td>
                            <td><?php echo number_format($t['nominal'])?></td>
                            <td><?php echo $t['keterangan']?></td>
                        </tr>
                        <?php $no++;?>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

  function fil(){
    var url='?';
    var tanggal1 =$("#tanggal1").val();
    var tanggal2 =$("#tanggal2").val();
    if(tanggal1){
      url+='&tanggal1='+tanggal1;
    }
    if(tanggal2){
      url+='&tanggal2='+tanggal2;
    }

    var tanggal11 =$("#tanggal11").val();
    var tanggal22 =$("#tanggal22").val();
    if(tanggal11){
      url+='&tanggal11='+tanggal11;
    }
    if(tanggal22){
      url+='&tanggal22='+tanggal22;
    }


    location =url;
  }

</script>