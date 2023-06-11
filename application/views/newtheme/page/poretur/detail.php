<!-- File: application/views/retur/detail.php -->

<!-- ... -->

<form action="<?php echo BASEURL.'Poretur/update/'.$po_retur['id']; ?>" method="POST" id="detailForm">
    <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input type="date" name="tanggal" class="form-control" value="<?php echo $po_retur['tanggal']; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="kode_po">Kode PO</label>
        <input type="text" name="kodepo" class="form-control" value="<?php echo $po_retur['kodepo']; ?>" readonly>
    </div>

    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea name="keterangan" class="form-control"><?php echo $po_retur['keterangan']; ?></textarea>
    </div>

    <div class="form-group">
        <label for="po_retur_detail">PO Retur Detail</label>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Size</th>
                    <th>Jumlah DZ</th>
                    <th>Jumlah PCS</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($po_retur_detail as $key => $detail) { ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td>
                        <input type="hidden" name="prods[<?php echo $key; ?>][id]" class="form-control" value="<?php echo $detail['id']; ?>" hidden>    
                        <input type="text" name="prods[<?php echo $key; ?>][size]" class="form-control" value="<?php echo $detail['size']; ?>" readonly>
                        </td>
                        <td>
                            <input type="number" name="prods[<?php echo $key; ?>][rincian_lusin]" class="form-control" value="<?php echo $detail['jumlah_dz']; ?>" >
                        </td>
                        <td>
                            <input type="number" name="prods[<?php echo $key; ?>][rincian_piece]" class="form-control" value="<?php echo $detail['jumlah_pcs']; ?>" >
                        </td>
                        <td>
                            <textarea name="prods[<?php echo $key; ?>][keterangan]" class="form-control" ><?php echo $detail['keterangan']; ?></textarea>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="col-md-4">
        <button type="submit" class="btn btn-primary full">Update</button>
    </div>
    <div class="col-md-4">
        <a href="<?php echo $batal ?>" class="btn btn-danger full">Batal</a>
    </div>
    <div class="col-md-4">
        <a href="javascript:void(0);" onclick="showGenerateConfirmation()" class="btn btn-success full">Generate Kirim Gudang</a>
    </div>
</form>

<!-- ... -->
<script>
    function showGenerateConfirmation() {
    var faktur = prompt("Masukkan Nomor Faktur Pengiriman:");
    var gudang_tujuan = prompt("Masukkan Gudang Tujuan");
    
    if (faktur) {
        var form = document.getElementById('detailForm');
        var formData = new FormData();

        // Get all form inputs including disabled ones
        var inputs = form.querySelectorAll('input, textarea');
        inputs.forEach(function(input) {
            formData.append(input.name, input.value);
        });

        formData.append('faktur', faktur);
        formData.append('tujuanItem', gudang_tujuan);

        generate_kirim_gudang(formData);
    }
}

function generate_kirim_gudang(formData) {
    $.ajax({
        url: "<?php echo BASEURL.'Poretur/generate_kirim_gudang'; ?>",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log(response);
            if(response>0){
                alert("Berhasil Di Generate");
                location.reload();
            }
        },
        error: function(xhr, status, error) {
            alert("Terjadi kesalahan: " + error);
        }
    });
}

</script>