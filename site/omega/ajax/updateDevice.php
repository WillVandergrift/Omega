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

if (!isset($_POST['txtDeviceId']) || !isset($_POST['txtDeviceName']) || !isset($_POST['txtDeviceHostname']) || !isset($_POST['txtDevicePort']))
{
    //Exit if a list of devices wasn't provided
    exit;
}

//Get the device ID
$id = $_POST['txtDeviceId'];

//Get the device name
$name = $_POST['txtDeviceName'];

//Get the device
$hostname = $_POST['txtDeviceHostname'];

//Get the list of devices that the user wants to add to the database
$port = $_POST['txtDevicePort'];

//Check to see if the user included a description. If not, create an empty string
if (isset($_POST['txtDeviceDesc']) && !empty($_POST['txtDeviceDesc']))
{
    $description = $_POST['txtDeviceDesc'];
}
else
{
    $description = "";
}

//Check to see if the user included a roomId. If not, place the device in the unknown room
if (isset($_POST['txtDeviceRoomId']) && !empty($_POST['txtDeviceRoomId']))
{
    $roomId = $_POST['txtDeviceRoomId'];
}
else
{
    $roomId = "1";
}

//Update the devices in the database
echo updateDevice($id, $roomId, $name, $description, $hostname, $port);