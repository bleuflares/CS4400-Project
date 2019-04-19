<?php
// Start the session
session_start();

 $_SESSION['transitHistoryFilter'] = false;

if (!$_SESSION["logged_in"]) {
    header("Location: http://localhost/CS4400-Project-master/web_gui/php/userLogin.php");
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

if (isset($_POST['filterButton'])){
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['transitHistoryFilter'] = True;
    echo '<script>console.log("%c Transit History Filter Session variable set", "color:blue")</script>';

}

if (isset($_POST['backButton'])) {

    $userType  = $_SESSION["userType"];

    if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
        echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';


        // $employeeType = $_SESSION["user_employeeType"];

        if (strpos($_SESSION["user_employeeType"], "Admin") !== false) {
            header('Location: http://localhost/web_gui/php/administratorFunctionality.php');
            exit();
        } else if (strpos($_SESSION["user_employeeType"], "Manager") !== false) {
            header('Location: http://localhost/web_gui/php/managerFunctionality.php');
            exit();
        } else if (strpos($_SESSION["user_employeeType"], "Staff") !== false) {
            header('Location: http://localhost/web_gui/php/staffFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
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
    } else if (strpos($userType, "User") !== false) {
        echo '<script>console.log("%cUser is JUST a USER", "color:blue")</script>';

        header('Location: http://localhost/web_gui/php/userFunctionality.php');
        exit();
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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


 



    </script>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Transit History</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-5">
                    <label>Transport Type </label>
                    <select style="margin-left: 1em;" name = "transportType">
                        <option value="ALL">ALL</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>
                </div>

                <div class="col-sm-7 ">
                    <label>Contain Site</label>
                    <select style="margin-left: 1em;" name = "containSite">
                        <?php
                        $result = $conn->query("SELECT SiteName FROM site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['SiteName'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <label>Route</label>

                    <input type="text" class="col-sm-1" style="text-align: center; margin-left: 0.5em; padding: 0em;"
                        placeholder="" name = "route">

                    <label style="margin-left: 0.5em;">Start Date</label>

                    <input type="date" class="unstyled col-sm-3" style="padding: 0; margin-left: 0.5em;" placeholder="" Name = "startDate">

                    <label style="margin-left: 0.5em;">End Date</label>

                    <input type="date" class="col-sm-3" style="padding: 0; margin-left: 0.5em;" placeholder="" name = "endDate">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 offset-4">
                    <button class="btn btn-sm btn-primary btn-block"
                        style="border-radius: 5px; margin-left: 2em;" name = "filterButton">Filter</button>
                </div>
            </div>

            <table id="table1" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Date</th>
                        <th style='text-align:center'>Route</th>
                        <th style='text-align:center'>Transport Type</th>
                        <th style='text-align:center'>Price</th>
                    </tr>
                </thead>

                <tbody>
                    <?php


                    if ($_SESSION['transitHistoryFilter'] == true) {

                            $containSite = $_POST['containSite'];


                        if ($_POST['transportType'] == "ALL") {
                            $transportType = "%%";
                        } else {
                            $transportType = $_POST['transportType'];
                        }

                        if (empty($_POST['route'])) {
                            $route = "%%";
                        } else {
                            $route = $_POST['route'];
                        }


                        if (empty($_POST['startDate'])) {
                            $startDate = "0000-00-00";
                        } else {
                            $startDate = $_POST['startDate'];
                            echo '<script>console.log("Works Input: ' . $_POST['startDate'] . '")</script>';

                        }

                        if (empty($_POST['endDate'])) {
                            $endDate = "9999-12-12"; 
                            echo '<script>console.log("Works Input: ' . $_POST['endDate'] . '")</script>';
                        } else {
                            $endDate = $_POST['endDate'];

                        }





                        echo '<script>console.log("Transport Input: ' . $transportType . '")</script>';
                        echo '<script>console.log("Contain Input: ' . $containSite . '")</script>';
                        echo '<script>console.log("Start Input: ' . $startDate . '")</script>';
                        echo '<script>console.log("End Input: ' . $endDate . '")</script>';
                        echo '<script>console.log("Route Input: ' . $route . '")</script>';
                        echo '<script>console.log("user Input: ' . $_SESSION["userName"] . '")</script>';
                        
                       
                        


                        $result = $conn->query("select DISTINCT tt.TransitDate, t.TransitRoute, t.TransitType,  t. TransitPrice
                        from transit t 
                        inner join taketransit tt on
                        t.transitType = tt.transitType
                        inner join taketransit ttt on
                        t.transitRoute = ttt.transitRoute

                        inner join connect c on   
                        t.transitType = c.transitType 

                        inner join connect cc on
                        t.transitRoute = cc.transitRoute

                        where tt.TransitDate >= '$startDate' AND tt.TransitDate <= '$endDate' 
                        AND t.TransitRoute like '$route' 
                        AND t.transitType like '$transportType'
                        AND c.SiteNAME like '$containSite'
                        AND tt.userName ='".$_SESSION["userName"]."';");



                        while ($row = $result->fetch()) {
                            
                            echo "<tr>";
                            echo "<td style='text-align:center'>" . $row['TransitDate'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['TransitRoute'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['TransitType'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['TransitPrice'] . "</td>";
                            echo "<tr>";
                        }

                        isset($_SESSION['transitHistoryFilter']) == false;

                    } else {
                    $result = $conn->query("SELECT tt.*, t.TransitPrice 
                                            FROM taketransit as tt 
                                                    INNER JOIN transit AS t 
                                                    ON tt.TransitType = t.TransitType 
                                                    AND tt.TransitRoute = t.TransitRoute 
                                            WHERE tt.Username = '" . $_SESSION["userName"] . "';");

                        while ($row = $result->fetch()) {
                            echo "<tr>";
                            echo "<td style='text-align:center'>" . $row['TransitDate'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['TransitRoute'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['TransitType'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['TransitPrice'] . "</td>";
                            echo "<tr>";
                        }
                    }
                ?>

                </tbody>
            </table>

            <div class="row">
                <div class="col-sm-2 offset-5">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px; margin-left: .25em;"
                        name="backButton">Back</button>
                </div>
            </div>

        </div>

    </form>

</body>

</html>