//Options var for package details ajax form
var options = {
    beforeSubmit:   validateUpdatePackageForm,  //pre-submit callback used for form validation
    success:        UpdatePackageSuccess        //post-submit callback
};

jQuery( document ).ready(function() {
    //Bind form using ajaxForm
    jQuery('#packageDetailsForm').ajaxForm(options);

    //Handles updating the icon preview when txtPackageIcon changes
    jQuery("#txtPackageIcon").keyup (function (e) {
        var path = jQuery(this).val();
        console.log('updateAppIconPreview: ' + path);
        jQuery('#imgPackageIconPreview').attr('src', path);
    });

    jQuery('#packageDetailsForm').parsley('validate');
});

//Submit the form using ajax
function submitUpdatePackageForm()
{
    jQuery('#packageDetailsForm').ajaxSubmit(options);
}

//Pre-submit verification callback
function validateUpdatePackageForm (formData, jqForm, options)
{
    return jQuery('#packageDetailsForm').parsley('validate');

    //Check to see if the device name, hostname, or vncPort fields is blank
    //var form = jqForm[0];

    //If device name is left blank, display error, and set focus to txtDeviceName
    //if (!form.txtPackageName.value || !form.txtPackageCommand.value ||
    //    !form.txtPackageUser.value || !form.txtPackagePassword.value || !form.txtPackagePasswordConfirm.value){
    //    jQuery("#updatePackageWarning").removeClass('hidden');
    //    jQuery("#updatePackageWarning").addClass('display-block');
    //    jQuery("#txtPackageName").focus();
    //   return false;
    //}

    //Form fields validate
    //return true;
}

//Successfully updated the package in the database
function UpdatePackageSuccess (result, statusText, xhr, $form) {
    if (result == true)
    {
        jQuery("#updatePackageWarning").removeClass('display-block');
        jQuery("#updatePackageWarning").addClass('hidden');

        //Load the main interface
        window.location.reload();
    }
    else if (result == false)
    {
        //Failed to add package
        alert('Failed to add packages');
    }

}