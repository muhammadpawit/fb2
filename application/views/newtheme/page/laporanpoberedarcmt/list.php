<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
  integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>
<div class="row no-print">
	<div class="col-md-4">
		<select id="select" multiple placeholder="Pilih nama cmt ..."></select>
	</div>
	<div class="col-md-4">
		<button class="btn btn-info" onclick="fil()">Filter</button>
		<button class="btn btn-info" onclick="cetak()">Print</button>
	</div>
</div>
<br><br>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<?php foreach($prods as $key=>$val){ ?>
				<h5 class="alert" style="background-color: <?php echo rand_color() ?>; color:white">
					Stok <?php echo $key ?>
				</h5>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th style="background-color: #ed975a !important;color: white" width="100">PO</th>
							<?php foreach($val as $v){ ?>
							<th><center><?php echo $v['nama'] ?></center></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="background-color: #7f8bb3 !important;color: white" width="100">Rincian</td>
							<?php foreach($val as $v){ ?>
								<td><center><?php echo $v['rincian'] ?></center></td>
							<?php } ?>
						</tr>
						<tr style="font-weight: 800">
							<td style="background-color: yellow;">Jumlah PO</td>
							<?php foreach($val as $v){ ?>
								<td><center><?php echo $v['jmlpo'] ?></center></td>
							<?php } ?>
						</tr>
						<tr style="font-weight: 800">
							<td style="background-color: yellow;">Jumlah DZ</td>
							<?php foreach($val as $v){ ?>
								<td><center><?php echo number_format(($v['pcspo']/12),2) ?></center></td>
							<?php } ?>
						</tr>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>
</div>
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
  integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>

<script>

	function fil(){
		var s = $("#select").val();

		url='?';

		url +='&cmt='+s;

		location = url;
	}
  $(function () {
    $("#select").selectize({
      plugins: ["restore_on_backspace", "clear_button"],
      delimiter: " - ",
      persist: false,
      maxItems: null,
      valueField: "id",
      labelField: "name",
      searchField: ["name", "id"],
      options: [
        { id : '<?php echo $all ?>', name:'Semua cmt '},
      	<?php foreach($cmt as $c) { ?>
        { id: "<?php echo $c['id_cmt'] ?>", name: "<?php echo strtolower($c['cmt_name']) ?>" },
        <?php } ?>
      ],
    });
  });
</script>