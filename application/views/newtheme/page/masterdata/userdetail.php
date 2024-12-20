<form method="post" action="<?php echo $action ?>">
	<input type="hidden" name="id_user" value="<?php echo $users['id_user']?>"/>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Nama</th>
						<th>:</th>
						<th>
							<input type="text" name="nama_user" value="<?php echo $users['nama_user']?>" class="form-control">
						</th>
					</tr>
					<tr>
						<th>Email</th>
						<th>:</th>
						<th>
							<input type="text" name="email_user" value="<?php echo $users['email_user']?>" class="form-control">
						</th>
					</tr>
					<tr>
						<th>Password</th>
						<th>:</th>
						<th><input type="password" name="password_user" class="form-control"></th>
					</tr>
					<tr>
						<th>Foto</th>
						<th>:</th>
						<th align="left">
							<img src="<?php echo BASEURL?><?php echo $users['foto']?>" class="profile-user-img img-responsive">
						</th>
					</tr>
					<tr>
						<th>Status</th>
						<th>:</th>
						<th>
							<select name="status" class="form-control select2bs4">
								<option value="0" <?php echo $users['status_user']==0 ? 'selected':'';?>>Non-Aktif</option>
								<option value="1" <?php echo $users['status_user']==1 ? 'selected':'';?>>Aktif</option>
							</select>
						</th>
					</tr>
					<tr>
						<th>Jabatan</th>
						<th>:</th>
						<th>
							<select name="jabatan_user" id="" class="form-control select2bs4">
								<option value=""></option>
								<?php foreach($jabatan as $j){ ?>
									<option value="<?php echo $j['id']?>" <?php echo $j['id']==$users['jabatan_user'] ? 'selected':''?>><?php echo $j['nama']?></option>
								<?php } ?>
							</select>
						</th>
					</tr>
					<tr>
						<th>Bagian</th>
						<th>:</th>
						<th>
							<select name="bagian_user" id="" class="form-control select2bs4">
								<option value=""></option>
								<?php foreach($bagian_user as $j){ ?>
									<option value="<?php echo $j['id']?>" <?php echo $j['id']==$users['bagian_user'] ? 'selected':''?>><?php echo $j['nama_bagian']?></option>
								<?php } ?>
							</select>
						</th>
					</tr>
				</thead>
			</table>
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