<?php
// Start the session
session_start();

$_SESSION['staffViewScheduleFilter'] = false;

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


if (isset($_POST['filterButton'])){
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['staffViewScheduleFilter'] = true;
    echo '<script>console.log("%c View Schedule Filter Session variable set", "color:blue")</script>';

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
    <form class="form-signin" method = "post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">View Schedule</h1>


        <div class="container">
            <div class="row">
                <div class="col-sm-3 offset-0">
                    <label>Event Name</label>
                </div>
                <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name = "eventName">

                </div>


                <div class="col-sm-4 offset-0">
                    <label>Description Keyword</label>
                </div>
                <div class="col-sm-2 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name = "descKeyword">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-2 offset-0">
                    <label>Start Date</label>
                </div>
                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress" name = "startDate">

                </div>


                <div class="col-sm-2 offset-0">
                    <label>End Date</label>
                </div>
                <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress" name = "endDate">

                </div>
            </div>

            <div class="row col-sm-12">

                <div class="col-sm-0 offset-2">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0"
                        style="border-radius: 5px;" name="filterButton">Filter</button>
                </div>
                <div class="col-sm-0 offset-5">
                    <input id="button" class="btn btn-sm btn-primary btn-block col-sm-" type="submit" name="button"
                        onclick="myFunction();" value="View Event" />
                </div>
            </div>


        </div>
        </div>




        <table id="test" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Event Name</th>
                    <th style='text-align:center'>Site Name</th>
                    <th style='text-align:center'>Start Date</th>
                    <th style='text-align:center'>End Date</th>
                </tr>
            </thead>

            <tbody>
            <?php
            if (($_SESSION['staffViewScheduleFilter']) == TRUE) {
                     echo '<script>console.log("hi", "color:blue")</script>';

                if (empty($_POST['eventName'])){
                        $eventName = "%%";
                    } else {
                        $eventName = $_POST['eventName'];
                    }
                if (empty($_POST['descKeyword'])) {
                        $descKey = "%%";
                    } else {
                        $descKey = '%' . $_POST['descKeyword'] . '%';
                    }
                if (empty($_POST['startDate'])) {
                        $startDate = "0000-00-00";
                    } else {
                        $startDate = $_POST['startDate'];
                    }

                if (empty($_POST['endDate'])) {
                        $endDate = "9999-12-31";
                    } else {
                        $endDate = $_POST['endDate'];
                    }
                $result = $conn->query("SELECT event.eventName,
                                        event.siteName,
                                        event.startDate,
                                        event.endDate,
                                        count(assignTo.staffUsername) as staffCount,
                                        datediff(event.EndDate, event.StartDate) as duration,
                                        event.capacity,
                                        event.eventPrice,
                                        event.description
                                        where event.eventName like '$eventName'
                                        and description like '$descKey'
                                        and event.startDate >= '$startDate'
                                        and event.endDate <= '$endDate'
                                        group by event.eventName,event.siteName,event.startDate, event.endDate;");


                    while ($row = $result->fetch()) {
                        $value = $row['eventName'] . "_" . $row['startDate'];
                        echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'>
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['eventName'] . "</label>
                                    </div>
                                    </td>";
                        echo "<td style='text-align:center'>" . $row['siteName'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['startDate'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['endDate'] . "</td>";
                    }
            } else {
                    echo '<script>console.log("hello", "color:blue")</script>';
                $result = $conn->query("SELECT event.eventName,
                                                event.siteName,
                                                event.startDate,
                                                event.endDate,
                                                count(assignTo.staffUsername) as staffCount,
                                                datediff(event.EndDate, event.StartDate) as duration,
                                                event.capacity,
                                                event.eventPrice,
                                                event.description
                                        from event left join assignTo on
                                            event.eventName = assignTo.eventName
                                            and event.siteName = assignTo.siteName
                                            and event.startDate = assignTo.startDate
                                        left join user on assignTo.staffUsername = user.username
                                        group by event.eventName,event.siteName,event.startDate, event.endDate;");

                    while ($row = $result->fetch()) {
                        $value = $row['eventName'] . "_" . $row['siteName'] . "_" . $row['startDate'] . "_" . $row['endDate'] . "_" . $row['staffCount'] . "_" . $row['duration'] . "_" . $row['capacity'] . "_" . $row['eventPrice'] . "_" . $row['description'] . "_" . $row['name'];
                        echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'>
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['eventName'] . "</label>
                                    </div>
                                    </td>";
                        echo "<td style='text-align:center'>" . $row['siteName'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['startDate'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['endDate'] . "</td>";
            }
        }

            ?>
            </tbody>
        </table>
        <div class="container">
            <div class="col-sm-2 offset-5">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Back</button>
            </div>
        </div>


        </div>
        </div>




    </form>


</body>



</html>