<?php
// Start the session
session_start();
$eventName =$_SESSION["toEventDetail2eventName"];
$siteName =$_SESSION["toEventDetail2siteName"];
$startDate = $_SESSION["toEventDetail2startDate"];
$endDate = $_SESSION["toEventDetail2endDate"];
$staffCount = $_SESSION["toEventDetail2staffCount"];
$duration =$_SESSION["toEventDetail2duration"];
$capacity =$_SESSION["toEventDetail2capacity"];
$eventPrice =$_SESSION["toEventDetail2EventPrice"];
$eventDescription= $_SESSION["toEventDetail2EventDescription"];

// if (!$_SESSION["logged_in"]) {
//     header("Location: http://localhost/web_gui/php/userLogin.php");
//     exit();
// }

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


    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Event Detail</h1>


        <div class="container">

        

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
                <div class="col-sm-4">
                    <label>Start Date</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $startDate . '</span>';
                    ?>
                </div>

                <div class="col-sm-4">
                    <label>End Date</label>
                    <?php
                    if ($siteRow) {
                        echo '<span style="font-weight: 600; margin-left: 2.25em;">' .  $endDate . '</span>';
                    } else {
                        echo '<span style="font-weight: 600; margin-left: 2.25em;">N/a</span>';
                    }
                    ?>
                </div>

                <div class="col-sm-4">
                    <label>Duration Days</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $duration . '</span>';
                    ?>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-4">
                    <label>Staff Assigned</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 1.15em;">' . $staffCount . '</span>'
                    ?>
                </div>

                <div class="col-sm-4">
                    <label>Capacity</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $capacity . '</span>';
                    ?>
                </div>

                <div class="col-sm-4">
                    <label>Price</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $eventPrice. '</span>';
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9">
                    <label>Description</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $eventDescription . '</span>';
                    ?>
                
                </div>
            </div>

            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <a type="submit" class="btn btn-primary" id="registerButton"
                        style="padding-left: 3.25em; padding-right: 3.25em; margin-left: 4em;"
                        href="./staffViewSchedule.php">Back</a>
                </div>
            </div>

        </div>

    </form>

</body>

</html>