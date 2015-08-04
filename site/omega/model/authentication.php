<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/24/13
 * Time: 8:23 AM
 * To change this template use File | Settings | File Templates.
 */

class authentication
{
    public $id;
    public $username;
    public $password;
    public $firstName;
    public $lastName;
    public $status;
    public $appId;


    function profileImage()
    {
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . "/assets/images/profiles/$this->id.png"))
        {
            echo "/assets/images/profiles/$this->id.png";
        }
        else
        {
            echo "/assets/images/profiles/nophoto.png";
        }
    }

    function fullName()
    {
        echo $this->firstName . " " . $this->lastName;
    }

    function firstName()
    {
        echo $this->firstName;
    }
}