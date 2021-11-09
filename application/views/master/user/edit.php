<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah User</h4>
                    <hr>
                   <form action="<?php echo BASEURL.'user/editAct/'.$user['id_user'] ?>" method="POST">
                        <div class="form-group">
                        	<label>Nama User</label>
                        	<input type="text" class="form-control" name="nama_user" value="<?php echo $user['nama_user'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email User</label>
                            <input type="email" class="form-control" name="email_user" value="<?php echo $user['email_user'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control selectpicker" data-live-search="true" data-title="Pilih Jabatan" name="jabatan_user">
                            	<?php foreach (flagJabatan() as $key => $jabatan): ?>
                                <option <?php if ($key == $user['jabatan_user']){ echo "selected='selected'";} ?> value="<?php echo $key ?>"><?php echo $jabatan ?></option>
                            	<?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <p>Kalau ga ganti password ya jangan diisi</p>
                            <input type="password" class="form-control" name="password_user">
                        </div>

                        <div class="form-group">
                            <label>Menu User</label>
                            <div class="row">
                            <?php $userMenu = explode(',', $user['menu_flag']);  ?>
                            <?php foreach ($menu as $key => $mn){ ?>
                            <?php if ($mn['parent_menu'] == 0){ ?>
                            <?php $menuChild = explode(",",$mn['child_menu']); ?>
                                <div class="col-4">
                                    <hr>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" <?php foreach ($userMenu as $key => $usMenu) { 
                                                    if ($mn['id_master_menu'] == $usMenu) {
                                                echo "checked='checked'";
                                                    }
                                            } ?> value="<?php echo $mn['id_master_menu'] ?>" id="customCheck<?php echo $mn['id_master_menu'] ?>" name="menu_flag[]">
                                        <label class="custom-control-label" for="customCheck<?php echo $mn['id_master_menu'] ?>"><?php echo $mn['nama_menu'] ?> <?php echo $mn['id_master_menu'] ?></label>
                                    </div>
                                    <hr>
                                <div class="row">
                                    <?php foreach ($menuChild as $key => $child): ?>
                                        <div class="col-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" <?php foreach ($userMenu as $key => $usMenu) {
                                                    if (searchMenu($child)['id_master_menu'] == $usMenu) {
                                                echo "checked='checked'";
                                                    }
                                            } ?> value="<?php echo searchMenu($child)['id_master_menu']; ?>" id="customCheck<?php echo searchMenu($child)['id_master_menu']; ?>" name="menu_flag[]">
                                                <label class="custom-control-label" for="customCheck<?php echo searchMenu($child)['id_master_menu']; ?>"><?php echo searchMenu($child)['nama_menu']; ?></label>
                                    </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                             </div>
                            <?php } ?>
                            <?php } ?>
                            </div>
                        </div>

                        
                        <div class="form-group">
                        	<label>Status </label>
                        	<select class="form-control" name="status_user" required>
                        		<option value="1">Active</option>
                        		<option value="0">Non Active</option>
                        	</select>
                        </div>
                        <button type="submit" class="btn btn-primary">SUBMIT</button>
                   </form>
                   <br><br><br><br>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->
<script src="<?php echo PLUGINS ?>bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
