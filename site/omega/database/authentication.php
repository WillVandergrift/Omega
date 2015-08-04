<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/24/13
 * Time: 8:26 AM
 * User database code
 */

function getUserFromDb($username, $password)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM authentication WHERE username = :username AND password = :password AND status = 'active' LIMIT 1");

    //Bind variables to query
    $query->bindValue(':username', $username);
    $query->bindValue(':password', $password);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        //Get query results
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'authentication');

        return $result[0];
    }
}

function getUserFromDbByAppID($appId)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM authentication WHERE appId = :appId AND status = 'active' LIMIT 1");

    //Bind variables to query
    $query->bindValue(':appId', $appId);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        //Get query results
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'authentication');

        return $result[0];
    }
}

function getTotalUsers()
{
    //Reference the global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT id FROM authentication WHERE status = 'active'");

    //Execute the query
    $query->execute();

    return $query->rowCount();
}

function getProfileById($id)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM authentication WHERE id = :id LIMIT 1");

    //Bind variables to query
    $query->bindValue(':id', $id);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        //Get query results
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'authentication');

        return $result[0];
    }
}


