<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.APP_NAME', 'DART')); ?></title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords"
        content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e(asset('assets\images\favicon.png')); ?>" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\bootstrap\css\bootstrap.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\icon\themify-icons\themify-icons.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\icon\font-awesome\css\font-awesome.min.css')); ?>">
    <!-- feather Awesome -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\icon\feather\css\feather.css')); ?>">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\css\jquery.min.css')); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\css\style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets\css\jquery.mCustomScrollbar.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets\pages\advance-elements\css\bootstrap-datetimepicker.css')); ?>">
    <!-- Date-range picker css  -->
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('bower_components\bootstrap-daterangepicker\css\daterangepicker.css')); ?>">

    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('bower_components\datatables.net-bs4\css\dataTables.bootstrap4.min.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('assets\pages\data-table\css\buttons.dataTables.min.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('bower_components\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css')); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\fullcalendar\css\fullcalendar.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('bower_components\fullcalendar\css\fullcalendar.print.css')); ?>" media='print'>

    <script type="text/javascript" src="<?php echo e(asset('bower_components\jquery\js\jquery.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('bower_components\jquery-ui\js\jquery-ui.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\bootbox.js')); ?>"></script>

    <link rel="stylesheet" href="<?php echo e(asset('bower_components\select2\css\select2.min.css')); ?>">

    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components/multiselect/css/multi-select.css')); ?>" />

    <!-- Switch component css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\switchery\css\switchery.min.css')); ?>">

    <!-- owl carousel css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\owl.carousel\css\owl.carousel.css')); ?>">
    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('bower_components\owl.carousel\css\owl.theme.default.css')); ?>">

    <link rel="stylesheet" type="text/css"
        href="<?php echo e(asset('bower_components\ekko-lightbox\css\ekko-lightbox.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('bower_components\lightbox2\css\lightbox.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('assets\js\charts.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\chartjs-plugin-datalabels.js')); ?>"></script>
    <!-- <script type="text/javascript" src="<?php echo e(asset('assets\js\chartjs-plugin-doughnutlabel.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\chartjs-plugin-labels.js')); ?>"></script> -->
</head>
<style>
    /* CSS used here will be applied after bootstrap.css */

    .dropdown {
        display: inline-block;
        margin-left: 20px;
        padding: 10px;
    }


    .glyphicon-bell {

        font-size: 1.5rem;
    }

    .notifications {
        min-width: 420px;
    }

    .notifications-wrapper {
        overflow: auto;
        max-height: 250px;
    }

    .menu-title {
        color: #ff7788;
        font-size: 1.5rem;
        display: inline-block;
    }

    .glyphicon-circle-arrow-right {
        margin-left: 10px;
    }


    .notification-heading,
    .notification-footer {
        padding: 2px 10px;
    }


    .dropdown-menu.divider {
        margin: 5px 0;
    }

    .item-title {

        font-size: 1.3rem;
        color: #000;

    }

    .notifications a.content {
        text-decoration: none;
        background: #ccc;

    }

    .notification-item {
        padding: 10px;
        margin: 5px;
        background: #ccc;
        border-radius: 4px;
    }

</style>

<body>
    <!-- Pre-loader start -->
    <?php $user = \Illuminate\Support\Facades\Auth::user(); ?>
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo" style="width: 220px;">

                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu" style="color:#000"></i>
                        </a>


                        <a href="<?php echo e(url('home')); ?>">

                            <img src="<?php echo e(asset('assets\images\Dart-logo2.png')); ?>" style="height: 40px">
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>

                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()">

                                    <i class="feather icon-maximize full-screen"></i>
                                </a>
                            </li>

                        </ul>
                        <div class="nav-left">
                            
                            <h4 style="float: left; padding: 10px 0px; margin: 0px;color:black;">DART MIS</h4>
                        </div>
                        


                        <ul class="nav-right">



                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">

                                        <div style="float:left;padding: 17px 0px;">

                                            <span
                                                style="float:left;font-size: 14px; font-weight: bold; width: 100%;line-height: 14px;color: black;">
                                                <?php if(Auth::check()): ?>
                                                    <?php echo e(Auth::user()->name); ?><?php endif; ?>
                                            </span>

                                        </div>
                                        <div style="float: left">
                                            <i class="feather icon-chevron-down"></i>
                                        </div>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu"
                                        data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        
                                        <li style="border-bottom:1px solid #ccc">
                                            <div>
                                                <a class="dropdown-item" href="<?php echo e(url('change-password')); ?>">
                                                    Change Password
                                                </a>

                                            </div>
                                        </li>

                                        <li>
                                            <div class="out">
                                                <a class="dropdown-item" class="out"  href="<?php echo e(route('logout')); ?>"
                                                    onclick="event.preventDefault(); ">
                                                    <?php echo e(__('Logout')); ?>

                                                </a>
                                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                                    style="display: none;">
                                                    <?php echo csrf_field(); ?>
                                                   
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </nav>

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="pcoded-inner-navbar main-menu pt-2" style="width: 220px;">
                            
                            <ul class="pcoded-item pcoded-left-item">
                                <?php if($user->u_type == 'QA'): ?>
                                    <li class=" ">
                                        <a href="<?php echo e(url('qualitycheck')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-home"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Quality Check</span>
                                        </a>
                                    </li>
                                    <!-- <li class="">
                                        <a href="<?php echo e(url('family')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-layers"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Family</span>
                                        </a>
                                    </li> -->

                                <?php elseif($user->u_type == 'M'): ?>
                                    <li class=" ">
                                        <a href="<?php echo e(url('qualitycheck')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-home"></i><b>A</b></span>
                                            <span class="pcoded-mtext">District Manager Check</span>
                                        </a>
                                    </li>
                                    <li class=" ">
                                        <a href="<?php echo e(url('facilitator')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-home"></i><b>A</b></span>
                                            <span class="pcoded-mtext">My Facilitators</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('family')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-layers"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Family</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('shg')); ?>">
                                            <span class="pcoded-micon"><i class="feather icon-box"></i><b>A</b></span>
                                            <span class="pcoded-mtext">SHG</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('cluster')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-box"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Cluster</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('federation')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-bookmark"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Federation</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('preanalytics')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-check-circle"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Task Assignment</span>
                                        </a>
                                    </li>


                                <?php elseif($user->u_type == 'CEO' || $user->u_type == 'A'): ?>
                                    <li class=" ">
                                        <a href="<?php echo e(url('home')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-home"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('family')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-layers"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Family</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('shg')); ?>">
                                            <span class="pcoded-micon"><i class="feather icon-box"></i><b>A</b></span>
                                            <span class="pcoded-mtext">SHG</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('cluster')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-box"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Cluster</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('federation')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-bookmark"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Federation</span>
                                        </a>
                                    </li>

                                    <li class="">
                                        <a href="<?php echo e(url('agency')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-users"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Agency</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('partner')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-check-circle"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Partner</span>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo e(url('users')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-check-circle"></i><b>A</b></span>
                                            <span class="pcoded-mtext">DART Team</span>
                                        </a>
                                    </li>

                                    <li class="">
                                        <a href="<?php echo e(url('preanalytics')); ?>">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-check-circle"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Task Assignment</span>
                                        </a>
                                    </li>
                                    <?php if($user->u_type == 'CEO'): ?>
                                        

                                        <li class="pcoded-hasmenu ">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i
                                                        class="feather icon-check-circle"></i><b>A</b></span>
                                                <span class="pcoded-mtext">App Labels</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="<?php if(Request::is('module') || Request::is('module/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('module')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">Module</span>
                                                    </a>
                                                </li>
                                                <li class="<?php if(Request::is('section') || Request::is('section/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('section')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">Section</span>
                                                    </a>
                                                </li>
                                                <li class="<?php if(Request::is('subsection') || Request::is('subsection/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('subsection')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">Sub section</span>
                                                    </a>
                                                </li>
    
                                                <li class="<?php if(Request::is('applabel') || Request::is('applabel/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('applabel')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">App label</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>

                                        <li class="pcoded-hasmenu <?php if(Request::is('category') || Request::is('category/*') || Request::is('subcategory') || Request::is('subcategory/*') || Request::is('questions') || Request::is('questions/*') || Request::is('option') || Request::is('option/*')): ?> pcoded-trigger <?php endif; ?>">
                                            <a href="javascript:void(0)">
                                                <span class="pcoded-micon"><i
                                                        class="feather icon-check-circle"></i><b>A</b></span>
                                                <span class="pcoded-mtext">Rating Questions</span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                <li class="<?php if(Request::is('category') || Request::is('category/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('category')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">Category</span>
                                                    </a>
                                                </li>
                                                <li class="<?php if(Request::is('subcategory') || Request::is('subcategory/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('subcategory')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">Sub Category</span>
                                                    </a>
                                                </li>
                                                <li class="<?php if(Request::is('questions') || Request::is('questions/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('questions')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">Questions</span>
                                                    </a>
                                                </li>
                                                <li class="<?php if(Request::is('option') || Request::is('option/*')): ?> active <?php endif; ?>">
                                                    <a href="<?php echo e(url('option')); ?>">
                                                        <span class="pcoded-micon"><i
                                                                class="feather feather icon-award"></i><b>A</b></span>
                                                        <span class="pcoded-mtext">Options</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <?php if($user->u_type == 'CEO'): ?>
                                        <li class=" ">
                                            <a href="<?php echo e(url('settings')); ?>">
                                                <span class="pcoded-micon"><i
                                                        class="feather icon-check-circle"></i><b>A</b></span>
                                                <span class="pcoded-mtext">Settings</span>
                                            </a>
                                        </li>
                                        <li class=" ">
                                            <a href="<?php echo e(url('logs')); ?>">
                                                <span class="pcoded-micon"><i
                                                        class="feather icon-check-circle"></i><b>A</b></span>
                                                <span class="pcoded-mtext">Logs</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-check-circle"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Maps</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="<?php if(Request::is('mapDatatableFamily') || Request::is('mapDatatableFamily/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('mapDatatableFamily')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Family map</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('mapDatatableSHG') || Request::is('mapDatatableSHG/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('mapDatatableSHG')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">SHG map</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('mapDatatableCluster') || Request::is('mapDatatableCluster/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('mapDatatableCluster')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Cluster map</span>
                                                </a>
                                            </li>

                                            <li class="<?php if(Request::is('mapDatatable') || Request::is('mapDatatable/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('mapDatatable')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Federation map</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    
                                    <li class="pcoded-hasmenu <?php if(Request::is('fedreports') || Request::is('fedreports/*') || Request::is('clusterreport')): ?> pcoded-trigger <?php endif; ?>">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-check-circle"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Reports</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="<?php if(Request::is('fedreports') || Request::is('fedreports/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('fedreports')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Analytics/Initial Rating
                                                        Results</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('CummulativeReport') || Request::is('CummulativeReport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('CummulativeReport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Cummulative Report</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('FamilyWealthReport') || Request::is('FamilyWealthReport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('FamilyWealthReport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Family Wealth Report</span>
                                                </a>
                                            </li>

                                            <li class="<?php if(Request::is('FacilitatorWiseReport') || Request::is('FacilitatorWiseReport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('FacilitatorWiseReport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Facilitator Wise Report</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('creditreport') || Request::is('CreditReport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('creditreport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Credit Report</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('creditloanreport') || Request::is('creditloanreport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('creditloanreport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Credit Loan Report</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('processStepreport') || Request::is('processStepreport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('processStepreport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Process Step Report</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('ManagerWiseReport') || Request::is('ManagerWiseReport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('ManagerWiseReport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Manager Wise Report</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('QualityWiseReport') || Request::is('QualityWiseReport/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('QualityWiseReport')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Quality Wise Report</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="pcoded-hasmenu ">
                                        <a href="javascript:void(0)">
                                            <span class="pcoded-micon"><i
                                                    class="feather icon-check-circle"></i><b>A</b></span>
                                            <span class="pcoded-mtext">Data Export</span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <li class="<?php if(Request::is('family_export') || Request::is('family_export/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('family_export')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Family Export</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('shg_export') || Request::is('shg_export/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('shg_export')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">SHG Export</span>
                                                </a>
                                            </li>
                                            <li class="<?php if(Request::is('cluster_export') || Request::is('cluster_export/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('cluster_export')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Cluster Export</span>
                                                </a>
                                             </li>
                                            <li class="<?php if(Request::is('federation_export') || Request::is('federation_export/*')): ?> active <?php endif; ?>">
                                                <a href="<?php echo e(url('federation_export')); ?>">
                                                    <span class="pcoded-micon"><i
                                                            class="feather feather icon-award"></i><b>A</b></span>
                                                    <span class="pcoded-mtext">Federation Export</span>
                                                </a>
                                             </li>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </nav>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content pl-0">
                            <div class="main-body">
                                <?php echo $__env->yieldContent('content'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade user_dialog" id="user_dialog" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Notification</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="" id="module" />
                    <input type="hidden" value="" id="module_id_val" />
                    <input type="hidden" value="" id="not_value" />
                    <input type="hidden" value="" id="module_guid_val" />
                    <p id="pass_id"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light notif_read">Ok</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).on("click", ".all_read", function() {

            $.ajax({
                type: 'GET',
                url: '/get_allnotification_read',
                data: '_token = <?php echo csrf_token(); ?>',
                success: function(data) {
                    if (data != '') {
                        location.reload();
                    }
                }
            });
        });
        $('.out').click(function() {
        //    alert('hii');
           
        
            $.ajax({
                    type: 'GET',
                    url: '/logout_detail',
                    data: '_token = <?php echo csrf_token(); ?>',
                    success: function(data) {
                        if (data != '') {
                           
                            
                        }
                    }
                });
               
            document.getElementById('logout-form').submit();
           
            
        });
        function notif_read($id,elem) {
           
            var message = $(elem).find('p').html();
            var notification_id = $id;
            
            bootbox.confirm({
                title: "Notification",
                message: message,
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function(result) {
                    if (result) {
                        if (notification_id > 0) {
                            $.ajax({
                                type: 'GET',
                                url: '/get_notification_read',
                                data: '_token = <?php echo csrf_token(); ?>&notification_id=' + notification_id,
                                success: function(data) {
                                    //alert(data);
                                    if (data != '') {
                                        location.reload();

                                    }
                                }
                            });
                        }
                    }
                }
            });
        }
    </script>
    <!-- Required Jquery -->
    <script type="text/javascript" src="<?php echo e(asset('bower_components\popper.js\js\popper.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('bower_components\bootstrap\js\bootstrap.min.js')); ?>"></script>
    <!-- jquery slimscroll js -->
    <script type="text/javascript" src="<?php echo e(asset('bower_components\jquery-slimscroll\js\jquery.slimscroll.js')); ?>">
    </script>
    <!-- modernizr js -->
    <script type="text/javascript" src="<?php echo e(asset('bower_components\modernizr\js\modernizr.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('bower_components\modernizr\js\css-scrollbars.js')); ?>"></script>

    <!-- Bootstrap date-time-picker js -->
    <script type="text/javascript"
        src="<?php echo e(asset('bower_components\bootstrap-datepicker\js\bootstrap-datepicker.min.js')); ?>"></script>
    <!-- Chart js -->
    <script type="text/javascript" src="<?php echo e(asset('bower_components\chart.js\js\Chart.js')); ?>"></script>

    <!-- light-box js -->
    <script type="text/javascript" src="<?php echo e(asset('bower_components\ekko-lightbox\js\ekko-lightbox.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('bower_components\lightbox2\js\lightbox.js')); ?>"></script>

    <script type="text/javascript" src="<?php echo e(asset('bower_components\select2\js\select2.full.min.js')); ?>"></script>
    <script type="text/javascript"
        src="<?php echo e(asset('bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('bower_components/multiselect/js/jquery.multi-select.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.quicksearch.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/pages/advance-elements/select2-custom.js')); ?>"></script>

    <!-- Custom js -->
    <script type="text/javascript" src="<?php echo e(asset('assets\js\pcoded.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\vartical-layout.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\script.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\export_table.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets\js\printThis.js')); ?>"></script>
    <!-- sweet alert js-->
    <script type="text/javascript" src="<?php echo e(asset('bower_components\moment\js\moment.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('bower_components\fullcalendar\js\fullcalendar.min.js')); ?>"></script>



    <style>
        .fc-day-grid-event .fc-content {
            text-overflow: ellipsis;
        }

        div.dataTables_wrapper>.row:nth-child(2)>div {
            overflow: auto;
        }

        .pcoded[theme-layout="vertical"] .pcoded-navbar .pcoded-item>li>a {
            padding: 3px 15px !important;
        }

        .page-header-breadcrumb {
            display: none !important;
        }

        .main-body .page-wrapper .page-header {
            margin-bottom: 15px !important;
        }

        .main-body .page-wrapper {
            padding: 0.5rem !important;
        }

        .table td {
            padding: .0rem .30rem;
            vertical-align: middle !important;
        }

        .table th {
            padding: .60rem !important;
            vertical-align: middle !important;
        }

        .pcoded .pcoded-navbar .pcoded-item>li>a {
            font-size: 12px !important;
        }

        a,
        body {
            font-size: 12px !important;
        }

        .btn-sm {
            padding: 6px 10px !important;
        }

        select.form-control:not([size]):not([multiple]) {
            height: calc(2rem + 2px) !important;
        }

        .form-control {
            font-size: .8rem !important;
        }


        .day {
            color: #000 !important;
        }

        td.disabled {
            color: #bbb !important;
        }

        td.disabled:hover {
            background-color: #fff !important;
            cursor: default !important;
        }

        select {
            padding: .3rem .75rem !important;
        }

        fieldset {
            border: 1px solid #ccc;
            padding: 5px;
        }

        legend {
            width: auto;
        }

        @media (min-width: 1200px) {
            .container {
                max-width: 95% !important;
            }
        }
        .black{
        background-color: black;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').on('keyup keydown keypress', function(e) {
                e.preventDefault();
            });

            $(".eye_link").on('click', function(event) {
                event.preventDefault();
                var index = $(this).index('.eye_link');
                //alert(index);
                if ($('.show_hide_password').eq(index).find('input').attr("type") == "text") {
                    $('.show_hide_password').eq(index).find('input').attr('type', 'password');
                    $('.show_hide_password').eq(index).find('i').addClass("fa-eye-slash");
                    $('.show_hide_password').eq(index).find('i').removeClass("fa-eye");
                } else if ($('.show_hide_password').eq(index).find('input').attr("type") == "password") {
                    $('.show_hide_password').eq(index).find('input').attr('type', 'text');
                    $('.show_hide_password').eq(index).find('i').removeClass("fa-eye-slash");
                    $('.show_hide_password').eq(index).find('i').addClass("fa-eye");
                }
            });
        });
    </script>
    <?php if(Request::is('federation/create') || Request::is('cluster/create')): ?>
        <script>
            $(function() {
                $('#mobile-collapse').trigger('click');
            })
        </script>
    <?php endif; ?>
</body>

</html>
<?php /**PATH D:\xampp\htdocs\village\resources\views/layouts/app.blade.php ENDPATH**/ ?>