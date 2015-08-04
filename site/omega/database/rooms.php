<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 3:42 PM
 * Handles database tasks related to private messages
 */


/**
 * This function gets a list of all rooms and then calls the function displayRoom to output html table content
 * @return null
 */
function getRooms()
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM rooms ");

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        echo "No Rooms in database.";
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'room');

        foreach($result as $package)
        {
            $package->displayRoomTable();
        }
    }
}

/**
 * This function gets a list of all rooms in a building and then calls the function displayRoom to output html table content
 * @param $buildings int the building id(s) to search for
 * @param $displayType string the type of output to display for the list of rooms
 * @param $defaultRoom int the room to set as default if not null
 * @return null
 */
function getRoomsInBuilding($buildings, $displayType, $defaultRoom)
{
    //Reference to global database object
    global $db;

    //Strip out unnecessary characters from the buildings array
    $buildings = str_replace("[","",$buildings);
    $buildings = str_replace("]","",$buildings);

    //Build our query
    $query = $db->prepare("SELECT * FROM rooms WHERE buildingId IN (" . $buildings. ")");

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        echo "No rooms in building.";
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'room');

        foreach($result as $room)
        {
            switch ($displayType)
            {
                case "list":
                    if (!empty($defaultRoom) && $defaultRoom == $room->id)
                    {
                        $room->displayRoomList(true, false);
                    }
                    else
                    {
                        $room->displayRoomList(false, false);
                    }
                    break;
                case "table":
                    $room->displayRoomTable();
                    break;
                case "multi":
                    $room->displayRoomList(false, true);
            }

        }
    }
}

/**
 * This function takes a room id and returns a record from the database if a matching id is found
 * @param $roomId the device id to search for in the database
 * @return null
 */
function getRoomById($roomId)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM rooms WHERE id = :roomId  LIMIT 1 ");

    //Bind variables to query
    $query->bindValue(':roomId', $roomId);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'room');

        return $result[0];
    }
}

/**
 * This function gets the number of rooms in the given building
 * @param $buildingId the building to get a room count for
 * @returns int the number of rooms in the building
 */
function getBuildingRoomCount($buildingId)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM rooms WHERE buildingId = :buildingId ");

    //Bind variables to query
    $query->bindValue(':buildingId', $buildingId);

    //Execute the query
    $query->execute();

    return $query->rowCount();
}

/**
 * Adds a building to the database
 * @param $buildingId int the id of the building to add the room to
 * @param $name string the name of the room to add
 * @param $description string a description for the room
 * @return bool true if buildings were added successfully
 */
function insertRoom($buildingId, $name, $description)
{
    //Reference to global database object
    global $db;

    //Prepare our INSERT statement
    $query = $db->prepare("INSERT INTO rooms (buildingId, name, description) values (:buildingId, :name, :description)");

    //Bind parameters
    $query->bindParam(':buildingId', $buildingId);
    $query->bindParam(':name', $name);
    $query->bindParam(':description', $description);

    //Execute the query
    return $query->execute();
}