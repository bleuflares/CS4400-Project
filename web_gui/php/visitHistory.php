<?php
// Start the session
session_start();
$_SESSION['exploreSiteFilter'] = False;

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


if (isset($_POST['filterButton'])) {
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['exploreSiteFilter'] = True;
    echo '<script>console.log("% Filter Session variable set", "color:blue")</script>';
}




?>

<?php

if (isset($_POST['backButton'])) {

    $userType  = $_SESSION["userType"];

    if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';


        if (strpos($_SESSION["user_employeeVisitorType"], "Admin") !== false) {
            header('Location: http://localhost/web_gui/php/administratorVisitorFunctionality.php');
            exit();
        } else if (strpos($_SESSION["user_employeeVisitorType"], "Manager") !== false) {
            header('Location: http://localhost/web_gui/php/managerVisitorFunctionality.php');
            exit();
        } else if (strpos($_SESSION["user_employeeVisitorType"], "Staff") !== false) {
            header('Location: http://localhost/web_gui/php/staffVisitorFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") === false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is ONLY a VISITOR", "color:blue")</script>';
        header('Location: http://localhost/web_gui/php/visitorFunctionality.php');
        exit();
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link rel="stylesheet" href="..\css\_universalStyling.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>




</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Visit History</h1>


        <div class="container">
            <div class="row">
                <div class="col-sm-0 offset-0">
                    <label>Event</label>
                </div>
                <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name ="eventName">

                </div>


                <div class="col-sm-0 offset-1">
                    <label>Site</label>
                    <select name = "siteName">
                    <option value="ALL">ALL</option>
                        <?php
                        $result = $conn->query("SELECT SiteName FROM Site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['SiteName'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="row col-sm-12">
                    <div class="col-sm-0 offset-0">
                        <label>Start Date</label>

                        <input type="date" class="col-sm-0" style="padding: 0;" placeholder="" name = "startDate">

                    </div>

                    <div class="col-sm-0 offset-1">
                        <label>End Date</label>

                        <input type="date" class="col-sm-0 offset-0" style="padding: 0;" placeholder="" name ="endDate">

                    </div>
                </div>

                <div class="row col-sm-12">

                    <div class="col-sm-0 offset-6">
                        <button class="btn btn-sm btn-primary btn-block col-sm-0  " style=" height:40px;
    width:60px;border-radius: 5px;" name = "filterButton">Filter</button>
                    </div>

                </div>
            </div>

            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Date</th>
                        <th style='text-align:center'>Event</th>
                        <th style='text-align:center'>Site</th>
                        <th style='text-align:center'>Price</th>

                    </tr>
                </thead>

                <tbody>

                </tbody>
                <?php
                if (($_SESSION['exploreSiteFilter']) == TRUE) {
                    echo '<script>console.log("%cMade it", "color:blue")</script>';
                    $username = $_SESSION["userName"];

                    if (empty($_POST['eventName'])) {
                        $eventName = "%%";

                    } else {
                        $eventName = $_POST['eventName'];
                    }

                    if ($_POST['siteName'] == "ALL") {
                                $siteName = "%%";

                    } else {
                        $siteName = $_POST['siteName'];
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

                    echo '<script>console.log("%cConnection failed: ' . $eventName . '", "color:red")</script>';
                    echo '<script>console.log("%cConnection failed: ' . $siteName . '", "color:red")</script>';
                   
                    echo '<script>console.log("%cConnection failed: ' . $startDate . '", "color:red")</script>';
                    echo '<script>console.log("%cConnection failed: ' . $endDate . '", "color:red")</script>';

                    $result = $conn->query("SELECT visitsite.visitSiteDate, coalesce(event.eventName,'None') as eventName, visitsite.siteName, coalesce(event.eventPrice, 0) as eventP FROM visitsite
                        left join visitevent on visitsite.visitorUsername = visitevent.visitorUsername
                        and visitsite.siteName = visitevent.siteName
                                        and visitsite.visitSiteDate = visitevent.visitEventDate
                        left join event on visitevent.eventName = event.eventName
                        and visitevent.siteName = event.siteName
                        and visitevent.startDate = event.startDate
                        where visitsite.visitorUsername = '$username'
                        and coalesce(event.eventName,'None') like '$eventName'
                        and visitsite.siteName like '$siteName'
                        and visitsite.visitSiteDate between '$startDate' and '$endDate';");

                        while ($row = $result->fetch()) {
                            echo "<tr>";
                        
                        
                            echo "<td style='text-align:center'> " . $row['visitSiteDate'] . "</td>";
                            echo "<td style='text-align:center'> " . $row['eventName'] . "</td>";
                            echo "<td style='text-align:center'> " . $row['siteName'] . "</td>";
                            echo "<td style='text-align:center'> $ " . $row['eventP'] . ".00</td>";
                        }
                    

                } else{ 

                    $username = $_SESSION["userName"];

                    $result = $conn->query("SELECT visitsite.visitSiteDate, event.eventName, visitsite.siteName, coalesce(event.eventPrice, 0) as eventP FROM visitsite
                    left join visitevent on visitsite.visitorUsername = visitevent.visitorUsername
                    and visitsite.siteName = visitevent.siteName
                                       and visitsite.visitSiteDate = visitevent.visitEventDate
                    left join event on visitevent.eventName = event.eventName
                    and visitevent.siteName = event.siteName
                    and visitevent.startDate = event.startDate
                    where visitsite.visitorUsername = '$username';");

                    while ($row = $result->fetch()) {
                        echo "<tr>";
                      
                       
                        echo "<td style='text-align:center'> " . $row['visitSiteDate'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['eventName'] . "</td>";
                        echo "<td style='text-align:center'> " . $row['siteName'] . "</td>";
                        echo "<td style='text-align:center'> $ " . $row['eventP'] . ".00</td>";
                    }
                }

?>

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