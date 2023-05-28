<div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="<?php echo BASEURL?><?php echo $p['foto']?>" alt="<?php echo callSessUser('nama_user')?> profile picture">

              <h3 class="profile-username text-center"><?php echo callSessUser('nama_user')?> </h3>

              <p class="text-muted text-center"><?php echo GetName('jabatan',callSessUser('jabatan')) ?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Followers</b> <a class="pull-right">0</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="pull-right">0</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="pull-right">0</a>
                </li>
              </ul>

              <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Pendidikan</strong>

              <p class="text-muted">
                
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>

              <p class="text-muted"></p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Motto Hidup</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
              <!-- <li><a href="#activity" data-toggle="tab">Activity</a></li> -->
              <li><a href="#timeline" data-toggle="tab">Logs</a></li>
            </ul>
            <div class="tab-content">
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline" style="height:500px;overflow:auto">
                <!-- The timeline -->
                <?php foreach($activity as $a){?>
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          <?php echo date('F Y',strtotime($a['tanggal'])) ?>
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <?php foreach($a['det'] as $d){ ?>
                  <li>
                    <i class="fa fa-check bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> <?php echo date('d F Y H:i:s',strtotime($d['waktu'])) ?></span>

                      <h3 class="timeline-header"><a href="#"> <?php echo $d['nama_user'] ?></a></h3>

                      <div class="timeline-body">
                        <?php echo $d['ket'] ?>
                      </div>
                      <div class="timeline-footer">
                        <!-- <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a> -->
                      </div>
                    </div>
                  </li>
                  <?php } ?>
                  <!-- END timeline item -->
                  <?php } ?>
                </ul>
                
              </div>
              <!-- /.tab-pane -->

              <div class="active tab-pane" id="settings">
                <form class="form-horizontal" method="post" enctype="multipart/form-data" action="<?php echo $save?>">
                  <input type="hidden" class="form-control" name="id_user" value="<?php echo callSessUser('id_user') ?>" id="nama_user" placeholder="Name">
                  <div class="form-group">
                    <label for="nama_user" class="col-sm-2 control-label">Nama</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="nama_user" value="<?php echo callSessUser('nama_user') ?>" id="nama_user" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" value="<?php echo callSessUser('email_user') ?>" placeholder="Email" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Foto</label>

                    <div class="col-md-4">
                      <img class="profile-user-img img-responsive" src="<?php echo BASEURL?><?php echo $p['foto']?>" alt="<?php echo callSessUser('nama_user')?> profile picture">
                      <br>
                      <input type="file" class="form-control" name="foto" id="inputName" placeholder="Name">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>