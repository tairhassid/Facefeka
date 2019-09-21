<?php
session_start();

?>


<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/detailsVerification.js"></script>
    <link rel="stylesheet" href="style/stylesheet.css">

</head>

<body>

    <div id="topDiv">
        <table>
            <tr>
                <td>
                    <h1 id="logo">Facefeka</h1>
                </td>
                <td id="tdLogin">
                    <div id="loginFormDiv">
                        <div class= "errorField generalError" id="loginError"></div>
                        <form method="post" id="loginForm" class="form-inline" onsubmit="return false;">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="loginEmail" class="loginDits">&nbsp;&nbsp;
                            <label for=pass>Password:</label>
                            <input type="password" name="pass" id="loginPass" class="loginDits">&nbsp;&nbsp;
                            <input type="submit" class="buttons" name="login" value="Log In" onclick="return clickLogin();">
                        </form>
                    </div>

                </td>
            </tr>
        </table>

    </div>

    <div id="bottomDiv">
        <div class="form-group" id="signupFormDiv">
            <div>
                <h2>Create an Account</h2>
            </div><br>
            <div class= "errorField generalError"></div>
            <form action="signup.php" id="signupForm" method="post">
                <div class="errorField emailError"></div>
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" class="name signupDits">&nbsp;&nbsp;
                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" class="name signupDits"> <br><br>
                
                <label>Email:</label>
                <input type="email" id="email" name="email" class="signupDits" placeholder="example@example.com"><br><br>

                <div class="errorField PwdError"></div>
                <label>Password:</label>
                <input type="password" id="pass" name="pass" class="signupDits"><br><br>
                <div class="errorField rptPwdError"></div>
                <label>Repeat Password:</label>
                <input type="password" id="rPass" name="rPass" class="signupDits"><br><br>

                <input type="submit" class="buttons" name="signup" id="signupButton" value="Sign Up">
            </form>
        </div>
    </div>


</body>


</html>

