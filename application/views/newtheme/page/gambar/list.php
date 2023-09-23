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
    <div class="col-md-12">
        <div class="timeline-item">
            <div class="timeline-body" style="overflow:scroll;max-height:500px;">
                <?php foreach($po as $p){ ?>
                    <img src="<?php echo BASEURL.$p['gambar_po']?>" alt="<?php echo $p['kode_po']?>" class="margin">
                <?php } ?>
            </div>
        </div>
    </div>
</div>