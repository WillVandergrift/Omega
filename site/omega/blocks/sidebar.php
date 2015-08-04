<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/14/13
 * Time: 12:41 PM
 */

require_once "database/database.php";
require_once "database/authentication.php";
require_once "database/buildings.php";
require_once "database/rooms.php";
require_once "model/building.php";
require_once "model/room.php";

?>

<div id="page-sidebar">
<div id="header-logo">
    Omega <i class="opacity-80">Search</i>

    <a href="javascript:;" class="tooltip-button" data-placement="bottom" title="Close sidebar" id="close-sidebar">
        <i class="glyph-icon icon-arrow-left"></i>
    </a>
    <a href="javascript:;" class="tooltip-button hidden" data-placement="bottom" title="Open sidebar" id="rm-close-sidebar">
        <i class="glyph-icon icon-search"></i>
    </a>
    <a href="javascript:;" class="tooltip-button hidden" title="Navigation Menu" id="responsive-open-menu">
        <i class="glyph-icon icon-search"></i>
    </a>
</div>
<div class="form-input col-md-12 search-bg-white mrg10T">
    <div class="mrg5B">Search by Name</div>
    <input type="text" placeholder="Device Name" name="txtSearchName" id="txtSearchName" value=""/>
    <br />
    <br />
    <div class="mrg5B">Search by Building</div>
    <div class="input-append-wrapper">
        <select data-placeholder="Search by building" name="selSearchBuilding" id ="selSearchBuilding" multiple class="chosen-select">
            <?php getBuildings("list", null); ?>
        </select>
    </div>
    <br />
    <div class="mrg5B">Search by Room</div>
    <div class="input-append-wrapper" id="searchRoomWrapper">
        <select data-placeholder="Search by Room" name="selSearchRoom" id="selSearchRoom" multiple class="chosen-select">

        </select>
    </div>
</div>
</div><!-- #page-sidebar -->