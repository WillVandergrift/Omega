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

$curPackage = getPackageById($_GET['packageId']);

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

        <!-- AgileUI Animations -->
        <link rel="stylesheet" type="text/css" href="assets/css/minified/form-elements.css">

        <!-- AgileUI JS -->
        <script type="text/javascript" src="assets/js/minified/aui-production.min.js"></script>

        <!-- JQuery Form -->
        <script type="text/javascript" src="assets/js/minified/jquery/jquery.form.min.js"></script>

        <!-- Parsley Validation JS -->
        <script type="text/javascript" src="assets/js/minified/validation/parsley.min.js"></script>

        <!-- Package JS -->
        <script type="text/javascript" src="assets/js/package.js"></script>

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
                            <i class="bg-blue-alt radius-all-100 glyph-icon icon-briefcase heading-icon"></i>
                            <div class="heading-content font-white">
                                <?php echo $curPackage->name ?>
                                <small>
                                    <?php echo $curPackage->description ?>
                                </small>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <!-- Toolbar -->
                        <!-- Save Package -->
                        <a href="javascript:submitUpdatePackageForm();" class="btn medium bg-dark-green mrg10T mrg15L">
                            <i class="glyph-icon icon-separator icon-save float-left"></i>
                                <span class="button-content">
                                    Save Changes
                                </span>
                        </a>
                        <!-- Delete Package -->
                        <a href="javascript:;" class="btn medium bg-dark-red mrg10T mrg15L">
                            <i class="glyph-icon icon-separator icon-clock-os-circle float-left"></i>
                                <span class="button-content">
                                    Delete Package
                                </span>
                        </a>

                        <!-- End Toolbar -->
                    </h4>

                    <div class="example-box">
                        <!-- Heading for form validation -->
                        <h4 id="updatePackageWarning" class="hidden heading-1 bg-black radius-all-4 btn text-left pad10A clearfix">
                            <i class="bg-dark-red radius-all-100 glyph-icon icon-exclamation heading-icon"></i>
                            <div class="heading-content font-white">
                                Package Name, Command, username and password are all required fields
                                <small>Please complete the fields marked with an asterisk (*)</small>
                            </div>
                        </h4>

                        <!-- Form for updating device details -->
                        <form id="packageDetailsForm" method="post" action="ajax/updatePackage.php" class="col-md-12 form-vertical center-margin">

                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Package Details -->
                                <div class="content-box mrg25A">
                                    <h3 class="content-box-header primary-bg">
                                        <span>Package Details</span>
                                    </h3>
                                    <div class="content-box-wrapper">
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    * Package Name:
                                                    <span>The friendly name for the package</span>
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <input type="text" placeholder="Package Name"
                                                       name="txtPackageName" id="txtPackageName"
                                                       parsley-required="true"
                                                       value="<?php echo $curPackage->name ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    Description:
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <textarea class="medium-textarea textarea-no-resize"
                                                          id="txtPackageDescription"
                                                          name="txtPackageDescription"
                                                    ><?php echo $curPackage->description ?></textarea>
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
                                <!-- Authentication Details -->
                                <div class="content-box mrg25A">
                                    <h3 class="content-box-header primary-bg">
                                        <span>Authentication</span>
                                    </h3>
                                    <div class="content-box-wrapper">
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    * User:
                                                    <span>The user account used to run the command on the device</span>
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <input type="text" placeholder="User"
                                                       name="txtPackageUser" id="txtPackageUser"
                                                       parsley-required="true"
                                                       value="<?php echo $curPackage->user ?>"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <!-- Password field -->
                                            <div class="col-md-6">
                                                <div class="form-label">
                                                    <label for class="label-description">
                                                        * Password:
                                                        <span>The password for the user account above</span>
                                                    </label>
                                                </div>
                                                <div class="form-input">
                                                    <input type="password" name="txtPackagePassword"
                                                           id="txtPackagePassword"
                                                           parsley-required="true"
                                                           parsley-equalto="#txtPackagePassword"
                                                           value="<?php echo $curPackage->password ?>"/>
                                                </div>
                                            </div>

                                            <!-- Confirm password field -->
                                            <div class="col-md-6">
                                                <div class="form-label">
                                                    <label for class="label-description">
                                                        Confirm Password:
                                                        <span>Confirm the password</span>
                                                    </label>
                                                </div>
                                                <div class="form-input">
                                                    <input type="password" name="txtPackagePasswordConfirm"
                                                           id="txtPackagePasswordConfirm"
                                                           parsley-equalto="#txtPackagePassword"
                                                           parsley-required="true"
                                                           value="<?php echo $curPackage->password ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Package Message -->
                                <div class="content-box mrg25A">
                                    <h3 class="content-box-header primary-bg">
                                        <span>Message</span>
                                    </h3>
                                    <div class="content-box-wrapper">
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    Display Message:
                                                    <span>Display a message to the user on package launch</span>
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <div class="onoffswitch">
                                                    <!-- Set the checkbox current state -->
                                                    <?php if ($curPackage->showMessage == 'true'): ?>
                                                        <input type="checkbox" name="chkPackageShowMessage" class="onoffswitch-checkbox" id="chkPackageShowMessage" checked>
                                                    <?php else: ?>
                                                        <input type="checkbox" name="chkPackageShowMessage" class="onoffswitch-checkbox" id="chkPackageShowMessage">
                                                    <?php endif; ?>
                                                    <label class="onoffswitch-label" for="chkPackageShowMessage">
                                                        <div class="onoffswitch-inner"></div>
                                                        <div class="onoffswitch-switch"></div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-label col-md-6">
                                                <label for class="label-description">
                                                    Message:
                                                </label>
                                            </div>
                                            <div class="form-input col-md-6">
                                                <textarea class="large-textarea textarea-no-resize"
                                                          id="txtPackageMessage"
                                                          name="txtPackageMessage"
                                                    ><?php echo $curPackage->message ?></textarea>
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
