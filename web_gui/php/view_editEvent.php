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
            header('Location: http://localhost/web_gui/php/manageEvent.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';

        if (strpos($_SESSION["user_employeeVisitorType"], "Manager") !== false) {
            header('Location: http://localhost/web_gui/php/manageEvent.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="refresh" content="3">

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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">View/Edit Event</h1>


        <div class="container">


            <div class="row">

                <div class="col-sm-6">
                    <label>Name</label>
                    <?php
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $row['Username'] . '</span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>Price ($)</label>
                    <?php
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $row['Username'] . '</span>';
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Start Date</label>
                    <?php
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $row['Username'] . '</span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>End Date</label>
                    <?php
                    // if ($siteRow) {
                    //     // echo '<span style="font-weight: 600; margin-left: 2.25em;">' .  $siteRow['SiteName'] . '</span>';
                    // } else {
                    //     // echo '<span style="font-weight: 600; margin-left: 2.25em;">N/a</span>';
                    // }
                    ?>
                </div>

            </div>


            <div class="row">
                <div class="col-sm-6">
                    <label>Minimum Staff Required</label>
                    <?php
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $row['Username'] . '</span>';
                    ?>
                </div>
                <div class="col-sm-6">
                    <label>Capacity</label>
                    <?php
                    // echo '<span style="font-weight: 600; margin-left: 1.15em;">' . $row['EmployeeID'] . '</span>'
                    ?>
                </div>
            </div>

            <br>

            <div class="row">
                <label for="exampleFormControlSelect2" style="">Staff Assigned</label>

                <select multiple style="display: inline; margin-left: 5em;" class="form-control col-sm-6 offset-1"
                    id="exampleFormControlSelect2">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>

            </div>

            <div class="row">
                <div class="col-sm-2 offset-0">
                    <label>Description</label>
                </div>
                <div class="col-sm-4 offset-1">
                    <textarea name="paragraph_text" cols="50" rows="8"></textarea>

                </div>

            </div>

            <br>

            <div class="row">
                <div class="col-sm-0 offset-0">
                    <label>Daily Visits Range</label>
                </div>
                <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">
                </div>


                <div class="col-sm-0 offset-0">
                    <label>Daily Revenue Range</label>
                </div>
                <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">
                </div>

            </div>
        </div>

        <br>

        <div class="row col-sm-12">

            <div class="col-sm-2 offset-2">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Filter</button>
            </div>

            <div class="col-sm-2 offset-4">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Update</button>
            </div>

        </div>



        <table id="test" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Date</th>
                    <th style='text-align:center'>Daily Visits</th>
                    <th style='text-align:center'>Daily Revenue (S)</th>
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