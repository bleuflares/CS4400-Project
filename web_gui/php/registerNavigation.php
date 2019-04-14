<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\registerNavigation.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Register Navigation</h1>
        <!-- <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div> -->

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="userOnly">User Only</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="visitorOnly">Visitor Only</button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeOnly">Employee Only</button>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-lg btn-primary btn-block" type="employeeVisitor">Employee-Visitor</button>
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