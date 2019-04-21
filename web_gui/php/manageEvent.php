<?php
// Start the session
session_start();

$_SESSION['manageEventFilter'] = false;
$_SESSION['deleteButton'] = false;

echo '<script>console.log("Input: ' . $_SESSION["user_employeeType"] . '")</script>';


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

if (isset($_POST['filterButton'])) {
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['manageEventFilter'] = True;
    echo '<script>console.log("%c Transit History Filter Session variable set", "color:blue")</script>';
}

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

if (isset($_POST['deleteButton'])) {


    $_SESSION['deleteButton'] = True;
    echo '<script>console.log("%cSuccessful Delete Button Push", "color:blue")</script>';
}

?>

<?php

if (isset($_POST['view_editButton'])) {


    $userType  = $_SESSION["userType"];
    echo '<script>console.log("Input: ' . $_SESSION["user_employeeType"] . '")</script>';


    if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
        echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';

        if (strpos($_SESSION["user_employeeType"], "Manager") !== false) {

            if (isset($_POST['optRadio'])) {
                $data = explode("_", $_POST['optRadio']);

                // echo '<script>console.log("Input: ' . $_POST['optRadio'] . '")</script>';
                // echo '<script>console.log("Input: ' . $data[1] . '")</script>';

                $_SESSION['manageEvent_eventName'] = $data[0];
                $_SESSION['manageEvent_eventStartDate'] = $data[1];
                $_SESSION['manageEvent_eventEndDate'] = $data[2];
                $_SESSION['manageEvent_eventPrice'] = $data[3];


                echo '<script>console.log("%cDate: ' . $data[1] . '", "color:green")</script>';

                header('Location: http://localhost/web_gui/php/view_editEvent.php');
                exit();
            } else {
                echo '<script language="javascript">';
                echo 'alert("Cannot View/Edit Event if a specific event is not chosen.")';
                echo '</script>';

                echo '<script>console.log("%cCannot View/Edit Event if a specific event is not chosen.", "color:red")</script>';;
            }
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';

        if (strpos($_SESSION["user_employeeVisitorType"], "Manager") !== false) {

            if (isset($_POST['optRadio'])) {
                $data = explode("_", $_POST['optRadio']);

                // echo '<script>console.log("Input: ' . $_POST['optRadio'] . '")</script>';
                // echo '<script>console.log("Input: ' . $data[1] . '")</script>';

                $_SESSION['manageEvent_eventName'] = $data[0];
                $_SESSION['manageEvent_eventStartDate'] = $data[1];
                $_SESSION['manageEvent_eventEndDate'] = $data[2];
                $_SESSION['manageEvent_eventPrice'] = $data[3];

                echo '<script>console.log("%cDate: ' . $data[1] . '", "color:green")</script>';

                header('Location: http://localhost/web_gui/php/view_editEvent.php');
                exit();
            } else {
                echo '<script language="javascript">';
                echo 'alert("Cannot View/Edit Event if a specific event is not chosen.")';
                echo '</script>';

                echo '<script>console.log("%cCannot View/Edit Event if a specific event is not chosen.", "color:red")</script>';;
            }
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    } else {
        echo '<script>console.log("%cUser is not a manager, hence should not be on this page. Please logout.", "color:red")</script>';
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
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name="eventName">

                </div>


                <div class="col-sm-4 offset-0">
                    <label>Description Keyword</label>
                </div>
                <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name="descKey">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-1 offset-0">
                    <label>Start Date</label>
                </div>
                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress" name="startDate">

                </div>


                <div class="col-sm-2 offset-0">
                    <label>End Date</label>
                </div>
                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress" name="endDate">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-0 offset-0">
                    <label>Duration Range</label>
                </div>
                <div class="col-sm-5">

                    <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name="lowDurRange">

                    <label> -- </label>

                    <input type="number" class="col-sm-4" style="text-align: center; width: 300px; " placeholder=""
                        name="highDurRange">
                </div>
                <div class="row">
                    <div class="col-sm-0 offset-0">
                        <label>Total Visits Range</label>
                    </div>
                    <div class="col-sm-5">

                        <input type="number" class="col-sm-4" style="text-align: center;" placeholder=""
                            name="lowVisitRange">

                        <label> -- </label>

                        <input type="number" class="col-sm-4" style="text-align: center;" placeholder=""
                            name="highVisitRange">
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 offset-0">
                <label>Total Revenue Range</label>
            </div>
            <div class="col-sm-5">

                <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name="lowRevRange">

                <label> -- </label>

                <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name="highRevRange">
            </div>
        </div>

        <div class="row col-sm-12">

            <div class="col-sm-0 offset-2">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px" name="filterButton"
                    ;>Filter</button>
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
                <?php
                if ($_SESSION['manageEventFilter'] == true) {


                    echo '<script>console.log("Here")</script>';
                    if (empty($_POST['eventName'])) {
                        $eventName = "%%";
                    } else {
                        $eventName = $_POST['eventName'];
                    }

                    if (empty($_POST['startDate'])) {
                        $startDate = "0000-00-00";
                    } else {
                        $startDate = $_POST['startDate'];
                    }

                    if (empty($_POST['endDate'])) {
                        $endDate = "9999-12-12";
                    } else {
                        $endDate = $_POST['endDate'];
                    }

                    if (empty($_POST['descKey'])) {
                        $descKey = "%%";
                    } else {
                        $descKey = '%' . $_POST['descKey'] . '%';
                    }

                    if (empty($_POST['startDate'])) {
                        $startDate = "0000-00-00";
                    } else {
                        $startDate = $_POST['startDate'];
                        echo '<script>console.log("Works Input: ' . $startDate . '")</script>';
                    }


                    if (empty($_POST['lowDurRange'])) {
                        $lowDurRange = 0;
                    } else {
                        $lowDurRange = $_POST['lowDurRange'];
                    }

                    if (empty($_POST['highDurRange'])) {
                        $highDurRange = 9223372036854775807;;
                    } else {
                        $highDurRange = $_POST['highDurRange'];
                    }
                    if (empty($_POST['lowVisitRange'])) {
                        $lowVisitRange = 0;
                    } else {
                        $lowVisitRange = $_POST['lowVisitRange'];
                    }

                    if (empty($_POST['highVisitRange'])) {
                        $highVisitRange = 9223372036854775807;;
                    } else {
                        $highVisitRange = $_POST['highVisitRange'];
                    }

                    if (empty($_POST['lowRevRange'])) {
                        $lowRevRange = 0;
                    } else {
                        $lowRevRange = $_POST['lowRevRange'];
                    }

                    if (empty($_POST['highRevRange'])) {
                        $highRevRange = 9223372036854775807;;
                    } else {
                        $highRevRange = $_POST['highRevRange'];
                    }


                    echo '<script>console.log("eventName: ' . $eventName . '")</script>';
                    echo '<script>console.log("startDate: ' . $startDate . '")</script>';
                    echo '<script>console.log("endDate: ' . $endDate . '")</script>';
                    echo '<script>console.log("descKey: ' . $descKey . '")</script>';
                    echo '<script>console.log("lowDurRange: ' . $lowDurRange . '")</script>';
                    echo '<script>console.log("highDurRange: ' . $highDurRange . '")</script>';
                    echo '<script>console.log("lowVisitRange: ' . $lowVisitRange . '")</script>';
                    echo '<script>console.log("highVisitRange: ' . $highVisitRange . '")</script>';
                    echo '<script>console.log("lowRevRange ' . $lowRevRange . '")</script>';
                    echo '<script>console.log("highRevRange: ' . $highRevRange . '")</script>';



                    $result = $conn->query("SELECT event.eventName,
                            datediff(event.endDate, event.startDate) as duration,
                                event.startDate,
                                event.endDate,
                                event.eventPrice,
                               staffassign.staffCount,
                               visitors.totalVisits,
                               visitors.totalVisits*eventPrice as totalRevenue
                               FROM event left join (SELECT eventName, startDate, count(*) as staffCount FROM assignTo group by 1,2) as staffAssign
                               on event.eventName = staffAssign.eventName
                            and event.startDate = staffAssign.startDate
                            left join (SELECT eventName, startDate, count(*) as totalVisits FROM visitEvent group by 1,2) as visitors
                            on event.eventName = visitors.eventName
                            and event.startDate = visitors.startDate
                               where event.eventName like '$eventName'
                               and event.startDate >= '$startDate'
                               and event.endDate <= '$endDate'
                               and event.description like '$descKey'
                               and (event.endDate - event.startDate) between $lowDurRange and $highDurRange
                               and visitors.totalVisits between $lowVisitRange and $highVisitRange
                               and visitors.totalVisits*eventPrice between $lowRevRange and $highRevRange
                               group by event.eventName,event.startDate;");


                    while ($row = $result->fetch()) {
                        $value = $row['eventName'] . "_" . $row['startDate'] . "_" . $row['endDate'] . "_" . $row['eventPrice'];
                        echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'>
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['eventName'] . "</label>
                                    </div>
                                    </td>";
                        echo "<td style='text-align:center'>" . $row['duration'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['staffCount'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['totalVisits'] . "</td>";
                        echo "<td style='text-align:center'> $ " . $row['totalRevenue'] . ".00</td>";
                    }
                } else {
                    $result = $conn->query("SELECT event.eventName,
                            datediff(event.endDate, event.startDate) as duration,
                                event.startDate,
                                event.endDate,
                                event.eventPrice,
                               staffassign.staffCount,
                               visitors.totalVisits,
                               visitors.totalVisits*eventPrice as totalRevenue
                               FROM event left join (SELECT eventName, startDate, count(*) as staffCount FROM assignTo group by 1,2) as staffAssign
                               on event.eventName = staffAssign.eventName
                            and event.startDate = staffAssign.startDate
                            left join (SELECT eventName, startDate, count(*) as totalVisits FROM visitEvent group by 1,2) as visitors
                            on event.eventName = visitors.eventName
                            and event.startDate = visitors.startDate
                               group by event.eventName,event.startDate;");



                    while ($row = $result->fetch()) {
                        $value = $row['eventName'] . "_" . $row['startDate'] . "_" . $row['endDate'] . "_" . $row['eventPrice'];
                        // $value_date = $row['startDate'];
                        echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'>
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['eventName'] . "</label>
                                    </div>
                                    </td>";
                        echo "<td style='text-align:center'>" . $row['duration'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['staffCount'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['totalVisits'] . "</td>";
                        echo "<td style='text-align:center'> $ " . $row['totalRevenue'] . ".00</td>";
                    }
                }


                if ($_SESSION['deleteButton'] == true) {

                    $eventName = $_POST['optRadio'];
                    echo '<script>console.log("eventName: ' . $eventName . '")</script>';
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
        </div>





    </form>


</body>



</html>