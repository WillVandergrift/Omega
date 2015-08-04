//Global variables for the search queries
var searchName = "";
var searchBuilding = "";
var searchRoom = "";

//Global variables
var curDevice;
var curPackage;

var rowsPerPage = 25;
var curPage = 1;
var numberOfPages;
var numberOfRows;

$.fn.filterTable = function (searchPhrase) {
    var phrase = searchPhrase.toLowerCase();
    var rows = $(this).find('tr');

    rows.each(function(index){
        //Loop through each row
        $(this).hide();
        $(this).children("td").each(function() {
            //Loop through each cell looking for the searchPhrase
            if ($(this).text().toLowerCase().contains(phrase))
            {
                $(this).parent('tr').show();
                return true;
            }
        });
    });

    return this;
};

jQuery( document ).ready(function()
{
    //Setup pagination
    setPaginationVars();

    //Paginate the table
    gotoPage(1);

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

function setPaginationVars()
{
    numberOfRows = jQuery('#tblDevices tr').length;
    numberOfPages = numberOfRows / rowsPerPage;
    numberOfPages = Math.ceil(numberOfPages);

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
                closeAppDrawer();
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
    showAppDrawer();

    setCurDevice(deviceId);
}

//Opens the Package Dialog window
function openPackageDialog()
{
    jQuery('#modal-packages').dialog('open');
    jQuery('.ui-widget-overlay').addClass('bg-black opacity-80');
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

//Closes the app drawer by sliding it down into view
function showAppDrawer()
{
    jQuery('#app-drawer').slideDown(750);
}

//Closes the app drawer by sliding it up out of view
function closeAppDrawer()
{
    jQuery('#app-drawer').slideUp(750);
}

//Displays the specified page in a paginated list
function gotoPage(pageNum)
{
    var direction;

    //Validate the page number
    if (pageNum < 1 || pageNum > numberOfPages)
    {
        return;
    }

    //Get our start and end row
    var startRow = (pageNum - 1) * rowsPerPage;
    var endRow = startRow + rowsPerPage;

    //Hide all rows before the starting point
    jQuery( ".device-list-item" ).slice( 0, startRow - 1).hide();

    //Show the rows in between the start and end range
    jQuery( ".device-list-item" ).slice( startRow, endRow ).show();

    //Hide all rows after the end point
    jQuery( ".device-list-item" ).slice( endRow + 1, numberOfRows - 1).hide();

    //Update the current page count
    curPage = pageNum;

    //Update the pagination display
    jQuery('#paginationDisplay').html("Page " + curPage + " of " + numberOfPages);
}