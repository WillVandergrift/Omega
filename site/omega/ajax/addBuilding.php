<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 1/2/14
 * Time: 12:52 PM
 */

require_once "../database/database.php";
require_once "../database/buildings.php";
require_once "../model/building.php";

if (!isset($_POST['txtBuildingName']))
{
    //Exit if a building name wasn't provided
    exit;
}

//Get the name of the building that the user wants to add to the database
$name = $_POST['txtBuildingName'];

//Check to see if the user included a description. If not, create an empty string
if (isset($_POST['txtBuildingDesc']))
{
    $description = $_POST['txtBuildingDesc'];
}
else
{
    $description = "";
}

//Insert the devices into the database
echo insertBuilding($name,$description);