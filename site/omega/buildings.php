<?php

require_once "database/database.php";
require_once "database/authentication.php";
require_once "database/buildings.php";
require_once "database/rooms.php";
require_once "model/authentication.php";
require_once "model/building.php";
require_once "model/room.php";

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

        <!-- Building JS -->
        <script type="text/javascript" src="assets/js/buildings.js"></script>



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

                    <!-- Add Building Popup -->
                    <div class="hide" id="modal-add-building" title="Add Building Dialog">
                        <div class="pad10A">
                            <div class="content-box remove-border dashboard-buttons clearfix">
                                <!-- Heading for form validation -->
                                <h4 id="addBuildingWarning" class="hidden heading-1 bg-black radius-all-4 btn text-left pad10A clearfix">
                                    <i class="bg-dark-red radius-all-100 glyph-icon icon-exclamation heading-icon"></i>
                                    <div class="heading-content font-white">
                                        Building Name is a required field
                                        <small>Please enter a building to add</small>
                                    </div>
                                </h4>

                                <!-- Form for adding a new building -->
                                <form id="addBuildingForm"  method="post" action="ajax/addBuilding.php" class="col-md-12 form-vertical center-margin">
                                    <div class="form-row">
                                        <div class="form-label col-md-6">
                                            <label for class="label-description">
                                                Building Name:
                                            </label>
                                        </div>
                                        <div class="form-input col-md-6">
                                            <textarea class="small-textarea textarea-no-resize" id="txtDeviceName" name="txtBuildingName"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-label col-md-6">
                                            <label for class="label-description">
                                                Description:
                                            </label>
                                        </div>
                                        <div class="form-input col-md-6">
                                            <textarea class="medium-textarea textarea-no-resize" id="txtDeviceDesc" name="txtBuildingDesc"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <button id="btnAddBuilding" class="btn medium bg-dark-green mrg5A">
                                                <span class="button-content">
                                                    <i class="glyph-icon icon-plus float-left"></i>
                                                        Add Building
                                                </span>
                                        </button>
                                        <a href="javascript:closeAddBuildingDialog();" class="btn medium bg-dark-red mrg5A">
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

                    <h4 class="heading-1 clearfix">
                        <div class="heading-1 bg-black btn text-left display-block pad10A clearfix">
                            <i class="bg-blue-alt radius-all-100 glyph-icon icon-building-o heading-icon"></i>
                            <div class="heading-content font-white">
                                Buildings
                                <small>
                                    Below is a list of all buildings in the district
                                </small>
                            </div>
                        </div>
                        <div class="clear"></div>

                        <!-- Toolbar -->
                        <!-- Add Device -->
                        <a href="javascript:openAddBuildingDialog();" class="btn medium bg-dark-green mrg10T mrg15L">
                            <i class="glyph-icon icon-separator icon-plus float-left"></i>
                                <span class="button-content">
                                    Add Building
                                </span>
                        </a>
                        <!-- End Toolbar -->
                    </h4>

                    <div class="example-box">
                        <div class="example-code">

                            <table class="table table-striped text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Rooms</th>
                                        <th class="text-center">Actions</th>
                                        <th>Name</th>
                                        <th class="text-center">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Display a list of buildings in the database -->
                                    <?php getBuildings("table", null) ?>
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
