<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\managerVisitorFunctionality.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manager Functionality</h1>

        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-1">
                    <a class="btn btn-lg btn-primary btn-block" type="userOnly" href="./manageProfile.php">Manage
                        Profile</a>
                </div>

                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="userOnly">Manage Event</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="visitorOnly">View Staff</button>
                </div>
                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="back">View Site Report</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeOnly">Explore Site</button>
                </div>

                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="back">Explore Event</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeOnly">Take Transit</button>
                </div>

                <div class="col-md-4 offset-2">
                    <a class="btn btn-lg btn-primary btn-block" type="back"
                        style="padding-left: 0px; padding-right: 0px;" href="./transitHistory.php">View Transit
                        History</a>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeVisitor"
                        style="padding-left: 0px; padding-right: 0px;">View Visit
                        History</button>
                </div>

                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeVisitor">Back</button>
                </div>
            </div>

        </div>

    </form>

</body>

</html>