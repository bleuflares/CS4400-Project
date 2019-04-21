<?php
// Start the session
session_start();
$eventName = $_SESSION["toEventDetailEventName"];
$siteName = $_SESSION["toEventDetailSiteName"];
$startDate = $_SESSION["toEventDetailStartDate"];
$endDate = $_SESSION["toEventDetailEndDate"];
$eventPrice = $_SESSION["toEventDetailEEventPrice"];
$tixRemainder = $_SESSION["toEventDetailTixRemaining"];
$descritpion = $_SESSION["toEventDetailEventDecription"];
$username = $_SESSION["userName"];

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

if (isset($_POST['visitDateButton'])) {
    $actualDateVisited = $_POST['actualDateVisited'];



    echo '<script>console.log("eventName: ' . $actualDateVisited . '")</script>';
    echo '<script>console.log("highRevRange:")</script>';

    $result = $conn->query("SELECT endDate from event where siteName = '$siteName' AND eventName = '$eventName' AND startDate = '$startDate';");
    while ($row = $result->fetch()) {
        $endDate = $row['endDate'];

    }

    echo '<script>console.log("eventName: ' . $startDate . '")</script>';
    echo '<script>console.log("eventName: ' . $endDate . '")</script>';
    echo '<script>console.log("eventName: ' . $actualDateVisited . '")</script>';

    // $conn->query("INSERT into visitevent values ('$username', '$eventName', '$startDate' ,'$siteName' , '$actualDateVisited');");



    if ($actualDateVisited > $endDate){
        echo '<script language="javascript">';
        echo 'alert("Cannot attend an Event that has already ended.")';
        echo '</script>';
    }

    else if ($actualDateVisited < $startDate){
        echo '<script language="javascript">';
        echo 'alert("Cannot attend an Event that has not started.")';
        echo '</script>';
    }
    else{
        $conn->query("INSERT into visitevent values ('$username', '$eventName', '$startDate' ,'$siteName' , '$actualDateVisited');");
    }

}
if (isset($_POST['backButton'])) {
    header('Location: http://localhost/web_gui/php/exploreEvent.php');
    exit();
}




?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">



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

    <?php
    $result = $conn->query("select  e.*, u.Password,
                                            u.Status,
                                            u.Firstname,
                                            u.Lastname,
                                            u.UserType
                                    from employee e inner join user u
                                    on e.Username = u.Username
                                    where u.Username = '" . $_SESSION["userName"] . "';");

    $row = $result->fetch();

    $username = $row['Username'];

    $siteManaged = $conn->query("select * from site where site.ManagerUsername = '$username';");

    $siteRow = $siteManaged->fetch();

    $emailsResults = $conn->query("select * from useremail ue where ue.Username = '$username';");

    ?>


    <form class="form-signin" method = "post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Event Detail</h1>


        <div class="container">

            <div class="row">


                <div class="col-sm-6">
                    <label>Event</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $eventName . '</span>';
                    ?>
                </div>

                <!-- <div class="col-sm-6">
                    <label>Last Name</label>
                    <?php
                    echo '<input type="text" class="col-sm-6" style="padding: 0; margin-left: 2em;" value="' . $row['Lastname'] . '">'
                    ?>
                </div> -->

                <div class="col-sm-6">
                    <label>Site</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $siteName . '</span>';
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Start Date</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $startDate . '</span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>End Date</label>
                    <?php
                    if ($siteRow) {
                        echo '<span style="font-weight: 600; margin-left: 2.25em;">' .  $endDate . '</span>';
                    } else {
                        echo '<span style="font-weight: 600; margin-left: 2.25em;">N/a</span>';
                    }
                    ?>
                </div>

            </div>


            <div class="row">
                <div class="col-sm-6">
                    <label>Ticket Price</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 1.15em;">' . $eventPrice . '</span>'
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>Ticket Remaining</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $tixRemainder . '</span>';
                    ?>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-9">
                    <label>Description</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 3.15em;">'
                        . $descritpion .
                        '</span>'
                    ?>
                </div>
            </div>

            <div class="form-row">
                <div class="col-sm-6">
                    <label>Visit Date</label>

                    <input type="date" class="col-sm-6" style="padding: 0; margin-left: 3.85em;" name ="actualDateVisited">

                </div>
                <div class="form-group row col-sm-6 ">
                    <button type="submit" class="btn btn-primary" id="registerButton"
                        style="padding-left: 3.25em; padding-right: 3.25em; margin-left: 4em;"
                        name = "visitDateButton">Log Visit</button>
                </div>
            </div>
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