<?php
// Start the session
session_start();
$delete  = $_SESSION["delete"] = FALSE;
$filter  = $_SESSION["filter"] = FALSE;

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

if (isset($_POST['filter'])){
     echo '<script>console.log("Filter Button Pushed")</script>';
     $filter  = $_SESSION["filter"] = TRUE;
     echo '<script>console.log("Filter Session Variable Created")</script>';

}

if (isset($_POST['create'])){
        if (isset($_POST['optRadio'])){
        
        $route = $_POST['optRadio'];

        $_SESSION["route"] = $route;


        header('Location: http://localhost/web_gui/php/createTransit.php');
            exit();
        }

    }

if (isset($_POST['delete'])){
     echo '<script>console.log("delete Button Pushed")</script>';
     $delete  = $_SESSION["delete"] = TRUE;
     echo '<script>console.log("delete Session Variable Created")</script>';

}


// Navigation of Back Button
if (isset($_POST['backButton'])) {

    $userType  = $_SESSION["userType"];

    if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
        echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';
        // $employeeType = $_SESSION["user_employeeType"];

        if (strpos($_SESSION["user_employeeType"], "Admin") !== false) {
            header('Location: http://localhost/web_gui/php/administratorFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin.", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';


        if (strpos($_SESSION["user_employeeVisitorType"], "Admin") !== false) {
            header('Location: http://localhost/web_gui/php/administratorVisitorFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are NOT a Admin.", "color:red")</script>';;
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

 <!--    <meta http-equiv="refresh" content="3"> -->

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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Transit</h1>

        <div class="container">

            <div class="row">
                <div class="col-sm-6">

                    <label>Transport Type</label>
                    <select name ="transportType">
                        <option value="ALL">ALL</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>

                </div>

                <div class="col-sm-1 offset-0">
                    <label>Route </label>
                </div>
                <div class="col-sm-3 offset-1">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name = "route">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <label>Contain Site</label>
                    <select name = "containSite">
                        <option value="ALL">ALL</option>
                        <?php
                        $result = $conn->query("SELECT SiteName FROM site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['SiteName'] . "</option>";
                        }
                        ?>
                    </select>
                </div>


                <div class="col-sm-7">
                    <label>Price Range</label>

                    <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name="lowerPrice">
                    

                    <label> -- </label>

                    <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name="upperPrice">

                </div>

                <div class="row col-sm-12">

                    <div class="col-sm-0 offset-3">
                        <button class="btn btn-sm btn-primary btn-block col-sm-0"
                            style="border-radius: 5px;" name = "filter">Filter</button>
                    </div>

                    <div class="col-sm-0 offset-3" style="text-align: right;">
                        <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit" name="create"
                            onclick="filter();" value="Create" />
                    </div>

                    <div class="col-sm-0 offset-1">
                        <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit" name="button"
                            onclick="myFunction();" value="Edit" />
                    </div>
                    <div class="col-sm-0 offset-1">
                        <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit" name="delete"
                            onclick="myFunction();" value="Delete" />
                    </div>
                </div>


            </div>
        </div>

        <table id="test" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Route</th>
                    <th style='text-align:center'>Transport Type</th>
                    <th style='text-align:center'>Price</th>
                    <th style='text-align:center'># Connected Sites</th>
                    <th style='text-align:center'># Transit Loggged</th>
                </tr>
            </thead>

            <tbody>
                <?php

            if (($_SESSION['delete']) == TRUE) {

                if ($_POST['transportType'] == "ALL") {
                            $transportType = "%%";

                } else {
                    $transportType = $_POST['transportType'];
                }

                if ($_POST['containSite'] == "ALL") {
                    $containSite = "%%";

                }else {
                    $containSite = $_POST['containSite'];
                }

                if (empty($_POST['route'])) {
                            $route = "%%";
                } else {
                    $route = $_POST['route'];
                }

                if (empty($_POST['lowerPrice'])) {
                            $lowerPrice = 0;
                } else {
                    $lowerPrice = $_POST['lowerPrice'];
                }

                if (empty($_POST['upperPrice'])) {
                            $upperPrice = 9223372036854775807;
                } else {
                    $upperPrice = $_POST['upperPrice'];

                }

            echo '<script>console.log("delete Session Variables set and Created")</script>';
            $result = $conn->query("DELETE from transit
                                                Where transitRoute like '$route';");
            }








            if (($_SESSION['filter']) == TRUE) {

                if ($_POST['transportType'] == "ALL") {
                            $transportType = "%%";

                } else {
                    $transportType = $_POST['transportType'];
                }

                if ($_POST['containSite'] == "ALL") {
                    $containSite = "%%";

                }else {
                    $containSite = $_POST['containSite'];
                }

                if (empty($_POST['route'])) {
                            $route = "%%";
                } else {
                    $route = $_POST['route'];
                }

                if (empty($_POST['lowerPrice'])) {
                            $lowerPrice = 0;
                } else {
                    $lowerPrice = $_POST['lowerPrice'];
                }

                if (empty($_POST['upperPrice'])) {
                            $upperPrice = 9223372036854775807;
                } else {
                    $upperPrice = $_POST['upperPrice'];
                }

            echo '<script>console.log("transportType Input: ' . $transportType . '")</script>';
            echo '<script>console.log("containSite Input: ' . $containSite . '")</script>';
            echo '<script>console.log("route Input: ' . $route. '")</script>';
            echo '<script>console.log("lowerPrice Input: ' . $lowerPrice . '")</script>';
            echo '<script>console.log("upperPrice Input: ' . $upperPrice . '")</script>';



                    $result = $conn->query("SELECT transit.transitRoute, transit.transitType, transit.transitPrice, connect.connectedSites, takeTransit.totalRiders
                                            from transit
                                            left join (select transitRoute, 
                                                        count(*) as connectedSites 
                                                        from connect group by transitRoute) as connect
                                                        on transit.transitRoute = connect.transitRoute
                                            left join (select transitRoute, 
                                                            count(*) as totalRiders 
                                                            from taketransit group by transitRoute) as takeTransit
                                                        on transit.transitRoute = takeTransit.transitRoute
                                            where transitType like '$transportType'
                                            and transit.transitRoute like '$route'
                                            and transitPrice between $lowerPrice and $upperPrice;");


                                        while ($row = $result->fetch()) { 
                                             echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'> 
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$route'>" . $row['transitRoute'] . "</label>
                                    </div>
                                    </td>";
                            echo "<td style='text-align:center'>" . $row['transitType'] . "</td>";
                            echo "<td style='text-align:center'> $" . $row['transitPrice'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['connectedSites'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['totalRiders'] . "</td>";
                            echo "<tr>";

                        }
                    }

     
                        







                 else {$result = $conn->query("SELECT c.transitRoute, c.transitType,tt.transitPrice, c.connectedSites,tt.totalRiders
                        FROM (select c.siteName, c.transitType, c.transitRoute, count(*) as connectedSites
                        from connect c
                        group by transitRoute) as c
                        Join
                        (select  t.transitRoute, t.transitPrice,
                        count(*) as totalRiders 
                        from taketransit tt
                        inner join transit t
                        on t.transitRoute = tt.transitRoute
                        group by transitRoute) as tt
                        where c.transitRoute = tt.transitRoute;");

                    $route = $row['transitRoute'];

                        while ($row = $result->fetch()) { 
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'> 
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$route'>" . $row['transitRoute'] . "</label>
                                    </div>
                                    </td>";
                            echo "<td style='text-align:center'>" . $row['transitType'] . "</td>";
                            echo "<td style='text-align:center'> " . $row['transitPrice'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['connectedSites'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['totalRiders'] . "</td>";
                            echo "<tr>";

                        }
            }
                ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-3 offset-4">
                <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px; margin-left: 1.5em;"
                    name="backButton">Back</button>
            </div>
        </div>

    </form>

</body>

</html>