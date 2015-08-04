<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 5:06 PM
 * Package class used to store information and business logic for packages
 */

class package
{
    public $id;
    public $name;
    public $description;
    public $command;
    public $user;
    public $password;
    public $icon;
    public $showMessage;
    public $message;
    public $hidden;
    public $objectType;

    public function displayPackageList()
    {
        //Output a list item for the device
        echo "
        <tr>
            <td><img src='" . $this->icon . "'/></td>
            <td>
            <a href='package.php?packageId=" . $this->id . "' class='btn medium bg-black font-white tooltip-button' data-placement='top' title='View Package Info'>
                <i class='glyph-icon icon-info'></i>
            </a>
            </td>
            <td class='font-bold text-left'>" . $this->name . "</td>
            <td class='text-left'>" . $this->description . "</td>
        </tr>
        ";
    }

    public function displayPackageGrid()
    {
        //Output a list item for the device
        echo "
            <a href='javascript:prepareToRunPackage(" . $this->id . ");' class='max-width-100 max-height-70 mrg10A btn vertical-button remove-border font-black bg-white border-black' title=''>
                <span class='glyph-icon icon-separator-vertical pad0A medium'>
                    <img src='" . $this->icon . "' alt='". $this->name ."' />
                </span>
                <span class='button-content'>" . $this->name . "</span>
            </a>
        ";
    }

    public function parseCommand($deviceId)
    {
        //Get the Device name from ID
        $device = getDeviceById($deviceId);

        //Replace [target] with the target device hostname
        $this->command = str_replace('[target]', $device->hostname, $this->command);

        //Replace [user] with the commands username
        $this->command = str_replace('[user]', $this->user, $this->command);

        //Replace [password] with the commands username
        $this->command = str_replace('[password]', $this->password, $this->command);
    }
}