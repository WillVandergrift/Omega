<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/31/13
 * Time: 11:19 AM
 */

require_once "../database/database.php";
require_once "../database/packages.php";
require_once "../model/package.php";

//Get the package ID that the user wants to execute a command on
$packageId = $_POST['packageId'];

//Get Package Info
$package = getPackageById($packageId);

//encode the package object using json and echo the results
echo json_encode($package);
