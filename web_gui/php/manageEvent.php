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

if (isset($_POST['backButton'])) {

    $userType  = $_SESSION["userType"];

    if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
        echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';

        if (strpos($_SESSION["user_employeeType"], "Manager") !== false) {
            header('Location: http://localhost/web_gui/php/managerFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';

        if (strpos($_SESSION["user_employeeVisitorType"], "Manager") !== false) {
            header('Location: http://localhost/web_gui/php/managerVisitorFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    }
}

?>

<?php

if (isset($_POST['view_editButton'])) {

    $userType  = $_SESSION["userType"];

    if (strpos($_SESSION["user_employeeType"], "Manager") !== false) {
        header('Location: http://localhost/web_gui/php/view_editEvent.php');
        exit();
    } else {
        echo '<script>console.log("%cUser is not a manager, hence should not be on this page. Please logout.", "color:red")</script>';;
    }
}

?>

<?php

if (isset($_POST['createButton'])) {

    $userType  = $_SESSION["userType"];

    if (strpos($_SESSION["user_employeeType"], "Manager") !== false) {
        header('Location: http://localhost/web_gui/php/createEvent.php');
        exit();
    } else {
        echo '<script>console.log("%cUser is not a manager, hence should not be on this page. Please logout.", "color:red")</script>';;
    }
}

?>


?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\_universalStyling.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


    <!-- <script type="text/javascript">

    $(document).ready(function() {
        $('#test').DataTable();
    } );

    </script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Event</h1>


        <div class="container">


            <div class="row">
                <div class="col-sm-1 offset-0">
                    <label>Name</label>
                </div>
                <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>


                <div class="col-sm-4 offset-0">
                    <label>Description Keyword</label>
                </div>
                <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-1 offset-0">
                    <label>Start Date</label>
                </div>
                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>


                <div class="col-sm-2 offset-0">
                    <label>End Date</label>
                </div>
                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-0 offset-0">
                    <label>Duration Range</label>
                </div>
                <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">
                </div>


                <div class="col-sm-0 offset-0">
                    <label>Total Visits Range</label>
                </div>
                <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 offset-2">
                <label>Total Revenue Range</label>
            </div>
            <div class="col-sm-3">

                <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                <label> -- </label>

                <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">
            </div>
        </div>

        <div class="row col-sm-12">

            <div class="col-sm-0 offset-2">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Filter</button>
            </div>

            <div class="col-sm-0 offset-2" style="text-align: right;">
                <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit" name="createButton"
                     value="Create" />


            </div>


            <div class="col-sm-0 offset-1">
                <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit"
                    name="view_editButton" value="View/Edit" />
            </div>
            <div class="col-sm-0 offset-1">
                <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit" name="deleteButton"
                    onclick="myFunction();" value="Delete" />
            </div>
        </div>


        </div>
        </div>




        <table id="test" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Name</th>
                    <th style='text-align:center'>Staff Count</th>
                    <th style='text-align:center'>Duration (Days)</th>
                    <th style='text-align:center'>Total Visits</th>
                    <th style='text-align:center'>Total Revenue ($)</th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>

        <div class="container">
            <div class="col-sm-2 offset-5">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;"
                    name="backButton">Back</button>
            </div>
        </div>
        </div>





    </form>


</body>



</html>