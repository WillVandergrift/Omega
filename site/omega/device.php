<?php

require_once "database/database.php";
require_once "database/authentication.php";
require_once "database/devices.php";
require_once "database/buildings.php";
require_once "database/rooms.php";
require_once "database/packages.php";
require_once "model/authentication.php";
require_once "model/device.php";
require_once "model/building.php";
require_once "model/room.php";
require_once "model/package.php";
require_once "helper/timeAgo.php";

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

$curDevice = getDeviceById($_GET['deviceId']);

$curRoom = getRoomById($curDevice->roomId);

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
        <link rel="shortcut icon" href="assets/images/icons/favicon.png?ver=1.3">

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

        <!-- Device JS -->
        <script type="text/javascript" src="assets/js/device.js"></script>

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

                    <br />
                    <br />

                    <div id="page-content">

                    <h4 class="heading-1 clearfix">
                        <div class="heading-1 bg-black btn text-left display-block pad10A clearfix">
                            <i class="bg-blue-alt radius-all-100 glyph-icon icon-desktop heading-icon"></i>
                            <div class="heading-content font-white">
                                <?php echo $curDevice->name ?>
                                <small>
                                    <?php echo $curDevice->description ?>
                                    <span>- Last check-in was <?php echo $curDevice->displayLastCheckIn(); ?></span>
                                </small>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <!-- Toolbar -->
                        <!-- Delete Device -->
                        <a href="javascript:submitUpdateDeviceForm();" class="btn medium bg-dark-green mrg10T mrg15L">
                            <i class="glyph-icon icon-separator icon-save float-left"></i>
                                <span class="button-content">
                                    Save Changes
                                </span>
                        </a>
                        <a href="javascript:;" class="btn medium bg-dark-red mrg10T mrg15L">
                            <i class="glyph-icon icon-separator icon-clock-os-circle float-left"></i>
                                <span class="button-content">
                                    Delete Device
                                </span>
                        </a>

                        <!-- End Toolbar -->
                    </h4>

                    <div class="example-box">
                        <!-- Heading for form validation -->
                        <h4 id="updateDeviceWarning" class="hidden heading-1 bg-black radius-all-4 btn text-left pad10A clearfix">
                            <i class="bg-dark-red radius-all-100 glyph-icon icon-exclamation heading-icon"></i>
                            <div class="heading-content font-white">
                                Device Name, Hostname, and VNC Port are all required fields
                                <small>Please complete the fields marked with an asterisk (*)</small>
                            </div>
                        </h4>

                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Device Details -->
                            <div class="content-box mrg25A">
                                <h3 class="content-box-header primary-bg">
                                    <span>Device Details</span>
                                </h3>
                                <div class="content-box-wrapper">
                                    <!-- Form for updating device details -->
                                    <form id="deviceDetailsForm"  method="post" action="ajax/updateDevice.php" class="col-md-12 form-vertical center-margin">
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    * Device Name:
                                                    <span>The friendly name for the device</span>
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <input type="text" placeholder="Device Name" name="txtDeviceName" id="txtDeviceName" value="<?php echo $curDevice->name ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    Description:
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <textarea class="medium-textarea textarea-no-resize" id="txtDeviceDesc" name="txtDeviceDesc"><?php echo $curDevice->description ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <!-- Building Select box -->
                                            <div class="col-md-6">
                                                <div class="form-label">
                                                    <label for class="label-description">
                                                        Building:
                                                    </label>
                                                </div>
                                                <div class="form-input">
                                                    <select id="buildingList" name="buildingList">
                                                        <?php getBuildings("list", $curRoom->buildingId); ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Room Select box -->
                                            <div class="col-md-6">
                                                <div class="form-label">
                                                    <label for class="label-description">
                                                        Room:
                                                    </label>
                                                </div>
                                                <div class="form-input">
                                                    <select id="roomList" name="roomList">
                                                        <?php getRoomsInBuilding($curRoom->buildingId, "list", $curRoom->id); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label col-md-2">
                                                <label for class="label-description">
                                                    * Hostname:
                                                    <span>The name or IP address used for remote access</span>
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <input type="text" placeholder="Hostname" name="txtDeviceHostname" id="txtDeviceHostname" value="<?php echo $curDevice->hostname ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    * VNC Port:
                                                    <span>The port used for VNC connections (Default 5950)</span>
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <input type="text" placeholder="VNC Port" name="txtDevicePort" id="txtDevicePort" value="<?php echo $curDevice->vncPort ?>"/>
                                            </div>
                                        </div>

                                        <!-- Hidden field for device ID -->
                                        <input type="hidden" name="txtDeviceId" id="txtDeviceId" value="<?php echo $curDevice->id ?>" />

                                        <!-- Hidden field for room ID -->
                                        <input type="hidden" name="txtDeviceRoomId" id="txtDeviceRoomId" value="" />
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Run Package -->
                            <div class="content-box mrg25A">
                                <h3 class="content-box-header primary-bg">
                                    <span>Run Package</span>
                                </h3>
                                <div class="content-box-wrapper">
                                    <div class="content-box remove-border mrg0A dashboard-buttons clearfix">
                                        <div class="max-height-483 vertical-overflow">
                                            <?php getPackagesIcons(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                	</div><!-- #page-content -->
	            </div><!-- #page-main -->
            </div><!-- #page-main-wrapper -->
        </div><!-- #page-wrapper -->

    </body>
</html>
