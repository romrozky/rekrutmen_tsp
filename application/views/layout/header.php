<!DOCTYPE html>
<html lang="en">
    <?php
	//print_r($this->session->all_userdata());
    if($this->session->userdata('username')==""){
		redirect('login/logout');
	}
    ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Favicon icon -->
        <link rel="icon" type="image/png" href="<?= base_url() ?>images/logo-mini2.png">
        <title>PT. XYZ - <?= $judul ?></title>

        <!-- Select2 -->
        <link href="<?php echo base_url('assets/plugins/select2/css/select2.min.css') ?>" rel="stylesheet">

        <!-- Datatables -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap.min.css">

        <!-- Date picker plugins css -->
        <link href="<?= base_url() ?>assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker plugins css -->
        <!-- <link href="<?= base_url() ?>assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"> -->
        <link href="<?= base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

        <!-- morris CSS -->
        <link href="<?= base_url() ?>assets/plugins/morrisjs/morris.css" rel="stylesheet">

        <!-- Bootstrap Core CSS -->
        <link href="<?= base_url() ?>assets/bootstrap.css" rel="stylesheet">

        <!-- Calendar CSS -->
        <link href="<?= base_url() ?>assets/plugins/calendar/dist/fullcalendar.css" rel="stylesheet" />

        <!-- morris CSS -->
        <link href="<?= base_url() ?>assets/morris.css" rel="stylesheet">
        <!-- Popup CSS -->
        <link href="<?= base_url() ?>assets/magnific-popup.css" rel="stylesheet">
        <!--alerts CSS -->
        <link href="<?= base_url() ?>assets/sweetalert.css" rel="stylesheet" type="text/css">

        <!-- CSS File Upload -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/dropify.css">

        <!-- Popup CSS -->
        <link href="<?= base_url() ?>assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="<?= base_url() ?>assets/style.css" rel="stylesheet">
        <!-- You can change the theme colors from here -->
        <link href="<?= base_url() ?>assets/blue.css" id="theme" rel="stylesheet">

        <style>
            .spinner {
                /* margin: 100px auto; */
                width: 50px;
                height: 20px;
                text-align: center;
                font-size: 10px;
                opacity: 0.8;
                filter: alpha(opacity=20);
            }

            .spinner > div {
                background-color: #fff;
                height: 100%;
                width: 6px;
                display: inline-block;

                -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
                animation: sk-stretchdelay 1.2s infinite ease-in-out;
            }

            .spinner .rect2 {
                -webkit-animation-delay: -1.1s;
                animation-delay: -1.1s;
            }

            .spinner .rect3 {
                -webkit-animation-delay: -1.0s;
                animation-delay: -1.0s;
            }

            .spinner .rect4 {
                -webkit-animation-delay: -0.9s;
                animation-delay: -0.9s;
            }

            .spinner .rect5 {
                -webkit-animation-delay: -0.8s;
                animation-delay: -0.8s;
            }

            @-webkit-keyframes sk-stretchdelay {
                0%, 40%, 100% { -webkit-transform: scaleY(0.4) }
                20% { -webkit-transform: scaleY(1.0) }
            }

            @keyframes sk-stretchdelay {
                0%, 40%, 100% {
                    transform: scaleY(0.4);
                    -webkit-transform: scaleY(0.4);
                }  20% {
                    transform: scaleY(1.0);
                    -webkit-transform: scaleY(1.0);
                }
            }

        </style>

        <!-- Bootstrap tether Core JavaScript -->
        <script src="<?= base_url() ?>assets/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/popper.min.js"></script>
        <script src="<?= base_url() ?>assets/bootstrap.min.js"></script>

        <!-- Calendar JavaScript -->
        <script src="<?= base_url() ?>/assets/plugins/calendar/jquery-ui.min.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body class="fix-header fix-sidebar card-no-border">
        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
        </div>
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <header class="topbar">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<?=site_url()?>">
                            <!-- Logo icon --><b>
                                <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                                <!-- Dark Logo icon -->
                                <img src="<?= base_url() ?>images/logo-mini.png" alt="homepage" class="dark-logo" />
                                <!-- Light Logo icon -->
                                <img src="<?= base_url() ?>images/logo-mini.png" alt="homepage" class="light-logo" />
                            </b>
                            <!--End Logo icon -->
                            <!-- Logo text --><span>
                                <!-- dark Logo text -->
                                <!-- Light Logo text -->
                                 </a>
                    </div>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <div class="navbar-collapse">
                        <!-- ============================================================== -->
                        <!-- toggle and nav items -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav mr-auto mt-md-0">
                            <!-- This is  -->
                            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                            <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                            <!-- ============================================================== -->
                            <!-- Comment -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <!--
                                                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                </a>
                                -->
                                <div class="dropdown-menu mailbox animated slideInUp">
                                    <ul>
                                        <li>
                                            <div class="drop-title">Notifications</div>
                                        </li>
                                        <li>
                                            <div class="message-center">
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                    <div class="mail-contnet">
                                                        <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                                </a>
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                    <div class="mail-contnet">
                                                        <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                                </a>
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                    <div class="mail-contnet">
                                                        <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                                </a>
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                    <div class="mail-contnet">
                                                        <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- End Comment -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- Messages -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown">
                                <!--
                                                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                    <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                </a>
                                -->
                                <div class="dropdown-menu mailbox animated slideInUp" aria-labelledby="2">
                                    <ul>
                                        <li>
                                            <div class="drop-title">You have 4 new messages</div>
                                        </li>
                                        <li>
                                            <div class="message-center">
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="user-img"> <img src="<?= base_url() ?>/assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                    <div class="mail-contnet">
                                                        <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                                </a>
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="user-img"> <img src="<?= base_url() ?>/assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                    <div class="mail-contnet">
                                                        <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                                </a>
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="user-img"> <img src="<?= base_url() ?>/assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                    <div class="mail-contnet">
                                                        <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                                </a>
                                                <!-- Message -->
                                                <a href="#">
                                                    <div class="user-img"> <img src="<?= base_url() ?>/assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                    <div class="mail-contnet">
                                                        <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                                </a>
                                            </div>
                                        </li>
                                        <li>
                                            <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <!-- ============================================================== -->
                            <!-- End Messages -->
                        </ul>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <ul class="navbar-nav my-lg-0 ">
                            <!-- ============================================================== -->
                            <!-- Search -->
                            <!-- ============================================================== -->
                            <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                                <form class="app-search">
                                    <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                            </li>
                            <!-- ============================================================== -->
                            <!-- Language -->
                            <!-- ============================================================== -->
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
                                <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
                            </li> -->
                            <!-- ============================================================== -->
                            <!-- Profile -->
                            <!-- ============================================================== -->
                            <li class="nav-item dropdown hidden-sm-down">
                                <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="line-height: 26px;">
                                    <!-- <img src="<?= base_url() ?>images/user.jpg" alt="user" class="profile-pic" /> -->
                                    <img src="<?= base_url() ?>images/user.jpg" alt="user" class="profile-pic" style="float: right; padding-top: 7px;" />
                                    <!-- <i class="mdi mdi-settings"></i> -->
                                    <div style="float: right;padding-top: 15px;padding-right: 10px;">
                                        <div style="line-height: 0px;text-align: right; color: #4a4a4a;">
                                            <?= $this->session->userdata('username') ?>
                                        </div>
                                        <span style="font-size: 11px;color: #4a4a4a;">
                                            <?= $this->convertion->mysql_date_2_date(date('Y-m-d')) ?>
                                        </span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right scale-up">
                                    <ul class="dropdown-user">
                                        <li>
                                            <div class="dw-user-box">
                                                <div class="u-img"><img src="<?= base_url() ?>images/user.jpg" alt="user"></div>
                                                <div class="u-text">
                                                    <h4><?= $this->session->userdata('username') ?></h4>
                                                    <p class="text-muted"><?= $this->session->userdata('email') ?></p></div>
                                            </div>
                                        </li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="#" id='acc_setting'><i class="ti-settings"></i> Account Setting</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="<?= site_url('Setting/mydata') ?>" ><i class="ti-user"></i> Profil Setting</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="<?= site_url() ?>/login/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- ============================================================== -->
            <!-- End Topbar header -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <aside class="left-sidebar">
                <!-- Sidebar scroll-->
                <div class="scroll-sidebar">
                    <!-- User profile -->
                    <div class="user-profile">
                        <!-- User profile image -->
                        <div class="profile-img"> <img src="<?= base_url() ?>images/user.jpg" alt="user" />
                            <!-- this is blinking heartbit-->
                            <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
                        </div>
                        <!-- User profile text-->
                        <div class="profile-text">
                            <h5><?= $this->session->userdata('username') ?></h5>

                            <a href="<?= site_url() ?>/login/logout" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>

                        </div>
                    </div>
                    <!-- End User profile text-->
                    <!-- Sidebar navigation-->
                   
                    <script>
                        $(document).on('click', '#acc_setting', function () {
                            $('#tampilmain_form').load("<?= site_url() ?>/User/modal_myform/", function () {
                                $('#modalmain_form').modal('show');
                            });
                        });
                    </script>
                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
							<?php
							if($this->session->userdata('userlevel')<3){
								?>
							<li>
                                <a href="<?= site_url() ?>/Dashboard" class="waves-effect waves-dark" aria-expanded="false">
                                    <i class="mdi mdi-home-outline"></i>
                                    <!-- <i class="mdi mdi-gauge"></i> -->
                                    <span class="hide-menu">
                                        Dashboard
                                        <!-- <span class="label label-rouded label-warning pull-right">4</span></span> -->
                                </a>
                            </li>
							<li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="fa fa-money"> </i>
                                    <span class="hide-menu">Master Data</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                            		<li><a href="<?= site_url('Master/main_cabang') ?>">Data Cabang</a></li>
                            		<li><a href="<?= site_url('Master/main_pengguna') ?>">Data Pengguna</a></li>
                            	</ul>								
                            </li>
							
								<?php
							}
							?>
							<li>
                                <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                                    <i class="fa fa-money"> </i>
                                    <span class="hide-menu">Data Barang</span>
                                </a>
                                <ul aria-expanded="false" class="collapse">
                            		<li><a href="<?= site_url('Barang/main_jenis') ?>">Jenis Barang</a></li>
                            		<li><a href="<?= site_url('Barang/main_barang') ?>">Data Barang</a></li>
                            		<li><a href="<?= site_url('Barang/main_history') ?>">Log Barang</a></li>
                            	</ul>								
                            </li>
							
                        </ul>
                    </nav>
                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!-- ============================================================== -->
            <!-- End Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="onoffswitch3" style="width: 100%;">
                        <input type="checkbox" name="onoffswitch3" class="onoffswitch3-checkbox" id="myonoffswitch3" checked>
                        <label class="onoffswitch3-label" for="myonoffswitch3" style="padding-left: 0;margin-bottom: 0;width: 100%;">
                            <span class="onoffswitch3-inner">
                                <span class="onoffswitch3-active">
                                    <marquee class="scroll-text">Romadhoni Rosyid aka Romrozky<span class="glyphicon glyphicon-forward"></span> <span class="glyphicon glyphicon-forward"></span>  </marquee>
                                    <span class="onoffswitch3-switch">Info Berjalan :<span class="glyphicon glyphicon-remove" style="display: none;"></span></span>
                                </span>
                                <span class="onoffswitch3-inactive"><span class="onoffswitch3-switch">SHOW BREAKING NEWS</span></span>
                            </span>
                        </label>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Container fluid  -->
                <!-- ============================================================== -->
                <div class="container-fluid">
                    <!-- ============================================================== -->
                    <!-- Start Page Content -->
                    <!-- ============================================================== -->
                    <div id="modalmain_form" class="modal" data-width="600">
                        <div id="tampilmain_form"></div>
                    </div>
