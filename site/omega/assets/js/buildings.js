jQuery( document ).ready(function() {

    //Prepare the add devices form
    var options = {
        beforeSubmit:   validateAddBuildingForm,  //pre-submit callback used for form validation
        success:        addBuildingSuccess        //post-submit callback
    };

    //Bind form using ajaxForm
    jQuery('#addBuildingForm').ajaxForm(options);

    jQuery( "#modal-add-building" ).dialog({
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
function validateAddBuildingForm (formData, jqForm, options)
{
    //Check to see if the building name field is blank
    var form = jqForm[0];

    //If building name is left blank, display error, and set focus to txtBuildingName
    if (!form.txtBuildingName.value){
        jQuery("#addBuildingWarning").removeClass('hidden');
        jQuery("#addBuildingWarning").addClass('display-block');
        jQuery("#txtBuildingName").focus();
        return false;
    }

    //Form fields validate
    return true;
}

//Successful login attempt
function addBuildingSuccess (result, statusText, xhr, $form)
{

    console.log(result);
    console.log(statusText);

    if (result == true)
    {
        jQuery("#addBuildingWarning").removeClass('display-block');
        jQuery("#addBuildingWarning").addClass('hidden');

        //Load the main interface
        window.location.replace("buildings.php");
    }
    else if (result == false)
    {
        //Failed to add devices
        alert('Failed to add building');
    }

}

//Opens the Add Building Dialog window
function openAddBuildingDialog()
{
    jQuery('#modal-add-building').dialog('open');
    jQuery('.ui-widget-overlay').addClass('bg-black opacity-80');
    jQuery("#txtBuildingName").focus();
}

//Closes the Add Building Dialog window
function closeAddBuildingDialog()
{
    jQuery('#modal-add-building').dialog('close');
    jQuery("#addBuildingWarning").removeClass('display-block');
    jQuery("#addBuildingWarning").addClass('hidden');
}