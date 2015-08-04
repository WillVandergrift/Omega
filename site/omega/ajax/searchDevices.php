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
require_once "../model/preferences.php";

//Load our session
session_start();

if (!isset($_POST['searchName']) || !isset($_POST['searchBuildings']) || !isset($_POST['searchRooms']))
{
    //Exit if a search phrase wasn't provided
    exit;
}

//Check to see if user preferences have been loaded, if not set default values
if(isset($_SESSION['preferences']) && !empty($_SESSION['preferences']))
{
    $rowsPerPage = $_SESSION["preferences"]->rowsPerPage;
}
else
{
    $rowsPerPage = 10;
}

//Get the page number
$pageNumber = $_POST['pageNumber'];
if (empty($pageNumber) || $pageNumber == 'null')
{
    $pageNumber = "1";
}

//Get the search name
$name = $_POST['searchName'];
if (empty($name) || $name == 'null')
{
    $name = "";
}

//Get the list of buildings to search in
$buildings = $_POST['searchBuildings'];
if (empty($buildings) || $buildings == 'null')
{
    $buildings = "";
}

//Get the list of rooms to search in
$rooms = $_POST['searchRooms'];
if (empty($rooms) || $rooms == 'null')
{
    $rooms = "";
}

//If the buildings list is empty, only search by name
if (empty($buildings))
{
    return searchDevicesByName($name, $pageNumber, $rowsPerPage);
}

//If the Rooms list is empty, search by name and building
if (empty($rooms))
{
    return searchDevicesByNameBuilding($name, $buildings, $pageNumber, $rowsPerPage);
}

//Search by name, building, and room
return searchDevicesByNameRoom($name, $rooms, $pageNumber, $rowsPerPage);