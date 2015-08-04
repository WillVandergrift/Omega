<?php
require "database/database.php";
require "database/user.php";
require "model/user.php";

//Start a session for the user
session_start();

//destroy any existing session
if ( isset($_SESSION['curUser']) )
{
    session_destroy();
}

$loginError = 0;

//Process user login
if ($_POST)
{
    //Get posted variables
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $result = getUserFromDb($user, $pass);

    if ($result == null)
    {
        $loginError = 1;
    }
    else
    {
        $loginError = 0;
        $_SESSION["curUser"] = $result;
        header("location:dashboard.php");
    }
}
?>

<!-- AUI Framework -->
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>AgileUI</title>
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
    <link rel="stylesheet" type="text/css" href="assets/css/minified/aui-production.min.css">

    <!-- Omega Login CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/index.css">

    <!-- Theme UI -->
    <link id="layout-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/layouts/default.min.css">
    <link id="elements-theme" rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/color-schemes/elements/default.min.css">

    <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/responsive.min.css">

    <!-- AgileUI Animations -->
    <link rel="stylesheet" type="text/css" href="assets/themes/minified/agileui/animations.min.css">


    <!-- Omega Authentication -->
    <script type="text/javascript">



        jQuery(function(){
            jQuery('#login').submit(function(){
                var user = jQuery('#username').val();
                var pass = jQuery('#password').val();
                if(user == '' || pass == '') {
                    alert('test');
                    jQuery('.login-alert').show();
                    return false;
                }
            });

            'document.getElementById("username").focus();
        });
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
        <form id="login"  method="post" class="col-md-3 center-margin form-vertical mrg25T" >
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
                                <input placeholder="Password" data-trigger="keyup" name="password" id="password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button-pane">
                    <button type="submit" class="btn large primary-bg text-transform-upr font-bold font-size-11 radius-all-4">
                                <span class="button-content">
                                    Login
                                </span>
                    </button>
                </div>
            </div>
            <div class="login-alert">
                <div class="divider"></div>
                <div class="form-row text-center">
                    <div data-layout="center" data-type="warning" class="bg-red btn large noty radius-all-100">
                                <span class="button-content pad20L pad20R">
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
        Omega UI - 2013
    </div>
</div><!-- #page-footer-wrapper -->

</body>
</html>
