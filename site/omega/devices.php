<?php

require_once "database/database.php";
require_once "database/authentication.php";
require_once "database/preferences.php";
require_once "database/devices.php";
require_once "database/packages.php";
require_once "model/authentication.php";
require_once "model/preferences.php";
require_once "model/device.php";
require_once "model/package.php";

//Load our session
session_start();

//Check for an empty session
if(isset($_SESSION['curUser']) && !empty($_SESSION['curUser']))
{
    $curUser = $_SESSION['curUser'];
    $myPreferences = $_SESSION["preferences"];
}
else
{
    header( 'Location: index.php' );
}

//Get the current page for pagination
if (isset($_POST['curPage']) && !empty($_POST['curPage']))
{
    $curPage = $_POST['curPage'];
}
else
{
    $curPage = 1;
}

//Pagination variables
$rowsPerPage = $myPreferences->rowsPerPage;
$numPages = getDevicePageCount($rowsPerPage);

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

        <!-- Theme UI -->
        <link id="layout-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/layouts/default.min.css">
        <link id="elements-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/elements/default.min.css">

        <!-- AgileUI Responsive -->
        <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/responsive.min.css">

        <!-- AgileUI Animations -->
        <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/animations.min.css">

        <!-- AgileUI JS -->
        <script type="text/javascript" src="assets/js/minified/aui-production.min.js"></script>

        <!-- JQuery Form -->
        <script type="text/javascript" src="assets/js/minified/jquery/jquery.form.min.js"></script>

        <!-- JS Header -->
        <script type="text/javascript" src="assets/js/header.js" ></script>

        <!-- JS Devices Page -->
        <script type="text/javascript" src="assets/js/devices.js" ></script>

    </head>
    <body class="fixed-header close-sidebar">
        <div id="loading" class="ui-front loader ui-widget-overlay bg-white opacity-100">
            <img src="assets/images/loader-dark.gif" alt="">
        </div>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->

        <div id="page-wrapper" class="demo-example">

        <!-- App Drawer -->
        <div id="app-drawer" class="hide app-drawer-background">
                <!-- Close Button -->
                <a href='javascript:closeAppDrawer();' class='btn large bg-black float-right'>
                    <i class='glyph-icon icon-chevron-up'></i>
                </a> <!-- End Close Button -->
                <div class="app-drawer-header">
                    <!-- Search Textbox -->
                    <input id="" class="tooltip-button" type="text" name="" title="" data-placement="right" placeholder="Search...">
                    <i class="glyph-icon icon-search"></i>
                    <!-- End Search Textbox -->
                </div>
                <div class="app-drawer">
                    <?php getPackages('grid'); ?>
                </div>
            </div>
            
            <div id="page-main">

                <div id="page-main-wrapper">
                    <!-- Add Device Popup -->
                    <div class="hide" id="modal-add-device" title="Add Device Dialog">
                        <div class="pad10A">
                            <div class="content-box remove-border dashboard-buttons clearfix">
                                    <!-- Heading for form validation -->
                                    <h4 id="addDeviceWarning" class="hidden heading-1 bg-black radius-all-4 btn text-left pad10A clearfix">
                                        <i class="bg-dark-red radius-all-100 glyph-icon icon-exclamation heading-icon"></i>
                                        <div class="heading-content font-white">
                                            Device Name is a required field
                                            <small>Please enter at least one device name to add</small>
                                        </div>
                                    </h4>

                                    <!-- Form for adding new devices -->
                                    <form id="addDeviceForm"  method="post" action="ajax/addDevices.php" class="col-md-12 form-vertical center-margin">
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    Device Name:
                                                    <span>Comma separate multiple names</span>
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <textarea class="medium-textarea textarea-no-resize" id="txtDeviceName" name="txtDeviceName"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    Description:
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <textarea class="small-textarea textarea-no-resize" id="txtDeviceDesc" name="txtDeviceDesc"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <button id="btnLogin" class="btn medium bg-dark-green mrg5A">
                                                <span class="button-content">
                                                    <i class="glyph-icon icon-plus float-left"></i>
                                                        Add Devices
                                                </span>
                                            </button>
                                            <a href="javascript:closeAddDeviceDialog();" class="btn medium bg-dark-red mrg5A">
                                                <span class="button-content">
                                                    <i class="glyph-icon icon-clock-os-circle float-left"></i>
                                                        Close
                                                </span>
                                            </a>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>

                    <!-- Include the header block -->
                    <?php include 'blocks/header.php' ?>

                    <br />
                    <br />

                    <div id="page-content">

                    <div id="loading-overlay" class="ui-front hide loader ui-widget-overlay bg-black opacity-60">
                        <img src="assets/images/loader-win8-light.gif" alt="" />
                    </div>

                    <h4 class="heading-1 clearfix">
                        <div class="heading-1 bg-black btn text-left display-block pad10A clearfix">
                            <i class="bg-blue-alt radius-all-100 glyph-icon icon-desktop heading-icon"></i>
                            <div class="heading-content font-white">
                                Devices
                                <small>
                                    Below is a list of devices in the organization that have been added to the database
                                </small>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <!-- Toolbar -->
                        <!-- Add Device -->
                        <a href="javascript:openAddDeviceDialog();" class="btn medium bg-dark-green mrg15L">
                            <i class="glyph-icon icon-separator icon-plus float-left"></i>
                                <span class="button-content">
                                    Add Device
                                </span>
                        </a>

                        <!-- Pagination Buttons -->
                        <div class="float-right" id="pagination-toolbar">
                            <a href="javascript:gotoPage(curPage - 1);" class="btn large bg-gray font-black mrg15L">
                                <i class="glyph-icon icon-arrow-left"></i>
                            </a>
                            <span class="mrg10L" id="paginationDisplay">Page 1 of 1</span>
                            <a href="javascript:gotoPage(curPage + 1);" class="btn large bg-gray font-black mrg15L">
                                <i class="glyph-icon icon-arrow-right"></i>
                            </a>
                        </div>


                    <!-- End Toolbar -->
                    </h4>

                    <div class="example-box">
                        <div class="example-code">
                            <table class="table text-center" id="tblDevices">
                                <colgroup>
                                    <col class="table-width-15pct" />
                                    <col class="table-width-25pct" />
                                    <col class="table-width-20pct" />
                                    <col class="table-width-40pct" />
                                </colgroup>

                                <thead>
                                    <tr>
                                        <th class="text-center">Actions</th>
                                        <th class="">Name</th>
                                        <th class="">Last User</th>
                                        <th class="">Description</th>
                                    </tr>
                                </thead>
                                <tbody id="deviceList">
                                    <!-- Display a list of devices in the database -->
                                    <?php getDevices($curPage, $rowsPerPage); ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                	</div><!-- #page-content -->
	            </div><!-- #page-main -->
            </div><!-- #page-main-wrapper -->
        </div><!-- #page-wrapper -->

    </body>
</html>
