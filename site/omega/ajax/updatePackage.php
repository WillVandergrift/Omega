<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 1/2/14
 * Time: 12:52 PM
 */

require_once "../database/database.php";
require_once "../database/packages.php";
require_once "../model/package.php";

if (!isset($_POST['txtPackageId']) || !isset($_POST['txtPackageName']) ||
    !isset($_POST['txtPackageCommand']) || !isset($_POST['txtPackageUser']) ||
    !isset($_POST['txtPackagePassword']))
{
    //Exit if the required fields weren't provided
    exit;
}

//Get the package ID
$id = $_POST['txtPackageId'];

//Get the package name
$name = $_POST['txtPackageName'];

//Get the package command
$command = $_POST['txtPackageCommand'];

//Get the package user
$user = $_POST['txtPackageUser'];

//Get the package password
$password = $_POST['txtPackagePassword'];

//Check to see if the user set a description. If not, set a default value
if (isset($_POST['txtPackageDescription']) && !empty($_POST['txtPackageDescription']))
{
    $description = $_POST['txtPackageDescription'];
}
else
{
    $description = "";
}

//Check to see if the user set an icon. If not, set a default value
if (isset($_POST['txtPackageIcon']) && !empty($_POST['txtPackageIcon']))
{
    $icon = $_POST['txtPackageIcon'];
}
else
{
    $icon = "/assets/images/apps/software-icon.png";
}

//Check to see if the user set show message. If not, set a default value
if (isset($_POST['chkPackageShowMessage']) && !empty($_POST['chkPackageShowMessage']))
{
    if ($_POST['chkPackageShowMessage'] == 'on')
    {
        $showMessage = 'true';
    }
    else
    {
        $showMessage = 'false';
    }
}
else
{
    $showMessage = "false";
}

//Check to see if the user set a message. If not, set a default value
if (isset($_POST['txtPackageMessage']) && !empty($_POST['txtPackageMessage']))
{
    $message = $_POST['txtPackageMessage'];
}
else
{
    $message = "";
}


//Update the package in the database
echo updatePackage($id, $name, $description, $command, $icon, $user, $password, $showMessage, $message);