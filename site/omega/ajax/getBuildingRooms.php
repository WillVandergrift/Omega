<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/31/13
 * Time: 11:19 AM
 */

require_once "../database/database.php";
require_once "../database/buildings.php";
require_once "../database/rooms.php";
require_once "../model/building.php";
require_once "../model/room.php";

$buildings = $_POST['buildings'];
$displayType = $_POST['displayType'];
$defaultRoom = $_POST['defaultRoom'];

//Echo a room list for the building
echo getRoomsInBuilding($buildings, $displayType, $defaultRoom);


