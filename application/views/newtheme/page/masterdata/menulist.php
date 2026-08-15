<style>
    .menu-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .menu-box-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .menu-box-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .menu-box-title i {
        color: #3c8dbc;
        font-size: 18px;
    }

    .menu-table {
        margin: 0;
        width: 100% !important;
    }

    .menu-table thead th {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e2e8f0 !important;
        padding: 12px 14px !important;
    }

    .menu-table tbody td {
        padding: 11px 14px !important;
        font-size: 13px !important;
        color: #1e293b !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .menu-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .btn-add-menu {
        background-color: #3c8dbc;
        color: #ffffff !important;
        border-radius: 8px;
        padding: 7px 16px;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-add-menu:hover {
        background-color: #2b6cb0;
        box-shadow: 0 2px 4px rgba(60, 141, 188, 0.3);
    }
</style>

<div class="row">
    <div class="col-md-12">
        <?php if ($this->session->flashdata('msg')) { ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <i class="fa fa-check-circle"></i> <?php echo $this->session->flashdata('msg'); ?>
            </div>
        <?php } ?>
    </div>
</div>

<div class="menu-box">
    <div class="menu-box-header">
        <h3 class="menu-box-title">
            <i class="fa fa-sitemap"></i> Kelola Daftar Menu System
        </h3>
        <a href="<?php echo $tambah ?>" class="btn-add-menu">
            <i class="fa fa-plus"></i> Tambah Menu Baru
        </a>
    </div>
    <div class="dash-box-body" style="padding: 20px;">
        <div class="table-responsive">
            <table class="table menu-table" id="datatable-menu-ajax">
                <thead>
                    <tr>
                        <th width="50" class="text-center">No</th>
                        <th>Nama Menu</th>
                        <th>URL Path</th>
                        <th>Lokasi / Hirarki</th>
                        <th width="70" class="text-center">Urutan</th>
                        <th width="140" class="text-center">Icon</th>
                        <th width="130" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data loaded asynchronously via AJAX DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $('#datatable-menu-ajax').DataTable({
        "processing": true,
        "serverSide": false,
        "ajax": {
            "url": "<?php echo BASEURL ?>Masterdata/menujson",
            "type": "GET"
        },
        "columns": [
            { "data": "no", "className": "text-center" },
            { 
                "data": "nama",
                "render": function(data, type, row) {
                    return '<strong style="color:#1e293b;">' + data + '</strong>';
                }
            },
            { 
                "data": "url",
                "render": function(data, type, row) {
                    if(data && data.trim() !== '') {
                        return '<code style="background:#f1f5f9; color:#0284c7; padding:2px 6px; border-radius:4px; font-size:12px;">' + data + '</code>';
                    }
                    return '<span class="text-muted" style="font-size:12px; font-style:italic;">-</span>';
                }
            },
            { 
                "data": "lokasi",
                "render": function(data, type, row) {
                    if (data === 'Menu Utama') {
                        return '<span class="badge" style="background:#3b82f6; color:#fff; font-weight:600; padding:4px 8px; font-size:11px;">' + data + '</span>';
                    }
                    return '<span class="badge" style="background:#f1f5f9; color:#334155; border:1px solid #cbd5e1; font-weight:500; padding:4px 8px; font-size:11px;">' + data + '</span>';
                }
            },
            { "data": "urutan", "className": "text-center" },
            { 
                "data": "icon",
                "className": "text-center",
                "render": function(data, type, row) {
                    var iconClass = data ? data : 'fa fa-bars';
                    return '<i class="' + iconClass + '" style="font-size:15px; color:#0284c7; margin-right:4px;"></i> <small class="text-muted" style="font-size:11px;">(' + iconClass + ')</small>';
                }
            },
            { 
                "data": null,
                "className": "text-center",
                "orderable": false,
                "render": function(data, type, row) {
                    return `
                        <a href="${row.edit}" class="btn btn-warning btn-xs" style="border-radius:4px; font-weight:600;"><i class="fa fa-edit"></i> Edit</a>
                        <a href="${row.delete}" class="btn btn-danger btn-xs" style="border-radius:4px; font-weight:600;" onclick="return confirm('Apakah anda yakin ingin menghapus menu ini?')"><i class="fa fa-trash"></i> Hapus</a>
                    `;
                }
            }
        ],
        "pageLength": 25,
        "language": {
            "search": "Cari Menu:",
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Tidak ada data menu ditemukan",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data menu",
            "infoEmpty": "Tidak ada data menu",
            "infoFiltered": "(disaring dari _MAX_ total data)",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "&gt;",
                "previous": "&lt;"
            }
        }
    });
});
</script>