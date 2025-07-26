<div class="row">
    <div class="col-md-12">
       <div class="alert" style="background-color:darkcyan !important;color: white">
           PO yang belum dikirim ke gudang yang proses produksinya lebih dari 1 bulan
       </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode PO</th>
                    <th>Tanggal Potong</th>
                    <th>Posisi PO</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1;?>
                <?php foreach($pendingkirimsudahpotong as $req){?>
                <tr>
                    <td><?php echo $no++?></td>    
                    <td><?php echo $req['kode_po']?></td>    
                    <td><?php echo formatTanggalIndo($req['created_date'])?></td>
                    <td><?php echo $req['posisi']?></td>    
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>