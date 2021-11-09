<link href="<?php echo PLUGINS ?>bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

<!-- Start Page content -->
<div class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">

                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-20">Tambah User</h4>
                    <hr>
                     <?php if ($this->session->flashdata('msg')) { ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                           <?php echo $this->session->flashdata('msg'); ?> 
                    </div>
                    <?php } ?>
                   <form action="<?php echo BASEURL.'user/settingAct' ?>" method="POST">
                        <div class="form-group">
                        	<label>Nama User</label>
                        	<input type="hidden" value="<?php echo $user['id_user'] ?>" name="idUser">
                        	<input type="text" class="form-control" name="nama_user" value="<?php echo $user['nama_user'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Email User</label>
                            <input type="email" class="form-control" name="email_user" value="<?php echo $user['email_user'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="passwordNew">
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
