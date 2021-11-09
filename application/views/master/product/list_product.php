<!-- DataTables -->
<link href="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo PLUGINS ?>datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />    
<div class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card-box table-responsive">
					<h4 class="m-t-0 header-title">Master Produk</h4>
					<div class="row">
                       <div class="col-12 mb-2 text-right">
                           <a href="<?php echo $tambah ?>" class="btn btn-primary">Tambah</a>
                       </div>
                   </div>
                   <p class="text-muted font-14 m-b-30">
                   <i>Contoh :</i>
                   	INSERT INTO `product` (`product_id`, `kodebarang`, `nama`, `satuan`, `quantity`, `price`, `hapus`, `date_added`, `user_added`) VALUES (NULL, 'BRG-001', 'ASAHAN BESAR', '2', '0', '0', '0', current_timestamp(), NULL);
                    <?php if ($this->session->flashdata('msg')) { ?>

                    <div class="alert alert-primary alert-dismissible fade show" role="alert">

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">

                            <span aria-hidden="true">×</span>

                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 

                    </div>

                       <?php } ?>

                    </p>
                   <table class="table table-bordered">
                   		<thead>
                   			<tr>
                   				<th>No</th>
                   				<th>Kode Barang</th>
                   				<th>Nama Barang</th>
                   				<th>Satuan</th>
                   				<th>Quantity</th>
                   				<th>Harga</th>
                   				<th></th>
                   			</tr>
                   		</thead>
                   		<tbody>
                   			<?php foreach($products as $p){?>
                   			<tr>
                   				<td><?php echo $i++?></td>
                   				<td><?php echo $p['kodebarang']?></td>
                   				<td><?php echo $p['nama']?></td>
                   				<td><?php echo $p['satuan']?></td>
                   				<td><?php echo $p['quantity']?></td>
                   				<td align="right"><?php echo $p['price']?></td>
                   				<td class="right"><?php foreach ($p['action'] as $action) { ?>
                           <a href="<?php echo $action['href']; ?>" class="badge badge-info waves-light waves-effect"><?php echo $action['text']; ?></a><br>
                          <?php } ?></td>
                   			</tr>
                   			<?php } ?>
                   		</tbody>
                   </table>
				</div>
			</div>
		</div>
	</div>
	
</div>



<!-- Required datatable js -->
<script src="<?php echo PLUGINS ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/dataTables.bootstrap4.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo PLUGINS ?>datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo PLUGINS ?>datatables/responsive.bootstrap4.min.js"></script>
<script type="text/javascript">