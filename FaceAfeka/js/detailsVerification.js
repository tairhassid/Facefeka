$(document).ready(function () {
    $("#signupForm").on('submit', function (e) {
        e.preventDefault();

        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var password = $("#pass").val();
        var cpassword = $("#rPass").val();

        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

        $(".errorField").hide();
        $(".errorField").text('');
        if (email == '' || password == '' || cpassword == '') {
            $(".generalError").append("<small>Please fill all fields</small>");
            $(".generalError").show();
            return false;
        } else if (email != '' || password != '' || cpassword != '') {
            $(".generalError").hide();
        }
        if (!(emailReg.test(email))) {
            $(".emailError").append("<small>Incorrect email address</small>");
            $(".emailError").show();
            return false;
        } else if ((emailReg.test(email))) {
            $(".emailError").hide();
        }
        if ((password.length) < 8) {
            $(".PwdError").append("<small>Password must contain atleast 8 character in length</small>");
            $(".PwdError").show();
            return false;
        } else if ((password.length) >= 8) {
            $(".PwdError").hide();
        }
        if (!(password).match(cpassword)) {
            $(".rptPwdError").append("<small>Passwords don't match. Try again</small>");
            $(".rptPwdError").show();
            return false;
        } else if ((password).match(cpassword)) {
            $(".rptPwdError").hide();
        }

        $.post("phpFiles/signup.php", {
                fname: fname,
                lname: lname,
                email: email,
                password: password
            },
            function (data, message) {

                if (data == "email") {
                    $('.emailError').append("<small>Email already exists</small>");
                    $(".emailError").show();
                } else if (data == "query") {
                    $(".generalError").append("<small>There was a problem signing you in, please try again later</small>");
                    $(".generalError").show();
                } else {
                    $("#signupFormDiv").find(".signupDits").val('');
                }
            })

        return true;
    });
});

function clickLogin() {
    var email = $("#loginEmail").val();
    var password = $("#loginPass").val();

    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    $("#loginError").hide();
    $("#loginError").text('');
    if (email == '' || password == '') {
        $("#loginError").append("<small>Please fill all fields</small>");
        $("#loginError").show();
        return false;
    } else if (email != '' || password != '') {
        $("#loginError").hide();
    }
    if (!(emailReg.test(email))) {
        $("#loginError").append("<small>Incorrect email address</small>");
        $("#loginError").show();
        return false;
    } else if ((emailReg.test(email))) {
        $("#loginError").hide();
    }
    if ((password.length) < 8) {
        $("#loginError").append("<small>Password must contain atleast 8 character in length</small>");
        $("#loginError").show();
        return false;
    } else if ((password.length) >= 8) {
        $("#loginError").hide();
    }

    $.post("phpFiles/login.php", {
            email: email,
            password: password
        },
        function (data, message) {
            if (data == "email") {
                $('#loginError').append("<small>Email or password incorrect</small>");
                $("#loginError").show();
            } else {
                window.location = "home.php";
            }
            $("#signupFormDiv").find(".loginFormDiv").val('');
        })

    return true;
}