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

//Start a session for the user
session_start();

//destroy any existing session
if ( isset($_SESSION['curUser']) )
{
    session_destroy();
}

//Get posted variables
$user = $_POST['username'];
$pass = md5($_POST['password']);

$result = getUserFromDb($user, $pass);

if ($result == null)
{
    echo 0;
}
else
{
    $_SESSION["curUser"] = $result;
    $_SESSION["preferences"] = getUserPreferences($result->id);
    echo 1;

}