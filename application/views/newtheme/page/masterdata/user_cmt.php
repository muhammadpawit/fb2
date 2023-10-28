<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id_user" value="<?php echo $users['id_user']?>"/>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<labe>Akses CMT</labe>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<a href="<?php echo $kembali?>" class="btn btn-danger btn-sm text-white full">Kembali</a>
		</div>
		<div class="col-md-6">
			<button type="submit" class="btn btn-success btn-sm full">Update</button>
		</div>
	</div>
</form>