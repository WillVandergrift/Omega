<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 1/2/14
 * Time: 12:52 PM
 */

require_once "../database/database.php";
require_once "../database/devices.php";
require_once "../model/device.php";

if (!isset($_POST['DeviceName']))
{
    //Exit if a list of devices wasn't provided
    exit;
}

//Get the device name
$hostName = $_POST['DeviceName'];

//Check to see if the username was included.
if (isset($_POST['Username']))
{
    $username = $_POST['Username'];
}
else
{
    $username = "";
}

//Set Last Check In Time
$checkIn = time();


//Check to see if the device exists in the database, If not, create it
$deviceExists = apiSearchDeviceByHostname($hostName);

if ($deviceExists == 0)
{
    $insertResult = insertDevice($hostName, "");

    if ($insertResult == 0)
    {
        //Failed to insert the device, exit
        echo "Failed to create new device";
        exit;
    }
}

//Update the device
$updateResult = apiUpdateDevice($hostName, $username, $checkIn);

echo $updateResult;