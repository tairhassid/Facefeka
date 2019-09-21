var xmlHttp;

function showHint(str) {
    if (str.length == 0) {
        document.getElementById("searchResult").innerHTML = "";
        return;
    }

    xmlHttp = GetXmlHttpObject();
    if (xmlHttp == null) {
        alert("Your browser does not support AJAX!");
        return;
    }

    var url = "phpFiles/search.php";
    url = url + "?q=" + str;
    url = url + "&sid=" + Math.random();
    xmlHttp.onreadystatechange = stateChanged; //this function is called everytime the readyState changes
    xmlHttp.open("GET", url, true);
    xmlHttp.send(null);
}

function stateChanged() {
    //if the request finished and response is ready
    if (xmlHttp.readyState == 4) {
        document.getElementById("searchResult").innerHTML = xmlHttp.responseText;
        //returns the server response as a JavaScript string
    }
}

function GetXmlHttpObject() {
    var xmlHttp = null;
    try {
        /* firefox, Opera 8.0+, Safari*/
        xmlHttp = new XMLHttpRequest();
        //exchange data with a web server behind the scenes
        //makes it possible to update parts of the web page without reloading
    } catch (e) {
        /*Iexplorer*/
        try {
            xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function addFriend(userId) {
    $.post("phpFiles/search.php", {
            user: userId
        },
        function (data, message) {
            if (data == "success") {
                $('#friendAdded').append("<label class='friendAddedText'>New friend was added!</label>");
                setTimeout(function () {
                    $(".friendAddedText").fadeOut().empty();
                }, 5000);
                $("#showPostsDiv").load("phpFiles/loadPosts.php");
            } else {
                $('#friendAdded').append("<label class='friendAddedText'>Failed to addd friend, please try again later</label>");
                setTimeout(function () {
                    $(".friendAddedText").fadeOut().empty();
                }, 5000);
            }
        })
}

//hide the search result table when pressing anywhere
//except the table itself
$(document).click(function () {
    $('.searchResultTable').hide();
})
$("#search").click(function (e) {
    e.stopPropagation(); //stops the propagation of the current event
    return false;
});