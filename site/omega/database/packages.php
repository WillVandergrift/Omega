<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 3:42 PM
 * Handles database tasks related to private messages
 */


/**
 * This function gets a list of all packages and then calls the function displayPackage to output html table content
 * @param $displayType string the type of display to use
 * @return null
 */
function getPackages($displayType)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM packages WHERE hidden = 'false'");

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        echo "No Packages in database.";
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'package');

        foreach($result as $package)
        {
            if ($displayType == "list")
            {
                $package->displayPackageList();
            }
            elseif ($displayType == "grid")
            {
                $package->displayPackageGrid();
            }
        }
    }
}



/**
 * This function takes a package id and returns a record from the database if a matching id is found
 * @param $packageId the device id to search for in the database
 * @return null
 */
function getPackageById($packageId)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM packages WHERE id = :packageId LIMIT 1");

    //Bind variables to query
    $query->bindValue(':packageId', $packageId);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'package');

        return $result[0];
    }
}

/**
 * This function gets the number of packages in the database
 * @return null
 */
function getPackageCount()
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT COUNT(*) FROM packages");
    $query->execute();

    return $query->fetchColumn();
}

/**
 * Updates the package in the database
 * @param $id
 * @param $name
 * @param $description
 * @param $command
 * @param $icon
 * @param $user
 * @param $password
 * @param $showMessage
 * @param $message
 * @return bool
 */
function updatePackage($id, $name, $description, $command, $icon, $user, $password, $showMessage, $message)
{
    try
    {
        //Reference to global database object
        global $db;

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        //Prepare our INSERT statement
        $query = $db->prepare("UPDATE packages SET name = :name, description = :description, command = :command,
                            icon = :icon, user = :user, password = :password,
                            showMessage = :showMessage, message = :message WHERE id = :id");

        //Bind parameters
        $query->bindParam(':id', $id);
        $query->bindParam(':name', $name);
        $query->bindParam(':description', $description);
        $query->bindParam(':command', $command);
        $query->bindParam(':icon', $icon);
        $query->bindParam(':user', $user);
        $query->bindParam(':password', $password);
        $query->bindParam(':showMessage', $showMessage);
        $query->bindParam(':message', $message);

        //Execute the query
        return $query->execute();
    }
    catch (PDOException $exception)
    {
        echo $exception->getMessage();
    }

}