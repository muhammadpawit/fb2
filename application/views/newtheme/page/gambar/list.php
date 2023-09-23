<style>
    /* Mengubah warna latar belakang track (garis latar belakang scroll) */
    ::-webkit-scrollbar-track {
        background-color: #f2f2f2; /* Ganti dengan warna latar belakang yang diinginkan */
    }

    /* Mengubah warna thumb (pegangan scroll) */
    ::-webkit-scrollbar-thumb {
        background-color: #333; /* Ganti dengan warna pegangan scroll yang diinginkan */
    }

    /* Mengubah tampilan umum scroll bar */
    ::-webkit-scrollbar {
        width: 12px; /* Ganti dengan lebar yang diinginkan */
    }

</style>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Nama PO</label>
            <select name="jenis_po" id="jenis_po" class="select2bs4" onchange="fill()">
                <option value="*">Pilih</option>
                <?php foreach($jenis as $j){ ?>
                    <option value="<?php echo $j['nama_jenis_po']?>" <?php echo $jenis_po==$j['nama_jenis_po'] ? 'selected':''; ?>><?php echo $j['nama_jenis_po']?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="timeline-item">
                <div class="timeline-body" style="overflow:scroll;max-height:500px;">
                    <?php foreach($po as $p){ ?>
                        <img src="<?php echo BASEURL.$p['gambar_po']?>" alt="<?php echo $p['kode_po']?>" class="margin" width="150">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function fill(){
        let url='?';

        let jenis=$("#jenis_po").val();
        if(jenis!='*'){
            url +='&jenis_po='+jenis;
        }

        location = url;
    }
</script>