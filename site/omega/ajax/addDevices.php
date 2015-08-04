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

if (!isset($_POST['txtDeviceName']))
{
    //Exit if a list of devices wasn't provided
    exit;
}

//Get the list of devices that the user wants to add to the database
$devices = $_POST['txtDeviceName'];

//Check to see if the user included a description. If not, create an empty string
if (isset($_POST['txtDeviceDesc']))
{
    $description = $_POST['txtDeviceDesc'];
}
else
{
    $description = "";
}

//Insert the devices into the database
echo bulkInsertDevices($devices,$description);