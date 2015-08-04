<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/14/13
 * Time: 9:25 AM
 * Handles ajax login request and validates credentials against the database
 */

require "../database/database.php";
require "../database/authentication.php";
require "../database/preferences.php";
require "../model/authentication.php";
require "../model/preferences.php";

//Get posted variables
$appId = $_POST['appId'];

$result = getUserFromDbByAppID($appId);

if ($result == null)
{
    echo 0;
}
else
{
    echo json_encode($result);

}
