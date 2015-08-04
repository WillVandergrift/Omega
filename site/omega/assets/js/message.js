jQuery( document ).ready(function() {

    jQuery( "#modal-message" ).dialog({
        autoOpen: true,
        modal: true,
        draggable: false,
        minWidth: 400,
        maxWidth: 400,
        minHeight: 300,
        maxHeight: 300,
        dialogClass: "",
        show: "fadeIn"
    });
});

//Closes the Message Dialog window
function closeMessageDialog()
{
    jQuery('#modal-message').dialog('close');
    window.close();
}