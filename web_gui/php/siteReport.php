<?php
// Start the session
session_start();
$_SESSION['staffReportFilterButton'] = false;

if (!$_SESSION["logged_in"]) {
    header("Location: http://localhost/web_gui/php/userLogin.php");
    exit();
}


if (isset($_POST['filterButton'])){
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['staffReportFilterButton'] = True;
    echo '<script>console.log("%c Transit History Filter Session variable set", "color:blue")</script>';

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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm" name ="Site Report">Site Report</h1>

        <div class="container">
            <div class="row">
                <div class="col-sm-2 offset-0">
                    <label>Start Date</label>
                </div>

                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress" name ="startDate">
                </div>

                <div class="col-sm-2 offset-0">
                    <label>End Date</label>
                </div>

                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress" name = "endDate">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-0 offset-1">
                    <label>Event Count Range</label>
                </div>

                <div class="col-sm-5">

                    <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name ="eventLowCountRange">

                    <label> -- </label>

                    <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name ="eventUpCountRange">
                </div>
                <div class="row">
                <div class="col-sm-0 offset-0">
                    <label>Staff Count Range</label>
                </div>

                <div class="col-sm-5">

                    <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name = "staffLowCountRange">

                    <label> -- </label>

                    <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name = "staffUpCountRange">
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-0 offset-1">
                <label>Total Visits Range</label>
            </div>

            <div class="col-sm-5">

                <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name ="lowTotalVisitRange">

                <label> -- </label>

                <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name = "upTotalVisitRange">
            </div>
            <div class="row">

            <div class="col-sm-0 offset-0">
                <label>Total Revenue Range</label>
            </div>
            <div class="col-sm-5">

                <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name = "lowRevRange">

                <label> -- </label>

                <input type="text" class="col-sm-3" style="text-align: center;" placeholder="" name = "upRevRange">
            </div>

        </div>


        <div class="row col-sm-12">

            <div class="col-sm-0 offset-2">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;" name = "filterButton">Filter</button>
            </div>

            <div class="col-sm-0 offset-7">
                <input id="button" class="btn btn-sm btn-primary btn-block col-sm-" type="submit" name="button"
                    onclick="myFunction();" value="Daily Detail" />
            </div>
        </div>


        </div>

        <table id="test" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Date</th>
                    <th style='text-align:center'>Event Count</th>
                    <th style='text-align:center'>Staff Count</th>
                    <th style='text-align:center'>Total Visits</th>
                    <th style='text-align:center'>Total Revenue ($)</th>
                </tr>
            </thead>

            <tbody>
                <?php
                #filter statement
                if ($_SESSION['staffReportFilterButton'] == True) {

                    echo '<script>console.log("%cSuccessful Filter", "color:blue")</script>';


                    if (empty($_POST['startDate'])) {
                        $startDate = "0000-00-00";
                    } else {
                        $startDate = $_POST['startDate'];
                    }

                    if (empty($_POST['eventLowCountRange'])) {
                        $eventLowCountRange = 0;
                    } else {
                        $lowCountRange = $_POST['eventLowCountRange'];
                    }

                    if (empty($_POST['"eventUpCountRange "'])) {
                        $eventUpCountRange = 9223372036854775807;
                    } else {
                        $eventUpCountRange  = $_POST['"eventUpCountRange "'];
                    }

                    if (empty($_POST['staffLowCountRange'])) {
                        $staffLowCountRange = 0;
                    } else {
                        $staffLowCountRange = $_POST['staffLowCountRange'];
                    }

                    if (empty($_POST['staffUpCountRange'])) {
                        $staffUpCountRange = 9223372036854775807;
                    } else {
                        $staffUpCountRange = $_POST['"staffUpCountRange"'];
                    }

                    if (empty($_POST['lowTotalVisitRange'])) {
                        $lowTotalVisitRange = 0;
                    } else {
                        $lowTotalVisitRange = $_POST['lowTotalVisitRange'];
                    }

                     if (empty($_POST['upTotalVisitRange'])) {
                        $upTotalVisitRange = 9223372036854775807;
                    } else {
                        $upTotalVisitRange = $_POST['upTotalVisitRange'];
                    }

                    if (empty($_POST['lowRevRange'])) {
                        $lowRevRange = 0;
                    } else {
                        $lowRevRange = $_POST['lowRevRange'];
                    }

                    if (empty($_POST['upRevRange'])) {
                        $upRevRange = 0;
                    } else {
                        $upRevRange = $_POST['upRevRange'];
                    }


                     echo '<script>console.log("Start Date ' . $startDate . '")</script>';
                    echo '<script>console.log("Event Low Count Range ' . $eventLowCountRange . '")</script>';
                    echo '<script>console.log("Event up count range' . $eventUpCountRange . '")</script>';
                    echo '<script>console.log("staff low count range' . $staffLowCountRange . '")</script>';
                    echo '<script>console.log("staff up count range ' . $staffUpCountRange . '")</script>';
                    echo '<script>console.log("low total visit range' . $lowTotalVisitRange . '")</script>';
                    echo '<script>console.log("up total visit range' . $upTotalVisitRange . '")</script>';
                    echo '<script>console.log("low rev range' . $lowRevRange . '")</script>';
                    echo '<script>console.log("uprevrange' . $upRevRange . '")</script>';

                    $result = $conn->query("");


                    while ($row = $result->fetch()) {

                            echo "<tr>";

                            echo "<td style='text-align:center'>" . $row['date'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['eventCount'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['staffCount'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['totalVisits'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['totalRevenue'] . "</td>";
                            echo "<tr>";
                        }

                    #default table
                 }  else {

                     $result = $conn->query("");

                        while ($row = $result->fetch()) {

                            echo "<tr>";

                            echo "<td style='text-align:center'>" . $row['date'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['eventCount'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['staffCount'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['totalVisits'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['totalRevenue'] . "</td>";
                            echo "<tr>";
                        }




                }
                ?>

            </tbody>


        </table>

        <div class="container">
            <div class="col-sm-2 offset-5">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;"
                    name="backButton">Back</button>
            </div>
        </div>

    </form>

</body>

</html>