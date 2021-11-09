<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>FORBOYS - PRODUCTION</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo ASSETS ?>images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo ASSETS ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ASSETS ?>css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ASSETS ?>css/metismenu.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo ASSETS ?>css/style.css" rel="stylesheet" type="text/css" />

        <script src="<?php echo ASSETS ?>js/modernizr.min.js"></script>
        <script src="<?php echo ASSETS ?>js/jquery.min.js"></script>
        
        <script src="<?php echo ASSETS ?>js/popper.min.js"></script>
        <script src="<?php echo ASSETS ?>js/bootstrap.min.js"></script>
        <script src="<?php echo ASSETS ?>js/metisMenu.min.js"></script>
        <script src="<?php echo ASSETS ?>js/waves.js"></script>
        <script src="<?php echo ASSETS ?>js/jquery.slimscroll.js"></script>

    </head>


    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">

                <div class="slimscroll-menu" id="remove-scroll">

                    <!-- LOGO -->
                    <div class="topbar-left">
                        <a href="<?php echo BASEURL.'dashboard'?>" class="logo">
                            <label>FORBOYS - PRODUCTION</label>
                        </a>
                    </div>

                    <!-- User box -->
                    <div class="user-box">
                        <div class="user-img">
                            <img src="<?php echo ASSETS ?>images/users/avatar-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        </div>
                        <h5><a href="#"><?php echo callSessUser('nama_user') ?></a> </h5>
                        <p class="text-muted"><?php echo flagJabatan()[callSessUser('jabatan_user')] ?></p>
                    </div>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                            <?php  
                            $menuheaderParent = headerCallParen(callSessUser('menu_flag')); 
                            $menuHeaderChild = headerCallChild(callSessUser('menu_flag'));
                            $subChildparent = headerCallSubChild(callSessUser('menu_flag'));
                            ?>
                            <?php //pre(callSessUser('menu_flag')); ?>
                        <ul class="metismenu" id="side-menu">

                            <!--<li class="menu-title">Navigation</li>-->

                            <li>
                                    <a href="<?php echo BASEURL.'dashboard'; ?>">
                                        <i class="fi-air-play"></i> <span> Dashboard </span>
                                    </a>
                             </li> 

                            <?php foreach ($menuheaderParent as $key => $menu) {?>
                                        
                            <?php if ($menu['child_menu'] == 0 && $menu['parent_menu'] == 0){ ?>
                                <li>
                                    <a href="<?php echo BASEURL.$menu['url_menu'] ?>">
                                        <i class="fi-air-play"></i> <span> <?php echo $menu['nama_menu'] ?> </span>
                                    </a>
                                </li>              
                            <?php } else { ?>        
                           
                                <li>
                                    <a href="<?php if(!empty($menu['parent_menu'])){ echo $menu['parent_menu'];} else { echo 'javascript: void(0);';} ?>"><i class="fi-layers"></i> <span> <?php echo $menu['nama_menu'] ?> </span> <span class="menu-arrow"></span></a>
                                    <ul class="nav-second-level" aria-expanded="false">
                                        <?php foreach ($menuHeaderChild as $key => $child): ?>
                                            <?php if ($menu['id_master_menu'] == $child['parent_menu']): ?>
                                            <li><a href="<?php echo BASEURL.$child['url_menu'] ?>"><?php echo $child['nama_menu'] ?></a></li>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </ul>
                                </li>

                                <?php } ?>
                            <?php } ?>

                        </ul>
<?php /* ?>
                        <ul class="metismenu" id="side-menu">
                            <?php foreach ($subChildparent[0]['children'] as $one): ?>
                            <li>
                                <?php if (!empty($one['children'])){ ?>
                                    <a href="javascript: void(0);"><i class="<?php echo $one['icon_menu'] ?>"></i><span> <?php echo $one['nama_menu'] ?> </span> <span class="menu-arrow"></span></a>
                                <?php } else { ?>
                                    <a href="<?php echo BASEURL.$one['url_menu'] ?>"><i class="<?php echo $one['icon_menu'] ?>"></i> <span> <?php echo $one['nama_menu'] ?> </span> <span class="menu-arrow"></span></a>
                                <?php } ?>
                                
                                <ul class="nav-second-level nav" aria-expanded="false">
                                <?php foreach ($one['children'] as $two){ ?>
                                    <?php if (!empty($two['children'])){ ?>
                                        <li><a href="javascript: void(0);" aria-expanded="false"><?php echo $two['nama_menu'] ?><span class="menu-arrow"></span></a>
                                        <ul class="nav-third-level nav" aria-expanded="false">
                                            <?php foreach ($two['children'] as $three): ?>
                                                <li><a href="javascript: void(0);">Level 2.1</a></li>
                                                <li><a href="javascript: void(0);">Level 2.2</a></li>
                                            <?php endforeach ?>
                                        </ul>
                                    <?php } else { ?>
                                        <li><a href="<?php echo BASEURL.$two['url_menu'] ?>"><?php echo $two['nama_menu'] ?></a></li>
                                    <?php } ?>
                                    </li>
                                <?php } ?>
                                </ul>
                            </li>
                            <?php endforeach ?>
                        </ul>
<?php */?>


                    </div>
                    <!-- Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->

            <div class="content-page">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <nav class="navbar-custom">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">

                            <!-- <li class="hide-phone app-search">
                                <form>
                                    <input type="text" placeholder="Search..." class="form-control">
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </li> -->

                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                                   aria-haspopup="false" aria-expanded="false">
                                    <img src="<?php echo ASSETS ?>images/users/avatar-1.jpg" alt="user" class="rounded-circle"> <span class="ml-1"><?php echo callSessUser('nama_user') ?><i class="mdi mdi-chevron-down"></i> </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="<?php echo BASEURL.'user/editUserSetting' ?>" class="dropdown-item notify-item">
                                        <i class="fi-head"></i> <span>My Account</span>
                                    </a>

                                    <!-- item-->
                                    <a href="<?php echo BASEURL.'login/signout' ?>" class="dropdown-item notify-item">
                                        <i class="fi-power"></i> <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="float-left">
                                <button class="button-menu-mobile open-left disable-btn">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </li>
                            <li>
                                <div class="page-title-box">
                                    <h4 class="page-title"><?php echo $this->uri->segment('1'); ?></h4>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item active">Welcome to Konvekmin admin panel !</li>
                                    </ol>
                                </div>
                            </li>

                        </ul>

                    </nav>

                </div>
                <!-- Top Bar End -->

