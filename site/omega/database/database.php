<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 12/13/13
 * Time: 6:54 PM
 * Connection code for MySQL database
 */

//Do not allow direct access to this file
// if ( $_SERVER['REQUEST_URI'] == $_SERVER['PHP_SELF'] ) die ("Direct access not premitted");

$dbServer = "localhost";
$dbName = "omega";
$dbUser = "root";
$dbPass = "queball";

$db = new PDO('mysql:host=' . $dbServer .';dbname=' . $dbName, $dbUser, $dbPass);

//Fixes using LIMIT with prepared statement variables (BREAKS OTHER QUERIES!!!!!)
//$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
