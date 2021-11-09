<div class="row">
    <div class="col-md-12">
        <div class="card" style="background-color: #2a9d5d;color: white">
          <div class="card-header">
            <div class="card-title" style="float:none !important;text-align: center;">
              Monitoring Progress Produksi
            </div>
          </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="alert" style="background-color: #3D6AA2 !important;color: white">Laporan Produksi Berjalan (pcs)</div>
        <table class="table table-bordered ss">
                <thead>
                  <tr>
                     <th>No</th>
                        <th>Nama PO</th>
                        <th>Potongan</th>
                        <th>Pengecekan</th>
                        <th>Sablon</th>
                        <th>Bordir</th>
                        <th>Kirim Jahit</th>
                        <th>Setor Jahit</th>
                        <th>Kirim Gudang</th>
                        <th>Selisih</th>
                  </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $('.ss').DataTable( {
            "ordering": true,
            "searching":true,
            "lengthChange": false,
            "ajax":'<?php echo BASEURL?>Json/monitor',
            responsive: true,
        });

    });
</script>