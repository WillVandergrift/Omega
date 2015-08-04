<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 3:42 PM
 * Handles database tasks related to private messages
 */


/**
 * This function gets a list of all buildings and then displays them based on displayType
 * @param $displayType string the type of output to display (list, table)
 * @param $defaultBuilding int the default building id to select
 * @return null
 */
function getBuildings($displayType, $defaultBuilding)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM buildings ");

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        echo "No Buildings in database.";
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'building');

        foreach($result as $building)
        {
            switch ($displayType)
            {
                case "table":
                    $building->displayBuildingTable();
                    break;
                case "list":
                    if (!empty($defaultBuilding) && $defaultBuilding == $building->id)
                    {
                        $building->displayBuildingList(true);
                    }
                    else
                    {
                        $building->displayBuildingList(false);
                    }
                    break;
            }
        }
    }
}

/**
 * This function takes a building id and returns a record from the database if a matching id is found
 * @param $buildingId int the device id to search for in the database
 * @return null
 */
function getBuildingById($buildingId)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM buildings WHERE id = :buildingId  LIMIT 1 ");

    //Bind variables to query
    $query->bindValue(':buildingId', $buildingId);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'building');

        return $result[0];
    }
}

/**
 * This function gets the number of buildings in the database
 * @return null
 */
function getBuildingCount()
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT COUNT(*) FROM buildings");

    //Execute the query
    $query->execute();

    return $query->fetchColumn();
}

/**
 * Adds a building to the database
 * @param $name string the name of the building to add
 * @param $description string a description for the building
 * @return bool true if buildings were added successfully
 */
function insertBuilding($name, $description)
{
    //Reference to global database object
    global $db;

    //Prepare our INSERT statement
    $query = $db->prepare("INSERT INTO buildings (name, description) values (:name, :description)");

    //Bind parameters
    $query->bindParam(':name', $name);
    $query->bindParam(':description', $description);

    //Execute the query
    return $query->execute();
}

/**
 * Display the specified buildings description
 * @param $buildingId int the id of the building
 */
function displayBuildingDescription($buildingId)
{
    echo getBuildingById($buildingId)->description;
}