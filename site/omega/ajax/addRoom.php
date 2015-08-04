<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 1/2/14
 * Time: 12:52 PM
 */

require_once "../database/database.php";
require_once "../database/rooms.php";
require_once "../model/room.php";

if (!isset($_POST['txtRoomName']))
{
    //Exit if a room name wasn't provided
    exit;
}

if (!isset($_POST['txtBuildingId']))
{
    //Exit if a building id wasn't provided
    exit;
}

//Get the name of the room that the user wants to add to the database
$name = $_POST['txtRoomName'];

//Get the id of the building that the user wants to add the room to
$buildingId = $_POST['txtBuildingId'];

//Check to see if the user included a description. If not, create an empty string
if (isset($_POST['txtRoomDesc']))
{
    $description = $_POST['txtRoomDesc'];
}
else
{
    $description = "";
}

//Insert the devices into the database
echo insertRoom($buildingId, $name, $description);