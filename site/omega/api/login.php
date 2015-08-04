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
$user = $_POST['username'];
$pass = md5($_POST['password']);

$result = getUserFromDb($user, $pass);

if ($result == null)
{
    echo 0;
}
else
{
    echo json_encode($result);

}