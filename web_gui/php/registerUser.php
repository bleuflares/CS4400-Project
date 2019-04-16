<?php
// Start the session
session_start();

if (!$_SESSION["logged_in"]) {
    header("Location: http://localhost/web_gui/php/userLogin.php");
    exit();
}

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

// echo '<script>console.log("BOOL' . $_POST['zipInput'] . ')</script>';


if (isset($_POST['fname'])  && !empty($_POST['lname']) && !empty($_POST['username']) && !empty($_POST['pass']) && !empty($_POST['cpass']) && !empty($_POST['email'])) {

    echo '<script>console.log("%cSuccessful Creation", "color:green")</script>';

    echo '<script>console.log("Name Input: ' . $_POST['nameInput'] . '")</script>';
    echo '<script>console.log("Zip Input: ' . $_POST['zipInput'] . '")</script>';
    echo '<script>console.log("address Input: ' . $_POST['addressInput'] . '")</script>';
    echo '<script>console.log("manager Input: ' . $_POST['managerInput'] . '")</script>';
    echo '<script>console.log("open Input: ' . $_POST['openInput'] . '")</script>';

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $cPass = $_POST['cPass'];
    if ($cPass == $pass) {
        $result = $conn->query("INSERT into site VALUES('$nameInput', '$addressInput', '$zipInput', '.$openInput', '.$managerInput.')");
    } else { }
} else {
    echo '<script>console.log("%cFailed Creation", "color:red")</script>';
}
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
                        <input type="password" class="form-control" id="inputPassword" name="pass">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputConfirmPassword" class="label .col-form-label col-sm-4"
                        id="confirmPasswordLabel">Confirm Password</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputConfirmPassword" name="cpass">
                    </div>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group row col-sm-12">
                    <label for="inputEmail" class="label .col-form-label col-sm-2" id="emailLabel">Email</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputEmail" name="email">
                    </div>

                    <button type="submit" class="btn btn-outline-dark">Add</button>
                </div>

            </div>

            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary" id="backButton">Back</button>
                    <button type="submit" class="btn btn-primary" id="registerButton">Register</button>
                </div>
            </div>


    </form>

    <script type="text/javascript">
    </script>

</body>


</html>