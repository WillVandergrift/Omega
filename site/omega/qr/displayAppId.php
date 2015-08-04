<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 2/13/14
 * Time: 8:41 AM
 */

require_once "../model/authentication.php";
include "library/qrlib.php";

//Load our session
session_start();

//Set the header for a png image
header("Content-Type: image/png");

//Check for an empty session
if(isset($_SESSION['curUser']) && !empty($_SESSION['curUser']))
{
    $appId = $_SESSION['curUser']->appId;

    if (!empty($appId))
    {
        //Output the qr code
        QRcode::png("appId:" . $appId, false, QR_ECLEVEL_L, 5);
    }
    else
    {
        //Display an error image
        readfile("../assets/images/alert-icon.png");
    }
}
else
{
    //Display an error image
    readfile("../assets/images/alert-icon.png");
}