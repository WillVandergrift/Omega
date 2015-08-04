/**
 * Created by Will on 1/3/14.
 */

jQuery(document).ready(function() {
    //Wire up keyboard events
    wireKeyboardEvents();
});

function wireKeyboardEvents()
{
    jQuery('#txtHeaderSearch').keyup(function(){
        if (this.value.length > 2)
        {
            lookupValue(this.value);
        }
        else
        {
            jQuery('#searchResults').fadeOut();
        }
    })

}

//Search the database for a matching value
function lookupValue(value)
{
    jQuery.ajax({
        url: 'ajax/searchEntities.php',
        data: { searchValue: value},
        type: 'post',
        success: function(data){
            $('#searchResults').fadeIn(); // Show the suggestions box
            displaySearchResults(data); //Parse the json result
        }
    });
}

function displaySearchResults(jsonResult)
{
    //Check for empty result
    if (jsonResult == "")
    {
        //Remove existing items from the results list
        $('#searchTable tr').remove();

        $('#searchTable').append(
            "<tr>" +
                "<td class='search-image glyph-icon icon-exclamation-circle'></td>" +
                "<td class='search-text'>" +
                "<span class='search-title'>Match not Found</span>" +
                "<br />" +
                "No objects were found that match the search criteria" +
                "</td>" +
                "</tr>"
        );

        return;
    }

    jsonResult = jQuery.parseJSON(jsonResult);

    //Remove existing items from the results list
    $('#searchTable tr').remove();

    //Loop through the results
    jQuery(jsonResult).each(function(){
        $('#searchTable').append(
          "<tr>" +
              "<td class='search-image glyph-icon " + getSearchImage(this.objectType) + "'></td>" +
              "<td class='search-text'>" +
                    "<span class='search-title'>" + this.name + "</span>" +
                    "<br />" +
                    this.description +
              "</td>" +
          "</tr>"
        );
    })
}

//Returns the image path for the object type in the search results
function getSearchImage(objectType)
{
    switch (objectType)
    {
        case "device":
            return "icon-desktop"
            break;
        default:
            return "icon-exclamation-circle"
            break;
    }
}

//Destroy the current user's session and redirect back to the login page
function logout()
{
    jQuery.ajax({
        url: 'ajax/logout.php',
        type: 'post',
        success: function(){
            window.location.href = "index.php";
        }
    });
}



