<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\visitorFunctionality.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Visitor Functionality</h1>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="userOnly">Explore Event</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="visitorOnly">Explore Site</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeOnly">View Visit History</button>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeVisitor">Take Transit</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="back">View Transit History</button>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="back">Back</button>
                </div>
            </div>


        </div>

    </form>

</body>

</html>