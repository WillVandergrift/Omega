<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/24/13
 * Time: 8:26 AM
 * User database code
 */

function getUserPreferences($authId)
{
    //Reference to global database object
    global $db;

    //Build our query
    $query = $db->prepare("SELECT * FROM preferences WHERE authId = :authId LIMIT 1");

    //Bind variables to query
    $query->bindValue(':authId', $authId);

    //Execute the query
    $query->execute();

    if ($query->rowCount() == 0)
    {
        return null;
    }
    else
    {
        //Get query results
        $result = $query->fetchAll(PDO::FETCH_CLASS, 'preferences');

        return $result[0];
    }
}


