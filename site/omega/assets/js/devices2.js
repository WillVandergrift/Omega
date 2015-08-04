//Global variables for the search queries
var searchName = "";
var searchBuilding = "";
var searchRoom = "";

//Global variables
var curDevice;
var curPackage;

var rowsPerPage;
var curPage;
var numberOfPages;

jQuery( document ).ready(function() {

    //Device Name Search Timer
    var searchDelay = 1000;
    var searchTimer;

    jQuery('#txtSearchName').keyup(function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(prepareSearchDevices, searchDelay);
    });

    //Update the search when the buildings list changes
    jQuery('#selSearchBuilding').change(updateRooms);

    //Update the search when the rooms list changes
    jQuery('#selSearchRoom').change(prepareSearchDevices);

    //Prepare the add devices form
    var options = {
        beforeSubmit:   validateAddDeviceForm,  //pre-submit callback used for form validation
        success:        addDeviceSuccess        //post-submit callback
    };

    //Bind form using ajaxForm
    jQuery('#addDeviceForm').ajaxForm(options);

    jQuery( "#modal-packages" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        minWidth: 555,
        maxWidth: 555,
        minHeight: 400,
        maxHeight: 400,
        dialogClass: "",
        show: "fadeIn"
    });

    jQuery( "#modal-add-device" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        minWidth: 500,
        minHeight: 300,
        dialogClass: "",
        show: "fadeIn"
    });
});

function setPaginationVars(page, rows, numPages)
{
    curPage = page;
    rowsPerPage = rows;
    numberOfPages = numPages;

    jQuery('#paginationDisplay').html("Page " + curPage + " of " + numberOfPages);
}


//Pre-submit verification callback
function validateAddDeviceForm (formData, jqForm, options) {
    //Check to see if the device name field is blank
    var form = jqForm[0];

    //If device name is left blank, display error, and set focus to txtDeviceName
    if (!form.txtDeviceName.value){
        jQuery("#addDeviceWarning").removeClass('hidden');
        jQuery("#addDeviceWarning").addClass('display-block');
        jQuery("#txtDeviceName").focus();
        return false;
    }

    //Form fields validate
    return true;
}

//Successful login attempt
function addDeviceSuccess (result, statusText, xhr, $form)
{
    if (result == true)
    {
        jQuery("#addDeviceWarning").removeClass('display-block');
        jQuery("#addDeviceWarning").addClass('hidden');

        //Load the main interface
        window.location.replace("devices.php");
    }
    else if (result == false)
    {
        //Failed to add devices
        alert('Failed to add devices');
    }

}

//Fetches information about the selected device and stores it in curDevice
function setCurDevice(deviceId)
{
    jQuery.ajax({
        url: 'ajax/getDeviceDetails.php',
        data: { deviceId: deviceId},
        type: 'post',
        success: function(device){
            curDevice = jQuery.parseJSON(device);
        }
    });
}

//Fetches information about the selected package and stores it in curPackage
function setCurPackage(packageId)
{
    jQuery.ajax({
        url: 'ajax/getPackageDetails.php',
        data: { packageId: packageId},
        type: 'post',
        success: function(package){
            curPackage = jQuery.parseJSON(package);
        }
    });
}

function prepareToRunPackage(packageId)
{
    //Get package details using an ajax call
    jQuery.ajax({
        url: 'ajax/getPackageDetails.php',
        data: { packageId: packageId},
        type: 'post',
        success: function(package){
            //If we successfully got the package details, continue running the package
            curPackage = jQuery.parseJSON(package);

            console.log(curPackage);

            //Make sure curDevice has been set
            if (typeof curDevice['id'] !== "undefined" && typeof curPackage['id'] != "undefined")
            {
                //Run the package
                runPackage(curDevice['id'], curPackage['id']);

                //Display an update for the user
                displayNotyPackageStarted();

                //Close the Package Dialog
                closePackagesDialog();
            }
            else
            {
                alert("Current Device is undefined");
            }
        },
        error: function(){
            //Inform the user that running the package failed
            displayNotyPackageError();
        }
    });
}

//Display a notification to the user letting them know the package started on the specified machine
function displayNotyPackageStarted()
{
    if (typeof curDevice['id'] !== "undefined" && typeof curPackage['id'] != "undefined")
    {
        //Display customized message
        if (curPackage['icon'] != "undefined")
        {
            var message = '<img src="' + curPackage['icon'] + '" /> The ' + curPackage['name'] + ' package is running on ' + curDevice['name'];
        }
        else
        {
            var message = '<i class="glyph-icon icon-briefcase mrg5R"></i> The ' + curPackage['name'] + ' package is running on ' + curDevice['name'];
        }
    }
    else
    {
        //Display generic message
        var message = '<i class="glyph-icon icon-briefcase mrg5R"></i> Package is running';
    }

    noty({
        text        : message,
        type        : 'notification',
        dismissQueue: false,
        timeout     : 3000,
        theme       : 'agileUI',
        layout      : 'top'
    });
}

//Display a notification to the user letting them know an error occured while running the package
function displayNotyPackageError()
{
    var message = '<i class="glyph-icon icon-clock-os-circle mrg5R"></i> An error occured while running the package';

    noty({
        text        : message,
        type        : 'notification',
        dismissQueue: false,
        timeout     : 3000,
        theme       : 'agileUI',
        layout      : 'top'
    });
}

//Run the selected package on the specified device
function runPackage(deviceId, packageId)
{
    jQuery.ajax({
        url: 'helper/runpackage.php',
        data: {
            deviceId: deviceId,
            packageId: packageId},
        type: 'post'
    });
}

//Get information about the selected device and open the Package dialog
function preparePackageDialog(deviceId)
{
    openPackageDialog();

    setCurDevice(deviceId);
}

//Opens the Package Dialog window
function openPackageDialog()
{
    jQuery('#modal-packages').dialog('open');
    jQuery('.ui-widget-overlay').addClass('bg-black opacity-80');
}

//Closes the Package Dialog window
function closePackagesDialog()
{
    jQuery('#modal-packages').dialog('close');
}

//Opens the Add Device Dialog window
function openAddDeviceDialog()
{
    jQuery('#modal-add-device').dialog('open');
    jQuery('.ui-widget-overlay').addClass('bg-black opacity-80');
    jQuery("#txtDeviceName").focus();
}

//Closes the Add Device Dialog window
function closeAddDeviceDialog()
{
    jQuery('#modal-add-device').dialog('close');
    jQuery("#addDeviceWarning").removeClass('display-block');
    jQuery("#addDeviceWarning").addClass('hidden');
}

function updateRooms()
{
    var buildings = jQuery('#selSearchBuilding').val();

    buildings = JSON.stringify(buildings);

    //Clear the room list and populate it with rooms from the building list
    jQuery.ajax({
        url: 'ajax/getBuildingRooms.php',
        data: {
            buildings: buildings,
            displayType: "multi",
            defaultRoom: null},
        type: 'post',
        success: function(rooms){
            console.log(rooms);
            jQuery('#selSearchRoom').html(rooms);
            jQuery('#selSearchRoom').trigger("chosen:updated");
            console.log('Finished Updating Room List');
        }
    });

    prepareSearchDevices();
}

//Get the number of results from the search query
function prepareSearchDevices()
{
    //Display the search overlay
    jQuery('#loading-overlay').show();

    curPage = 1;

    var name = jQuery('#txtSearchName').val();
    var buildings = jQuery('#selSearchBuilding').val();
    var rooms = jQuery('#selSearchRoom').val();

    buildings = JSON.stringify(buildings);
    rooms = JSON.stringify(rooms);

    //Search for devices that are in the specified building(s)
    jQuery.ajax({
        url: 'ajax/searchDevicesCount.php',
        data: {
            pageNumber: 1,
            searchName: name,
            searchBuildings: buildings,
            searchRooms: rooms},
        type: 'post',
        success: function(pageCount){
            console.log(pageCount);
            numberOfPages = pageCount;
            jQuery('#paginationDisplay').html("Page " + curPage + " of " + numberOfPages);
            searchDevices(curPage);
        }
    });
}


//Search for devices matching the criteria
function searchDevices(pageNum)
{
    //Display the search overlay
    jQuery('#loading-overlay').show();

    console.log('searching');
    var name = jQuery('#txtSearchName').val();
    var buildings = jQuery('#selSearchBuilding').val();
    var rooms = jQuery('#selSearchRoom').val();

    buildings = JSON.stringify(buildings);
    rooms = JSON.stringify(rooms);

    console.log(rooms);

    //Search for devices that are in the specified building(s)
    jQuery.ajax({
        url: 'ajax/searchDevices.php',
        data: {
            pageNumber: pageNum,
            searchName: name,
            searchBuildings: buildings,
            searchRooms: rooms},
        type: 'post',
        success: function(devices){
            console.log(devices);
            jQuery('#deviceList').html(devices);
            console.log('Finished Updating Room List');
            //Hide the search overlay
            jQuery('#loading-overlay').hide();

            //Update our current page
            if (pageNum != null)
            {
                curPage = pageNum;
                jQuery('#paginationDisplay').html("Page " + curPage + " of " + numberOfPages);
            }
        },
        error: function(){
            console.log('Error updating room list');
            //Hide the search overlay
            jQuery('#loading-overlay').hide();
        }
    });
}

//Displays the next page of devices
function nextPage()
{
    if (curPage <  numberOfPages)
    {
        searchDevices(curPage + 1)
    }
}

//Displays the previous page of devices
function prevPage()
{
    if (curPage >  1)
    {
        searchDevices(curPage - 1)
    }
}
