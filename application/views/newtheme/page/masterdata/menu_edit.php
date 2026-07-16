<form method="post" action="<?php echo $action; ?>">
	<input type="hidden" name="id" value="<?php echo $m['id']?>">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Nama Menu</label>
				<input type="text" name="nama" class="form-control" value="<?php echo $m['nama']?>">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Url</label>
				<input type="text" name="url" class="form-control" value="<?php echo $m['url']?>">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Urutan</label>
				<input type="number" name="urutan" class="form-control" value="<?php echo $m['urutan']?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Group Menu</label>
				<select name="parent_id" id="grouping" class="form-control select2bs4" data-live-search="true">
					<option value="0">Pilih</option>
					<?php foreach($parent as $p){?>
						<option value="<?php echo $p['id']?>" <?php echo $group_id==$p['id']?'selected':'';?>><?php echo $p['nama']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Sub Menu 1</label>
				<select name="sub1" id="sub1" class="form-control" data-live-search="true">
					<option value="0">Pilih</option>
					<?php foreach($sub1_options as $opt){ ?>
						<option value="<?php echo $opt['id']?>" <?php echo $sub1_id == $opt['id'] ? 'selected' : ''; ?>><?php echo $opt['nama']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Sub Menu 2</label>
				<select name="sub2" id="sub2" class="form-control" data-live-search="true">
					<option value="0">Pilih</option>
					<?php foreach($sub2_options as $opt){ ?>
						<option value="<?php echo $opt['id']?>" <?php echo $sub2_id == $opt['id'] ? 'selected' : ''; ?>><?php echo $opt['nama']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>Sub Menu 3</label>
				<select name="sub3" id="sub3" class="form-control" data-live-search="true">
					<option value="0">Pilih</option>
					<?php foreach($sub3_options as $opt){ ?>
						<option value="<?php echo $opt['id']?>" <?php echo ($m['sub3'] == 1 && $m['parent_id'] == $opt['id']) ? 'selected' : ''; ?>><?php echo $opt['nama']?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Icon </label><br>
				<input type="radio" name="icon" value="fas fa-tachometer-alt" <?php echo $m['icon']=='fas fa-tachometer-alt'?'checked':'' ?> required> <i class="fas fa-tachometer-alt"></i> (Menu utama)<br>
				<input type="radio" name="icon" value="fas fa-circle" <?php echo $m['icon']=='fas fa-circle'?'checked':'' ?> required> <i class="fas fa-circle"></i> (Sub Menu 1)<br>
				<input type="radio" name="icon" value="far fa-dot-circle nav-icon" <?php echo $m['icon']=='far fa-dot-circle nav-icon'?'checked':'' ?> required> <i class="far fa-dot-circle nav-icon"></i> (Sub Menu 2)<br>
				<input type="radio" name="icon" value="fa fa-angle-right" <?php echo $m['icon']=='fa fa-angle-right'?'checked':'' ?> required> <i class="fa fa-angle-right"></i> (Sub Menu 3)
			</div>
		</div>
		<div class="col-md-4">
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