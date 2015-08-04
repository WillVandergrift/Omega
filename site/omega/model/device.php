<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 5:06 PM
 * Message class used to store information and logic for private messaging
 */

class device
{
    public $id;
    public $name;
    public $description;
    public $user;
    public $hostname;
    public $lastCheckInTime;
    public $objectType;

    public function displayDevice()
    {
        //Output a list item for the device
        echo "
        <tr class='device-list-item' data-url='device.php?deviceId=" . $this->id . "'>
            <td>
                <a href='' class='btn small border-gray-dark'>
                    <i class='glyph-icon icon-check'></i>
                </a>
                <a href='helper/buildVncFile.php?deviceId=" . $this->id . "' class='btn small bg-blue-alt tooltip-button' data-placement='top' title='Start Remote Session'>
                    <i class='glyph-icon icon-desktop'></i>
                </a>
                <a href='device.php?deviceId=" . $this->id . "' class='btn small bg-black font-white tooltip-button' data-placement='top' title='View Device Info'>
                    <i class='glyph-icon icon-info'></i>
                </a>
                <a href='javascript:preparePackageDialog(" . $this->id . ");' title='Select Package' class='btn small bg-dark-green tooltip-button'>
                    <span class='button-content'>
                        <i class='glyph-icon font-size-11 icon-suitcase'></i>
                        <i class='glyph-icon font-size-11 icon-chevron-down'></i>
                    </span>
                </a>
            </td>
            <td class='font-bold text-left'>" . $this->name . "</td>
            <td class='font-bold text-left'>" . $this->user . "</td>
            <td class='font-bold text-left'>" . $this->description . "</td>
        </tr>
        ";
    }

    public function displayDeviceSearchResults()
    {
        echo "<p>" . $this->hostname . "</p>";
    }

    public function displayLastCheckin()
    {
        if ($this->lastCheckInTime != null)
        {
            echo timeAgo($this->lastCheckInTime);
        }
        else
        {
            echo "unknown";
        }
    }
}