<?php


//Load our session
session_start();

//Check for an empty session
if(isset($_SESSION['curUser']) && !empty($_SESSION['curUser']))
{
    header( 'Location: dashboard.php' );
}

?>

<!-- AUI Framework -->
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Omega UI</title>
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
    <link rel="stylesheet" type="text/css" href="assets/css/minified/aui-production.min.css">

    <!-- Omega Login CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">

    <!-- Theme UI -->
    <link id="layout-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/layouts/default.min.css">
    <link id="elements-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/elements/default.min.css">

    <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/responsive.min.css">

    <!-- AgileUI Animations -->
    <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/animations.min.css">

    <!-- jQuery -->
    <script type="text/javascript" src="assets/js/minified/jquery/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="assets/js/minified/jquery/jquery.form.min.js"></script>

    <!-- JS Header -->
    <script type="text/javascript" src="assets/js/header.js" ></script>

    <!-- Login Authentication -->
    <script type="text/javascript">
        //Set focus to the username field
        jQuery(document).ready(function() {
            jQuery("#username").focus();

        }); //End set field focus


        //Prepare Ajax form options
        jQuery(document).ready(function() {
            var options = {
                beforeSubmit:   validateLoginForm,  //pre-submit callback used for form validation
                success:        loginSuccess        //post-submit callback
            };

            //Bind form using ajaxForm
            jQuery('#loginForm').ajaxForm(options);

        }); //End prepare Ajax form options


        //Pre-submit verification callback
        function validateLoginForm (formData, jqForm, options) {
            //Check to see if both username and password have been filled out
            var form = jqForm[0];

            //If one of the fields is left blank, display error, clear fields, and set focus to username
            if (!form.username.value || !form.password.value){
                jQuery("#loginAlertMessgae").text("Username and password are required");
                jQuery("#loginAlert").fadeIn();
                jQuery("#username").val("");
                jQuery("#password").val("");
                jQuery("#username").focus();
                return false;
            }

            //Form fields validate
            return true;
        }

        //Successful login attempt
        function loginSuccess (responseText, statusText, xhr, $form) {
            if (responseText == 1)
            {
                jQuery("#loginAlert").hide();

                //Load the main interface
                window.location.replace("dashboard.php");
            }
            else if (responseText == 0)
            {
                //Failed login attempt

                //Display error div
                jQuery("#loginAlertMessgae").text("Invalid username or password");
                jQuery("#loginAlert").fadeIn();

                //clear password field and set focus
                jQuery("#password").val("");
                jQuery("#password").focus();
            }

        }
    </script>
</head>
<body>

<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
<![endif]-->

<div id="login-page" class="mrg25B">

    <div id="page-header" class="clearfix">
        <div id="page-header-wrapper" class="clearfix">
            <div id="header-logo">
                Omega <i class="opacity-80">UI</i>
            </div>
        </div>
    </div><!-- #page-header -->

</div>
<div class="pad20A">

    <div class="row">
        <div class="clear"></div>
        <form id="loginForm"  method="post" action="ajax/login.php" class="col-md-3 center-margin form-vertical mrg25T" >
            <div id="login-form" class="content-box drop-shadow">
                <h3 class="content-box-header ui-state-default">
                    <div class="glyph-icon icon-separator">
                        <i class="glyph-icon icon-user"></i>
                    </div>
                    <span>Login</span>
                </h3>
                <div class="content-box-wrapper pad20A pad0B">
                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="login_user">
                                Username:
                            </label>
                        </div>
                        <div class="form-input col-md-10">
                            <div class="form-input-icon">
                                <i class="glyph-icon icon-user ui-state-default"></i>
                                <input placeholder="Username" data-trigger="change" type="text" name="username" id="username">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-label col-md-2">
                            <label for="login_pass">
                                Password:
                            </label>
                        </div>
                        <div class="form-input col-md-10">
                            <div class="form-input-icon">
                                <i class="glyph-icon icon-unlock-alt ui-state-default"></i>
                                <input placeholder="Password" data-trigger="keyup" name="password" type="password" id="password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-pane">
                    <button id="btnLogin" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4">
                                <span class="button-content">
                                    Login
                                </span>
                    </button>
                </div>
            </div>
            <div id="loginAlert">
                <div class="divider"></div>
                <div class="form-row text-center">
                    <div data-layout="center" data-type="warning" class="bg-red btn large noty radius-all-100">
                                <span id="loginAlertMessage" class="button-content pad20L pad20R">
                                    Invalid username or password
                                </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="page-footer-wrapper" class="login-footer">
    <div id="page-footer">
        Omega UI - <?php print(Date("Y")); ?>
    </div>
</div><!-- #page-footer-wrapper -->

</body>
</html>
