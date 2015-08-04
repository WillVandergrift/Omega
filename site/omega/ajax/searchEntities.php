<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 1/12/14
 * Time: 10:53 PM
 */

require_once "../database/database.php";
require_once "../database/devices.php";
require_once "../database/preferences.php";
require_once "../model/device.php";
require_once "../model/result.php";

if (!isset($_POST['searchValue']))
{
    //Exit if a search phrase wasn't provided
    exit;
}

//Get the page number
$searchValue = $_POST['searchValue'];

//Setup an array to store our search results
$searchResults = array();
$devicesResult = searchDevicesByName($searchValue);

if ($devicesResult != null && count($devicesResult) > 0)
{
    $searchResults = array_merge($searchResults, $devicesResult);
}

if (count($searchResults) > 0)
{
    echo json_encode($searchResults);
}
else
{
    echo null;
}