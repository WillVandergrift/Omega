<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 3:42 PM
 * Handles database tasks related to private messages
 */

/**
 * @param $rowsPerPage int the number of results per page
 * @return float the number of pages in the result set
 */
function getDevicePageCount($rowsPerPage)
{
    //Reference to global database object
    global $db;

    //Get a page count for the query
    $pgQuery = $db->prepare("SELECT COUNT(*) FROM devices");
    $pgQuery->execute();

    return ceil($pgQuery->fetchColumn() / $rowsPerPage);
}

/**
 * Returns the number of devices in the database
 * @return float the number of devices in the database
 */
function getDeviceCount()
{
    //Reference to global database object
    global $db;

    //Get a page count for the query
    $pgQuery = $db->prepare("SELECT COUNT(*) FROM devices");
    $pgQuery->execute();

    return $pgQuery->fetchColumn();
}

function getDevices($pageNumber, $rowsPerPage)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM devices
                           LIMIT " . $rowsPerPage);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        echo "No Devices in database.";
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'device');

        foreach($result as $device)
        {
            $device->displayDevice();
        }
    }
}

/**
 * This function takes a device hostname and returns a record from the database if a matching id is found
 * @param $hostname string the device name to search for in the database
 * @return null
 */
function apiSearchDeviceByHostname($hostname)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM devices WHERE hostname = :hostname  LIMIT 1 ");

    //Bind variables to query
    $query->bindValue(':hostname', $hostname);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return 0;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'device');

        return $result[0];
    }
}

/**
 * Gets a count of all records that match the given criteria
 * @param $phrase string the device name to search for
 * @param $rowsPerPage int the number of rows to display per page
 */
function searchDevicesByNameCount($phrase, $rowsPerPage)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT COUNT(*) FROM devices
                           WHERE name LIKE :phrase");

    //Bind variables to query
    $query->bindValue(':phrase', '%' . $phrase . '%');
    //Execute the query
    $query->execute();

    $pages = $query->fetchColumn();
    echo ceil($pages / $rowsPerPage);
}

function searchDevicesByName($phrase)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM devices
                           WHERE name LIKE :phrase");

    //Bind variables to query
    $query->bindValue(':phrase', '%' . $phrase . '%');
    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        $searchResult = $query->fetchAll(PDO::FETCH_CLASS, 'device');

        //Fetch all matching records
        //$result = $query->fetchAll();

        //Create a new array of result items to store our search results in
        //$searchResult = array();

        //foreach ($result as $item)
        //{
         //   $resultItem = new result;
         //   $resultItem->id = $item[id];
         //   $resultItem->name = $item[name];
         //   $resultItem->description = $item[description];
         //   $resultItem->objectType = "device";

         //   $searchResult[] = $resultItem;
        //}

        //Return our list of search results
        return $searchResult;
    }
}

/**
 * Gets a count of all devices that fit the description
 * @param $phrase string a device name to search for
 * @param $buildings string a list of building ids to search for
 * @param $rowsPerPage int the number of rows to display per page
 */
function searchDevicesByNameBuildingCount($phrase, $buildings, $rowsPerPage)
{
    //Reference to global database object
    global $db;

    //Strip out unnecessary characters from the buildings array
    $buildings = str_replace("[","",$buildings);
    $buildings = str_replace("]","",$buildings);

    //Build our query
    $query = $db->prepare("SELECT COUNT(*) FROM devices
                            INNER JOIN rooms
                            ON devices.roomId = rooms.id
                            WHERE devices.name LIKE :phrase AND buildingId IN (" . $buildings. ")");

    //Bind variables to query
    $query->bindValue(':phrase', '%' . $phrase . '%');
    //Execute the query
    $query->execute();

    $pages = $query->fetchColumn();
    echo ceil($pages / $rowsPerPage);
}

function searchDevicesByNameBuilding($phrase, $buildings, $pageNumber, $rowsPerPage)
{
    //Reference to global database object
    global $db;

    //Calculate the starting record
    $startRecord = (($pageNumber - 1) * $rowsPerPage);

    //Strip out unnecessary characters from the buildings array
    $buildings = str_replace("[","",$buildings);
    $buildings = str_replace("]","",$buildings);

    //Build our query
    $query = $db->prepare("SELECT devices.* FROM devices
                            INNER JOIN rooms
                            ON devices.roomId = rooms.id
                            WHERE devices.name LIKE :phrase AND buildingId IN (" . $buildings. ")
                            LIMIT " . $startRecord . ", " . $rowsPerPage);

    //Bind variables to query
    $query->bindValue(':phrase', '%' . $phrase . '%');
    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        echo "No Devices in database.";
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'device');

        foreach($result as $device)
        {
            $device->displayDevice();
        }
    }
}

/**
 * Gets a count of all the devices matching the given description
 * @param $phrase string the device name to search for
 * @param $rooms string a list of room ids to search for
 * @param $rowsPerPage int the number of rows to display per page
 */
function searchDevicesByNameRoomCount($phrase, $rooms, $rowsPerPage)
{
    //Reference to global database object
    global $db;

    //Strip out unnecessary characters from the rooms array
    $rooms = str_replace("[","",$rooms);
    $rooms = str_replace("]","",$rooms);

    //Build our query
    $query = $db->prepare("SELECT COUNT(*) FROM devices
                            WHERE name LIKE :phrase AND
                            roomId IN (" . $rooms . ")");

    //Bind variables to query
    $query->bindValue(':phrase', '%' . $phrase . '%');
    //Execute the query
    $query->execute();

    $pages = $query->fetchColumn();
    echo ceil($pages / $rowsPerPage);
}

function searchDevicesByNameRoom($phrase, $rooms, $pageNumber, $rowsPerPage)
{
    //Reference to global database object
    global $db;

    //Calculate the starting record
    $startRecord = (($pageNumber - 1) * $rowsPerPage);

    //Strip out unnecessary characters from the rooms array
    $rooms = str_replace("[","",$rooms);
    $rooms = str_replace("]","",$rooms);

    //Build our query
    $query = $db->prepare("SELECT * FROM devices
                            WHERE name LIKE :phrase AND
                            roomId IN (" . $rooms . ")
                            LIMIT " . $startRecord . ", " . $rowsPerPage);

    //Bind variables to query
    $query->bindValue(':phrase', '%' . $phrase . '%');
    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        echo "No Devices in database.";
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'device');

        foreach($result as $device)
        {
            $device->displayDevice();
        }
    }
}

/**
 * This function takes a device id and returns a record from the database if a matching id is found
 * @param $deviceId the device id to search for in the database
 * @return null
 */
function getDeviceById($deviceId)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM devices WHERE id = :deviceId  LIMIT 1 ");

    //Bind variables to query
    $query->bindValue(':deviceId', $deviceId);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'device');

        return $result[0];
    }
}

/**
 * This function returns the css style to use for a devices status based on ping results from pingDevice
 * @param $hostname the hostname to ping
 * @return string the css style to use
 */
function setDeviceStatusColor($hostname)
{
    if (pingDevice($hostname))
    {
        return "bg-dark-green";
    }
    else
    {
        return "bg-dark-red";
    }
}

/**
 * This function pings a given hostname and return 0 if the host was unreachable or 1 if the host responded
 * @param $hostname string the hostname to ping
 * @return bool the result of pinging the hostname
 */
function pingDevice($hostname)
{
    exec('ping -n 1 -w 1 ' . $hostname, $output, $result);

    return !$result;
}

function bulkInsertDevices($devicesList, $description)
{
    //Split the string up
    $devices = explode(",", $devicesList);

    //Trim the description
    $description = trim($description);

    //Loop through each device name and call insertDevice
    foreach ($devices as $dev)
    {
        $dev = trim($dev);
        if (!insertDevice($dev, $description))
        {
            //On failure to add record, abort
            return false;
        }
    }

    //Notify the caller that everything went well
    return true;
}

/**
 * Adds a device to the database
 * @param $name string the name of the device to add
 * @param $description string a description for the device
 * @return bool true if devices were added successfully
 */
function insertDevice($name, $description)
{
    //Reference to global database object
    global $db;

    //Prepare our INSERT statement
    $query = $db->prepare("INSERT INTO devices (name, description, hostname) values (:name, :description, :name)");

    //Bind parameters
    $query->bindParam(':name', $name);
    $query->bindParam(':description', $description);

    //Execute the query
    return $query->execute();
}

/**
 * Updates the specified device in the database
 * @param $hostname
 * @param $user
 * @param $checkIn
 */
function apiUpdateDevice($hostname, $user, $checkIn)
{
    try
    {
        //Reference to global database object
        global $db;

        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        //Prepare our INSERT statement
        $query = $db->prepare("UPDATE devices SET user = :user, lastCheckInTime = :checkIn
                                WHERE hostname = :hostname");

        //Bind parameters
        $query->bindParam(':hostname', $hostname);
        $query->bindParam(':checkIn', $checkIn);
        $query->bindParam(':user', $user);

        //Execute the query
        return $query->execute();
    }
    catch (PDOException $exception)
    {
        echo $exception->getMessage();
    }
}

/**
 * Updates the specified device in the database
 * @param $id
 * @param $roomId
 * @param $name
 * @param $description
 * @param $hostname
 * @param $port
 * @return bool
 */
function updateDevice($id, $roomId, $name, $description, $hostname, $port)
{
    try
    {
        //Reference to global database object
        global $db;

        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

        //Prepare our INSERT statement
        $query = $db->prepare("UPDATE devices SET roomId = :roomId, name = :name, description = :description,
                            hostname = :hostname, vncPort = :port WHERE id = :id");

        //Bind parameters
        $query->bindParam(':id', $id);
        $query->bindParam(':roomId', $roomId);
        $query->bindParam(':name', $name);
        $query->bindParam(':description', $description);
        $query->bindParam(':hostname', $hostname);
        $query->bindParam(':port', $port);

        //Execute the query
        return $query->execute();
    }
    catch (PDOException $exception)
    {
        echo $exception->getMessage();
    }
}