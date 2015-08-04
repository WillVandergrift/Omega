<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 5:06 PM
 * Package class used to store information and business logic for packages
 */

class room
{
    public $id;
    public $buildingId;
    public $name;
    public $description;

    public function displayRoomTable()
    {
        //Output a list item for the room
        echo "
        <tr>
            <td>
                <a href='helper/buildVncFile.php?roomId=" . $this->id . "' class='btn medium bg-blue-alt tooltip-button' data-placement='top' title='Room Info'>
                    <i class='glyph-icon icon-info'></i>
                </a>
                <a href='device.php?deviceId=" . $this->id . ";' class='btn medium bg-black font-white tooltip-button' data-placement='top' title='Delete Room'>
                    <i class='glyph-icon icon-clock-os'></i>
                </a>
            </td>
            <td class='font-bold text-left'>" . $this->name . "</td>
            <td class='font-bold text-left'>" . $this->description . "</td>
        </tr>
        ";
    }

    /**
     * Display a list of rooms using
     * @param $selected
     * @param $showBuildingName
     */
    public function displayRoomList($selected, $showBuildingName)
    {
        if ($showBuildingName)
        {
            //Get building info
            $buildingName = getBuildingById($this->buildingId)->name;

            //Output a list item for the room and include building name
            echo "<option value='" . $this->id . "' data-id='" . $this->id . "'>" . $buildingName . " - " . $this->name ."</option>";
        }
        else
        {
            if ($selected)
            {
                //Output a list item for the room and mark it as selected
                echo "<option selected='selected' value='" . $this->id . "' data-id='" . $this->id . "'>" . $this->name ."</option>";
            }
            else
            {
                //Output a list item for the room
                echo "<option value='" . $this->id . "' data-id='" . $this->id . "'>" . $this->name ."</option>";
            }
        }
    }
}