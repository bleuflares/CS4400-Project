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
?>

<?php

if (isset($_POST['registerButton'])) {

    $anyValidEmails = false;

    foreach ($_POST['email'] as $email) {

        if ($email !== "") {
            $anyValidEmails = true;
        }
    }

    if ($anyValidEmails) {
        echo '<script>console.log("%cThere exist an valid EMAIL", "color:green")</script>';
    } else {
        echo '<script>console.log("%cThere DOES NOT exist ANY valid EMAILS", "color:red")</script>';
    }


    if (
        !empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['username'])
        && !empty($_POST['password']) && !empty($_POST['cPass']) && $anyValidEmails
    ) {
        echo '<script>console.log("%cAll Required Fields Filled", "color:green")</script>';

        // echo '<script>console.log("First Name Input: ' . $_POST['fname'] . '")</script>';
        // echo '<script>console.log(" Last Name Input: ' . $_POST['lname'] . '")</script>';
        // echo '<script>console.log("Username Input: ' . $_POST['username'] . '")</script>';
        // echo '<script>console.log("Password Input: ' . $_POST['password'] . '")</script>';
        // echo '<script>console.log("cPass Input: ' . $_POST['cPass'] . '")</script>';
        // echo '<script>console.log("email Input: ' . $_POST['email'] . '")</script>'

        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $cPass = $_POST['cPass'];
        // $email = $_POST['email'];

        if ($password == $cPass) {
            $result = $conn->query("INSERT into user VALUES('$username', '$password','Pending', '$fname', '$lname', 'User')");

            foreach ($_POST['email'] as $email) {
                if ($email !== "") {
                    $result = $conn->query("INSERT into useremail VALUES('$username', '$email')");
                }
            }
            echo '<script>console.log("%cSuccessful Creation", "color:green")</script>';
            // $result = $conn->query("INSERT into useremail VALUES('$username', '$email')");
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

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\registerVisitor.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <form class="form-signin" method="post">

        <h1 class="mb-3 font-weight-heavy" id="titleOfForm">Register Visitor</h3>

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
                        <input type="password" class="form-control" id="inputPassword" name="password" pattern=".{8,25}"
                            placeholder="At least 8 characters">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputConfirmPassword" class="label .col-form-label col-sm-4"
                        id="confirmPasswordLabel">Confirm Password</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputConfirmPassword" name="cPass"
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
                                pattern="[a-z0-9]+@[a-z0-9]+\.[a-z0-9]{1,}$"> -->
                        </div>
                    </div>

                </div>
                <button type="button" class="btn btn-outline-dark" onclick="addField()" name="addEmail">Add</button>

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