<p class="text-muted font-14 m-b-30">
    <?php if ($this->session->flashdata('msg')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <?php echo $this->session->flashdata('msg'); ?> 
    </div>
    <?php } ?>
</p>
<form method="post" action="<?php echo $action?>">
<input type="hidden" name="id" value="<?php echo $pembayaran['id']?>">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">    
            <label>Tanggal</label>
            <input type="date" name="tanggal" value="<?php echo date('Y-m-d', strtotime($pembayaran['tanggal']))?>" class="form-control" required="required">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Cmt</label>
            <select name="cmt" id="cmt" class="form-control select2bs4 byrcmt" onchange="ubahcmt()" data-live-search="true" required="required">
                <option value="*">Pilih</option>
                <?php foreach($cmt as $c){?>
                    <option value="<?php echo $c['id_cmt']?>" <?php echo ($c['id_cmt'] == $pembayaran['idcmt']) ? 'selected' : ''; ?>><?php echo strtolower($c['cmt_name'])?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Metode Pengiriman</label>
            <select name="metode" class="form-control">
                <option value="1" <?php echo ($pembayaran['metode_pengiriman'] == 1) ? 'selected' : ''; ?>>Diambil</option>
                <option value="2" <?php echo ($pembayaran['metode_pengiriman'] == 2) ? 'selected' : ''; ?>>Dikirim oleh CMT</option>
            </select>
            <input type="hidden" name="potongan_bangke" class="form-control" value="<?php echo $pembayaran['potongan_bangke']?>">
            <input type="hidden" name="pengembalian_bangke" class="form-control" value="<?php echo $pembayaran['pengembalian_bangke']?>">
            <input type="hidden" name="biaya_transport" class="form-control" value="<?php echo $pembayaran['biaya_transport']?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label><input type="radio" name="pot_pinjaman" value="1" <?php echo ($pot_pinjaman_type == 1) ? 'checked' : ''; ?>> Potongan Pinjaman</label>
            <label><input type="radio" name="pot_pinjaman" value="2" <?php echo ($pot_pinjaman_type == 2) ? 'checked' : ''; ?>> Potongan Claim</label>
            <input type="number" id="potongan_lainnya" name="potongan_lainnya" class="form-control" value="<?php echo $pembayaran['potongan_lainnya']?>">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Trip Ke-</label>
            <select name="tripke" class="form-control" required>
                <option value="">Pilih</option>
                <option value="1" <?php echo ($pembayaran['tripke'] == 1) ? 'selected' : ''; ?>>1</option>
                <option value="2" <?php echo ($pembayaran['tripke'] == 2) ? 'selected' : ''; ?>>2</option>
            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Keterangan</label>
            <input type="hidden" name="totalbayar" id="totalbayar" class="form-control" value="<?php echo $pembayaran['total']?>" readonly="readonly">
            <input type="text" name="keterangan" class="form-control" value="<?php echo htmlspecialchars($pembayaran['keterangan'] ?? ''); ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Potongan Transport</label>
            <select name="pot_transport" id="sub1" class="form-control" data-live-search="true">
                <option value="0-0">0</option>
                <?php if(!empty($transport_options)){ ?>
                    <?php foreach($transport_options as $to){ ?>
                        <?php 
                            $val = $to['id'].'-'.$to['biaya_transport'];
                            $sel = ($pembayaran['transport_dari_id'] == $to['id']) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $val; ?>" <?php echo $sel; ?>>
                            <?php echo date('d/m/Y', strtotime($to['tanggal'])).' '.$to['biaya_transport']; ?>
                        </option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
            <br><b>PO Yang Dikerjakan</b><br>
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
            <?php 
            $row = 0;
            if(!empty($products)){
                foreach($products as $p){
                    $current_pct = 1;
                    if (preg_match('/(\d+)\s*%/', $p['keterangan'] ?? '', $matches)) {
                        $current_pct = ((float)$matches[1]) / 100;
                    }
            ?>
            <tbody data-parent="0" id="product-row<?php echo $row?>" data="<?php echo $row?>">
                <tr>
                    <td>
                        <input type="hidden" class="jumlahDz" name="products[<?php echo $row?>][jumlah_po_dz]" value="<?php echo $p['jumlah_po_dz']?>" required>
                        <input type="hidden" class="jumlahPc" name="products[<?php echo $row?>][jumlah_po_pcs]" value="<?php echo $p['jumlah_po_pcs']?>" required>
                        <select type="text" class="select2 select2bs4 kodepo" name="products[<?php echo $row?>][kode_po]" data-size="4" data-live-search="true" data-style="btn-success" data-title="Pilih item" required style="width: 150px !important;">
                            <option value="">Pilih</option>
                            <?php foreach ($kodepo as $key => $po) { ?>
                                <option value="<?php echo $po['id_produksi_po'] ?>" data-item="<?php echo $po['id_produksi_po'] ?>" <?php echo ($po['id_produksi_po'] == $p['kode_po'] || $po['kode_po'] == $p['kode_po']) ? 'selected' : ''; ?>>
                                    <?php echo $po['nama_po'].' '.$po['kode_po'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" size="4" class="potongan" value="<?php echo $p['potongan']?>" name="products[<?php echo $row?>][potongan]" onblur="updatepcs(<?php echo $row?>)" readonly></td>
                    <td><input type="text" size="4" class="kirimpcs" value="<?php echo $p['kirimpcs']?>" name="products[<?php echo $row?>][kirimpcs]" onblur="updatepcs(<?php echo $row?>)" readonly></td>
                    <td><input type="hidden" class="dz" value="<?php echo $p['jumlah_dz']?>" name="products[<?php echo $row?>][dz]" onblur="updatedz(<?php echo $row?>)" readonly><input type="text" size="4" class="jumlahDz" value="<?php echo $p['jumlah_dz']?>" name="products[<?php echo $row?>][jumlah_dz]" readonly></td>
                    <td><input type="text" size="4" class="jumlahPc pcs" value="<?php echo $p['jumlah_pcs']?>" name="products[<?php echo $row?>][jumlah_pcs]" onblur="updatepcs(<?php echo $row?>)" required></td>
                    <td><input type="text" size="5" class="harga" value="<?php echo $p['harga']?>" name="products[<?php echo $row?>][harga]"></td>
                    <td><input type="text" size="10" class="total" value="<?php echo $p['total']?>" name="products[<?php echo $row?>][total]" readonly></td>
                    <td>
                        <select name="products[<?php echo $row?>][percent]" class="pmb" style="width: 50px;">
                            <option value="">Pilih</option>
                            <option value="1" <?php echo ($current_pct == 1) ? 'selected' : ''; ?>>100%</option>
                            <option value="0.9" <?php echo ($current_pct == 0.9) ? 'selected' : ''; ?>>90%</option>
                            <option value="0.8" <?php echo ($current_pct == 0.8) ? 'selected' : ''; ?>>80%</option>
                            <option value="0.7" <?php echo ($current_pct == 0.7) ? 'selected' : ''; ?>>70%</option>
                            <option value="0.5" <?php echo ($current_pct == 0.5) ? 'selected' : ''; ?>>50%</option>
                            <option value="0.4" <?php echo ($current_pct == 0.4) ? 'selected' : ''; ?>>40%</option>
                            <option value="0.3" <?php echo ($current_pct == 0.3) ? 'selected' : ''; ?>>30%</option>
                            <option value="0.2" <?php echo ($current_pct == 0.2) ? 'selected' : ''; ?>>20%</option>
                            <option value="0.1" <?php echo ($current_pct == 0.1) ? 'selected' : ''; ?>>10%</option>
                            <option value="0" <?php echo ($current_pct === 0.0 || $current_pct === 0) ? 'selected' : ''; ?>>0%</option>
                        </select>
                    </td>
                    <td><textarea class="keterangan" name="products[<?php echo $row?>][keterangan]" cols="10" rows="5"><?php echo $p['keterangan']?></textarea></td>
                    <td>
                        <span class="pot1"><?php echo (!empty($p['potpertama']) && $p['potpertama'] > 0) ? $p['potpertama'].' <br>('.$p['popembayaran'].')' : ''; ?></span>
                        <select type="text" style="width:80px" class="select2 potpertama" data-id="<?php echo $row?>" name="products[<?php echo $row?>][potpertama]" data-size="4" data-live-search="true" data-title="Pilih item" required>
                            <?php if(!empty($p['potpertama']) && $p['potpertama'] > 0){ ?>
                                <option value="<?php echo $p['potpertama'].','.$p['idpembayaranpertama'].','.$p['popembayaran']; ?>" selected><?php echo $p['potpertama'].' ('.$p['popembayaran'].')'; ?></option>
                                <option value="0">0</option>
                            <?php } else { ?>
                                <option value="0" selected>0</option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select type="text" style="width: 50px;" class="select2" data-id="<?php echo $row?>" name="products[<?php echo $row?>][trans]" data-size="4" data-live-search="true" data-title="Pilih item" required>
                            <option value="1" <?php echo ($p['trans'] == 1) ? 'selected' : ''; ?>>Ya</option>
                            <option value="2" <?php echo ($p['trans'] == 2) ? 'selected' : ''; ?>>Tidak</option>
                        </select>
                    </td>
                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>
                </tr>
            </tbody>
            <?php 
                    $row++;
                }
            }
            ?>
            <tfoot></tfoot>
        </table>

        <b>Potongan Bangke</b>
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
            <?php 
            $b_row = 0;
            if(!empty($bangke)){
                foreach($bangke as $b){
            ?>
            <tbody data-parent="0" id="bangke-row<?php echo $b_row?>" data="<?php echo $b_row?>">
                <tr>
                    <td>
                        <select type="text" class="form-control select2bs4 kodepo" name="bangke[<?php echo $b_row?>][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required>
                            <?php foreach ($kodepo as $key => $po) { ?>
                                <option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>" <?php echo ($po['kode_po'] == $b['kode_po']) ? 'selected' : ''; ?>>
                                    <?php echo $po['nama_po'].' '.$po['kode_po'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="bangke[<?php echo $b_row?>][qty]" value="<?php echo $b['qty']?>" required></td>
                    <td><input type="text" class="form-control" name="bangke[<?php echo $b_row?>][harga]" value="<?php echo $b['harga']?>" required></td>
                    <td><input type="text" class="form-control" name="bangke[<?php echo $b_row?>][keterangan]" value="<?php echo htmlspecialchars($b['keterangan'] ?? ''); ?>" required></td>
                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>
                </tr>
            </tbody>
            <?php 
                    $b_row++;
                }
            }
            ?>
            <tfoot></tfoot>
        </table>

        <b>Pengembalian Bangke</b>
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
            <?php 
            $kb_row = 0;
            if(!empty($kembalianbangke)){
                foreach($kembalianbangke as $kb){
            ?>
            <tbody data-parent="0" id="kbangke-row<?php echo $kb_row?>" data="<?php echo $kb_row?>">
                <tr>
                    <td>
                        <select type="text" class="form-control select2bs4 kodepo" name="kembalianbangke[<?php echo $kb_row?>][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required>
                            <?php foreach ($kodepo as $key => $po) { ?>
                                <option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>" <?php echo ($po['kode_po'] == $kb['kode_po']) ? 'selected' : ''; ?>>
                                    <?php echo $po['nama_po'].' '.$po['kode_po'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="kembalianbangke[<?php echo $kb_row?>][qty]" value="<?php echo $kb['qty']?>" required></td>
                    <td><input type="text" class="form-control" name="kembalianbangke[<?php echo $kb_row?>][harga]" value="<?php echo $kb['harga']?>" required></td>
                    <td><input type="text" class="form-control" name="kembalianbangke[<?php echo $kb_row?>][keterangan]" value="<?php echo htmlspecialchars($kb['keterangan'] ?? ''); ?>" required></td>
                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>
                </tr>
            </tbody>
            <?php 
                    $kb_row++;
                }
            }
            ?>
            <tfoot></tfoot>
        </table>

        <b>Potongan Alat-alat</b>
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
            <?php 
            $alat_row = 0;
            if(!empty($alat)){
                foreach($alat as $a){
            ?>
            <tbody data-parent="0" id="alat-row<?php echo $alat_row?>" data="<?php echo $alat_row?>">
                <tr>
                    <td>
                        <?php if(isset($a['id_distribusi']) && !empty($a['id_distribusi'])){ ?>
                            <input type="hidden" class="form-control" name="alat[<?php echo $alat_row?>][id_distribusi]" value="<?php echo $a['id_distribusi']?>">
                        <?php } ?>
                        <select type="text" class="form-control select2bs4 alat" name="alat[<?php echo $alat_row?>][rincian]" data-size="4" data-live-search="true" data-title="Pilih item" required>
                            <option value="">Pilih</option>
                            <?php foreach ($product as $key => $po) { ?>
                                <option value="<?php echo $po['nama'] ?>" data-item="<?php echo $po['product_id'] ?>" <?php echo ($po['nama'] == $a['rincian']) ? 'selected' : ''; ?>>
                                    <?php echo $po['nama'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="alat[<?php echo $alat_row?>][qty]" value="<?php echo $a['qty']?>" required></td>
                    <td><input type="text" class="form-control hargaalat" name="alat[<?php echo $alat_row?>][harga]" value="<?php echo $a['harga']?>" required></td>
                    <td><input type="text" class="form-control" name="alat[<?php echo $alat_row?>][keterangan]" value="<?php echo htmlspecialchars($a['keterangan'] ?? ''); ?>" required></td>
                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>
                </tr>
            </tbody>
            <?php 
                    $alat_row++;
                }
            }
            ?>
            <tfoot></tfoot>
        </table>

        <b>Potongan Mesin</b>
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
            <?php 
            $m_row = 0;
            if(!empty($mesin)){
                foreach($mesin as $m){
            ?>
            <tbody data-parent="0" id="mesin-row<?php echo $m_row?>" data="<?php echo $m_row?>">
                <tr>
                    <td><input type="text" class="form-control" name="mesin[<?php echo $m_row?>][rincian]" value="<?php echo htmlspecialchars($m['rincian'] ?? ''); ?>" required></td>
                    <td><input type="text" class="form-control" name="mesin[<?php echo $m_row?>][qty]" value="<?php echo $m['qty']?>" required></td>
                    <td><input type="text" class="form-control" name="mesin[<?php echo $m_row?>][harga]" value="<?php echo $m['harga']?>" required></td>
                    <td><input type="text" class="form-control" name="mesin[<?php echo $m_row?>][keterangan]" value="<?php echo htmlspecialchars($m['keterangan'] ?? ''); ?>" required></td>
                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>
                </tr>
            </tbody>
            <?php 
                    $m_row++;
                }
            }
            ?>
            <tfoot></tfoot>
        </table>

        <b>Potongan Vermak</b>
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
            <?php 
            $v_row = 0;
            if(!empty($vermak)){
                foreach($vermak as $v){
            ?>
            <tbody data-parent="0" id="vermak-row<?php echo $v_row?>" data="<?php echo $v_row?>">
                <tr>
                    <td><input type="text" class="form-control" name="vermak[<?php echo $v_row?>][rincian]" value="<?php echo htmlspecialchars($v['rincian'] ?? ''); ?>" required></td>
                    <td><input type="text" class="form-control" name="vermak[<?php echo $v_row?>][qty]" value="<?php echo $v['qty']?>" required></td>
                    <td><input type="text" class="form-control" name="vermak[<?php echo $v_row?>][harga]" value="<?php echo $v['harga']?>" required></td>
                    <td><input type="text" class="form-control" name="vermak[<?php echo $v_row?>][keterangan]" value="<?php echo htmlspecialchars($v['keterangan'] ?? ''); ?>" required></td>
                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>
                </tr>
            </tbody>
            <?php 
                    $v_row++;
                }
            }
            ?>
            <tfoot></tfoot>
        </table>

        <b>Tambahan Lainnya</b>
        <table class="table table-bordered" id="tambahlainnya">
            <thead>
                <tr>
                    <th>Nominal (Rp)</th>
                    <th>Keterangan</th>
                    <th align="right">
                        <a onclick="tambahlainnya()" class="btn btn-success btn-sm text-white"><i class="fa fa-plus"></i></a>
                    </th>
                </tr>
            </thead>
            <?php 
            $tl_row = 0;
            if(!empty($tambahan)){
                foreach($tambahan as $tl){
            ?>
            <tbody data-parent="0" id="tambahan-row<?php echo $tl_row?>" data="<?php echo $tl_row?>">
                <tr>
                    <td><input type="text" class="form-control" name="tambahan[<?php echo $tl_row?>][nominal]" value="<?php echo $tl['nominal']?>" required></td>
                    <td><input type="text" class="form-control" name="tambahan[<?php echo $tl_row?>][keterangan]" value="<?php echo htmlspecialchars($tl['keterangan'] ?? ''); ?>" required></td>
                    <td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td>
                </tr>
            </tbody>
            <?php 
                    $tl_row++;
                }
            }
            ?>
            <tfoot></tfoot>
        </table>
    </div>
</div>
<div class="row" style="margin-top: 20px;">
    <div class="col-md-6">
        <div class="form-group">
            <a href="<?php echo BASEURL.'Pembayaran/cmtjahit';?>" style="width: 100% !important" class="btn btn-danger text-white">Batalkan</a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <button type="submit" class="btn btn-info" style="width: 100% !important">Simpan Perubahan</button>
        </div>
    </div>
</div>
</form>

<script type="text/javascript">
    var i = <?php echo $row; ?>;
    var j = <?php echo $b_row; ?>;
    var k = <?php echo $kb_row; ?>;
    var l = <?php echo $alat_row; ?>;
    var m = <?php echo $m_row; ?>;
    var v = <?php echo $v_row; ?>;
    var tl = <?php echo $tl_row; ?>;

    function initPotpertama(element) {
        var cmts = $('select[name=\'cmt\']').val();
        element.select2({
            ajax: {
                url: "<?php echo BASEURL?>Pembayaran/caripembayaran",
                dataType: 'json',
                data: function (params) {
                    return {
                        po: params.term,
                        cmt: cmts,
                    };
                },
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
            }
        }).on("select2:select", function(e){
            var id = $(this).val();
            var s = id.split(",");
            var dai = $(this).closest('tr');
            dai.find(".pot1").html(s[0] + ' <br>(' + s[2] + ')');
        });
    }

    $(document).ready(function(){
        $('.select2bs4').select2();
        $('.potpertama').each(function(){
            initPotpertama($(this));
        });
        update();
    });

    function tambah(){
        var cmts = $('select[name=\'cmt\']').val();
        if(cmts == "*"){
            alert("Mohon cmt dipilih terlebih dahulu");
            return false;
        }
        var html = '<tbody data-parent="0" id="product-row' + i + '" data="' + i + '"><tr>';
        html += '<td><input type="hidden" class="jumlahDz" name="products[' + i + '][jumlah_po_dz]" required><input type="hidden" class="jumlahPc" name="products[' + i + '][jumlah_po_pcs]" required><select type="text" class="select2 select2bs4 kodepo" name="products[' + i + '][kode_po]" data-size="4" data-live-search="true" data-style="btn-success" data-title="Pilih item" required style="width: 150px !important;"><option value="">Pilih</option><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['id_produksi_po'] ?>" data-item="<?php echo $po['id_produksi_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" size="4" class="potongan" value="0" name="products[' + i + '][potongan]" onblur="updatepcs(' + i + ')" readonly></td>';
        html += '<td><input type="text" size="4" class="kirimpcs" name="products[' + i + '][kirimpcs]" onblur="updatepcs(' + i + ')" readonly></td>';
        html += '<td><input type="hidden" class="dz" name="products[' + i + '][dz]" onblur="updatedz(' + i + ')" readonly><input type="text" size="4" class="jumlahDz" name="products[' + i + '][jumlah_dz]" readonly></td>';
        html += '<td><input type="text" size="4" class="jumlahPc pcs" name="products[' + i + '][jumlah_pcs]" onblur="updatepcs(' + i + ')" required></td>';
        html += '<td><input type="text" size="5" class="harga" name="products[' + i + '][harga]"></td>';
        html += '<td><input type="text" size="10" class="total" name="products[' + i + '][total]" readonly></td>';
        html += '<td><select name="products[' + i + '][percent]" class="pmb" required style="width: 50px;"><option value="">Wajib dipilih</option><option value="1">100%</option><option value="0.9">90%</option><option value="0.8">80%</option><option value="0.7">70%</option><option value="0.5">50%</option><option value="0.4">40%</option><option value="0.3">30%</option><option value="0.2">20%</option><option value="0.1">10%</option><option value="0">0%</option></select></td>';
        html += '<td><textarea class="keterangan" name="products[' + i + '][keterangan]" cols="10" rows="5"></textarea></td>';
        html += '<td><span class="pot1"></span><select type="text" style="width:80px" class="select2 potpertama" data-id="' + i + '" name="products[' + i + '][potpertama]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="0" selected>0</option></select></td>';
        html += '<td><select type="text" style="width: 50px;" class="select2" data-id="' + i + '" name="products[' + i + '][trans]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="1" selected>Ya</option><option value="2">Tidak</option></select></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html += '</tr></tbody>';
        $("#tbls tfoot").before(html);
        $('#product-row' + i + ' .select2bs4').select2();
        initPotpertama($('#product-row' + i + ' .potpertama'));
        i++;
    }

    $(document).on('change', '.pmb', function(e){
        var dataItem = $(this).find(':selected').val();
        var dai = $(this).closest('tr');
        var pcs = dai.find(".pcs").val();
        var harga = dai.find(".harga").val();
        var dz = parseFloat((pcs/12).toFixed(2));
        var hasil = dz * harga * dataItem;
        dai.find(".keterangan").val("Pembayaran " + Number(dataItem * 100) + " %");
        dai.find(".total").val(hasil.toFixed(2));
        update();
    });

    function ubahcmt() {
        var info = window.location.origin;
        var uri = (info == 'http://localhost') ? window.location.origin + '/fb2/Json/' : window.location.origin + '/Json/';
        var cmts = $('select[name=\'cmt\']').val();

        $.get(uri + 'checkpinjaman?&cmt=' + cmts, function(data){   
            if(data == ''){
                $('#potongan_lainnya').val(0);
                $("input[name=pot_pinjaman][value=2]").prop('checked', true);
            }else{
                $('#potongan_lainnya').val(data);
                $("input[name=pot_pinjaman][value=1]").prop('checked', true);
            }
        });

        $.get(uri + 'cekpotonganalat?&cmt=' + cmts, function(data){   
            var obj = JSON.parse(data);  
            $.each(obj, function(index, item) {
                var html = '<tbody data-parent="0" id="alat-row' + l + '" data="' + l + '"><tr>';
                html += '<td><input type="hidden" class="form-control" name="alat[' + l + '][id_distribusi]" value="' + item.id + '" required><input type="text" class="form-control" name="alat[' + l + '][rincian]" value="' + item.nama_item + '" required></td>';
                html += '<td><input type="text" class="form-control" name="alat[' + l + '][qty]" value="' + item.jumlah + '" required></td>';
                html += '<td><input type="text" class="form-control" name="alat[' + l + '][harga]" value="' + item.harga_item + '" required></td>';
                html += '<td><input type="text" class="form-control" name="alat[' + l + '][keterangan]" value="' + item.keterangan + '" required></td>';
                html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
                html += '</tr></tbody>';
                l++;
                $("#alat tfoot").before(html);
            });            
        });
    }

    function tambahbangke(){
        var html = '<tbody data-parent="0" id="bangke-row' + j + '" data="' + j + '"><tr>';
        html += '<td><select type="text" class="form-control select2bs4 kodepo" name="bangke[' + j + '][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control" name="bangke[' + j + '][qty]" required></td>';
        html += '<td><input type="text" class="form-control" name="bangke[' + j + '][harga]" required></td>';
        html += '<td><input type="text" class="form-control" name="bangke[' + j + '][keterangan]" value="-" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html += '</tr></tbody>';
        $("#bangke tfoot").before(html);
        $('#bangke-row' + j + ' .select2bs4').select2();
        j++;
    }

    function tambahkembalianbangke(){
        var html = '<tbody data-parent="0" id="kbangke-row' + k + '" data="' + k + '"><tr>';
        html += '<td><select type="text" class="form-control select2bs4 kodepo" name="kembalianbangke[' + k + '][kode_po]" data-size="4" data-live-search="true" data-title="Pilih item" required><?php foreach ($kodepo as $key => $po) { ?><option value="<?php echo $po['kode_po'] ?>" data-item="<?php echo $po['kode_po'] ?>"><?php echo $po['nama_po'].' '.$po['kode_po'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control" name="kembalianbangke[' + k + '][qty]" required></td>';
        html += '<td><input type="text" class="form-control" name="kembalianbangke[' + k + '][harga]" required></td>';
        html += '<td><input type="text" class="form-control" name="kembalianbangke[' + k + '][keterangan]" value="-" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html += '</tr></tbody>';
        $("#kbangke tfoot").before(html);
        $('#kbangke-row' + k + ' .select2bs4').select2();
        k++;
    }

    function tambahalat(){
        var cmts = $('select[name=\'cmt\']').val();
        if(cmts == "*"){
            alert("Mohon cmt dipilih terlebih dahulu");
            return false;
        }
        var html = '<tbody data-parent="0" id="alat-row' + l + '" data="' + l + '"><tr>';
        html += '<td><select type="text" class="form-control select2bs4 alat" name="alat[' + l + '][rincian]" data-size="4" data-live-search="true" data-title="Pilih item" required><option value="">Pilih</option><?php foreach ($product as $key => $po) { ?><option value="<?php echo $po['nama'] ?>" data-item="<?php echo $po['product_id'] ?>"><?php echo $po['nama'] ?></option><?php } ?></select></td>';
        html += '<td><input type="text" class="form-control" name="alat[' + l + '][qty]" required></td>';
        html += '<td><input type="text" class="form-control hargaalat" name="alat[' + l + '][harga]" required></td>';
        html += '<td><input type="text" class="form-control" name="alat[' + l + '][keterangan]" value="-" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html += '</tr></tbody>';
        $("#alat tfoot").before(html);
        $('#alat-row' + l + ' .select2bs4').select2();
        l++;
    }

    function tambahmesin(){
        var html = '<tbody data-parent="0" id="mesin-row' + m + '" data="' + m + '"><tr>';
        html += '<td><input type="text" class="form-control" name="mesin[' + m + '][rincian]" required></td>';
        html += '<td><input type="text" class="form-control" name="mesin[' + m + '][qty]" required></td>';
        html += '<td><input type="text" class="form-control" name="mesin[' + m + '][harga]" required></td>';
        html += '<td><input type="text" class="form-control" name="mesin[' + m + '][keterangan]" value="-" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html += '</tr></tbody>';
        $("#mesin tfoot").before(html);
        $('#mesin-row' + m + ' .select2bs4').select2();
        m++;
    }

    function tambahvermak(){
        var html = '<tbody data-parent="0" id="vermak-row' + v + '" data="' + v + '"><tr>';
        html += '<td><input type="text" class="form-control" name="vermak[' + v + '][rincian]" required></td>';
        html += '<td><input type="text" class="form-control" name="vermak[' + v + '][qty]" required></td>';
        html += '<td><input type="text" class="form-control" name="vermak[' + v + '][harga]" required></td>';
        html += '<td><input type="text" class="form-control" name="vermak[' + v + '][keterangan]" value="-" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html += '</tr></tbody>';
        $("#vermak tfoot").before(html);
        $('#vermak-row' + v + ' .select2bs4').select2();
        v++;
    }

    function tambahlainnya(){
        var html = '<tbody data-parent="0" id="tambahan-row' + tl + '" data="' + tl + '"><tr>';
        html += '<td><input type="text" class="form-control" name="tambahan[' + tl + '][nominal]" required></td>';
        html += '<td><input type="text" class="form-control" name="tambahan[' + tl + '][keterangan]" value="-" required></td>';
        html += '<td><button type="button" name="btnRemove" class="btn btn-danger btn-xs remove"><span class="fa fa-trash"></span></button></td></tr>';
        html += '</tr></tbody>';
        $("#tambahlainnya tfoot").before(html);
        $('#tambahan-row' + tl + ' .select2bs4').select2();
        tl++;
    }

    function update(){
        var grandtotal = 0;
        $("#tbls .total").each(function(){
            var val = parseFloat($(this).val()) || 0;
            grandtotal += val;
        });
        $("#totalbayar").val(grandtotal);
    }

    function updatedz(k){
        var jumlah = $("input[name='products[" + k + "][jumlah_dz]']").val();
        var harga = $("input[name='products[" + k + "][harga]']").val();
        var total = Number(jumlah) * Number(harga);
        $("input[name='products[" + k + "][total]']").val(total);
        $("input[name='products[" + k + "][jumlah_pcs]']").val(Math.round(jumlah * 12));
        update();     
    }

    function updatepcs(k){
        var pcs = $("input[name='products[" + k + "][jumlah_pcs]']").val();
        $("input[name='products[" + k + "][jumlah_dz]']").val((pcs / 12).toFixed(2));
        var harga = $("input[name='products[" + k + "][harga]']").val();
        if(harga){
            var dz = parseFloat((pcs / 12).toFixed(2));
            var pct = $("select[name='products[" + k + "][percent]']").val() || 1;
            $("input[name='products[" + k + "][total]']").val((dz * harga * pct).toFixed(2));
        }
        update();
    }

    $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
        update();
    });

    $(document).on('change', '.kodepo', function(e){
        var cmts = $('select[name=\'cmt\']').val();
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        if(!dataItem) return;

        $.get("<?php echo BASEURL.'finishing/setorcmtjahit' ?>", { kodepo: dataItem, cmt: cmts })
          .done(function(data) {
            var obj = JSON.parse(data);
            if(obj !== null){
                var dz = obj.qty_tot_pcs / 12;
                dai.find(".jumlahDz").val(dz.toFixed(2));
                dai.find(".dz").val(dz.toFixed(2));
                dai.find(".jumlahPc").val(obj.qty_tot_pcs);
                dai.find(".total").val(0);
            }
        });

        $.get("<?php echo BASEURL.'finishing/kirimcmtjahit' ?>", { kodepo: dataItem, cmt: cmts })
          .done(function(data) {
            var obj = JSON.parse(data);
            if(obj !== null){
                var dz = obj.qty_tot_pcs / 12;
                dai.find(".dz").val(dz.toFixed(2));
                dai.find(".jumlahPc").val(obj.qty_tot_pcs);
                dai.find(".harga").val(obj.cmt_job_price);
            }
        });

        $.get("<?php echo BASEURL.'Json/pmbpotong' ?>", { kodepo: dataItem })
          .done(function(data) {
            var obj = JSON.parse(data);
            if(obj != null){
                dai.find(".potongan").val(obj.potongan);
            }else{
                dai.find(".potongan").val(0);
            }
        });

        $.get("<?php echo BASEURL.'Json/pmbkirim' ?>", { kodepo: dataItem, cmt: cmts })
          .done(function(data) {
            var obj = JSON.parse(data);
            if(obj !== null){
                var total = Number(obj.kirimpcs / 12) * Number(obj.harga);
                dai.find(".kirimpcs").val(obj.kirimpcs);
                dai.find(".total").val(total);
                update();
            }else{
                dai.find(".kirimpcs").val(0);
            }
        });
    });

    $(document).on('change', '.alat', function(e){
        var cmts = $('select[name=\'cmt\']').val();
        var dataItem = $(this).find(':selected').data('item');
        var dai = $(this).closest('tr');
        if(!dataItem) return;

        $.get("<?php echo BASEURL.'Pembayaran/product_harga' ?>", { product_id: dataItem, cmt: cmts })
          .done(function(data) {
            var obj = JSON.parse(data);
            if(obj !== null){
                dai.find(".hargaalat").val(obj.harga_skb);
            }
        });
    });
</script>
