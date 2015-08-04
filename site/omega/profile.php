<?php

require_once "database/database.php";
require_once "database/authentication.php";
require_once "model/authentication.php";

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
                            <i class="bg-blue-alt radius-all-100 glyph-icon icon-user heading-icon"></i>
                            <div class="heading-content font-white">
                                <?php echo $curUser->firstName . " " . $curUser->lastName ?>
                                <small>
                                    User profile for <?php echo $curUser->firstName . " " . $curUser->lastName ?>
                                </small>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <!-- Toolbar -->
                        <!-- Change Password -->
                        <a href="javascript:preparePackageDialog( <?php echo $curUser->id ?> );" class="btn medium bg-black mrg10T mrg15L">
                            <i class="glyph-icon icon-separator icon-lock float-left"></i>
                                <span class="button-content">
                                    Change Password
                                </span>
                        </a>

                        <!-- End Toolbar -->
                    </h4>

                    <div class="example-box">

                    <!-- Form for updating user details -->
                    <form id="profileDetailsForm" method="post" action="ajax/updateProfile.php" class="col-md-12 form-vertical center-margin">

                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Package Details -->
                            <div class="content-box mrg25A">
                                <h3 class="content-box-header primary-bg">
                                    <span>Profile Details</span>
                                </h3>
                                <div class="content-box-wrapper">
                                    <div class="form-row">
                                        <!-- First Name field -->
                                        <div class="col-md-6">
                                            <div class="form-label">
                                                <label for class="label-description">
                                                    * First Name:
                                                </label>
                                            </div>
                                            <div class="form-input">
                                                <input type="text" name="txtProfileFirstName"
                                                       id="txtProfileFirstName"
                                                       parsley-required="true"
                                                       value="<?php echo $curUser->firstName ?>"/>
                                            </div>
                                        </div>

                                        <!-- Last Name field -->
                                        <div class="col-md-6">
                                            <div class="form-label">
                                                <label for class="label-description">
                                                    * Last Name:
                                                </label>
                                            </div>
                                            <div class="form-input">
                                                <input type="text" name="txtProfileLastName"
                                                       id="txtProfileLastName"
                                                       parsley-required="true"
                                                       value="<?php echo $curUser->lastName ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label col-md-2">
                                            <label for class="label-description">
                                                * Command:
                                                <span>The command to run on the device</span>
                                            </label>
                                        </div>
                                        <div class="form-input col-md-6">
                                            <textarea class="medium-textarea textarea-no-resize"
                                                      id="txtPackageCommand"
                                                      name="txtPackageCommand"
                                                      parsley-required="true"
                                                ><?php echo $curPackage->command ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <!-- Icon field -->
                                        <div class="col-md-6">
                                            <div class="form-label">
                                                <label for class="label-description">
                                                    Icon:
                                                    <span>path relative to: http://omega.osage.k12.mo.us</span>
                                                </label>
                                            </div>
                                            <div class="form-input">
                                                <input type="text" name="txtPackageIcon" id="txtPackageIcon" value="<?php echo $curPackage->icon ?>"/>
                                            </div>
                                        </div>

                                        <!-- icon preview -->
                                        <div class="col-md-6">
                                            <div class="form-label">
                                                <label for class="label-description">
                                                    Icon Preview
                                                    <span>Icons should be a 24x24 png file</span>
                                                </label>
                                            </div>
                                            <div class="form-input">
                                                <img class="max-width-24 max-height-24" id="imgPackageIconPreview" src="<?php echo $curPackage->icon ?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Mobile Device -->
                            <div class="content-box mrg25A">
                                <h3 class="content-box-header primary-bg">
                                    <span>Mobile Devices</span>
                                </h3>
                                <div class="content-box-wrapper">
                                    <div class="form-row">
                                        <div class="form-label col-md-6">
                                            <label for class="label-description text-center">
                                                App ID
                                                <span>Scan the QR Code from the mobile app to link your device with your account</span>
                                            </label>
                                        </div>
                                        <div class="form-label col-md-6 center-div">
                                            <img src="qr/displayAppId.php" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden field for device ID -->
                        <input type="hidden" name="txtPackageId" id="txtPackageId" value="<?php echo $curPackage->id ?>" />

                    </form>
                    </div>
                	</div><!-- #page-content -->
	            </div><!-- #page-main -->
            </div><!-- #page-main-wrapper -->
        </div><!-- #page-wrapper -->

    </body>
</html>
