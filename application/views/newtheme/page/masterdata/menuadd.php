<form method="post" action="<?php echo $action?>">
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Nama Menu Baru</label>
				<input type="text" name="nama" class="form-control" required="required">
			</div>
			<div class="form-group">
				<label>Url</label>
				<input type="text" name="url" class="form-control" required="required">
			</div>
			<div class="form-group">
				<label>Icon </label><br>
				<input type="radio" name="icon" value="fas fa-tachometer-alt" required> <i class="fas fa-tachometer-alt"></i> (Menu utama)<br>
				<input type="radio" name="icon" value="fas fa-circle" required> <i class="fas fa-circle"></i> (Sub Menu 1)<br>
				<input type="radio" name="icon" value="far fa-dot-circle nav-icon" required> <i class="far fa-dot-circle nav-icon"></i> (Sub Menu 2)<br>
				<input type="radio" name="icon" value="fa fa-angle-right" required> <i class="fa fa-angle-right"></i> (Sub Menu 3)
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<label>Group Menu</label>
				<select name="parent_id" id="grouping" class="form-control select2bs4" data-live-search="true">
					<option value="0">Pilih</option>
					<?php foreach($parent as $p){?>
						<option value="<?php echo $p['id']?>"><?php echo $p['nama']?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label>Sub Menu 1</label>
				<select name="sub1" id="sub1" class="form-control" data-live-search="true">
					<option value="0">Pilih</option>
				</select>
			</div>
			<div class="form-group">
				<label>Sub Menu 2</label>
				<select name="sub2" id="sub2" class="form-control" data-live-search="true">
					<option value="0">Pilih</option>
				</select>
			</div>
			<div class="form-group">
				<label>Sub Menu 3</label>
				<select name="sub3" id="sub3" class="form-control" data-live-search="true">
					<option value="0">Pilih</option>
				</select>
			</div>
			<div class="form-group">
				
				<button type="submit" class="btn btn-info btn-sm">Simpan</button>
				<a href="<?php echo $kembali?>" class="btn btn-danger btn-sm text-white">Kembali</a>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	$( "#grouping" ).change(function() {
  		$('#sub1').empty();
	  val = $(this).val();
	  $.get("<?php echo BASEURL.'Masterdata/menugetsub/1' ?>?&parent_id="+val, 
	    function(data){   
	    console.log(data);
	    $('#sub1').append(data);
	  });
	});

	$( "#sub1" ).change(function() {
  		$('#sub2').empty();
	  val = $(this).val();
	  $.get("<?php echo BASEURL.'Masterdata/menugetsub/2' ?>?&parent_id="+val, 
	    function(data){   
	    console.log(data);
	    $('#sub2').append(data);
	  });
	});

	$( "#sub2" ).change(function() {
  		$('#sub3').empty();
	  val = $(this).val();
	  $.get("<?php echo BASEURL.'Masterdata/menugetsub' ?>?&parent_id="+val, 
	    function(data){   
	    console.log(data);
	    $('#sub3').append(data);
	  });
	});
</script>