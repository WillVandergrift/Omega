<?php
/**
 * Created by JetBrains PhpStorm.
 * User: William
 * Date: 8/25/13
 * Time: 5:06 PM
 * Package class used to store information and business logic for packages
 */

class building
{
    public $id;
    public $name;
    public $description;

    public function displayBuildingTable()
    {
        //Output a list item for the building
        echo "
        <tr>
            <td>" . getBuildingRoomCount( $this->id ) . "</td>
            <td>
                <a href='helper/buildVncFile.php?buildingId=" . $this->id . "' class='btn medium bg-blue-alt tooltip-button' data-placement='top' title='Building Info'>
                    <i class='glyph-icon icon-info'></i>
                </a>
                <a href='buildingRooms.php?buildingId=" . $this->id . "' class='btn medium bg-black font-white tooltip-button' data-placement='top' title='Rooms in Building'>
                    <i class='glyph-icon icon-building-o'></i>
                </a>
            </td>
            <td class='font-bold text-left'>" . $this->name . "</td>
            <td class='font-bold text-left'>" . $this->description . "</td>
        </tr>
        ";
    }

    public function displayBuildingList($selected)
    {
        if ($selected)
        {
            //Output a list item for the building
            echo "<option selected='selected' value='" . $this->id . "' data-id='" . $this->id  . "'>" . $this->name . "</option>";
        }
        else
        {
            //Output a list item for the building
            echo "<option value='" . $this->id . "' data-id='" . $this->id  . "'>" . $this->name . "</option>";
        }
    }
}