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

$eventName = $_SESSION['manageEvent_eventName'];
$startDate = date('Y-m-d', strtotime($_SESSION['manageEvent_eventStartDate']));
$endDate = date('Y-m-d', strtotime($_SESSION['manageEvent_eventEndDate']));

$result = $conn->query("SELECT * 
                            FROM cs4400_testdata.event 
                            WHERE eventName = '$eventName' AND startDate = '" . $startDate . "';");

echo '<script>console.log("%cValue: ' . $eventName . '", "color:green")</script>';

echo '<script>console.log("%cValue: ' . $startDate . '", "color:green")</script>';

echo '<script>console.log("%cRow Count: ' . $result->rowCount()  . '", "color:green")</script>';


if ($result->rowCount() > 0) {
    $dataRow = $result->fetch();

    echo '<script>console.log("%cValue: ' . $dataRow['startDate'] . '", "color:green")</script>';
} else {
    echo '<script>console.log("%cFailed to Find the Event Entry in the Database", "color:red")</script>';
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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">View/Edit Event</h1>


        <div class="container">


            <div class="row">

                <div class="col-sm-6">
                    <label>Name</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $dataRow['eventName'] . '</span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>Price ($)</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $dataRow['eventPrice'] . '</span>';
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Start Date</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $dataRow['startDate'] . '</span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>End Date</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' .  $dataRow['endDate'] . '</span>';
                    ?>
                </div>

            </div>


            <div class="row">
                <div class="col-sm-6">
                    <label>Minimum Staff Required</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $dataRow['minStaffRequired'] . '</span>';
                    ?>
                </div>
                <div class="col-sm-6">
                    <label>Capacity</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 1.15em;">' . $dataRow['capacity'] . '</span>'
                    ?>
                </div>
            </div>

            <br>

            <div class="row">
                <label for="exampleFormControlSelect2" style="">Staff Assigned</label>

                <select multiple style="display: inline; margin-left: 5em;" class="form-control col-sm-6 offset-1"
                    id="exampleFormControlSelect2">
                    <?php
                    $staffResult = $conn->query("SELECT * 
                                                FROM assignto 
                                                WHERE eventName ='$eventName' 
                                                AND startDate = '$startDate';");

                    while ($staffDataRow = $staffResult->fetch()) {
                        $staffUsername = $staffDataRow['staffUsername'];
                        $staffNameTable = $conn->query("SELECT concat(user.firstname, ' ',user.lastname) as fullName
                                                        FROM user 
                                                        WHERE userName = '$staffUsername' ;");

                        $staffNameRow = $staffNameTable->fetch();
                        echo "<option selected='selected'>" . $staffNameRow['fullName'] . "</option>";
                    }

                    $startDate = date('Y-m-d', strtotime($_SESSION['manageEvent_eventStartDate']));
                    $endDate = date('Y-m-d', strtotime($_SESSION['manageEvent_eventEndDate']));

                    $availableStaffResult = $conn->query("SELECT distinct concat(user.firstName,' ',user.lastName) as Name 
                                                        from employee left join user on user.username = employee.username
                                                        where concat(user.firstName,' ',user.lastName) not in (
                                                            select distinct concat(user.firstName,' ',user.lastName) as Name 
                                                            from employee left join user on user.username = employee.username
                                                            left join assignTo on employee.username = assignTo.staffUsername
                                                            left join event on event.eventName = assignTo.eventName
                                                            and event.startDate = assignTo.startDate
                                                            and event.siteName = assignTo.siteName
                                                            and (
                                                                (event.startDate between '$startDate' and '$endDate') 
                                                                or (event.endDate between '$startDate' and '$endDate') 
                                                                or (event.startDate <= '$startDate' and event.endDate >= '$endDate'))
                                                        where event.eventName is not null)
                                                        and employee.employeeType = 'Staff';");


                    while ($availableStaffDataRow = $availableStaffResult->fetch()) {
                        $availableStaffName = $availableStaffDataRow['Name'];

                        echo "<option>" . $availableStaffName . "</option>";
                    }
                    ?>
                </select>

            </div>

            <div class="row">
                <div class="col-sm-2 offset-0">
                    <label>Description</label>
                </div>
                <div class="col-sm-4 offset-1">
                    <?php
                    echo '<textarea name="paragraph_text" cols="50" rows="8">' . $dataRow['description'] . '</textarea>'
                    ?>
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
                    <th style='text-align:center'>Daily Revenue ($)</th>
                </tr>
            </thead>

            <?php

            $startDate = strtotime($_SESSION['manageEvent_eventStartDate']);
            $endDate = strtotime($_SESSION['manageEvent_eventEndDate']);
            $eventPrice = $_SESSION['manageEvent_eventPrice'];

            $durationOfEvent = $endDate - $startDate;
            $durationInDays  = round($durationOfEvent / (60 * 60 * 24));


            while ($durationInDays >= 0) {


                // $startDate = date('Y-m-d', strtotime("+1 day", $startDate));

                $currentDate = date('Y-m-d', $startDate);

                $eventName = $_SESSION['manageEvent_eventName'];

                $totalDailyVisits = $conn->query("SELECT eventName, startDate, siteName, visitEventDate
                                                    FROM visitevent 
                                                    WHERE eventName = '$eventName' and visitEventDate = '$currentDate';");



                echo '<script>console.log("%cValue: ' . $durationInDays . '", "color:green")</script>';

                echo "<tr>";
                echo   "<td style='text-align:center'>" . date('Y-m-d', $startDate) . "</td>";
                echo "<td style='text-align:center'>" . $totalDailyVisits->rowCount()  . "</td>";
                echo "<td style='text-align:center'>" .  $totalDailyVisits->rowCount() * $eventPrice . "</td>";
                echo "<tr>";

                $startDate = $startDate + (60 * 60 * 24);
                $durationInDays = $durationInDays - 1;
            }

            ?>

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