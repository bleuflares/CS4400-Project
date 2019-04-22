<?php
session_start();

if (!$_SESSION["logged_in"]) {
    header("Location: http://localhost/web_gui/php/userLogin.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\administratorFunctionality.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="..\css\_universalStyling.css">

</head>

<body>

    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Administrator Functionality</h1>

        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-1">
                    <a class="btn btn-lg btn-primary btn-block" type="userOnly" href="./manageProfile.php">Manage
                        Profile</a>
                </div>

                <div class="col-md-4 offset-2">
                    <a class="btn btn-lg btn-primary btn-block" type="userOnly" href="./takeTransit.php">Take
                        Transit</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <a class="btn btn-lg btn-primary btn-block" type="visitorOnly" href="./manageUser.php">Manage
                        User</a>
                </div>
                <div class="col-md-4 offset-2">
                    <a class="btn btn-lg btn-primary btn-block" style="padding-left: 0px; padding-right: 0px;"
                        type="back" href="./transitHistory.php">View Transit
                        History</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <a class="btn btn-lg btn-primary btn-block" type="employeeOnly" href="./manageTransit.php">Manage
                        Transit</a>
                </div>

                <div class="col-md-4 offset-2">
                    <a class="btn btn-lg btn-primary btn-block" type="back" href="./userLogin.php">Back</a>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4 offset-1">
                    <a class="btn btn-lg btn-primary btn-block" type="employeeVisitor" href="./manageSite.php">Manage
                        Site</a>
                </div>
            </div>


        </div>

    </form>

</body>

</html>