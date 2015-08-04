<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/31/13
 * Time: 11:19 AM
 */

require_once "../database/database.php";
require_once "../database/devices.php";
require_once "../model/device.php";

//Get the device ID that the user wants to execute a command on
$deviceId = $_POST['deviceId'];

//Get Device Info
$device = getDeviceById($deviceId);

//encode the device object using json and echo the results
echo json_encode($device);
