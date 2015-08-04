<?php
/**
 * Created by PhpStorm.
 * User: Will
 * Date: 1/3/14
 * Time: 4:27 PM
 */
session_start();

session_destroy();

$_SESSION = array();