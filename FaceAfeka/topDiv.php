
<div id="topDiv">
        <div id="topDivChild">
            <table id="tableTop">
            <tr>
                <td><a href='home.php'><h1 id="logo">Facefeka</h1></a></td>
            <!-- </tr> -->
            <!-- <tr> -->
                <td class="tdTop">    
                <?php
                echo  "<a href='profile.php'><img class='profilePicture' src='";
                if(is_null($profilePic)) {
                    echo "images/profilePicture.jpg";
                } else {
                    echo "uploads/thumbs/user" . $loginSession . "/" . $profilePic;
                }
                echo "' width=50px height=50px>";
                echo "</a>";

                echo "<label id='ownerName'>" . $fname . " " . $lname . "</label>";
                ?>
                </td>
                <td class="tdTop">
                <div id="search">
                    <table>
                    <form onsubmit="return false;">
                    <tr><td><div id="friendAdded"></div></td></tr>
                    <tr><td><input type="text" id="searchText" placeholder="search" onkeyup="showHint(this.value)" onmouseup="showHint(this.value)" autocomplete="off"></td>
                    <td><button class="buttons" id="searchButton" disabled><img id="searchImage" src="images/search.png"></button></td></tr>
                    <tr><td><div id="searchResult"></div></td></tr>
                    </table>
                </form>
                </div>
                </td>
            
                <label style="float:right"><a href="phpFiles/logout.php">Sign Out</a></label>
        
            </tr>
            </table>
        </div>
    </div>