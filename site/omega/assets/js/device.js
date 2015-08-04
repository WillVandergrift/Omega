var curDevice = "";
var curPackage ="";

//Options var for device details ajax form
var options = {
    beforeSubmit:   validateUpdateDeviceForm,  //pre-submit callback used for form validation
    success:        UpdateDeviceSuccess        //post-submit callback
};

jQuery( document ).ready(function() {
    //Bind form using ajaxForm
    jQuery('#deviceDetailsForm').ajaxForm(options);

    jQuery( "#modal-packages" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        minWidth: 500,
        minHeight: 300,
        dialogClass: "",
        show: "fadeIn"
    });

    //Event Handler for Building List Changed
    $( "#buildingList" ).change(function() {
        updateRoomList();
    });

    //Event Handler for Room List Changed
    $( "#roomList" ).change(function() {
        updateSelectedRoomId();
    });
});

//Submit the form using ajax
function submitUpdateDeviceForm()
{
    jQuery('#deviceDetailsForm').ajaxSubmit(options);
}

function updateRoomList()
{
    //get the building id by reading the data-id attribute of the selected item
    var buildingId = jQuery('option:selected', '#buildingList').data('id');

    console.log('Selected Building Id: ' + buildingId);

    //Fetch a list of rooms for the selected building using ajax
    jQuery.ajax({
        url: 'ajax/getBuildingRooms.php',
        data: {
            buildings: buildingId,
            displayType: "list",
            defaultRoom: null},
        type: 'post',
        success: function(rooms){
            console.log(rooms);
            jQuery('#roomList').html(rooms);
        }
    });
}

function updateSelectedRoomId()
{
    //get the room id by reading the data-id attribute of the selected item
    var roomId = jQuery('option:selected', '#roomList').data('id');

    //Update the hidden room id field
    jQuery('#txtDeviceRoomId').val(roomId);
}

//Pre-submit verification callback
function validateUpdateDeviceForm (formData, jqForm, options) {
    //Check to see if the device name, hostname, or vncPort fields is blank
    var form = jqForm[0];

    //If device name is left blank, display error, and set focus to txtDeviceName
    if (!form.txtDeviceName.value || !form.txtDevicePort.value || !form.txtDeviceHostname.value){
        jQuery("#updateDeviceWarning").removeClass('hidden');
        jQuery("#updateDeviceWarning").addClass('display-block');
        jQuery("#txtDeviceName").focus();
        return false;
    }

    //Form fields validate
    return true;
}

//Successfully updated the device in the database
function UpdateDeviceSuccess (result, statusText, xhr, $form) {

    console.log(result);

    if (result == true)
    {
        jQuery("#updateDeviceWarning").removeClass('display-block');
        jQuery("#updateDeviceWarning").addClass('hidden');

        //Load the main interface
        window.location.reload();
    }
    else if (result == false)
    {
        //Failed to add devices
        alert('Failed to add devices');
    }

}

//Fetches information about the selected package and stores it in curPackage
function setCurPackage(packageId)
{
    jQuery.ajax({
        url: 'helper/getPackageDetails.php',
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
        url: 'helper/getPackageDetails.php',
        data: { packageId: packageId},
        type: 'post',
        success: function(package){
            //If we successfully got the package details, continue running the package
            curPackage = jQuery.parseJSON(package);

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

//Get information about the selected device and open the Package dialog
function preparePackageDialog(deviceId)
{
    openPackageDialog();

    setCurDevice(deviceId);
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