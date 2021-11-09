<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                   <form action="<?php echo BASEURL.'user/tambahAct' ?>" method="POST">
                        <div class="form-group">
                        	<label>Nama User</label>
                        	<input type="text" class="form-control" name="nama_user" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label>Email User</label>
                            <input type="email" autocomplete="off" class="form-control" name="email_user" required>
                        </div>
                        <div class="form-group">
                            <label>Jabatan</label>
                            <select class="form-control selectpicker" data-live-search="true" data-title="Pilih Jabatan" name="jabatan_user">
                                <?php foreach ($jabatan as $j): ?>
                                <option value="<?php echo $j['id'] ?>"><?php echo $j['nama'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password_user">
                        </div>
                        <!--
                        <div class="form-group">
                        <label>Menu User</label>
                        <div class="row">

                        <?php foreach ($menu as $key => $mn): ?>
                        <?php if ($mn['parent_menu'] == 0){ ?>
                                    <?php $menuChild = explode(",",$mn['child_menu']); ?>
                            <div class="col-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" value="<?php echo $mn['id_master_menu'] ?>" id="customCheck<?php echo $mn['id_master_menu'] ?>" name="menu_flag[]">
                                    <label class="custom-control-label" for="customCheck<?php echo $mn['id_master_menu'] ?>"><?php echo $mn['nama_menu'] ?></label>
                                </div>
                                <hr>
                            <div class="row">
                                <?php foreach ($menuChild as $key => $child): ?>

                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" value="<?php echo searchMenu($child)['id_master_menu']; ?>" id="customCheck<?php echo searchMenu($child)['id_master_menu']; ?>" name="menu_flag[]" >
                                            <label class="custom-control-label" for="customCheck<?php echo searchMenu($child)['id_master_menu']; ?>"><?php echo searchMenu($child)['nama_menu']; ?></label>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            </div>
                         </div>
                        <?php } ?>
                        <?php endforeach ?>
                        </div>
                            
                        </div>-->
                        <div class="form-group">
                        	<label>Status </label>
                        	<select class="form-control select2bs4" name="status_user" required data-live-search="true">
                        		<option value="1">Active</option>
                        		<option value="0">Non Active</option>
                        	</select>
                        </div>
                        <button type="submit" class="btn btn-info btn-sm">Simpan</button>
                        <a href="<?php echo BASEURL.'masterdata/user';?>" class="btn btn-sm btn-danger text-white">Batal</a>
                   </form>
                   <br><br><br><br>
                </div>

            </div>

        </div>
        <!-- end row -->

    </div> <!-- container -->

</div> <!-- content -->