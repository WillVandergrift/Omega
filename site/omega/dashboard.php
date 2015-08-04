<?php

require_once "database/database.php";
require_once "database/authentication.php";
require_once "database/devices.php";
require_once "database/packages.php";
require_once "database/buildings.php";
require_once "model/authentication.php";
require_once "model/device.php";
require_once "model/package.php";
require_once "model/building.php";

//Load our session
session_start();

//Check for an empty session
if(isset($_SESSION['curUser']) && !empty($_SESSION['curUser']))
{
    $curUser = $_SESSION['curUser'];
}
else
{
    header( 'Location: index.php' );
}

?>

<!-- AUI Framework -->
<!DOCTYPE html>
    <html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Omega</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Favicons -->

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/icons/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/icons/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/icons/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/images/icons/apple-touch-icon-57-precomposed.png">
        <meta name="msapplication-square150x150logo" content="assets/images/icons/app-icon-150.png">
        <meta name="msapplication-TileColor" content="#000">
        <link rel="shortcut icon" href="assets/images/icons/favicon.png">

        <!--[if lt IE 9]>
          <script src="assets/js/minified/core/html5shiv.min.js"></script>
          <script src="assets/js/minified/core/respond.min.js"></script>
        <![endif]-->

        <!-- AgileUI CSS Core -->
        <link rel="stylesheet" type="text/css" href="assets/css/minified/app-development.css">

        <!-- Dashboard CSS -->
        <link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">

        <!-- Theme UI -->
        <link id="layout-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/layouts/default.min.css">
        <link id="elements-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/elements/default.min.css">

        <!-- AgileUI Responsive -->
        <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/responsive.min.css">

        <!-- AgileUI Animations -->
        <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/animations.min.css">

        <!-- AgileUI JS -->
        <script type="text/javascript" src="assets/js/minified/aui-production.min.js"></script>

        <!-- JS Header -->
        <script type="text/javascript" src="assets/js/header.js" ></script>

    </head>
    <body class="fixed-sidebar fixed-header close-sidebar">
        

        <div id="loading" class="ui-front loader ui-widget-overlay bg-white opacity-100">
            <img src="assets/images/loader-dark.gif" alt="">
        </div>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div id="page-wrapper" class="demo-example">

            <div id="page-main">

                <div id="page-main-wrapper">

                    <!-- Include the header block -->
                    <?php include 'blocks/header.php' ?>

                    <div id="page-content">

                        <div class="row mrg30A">
                            <!-- Spacer for top of page -->
                        </div>

                        <!-- Row 1 -->
                        <div class="row mrg10A">

                            <div class="col-md-2">
                                <!-- Spacer for Left Column -->
                            </div>

                            <!-- Devices Dashboard -->
                            <div class="col-md-4 mrg20T">
                                <a href="devices.php" class="tile-button btn clearfix bg-white" title="">
                                    <div class="tile-header pad10A font-size-13 popover-title">
                                        Devices
                                    </div>
                                    <div class="tile-content-wrapper">
                                        <i class="glyph-icon icon-desktop"></i>
                                        <div class="tile-content">
                                            <?php echo getDeviceCount(); ?>
                                        </div>
                                        <small>
                                            Devices in Database
                                        </small>
                                    </div>
                                    <div class="tile-footer mrg5A primary-bg">
                                        view details
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </div>
                                </a>
                            </div> <!-- End Devices Dashboard -->

                            <!-- Packages Dashboard -->
                            <div class="col-md-4 mrg20T">

                                <a href="packages.php" class="tile-button btn clearfix bg-white" title="">
                                    <div class="tile-header pad10A font-size-13 popover-title">
                                        Packages
                                    </div>
                                    <div class="tile-content-wrapper">
                                        <i class="glyph-icon icon-suitcase"></i>
                                        <div class="tile-content">
                                            <?php echo getPackageCount(); ?>
                                        </div>
                                        <small>
                                            Packages in Database
                                        </small>
                                    </div>
                                    <div class="tile-footer mrg5A primary-bg">
                                        view details
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </div>
                                </a>
                            </div>  <!-- End Packages Dashboard -->

                        </div> <!-- End Row 1 -->

                        <!-- Row 2 -->
                        <div class="row mrg10A">

                            <div class="col-md-2">
                                <!-- Spacer for Left Column -->
                            </div>

                            <!-- Users Dashboard -->
                            <div class="col-md-4 mrg20T">
                                <a href="javascript:;" class="tile-button btn clearfix bg-white" title="">
                                    <div class="tile-header pad10A font-size-13 popover-title">
                                        Users
                                    </div>
                                    <div class="tile-content-wrapper">
                                        <i class="glyph-icon icon-user"></i>
                                        <div class="tile-content">
                                            1
                                        </div>
                                        <small>
                                            Users in Database
                                        </small>
                                    </div>
                                    <div class="tile-footer mrg5A primary-bg">
                                        view details
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </div>
                                </a>
                            </div> <!-- End Devices Dashboard -->

                            <!-- Buildings Dashboard -->
                            <div class="col-md-4 mrg20T">

                                <a href="buildings.php" class="tile-button btn clearfix bg-white" title="">
                                    <div class="tile-header pad10A font-size-13 popover-title">
                                        Buildings
                                    </div>
                                    <div class="tile-content-wrapper">
                                        <i class="glyph-icon icon-building-o"></i>
                                        <div class="tile-content">
                                            <?php echo getBuildingCount(); ?>
                                        </div>
                                        <small>
                                            Buildings in the District
                                        </small>
                                    </div>
                                    <div class="tile-footer mrg5A primary-bg">
                                        view details
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </div>
                                </a>
                            </div>  <!-- End Buildings Dashboard -->

                        </div> <!-- End Row 2 -->

                        <!-- Row 3 -->
                        <div class="row mrg10A">

                            <div class="col-md-2">
                                <!-- Spacer for Left Column -->
                            </div>

                            <!-- Settings Dashboard -->
                            <div class="col-md-4 mrg20T">

                                <a href="javascript:;" class="tile-button btn clearfix bg-white" title="">
                                    <div class="tile-header pad10A font-size-13 popover-title">
                                        Settings
                                    </div>
                                    <div class="tile-content-wrapper">
                                        <i class="glyph-icon icon-gears"></i>
                                        <div class="tile-content">
                                            Settings
                                        </div>
                                        <small>
                                            User and System Settings
                                        </small>
                                    </div>
                                    <div class="tile-footer mrg5A primary-bg">
                                        view details
                                        <i class="glyph-icon icon-arrow-right"></i>
                                    </div>
                                </a>
                            </div>  <!-- End Settings Dashboard -->

                        </div> <!-- End Row 3 -->

                        <div class="row mrg20A">

                	</div><!-- #page-content -->
	            </div><!-- #page-main -->
            </div><!-- #page-main-wrapper -->
        </div><!-- #page-wrapper -->
    </body>