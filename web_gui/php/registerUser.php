<?php
// Start the session
session_start();

global $conn;
try {
    $conn = new PDO(
        "mysql:host=" . $_SESSION['serverName'] . ";dbname=" . $_SESSION['databaseScheme'] . "",
        $_SESSION["databaseUserName"],
        $_SESSION["databasePassword"]
    );
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo '<script>console.log("Connected Successfully to DB")</script>';
} catch (PDOException $e) {
    echo '<script>console.log("%cConnection failed: ' . $e->getMessage() . '", "color:red")</script>';
}

$_SESSION["registerUser_EmailCounter"] = 0;
?>

<?php

if (isset($_POST['registerButton'])) {

    $anyValidEmails = false;

    foreach ($_POST['email'] as $email) {

        if ($email !== "") {
            $anyValidEmails = true;
        }

        // echo '<script>console.log("%cEMAIL: ' . $email . '", "color:green")</script>';
        // $bool = ($email !== "");
        // echo '<script>console.log("%cEMAIL: ' . ($bool) . '", "color:green")</script>';
    }

    if ($anyValidEmails) {
        echo '<script>console.log("%cThere exist an valid EMAIL", "color:green")</script>';
    } else {
        echo '<script>console.log("%cThere DOES NOT exist ANY valid EMAILS", "color:red")</script>';
    }

    if (
        !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['username'])
        && !empty($_POST['pass']) && !empty($_POST['cpass']) && $anyValidEmails
    ) {

        echo '<script>console.log("%cAll Required Fields Filled", "color:green")</script>';

        // echo '<script>console.log("Name Input: ' . $_POST['nameInput'] . '")</script>';
        // echo '<script>console.log("Zip Input: ' . $_POST['zipInput'] . '")</script>';
        // echo '<script>console.log("address Input: ' . $_POST['addressInput'] . '")</script>';
        // echo '<script>console.log("manager Input: ' . $_POST['managerInput'] . '")</script>';
        // echo '<script>console.log("open Input: ' . $_POST['openInput'] . '")</script>';

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        // $email = $_POST['email'];
        $cPass = $_POST['pass'];
        $password = $_POST['pass'];
        if ($cPass == $pass) {
            $result = $conn->query("INSERT into user VALUES('$username', '$pass', 'Pending', '.$fname', '$lname', 'User')");

            foreach ($_POST['email'] as $email) {
                if ($email !== "") { 
                    $result = $conn->query("INSERT into useremail VALUES('$username', '$email')");
                }
            }
            echo '<script>console.log("%cSuccessful Creation", "color:green")</script>';
        } else {
            echo '<script language="javascript">';
            echo 'alert("Passwords Do Not Match. Please try registering again.")';
            echo '</script>';
        }
    } else {
        echo '<script language="javascript">';
        echo 'alert("Failed to Register. There was an empty field. Please register again.")';
        echo '</script>';
    }
}
?>


<?php

if (isset($_POST['backButton'])) {

    header('Location: http://localhost/web_gui/php/registerNavigation.php');
    exit();
}

?>


<?php

if (isset($_POST['addEmail'])) {

    $_SESSION["registerUser_EmailCounter"] = $_SESSION["registerUser_EmailCounter"] + 1;

    $value =  $_SESSION["registerUser_EmailCounter"];

    echo '<script>console.log("%cSuccessful Creation' . $value . '", "color:green")</script>';
}

?>


<?php
$cookie_name = "registerUser_EmailCounter";
$cookie_value = 0;
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
?>



<!DOCTYPE html>
<html>

<!-- style="border:red 1px solid;" -->

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\registerUser.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <form class="form-signin" method="post">

        <h1 class="mb-3 font-weight-heavy" id="titleOfForm">Register User</h3>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4" id="firstNameLabel">First
                        Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputFirstName" name="fname">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-4" id="lastNameLabel">Last
                        Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputLastName" name="lname">
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputUsername" class="label .col-form-label col-sm-4"
                        id="userNameLabel">Username</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputUsername" name="username">
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputPassword" class="label .col-form-label col-sm-4"
                        id="passwordLabel">Password</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword" name="pass" pattern=".{8,25}"
                            placeholder="At least 8 characters">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputConfirmPassword" class="label .col-form-label col-sm-4"
                        id="confirmPasswordLabel">Confirm Password</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputConfirmPassword" name="cpass"
                            pattern=".{8,25}" placeholder="At least 8 characters">
                    </div>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group row col-sm-12">
                    <label for="inputEmail" class="label .col-form-label col-sm-2" id="emailLabel">Email</label>

                    <div class="col-sm-6">
                        <div id="emailContainer">
                            <!-- <input type="text" class="form-control" id="inputEmail" name="email"
                                pattern="[a-z0-9]+@[a-z0-9]+\.[a-z0-9]{2,}$"> -->
                        </div>
                    </div>

                </div>
                <input type="button" class="btn btn-outline-dark" onclick="addField()" name="addEmail" value="ADD" />

            </div>

            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary" id="backButton" name="backButton">Back</button>
                    <button type="submit" class="btn btn-primary" id="registerButton"
                        name="registerButton">Register</button>
                </div>
            </div>


    </form>

    <script type='text/javascript'>
    var i;

    function addField() {
        // Container <div> where dynamic content will be placed
        var container = document.getElementById("emailContainer");

        if (i == null) {
            i = 0;
        } else {
            i++;
        }

        // Create an <input> element, set its type and name attributes
        var input = document.createElement("input");
        input.type = "text";
        input.name = "email[]";
        input.id = "email" + i;
        input.pattern = "[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]{1,}$";
        input.className = "form-control removableEmail";
        input.style = "margin-left: -1em;"

        container.appendChild(input);

        var button = document.createElement("button");
        button.innerHTML = "Remove";
        button.value = "email" + i;
        button.type = "button";
        button.onclick = function() {
            console.log(this.value);

            var totalEmailInputsLeft = document.querySelectorAll(".removableEmail").length;

            if (totalEmailInputsLeft > 1) {
                var removeID = this.value;
                document.getElementById(removeID).nextSibling.nextSibling.remove();
                document.getElementById(removeID).nextSibling.remove();
                document.getElementById(removeID).remove();
            }
        };

        container.appendChild(button);

        // Append a line break 
        container.appendChild(document.createElement("br"));
    }

    window.onload = function() {
        addField();
    };
    </script>

</body>


</html>