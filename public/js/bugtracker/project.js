/*
function openCity(evt, cityName) {

    var url = $(evt.target).attr('data-href');

    getPageAndAppend(url, $('#'+cityName));
    

    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

function getPageAndAppend(url, element){

    $.ajaxPrefilter(function( options, originalOptions, jqXHR ) { options.async = true; });

    console.log ('load page');
    $.ajax({
        type: "GET",
        url: url,
        async: true,
        beforeSend: function(data){
            //console.log('before-send');
        },
        success: function(page)
        {
            //return page;
            element.html(page);
            updateCreateIssueForm();
        },
        error: function(error){
            //console.log(data);
        }
    });

}

*/
