<?php
/**
 * Created by PhpStorm.
 * User: William
 * Date: 12/14/13
 * Time: 12:27 PM
 */

?>

<div id="page-header" class="clearfix">
    <div id="page-header-wrapper" class="clearfix">
        <input type="text" class="search-box input" placeholder="Search" name="txtHeaderSearch" id="txtHeaderSearch" value=""/>
        <div id="searchResults" class="search-results">
            <table id="searchTable" class="search-table">

            </table>
        </div>
        <div class="top-icon-bar dropdown">
            <a href="javascript:;" title="" class="user-ico clearfix" data-toggle="dropdown">
                <img width="36" src="<?php $curUser->profileImage() ?>" alt="">
                <span><?php $curUser->firstName() ?></span>
                <i class="glyph-icon icon-chevron-down"></i>
            </a>
            <ul class="dropdown-menu float-right">
                <li>
                    <a href="profile.php" title="">
                        <i class="glyph-icon icon-user mrg5R"></i>
                        My Profile
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a class="font-orange" href="javascript:logout();" title="">
                        <i class="glyph-icon icon-sign-out mrg5R"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
        <div class="top-icon-bar">
            <!-- Devices Button -->
            <a href="devices.php" id="toolbar-devices" class="button" data-width="0">
                <i  id="testId" class="glyph-icon icon-desktop text-left pad17L"></i>
            </a>
            <!-- Packages Button -->
            <a href="packages.php" id="toolbar-packages" class="button" data-width="0">
                <i class="glyph-icon icon-suitcase text-left pad17L"></i>
            </a>
            <!-- Users Button -->
            <a href="javascript:;" id="toolbar-users" class="button" data-width="0">
                <i class="glyph-icon icon-user text-left pad17L"> </i>
            </a>
            <!-- Buildings Button -->
            <a href="buildings.php" id="toolbar-buildings" class="button" data-width="0">
                <i class="glyph-icon icon-building-o text-left pad17L"> </i>
            </a>
            <!-- Settings Button -->
            <a href="javascript:;" id="toolbar-settings" class="button" data-width="0">
                <i class="glyph-icon icon-gears text-left pad17L"></i>
            </a>
            <!-- Dashboard Button -->
            <a href="dashboard.php" id="toolbar-dashboard" class="button" data-width="0">
                <i class="glyph-icon icon-dashboard text-left pad17L"></i>
                </i>
            </a>
        </div>
    </div>
</div><!-- #page-header -->