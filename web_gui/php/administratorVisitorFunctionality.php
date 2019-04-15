<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\administratorVisitorFunctionality.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Administrator Functionality</h1>

        <div class="container">
            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="userOnly">Manage Profile</button>
                </div>

                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="userOnly">Manage User</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="visitorOnly">Manage Transit</button>
                </div>
                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="back">Take Transit</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeOnly">Manage Site</button>
                </div>

                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="back">Explore Site</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeOnly">Explore Event</button>
                </div>

                <div class="col-md-4 offset-2">
                    <button class="btn btn-lg btn-primary btn-block" type="back">View Visit History</button>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4 offset-1">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeVisitor"
                        style="padding-left: 0px; padding-right: 0px;">View Transit
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