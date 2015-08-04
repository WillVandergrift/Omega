jQuery( document ).ready(function() {

    //Prepare the add devices form
    var options = {
        beforeSubmit:   validateAddRoomForm,  //pre-submit callback used for form validation
        success:        addRoomSuccess        //post-submit callback
    };

    //Bind form using ajaxForm
    jQuery('#addRoomForm').ajaxForm(options);

    jQuery( "#modal-add-room" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: false,
        minWidth: 500,
        minHeight: 300,
        dialogClass: "",
        show: "fadeIn"
    });
});


//Pre-submit verification callback
function validateAddRoomForm (formData, jqForm, options)
{
    //Check to see if the building name field is blank
    var form = jqForm[0];

    //If room name is left blank, display error, and set focus to txtRoomName
    if (!form.txtRoomName.value){
        jQuery("#addRoomWarning").removeClass('hidden');
        jQuery("#addRoomWarning").addClass('display-block');
        jQuery("#txtRoomName").focus();
        return false;
    }

    //Form fields validate
    return true;
}

//Successful login attempt
function addRoomSuccess (result, statusText, xhr, $form)
{

    console.log(result);
    console.log(statusText);

    if (result == true)
    {
        jQuery("#addRoomWarning").removeClass('display-block');
        jQuery("#addRoomWarning").addClass('hidden');

        //Reload the page
        window.location.reload();
    }
    else if (result == false)
    {
        //Failed to add devices
        alert('Failed to add room');
    }

}

//Opens the Add Building Dialog window
function openAddRoomDialog()
{
    jQuery('#modal-add-room').dialog('open');
    jQuery('.ui-widget-overlay').addClass('bg-black opacity-80');
    jQuery("#txtRoomName").focus();
}

//Closes the Add Building Dialog window
function closeAddRoomDialog()
{
    jQuery('#modal-add-room').dialog('close');
    jQuery("#addRoomWarning").removeClass('display-block');
    jQuery("#addRoomWarning").addClass('hidden');
}