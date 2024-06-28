<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Forboys Production System</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo ASSETS; ?>images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo ASSETS; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ASSETS; ?>css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ASSETS; ?>css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ASSETS; ?>css/style.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo ASSETS; ?>js/modernizr.min.js"></script>

        <!-- PushAlert -->
        <script type="text/javascript">
                (function(d, t) {
                        var g = d.createElement(t),
                        s = d.getElementsByTagName(t)[0];
                        g.src = "https://cdn.pushalert.co/integrate_a704c8bf56f63c0de758b5513d2d18a0.js";
                        s.parentNode.insertBefore(g, s);
                }(document, "script"));
        </script>
        <!-- End PushAlert -->
        <style type="text/css">
            .footer { 
              position: relative;
              /*left: 0;*/
              bottom: 0;
              /*width: 100%;*/
              /*background-color: red;*/
              /*color: white;*/
              /*text-align: center;*/
             }
        </style>
    </head>


    <body class="account-pages">

        <!-- Begin page -->
        <div class="accountbg" style="background: url('<?php echo ASSETS; ?>bg.jpg');background-size: cover;"></div>

        <div class="wrapper-page account-page-full">

            <div class="card">
                <div class="card-block">

                    <div class="account-box">

                        <div class="card-box p-5">
                            <h2 class="text-uppercase text-center pb-4">
                                <a href="<?php echo BASEURL?>" class="text-success">
                                    Forboys Production System
                                </a><br>
                                <img src="https://forboysproduction.com/assets/images/0001.jpg" height="180px">
                            </h2>
                            <form class="" action="<?php echo BASEURL.'login/auth' ?>" method="POST">
                                <div class="row">
                                  <div class="col-md-12">
                                    <?php if ($this->session->flashdata('gagal')) { ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                        <?php echo $this->session->flashdata('gagal'); ?> 
                                    </div>
                                    <?php } ?>
                                  </div>
                                </div>
                                <div class="form-group m-b-20 row">
                                    <div class="col-12">
                                        <label for="emailaddress">Email address</label>
                                        <input class="form-control" type="text" id="emailaddress" name="email" required="" placeholder="Enter your email" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="form-group row m-b-20">
                                    <div class="col-12">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" required="" id="password" name="password" placeholder="Enter your password">
                                    </div>
                                </div>

                                <div class="form-group row text-center m-t-10">
                                    <div class="col-12">
                                        <button class="btn btn-block btn-custom waves-effect waves-light" type="submit">Sign In</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

            <div class="m-t-40 text-center footer">
                <p class="account-copyright">2020 - <?php echo date('Y')?> Forboys Production</p>
            </div>

        </div>



        <!-- jQuery  -->
        <script src="<?php echo ASSETS; ?>js/jquery.min.js"></script>
        <script src="<?php echo ASSETS; ?>js/popper.min.js"></script>
        <script src="<?php echo ASSETS; ?>js/bootstrap.min.js"></script>
        <script src="<?php echo ASSETS; ?>js/metisMenu.min.js"></script>
        <script src="<?php echo ASSETS; ?>js/waves.js"></script>
        <script src="<?php echo ASSETS; ?>js/jquery.slimscroll.js"></script>

        <!-- App js -->
        <script src="<?php echo ASSETS; ?>js/jquery.core.js"></script>
        <script src="<?php echo ASSETS; ?>js/jquery.app.js"></script>

    </body>
</html>