<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/18/13
 * Time: 9:34 AM
 * This script runs a specified package on the target device
 */


require_once "../database/database.php";
require_once "../database/devices.php";
require_once "../database/packages.php";
require_once "../model/device.php";
require_once "../model/package.php";

//Get the device ID that the user wants to execute a command on
$deviceId = $_POST['deviceId'];

//Get the package ID that the user wants to execute
$packageId = $_POST['packageId'];

//Get Package Info
$package = getPackageById($packageId);

//Prepare the package for use
$package->parseCommand($deviceId);

//Execute the command
exec($package->command, $output, $err);

//Check to see if we should display a message to the user
//if ($package->showMessage = 'true')
//{
//    sleep(5);
//    $displayCmd = getPackageById('1');
//    $displayCmd->parseCommand($deviceId);
//    exec($displayCmd->command . $package->message , $output, $err);
//}

echo "Command: ";
echo $package->command;
