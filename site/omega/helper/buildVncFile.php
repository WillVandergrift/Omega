<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/17/13
 * Time: 3:54 PM
 * This script takes a template vnc file and create a vnc file for the given computer
 */

require "../database/database.php";
require "../database/devices.php";
require "../model/device.php";

//Get the device ID that the user wants to connect to
$deviceId = $_GET['deviceId'];

//Query the database and return information about the device
$device = getDeviceById($deviceId);

//Create a copy of the vnc template and rename it to match the device name
$vncFile = "../vnc/sessions/" . $device->name . ".vnc";

copy("../vnc/template.vnc", $vncFile);

//Change the filename in the vnc file
$output = file_get_contents($vncFile);
$output = str_replace("[host]", $device->hostname, $output);
$output = str_replace("[port]", $device->vncPort, $output);
file_put_contents($vncFile, $output);

header('Content-Disposition: attachment; filename=' . $device->name . ".vnc");
header("Content-type: application/vnc");
readfile($vncFile);