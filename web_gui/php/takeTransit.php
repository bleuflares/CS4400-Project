<?php
// Start the session
session_start();
$_SESSION['manageTransitFilter'] = false;
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
if (isset($_POST['logTransitButton'])) {
    if (isset($_POST['optRadio'])) {
        if (!empty($_POST['logDateInput'])) {
            $username = $_SESSION["userName"];
            $logTransitDate = $_POST['logDateInput'];
            $transitRoute = $_POST['optRadio'];
            $result = $conn->query("SELECT * from taketransit where username = '$username' and TransitDate = '$logTransitDate' AND transitRoute = '$transitRoute';");
            if ($result->rowCount() == 0) {
                $transitResult = $conn->query("SELECT * from transit where transitRoute = '$transitRoute';");
                $transitRow = $transitResult->fetch();
                $transitType = $transitRow['TransitType'];
                echo '<script>console.log("%cUser: ' . $username . '", "color:green")</script>';
                echo '<script>console.log("%cDate: ' . $_POST['logDateInput'] . '", "color:green")</script>';
                echo '<script>console.log("%cRoute: ' . $_POST['optRadio'] . '", "color:green")</script>';
                echo '<script>console.log("%cType: ' . $transitType . '", "color:green")</script>';
                $conn->query("INSERT INTO taketransit values('$username', '$transitType', '$transitRoute', '$logTransitDate');");
                echo '<script>console.log("%cSuccessful.", "color:green")</script>';
                echo '<script language="javascript">';
                echo 'alert("Successful Log of travel on transit on the particular day!")';
                echo '</script>';
            } else {
                echo '<script>console.log("%cCannot log Transit if you do not Enter a Transit Date.", "color:red")</script>';
                echo '<script language="javascript">';
                echo 'alert("Cannot log Transit since you have taken this same transit on the same day.")';
                echo '</script>';
            }
        } else {
            echo '<script>console.log("%cCannot log Transit if you do not Enter a Transit Date.", "color:red")</script>';
            echo '<script language="javascript">';
            echo 'alert("Cannot log Transit if you do not Enter a Transit Date.")';
            echo '</script>';
        }
    } else {
        echo '<script>console.log("%cCannot log Transit if you do not select a Route.", "color:red")</script>';
        echo '<script language="javascript">';
        echo 'alert("Cannot log Transit if you do not select a Route.")';
        echo '</script>';
    }
}
?>

<?php
if (isset($_POST['filterButton'])) {
    echo '<script>console.log("%cSuccessful Filter", "color:green")</script>';
    echo '<script>console.log("Session Filter Varable is now True : ")</script>';
    $_SESSION['manageTransitFilter'] = True;
}
?>


<?php
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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Take Transit</h1>


        <div class="container">


            <div class="row">
                <div class="col-sm-6">
                    <label>Contain Site</label>
                    <select name="contain">
                        <?php
                        $result = $conn->query("SELECT SiteName FROM site");
                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['SiteName'] . "</option>";
                        }
                        ?>
                    </select>
                </div>


                <div class="col-sm-4 offset-2">
                    <label>Transport Type </label>
                    <select name="transport">
                        <option value="ALL">ALL</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <label>Price Range</label>

                    <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name="price1Input">
                    

                    <label> -- </label>

                    <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name="price2Input">

                </div>


                <div class="col-sm-3 offset-1">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px;"
                        name="filterButton">Filter</button>
                </div>
            </div>




            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Route</th>
                        <th style='text-align:center'>Transport Type</th>
                        <th style='text-align:center'>Price</th>
                        <th style='text-align:center'># Connected Sites</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if ($_SESSION['manageTransitFilter'] == true) {
                        $containSite = $_POST['contain'];
                        if ($_POST['transport'] == "ALL") {
                            $transportType = "%%";
                        } else {
                            $transportType = $_POST['transport'];
                        }
                        if (empty($_POST['price1Input'])) {
                            $price1 = 0;
                        } else {
                            $price1 = $_POST['price1Input'];
                        }
                        if (empty($_POST['price2Input'])) {
                            $price2 = 9223372036854775807;
                        } else {
                            $price2 = $_POST['price2Input'];
                        }
                        echo '<script>console.log("Works Input: ' . $_POST['contain'] . '")</script>';
                        echo '<script>console.log("Works Input: ' . $_POST['transport'] . '")</script>';
                        echo '<script>console.log("Works Input: ' . $_POST['price1Input'] . '")</script>';
                        echo '<script>console.log("Works Input: ' . $_POST['price2Input'] . '")</script>';
                        $result = $conn->query("SELECT u.transitRoute, u.transitType, ue.transitPrice, u.connectedSites
                                                from ( 
                                                    select transitRoute, transitType, count(*) as connectedSites 
                                                    from connect where sitename LIKE '$containSite' AND transitType Like '$transportType'
                                                    group by transitRoute)
                                                as u inner join (
                                                    select transitRoute, transitPrice, transitType from transit)
                                                as ue on ue.transitRoute = u.transitRoute
                                                where transitPrice BETWEEN $price1 AND $price2;");
                        while ($row = $result->fetch()) {
                            $route = $row['transitRoute'];
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'> 
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$route'>" . $row['transitRoute'] . "</label>
                                    </div>
                                    </td>";
                            echo "<td style='text-align:center'>" . $row['transitType'] . "</td>";
                            echo "<td style='text-align:center'> $" . $row['transitPrice'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['connectedSites'] . "</td>";
                            echo "<tr>";
                        }
                        $_SESSION['manageTransitFilter'] == false;
                    } else {
                        // Generates orginal tables
                        $result = $conn->query("select 
                                                    transit.TransitRoute, 
                                                    transit.TransitType, 
                                                    transit.TransitPrice, 
                                                    count.Total 
                                                from transit inner join (select 
                                                                            sitename, 
                                                                            transitroute, 
                                                                            count(*) as total 
                                                                        from connect 
                                                                        group by transitroute) 
                                                count on transit.transitroute = count.transitroute;");
                        while ($row = $result->fetch()) {
                            $route = $row['TransitRoute'];
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'> 
                                        <div class='radio'>
                                            <label><input type='radio' id='express' name='optRadio' value ='$route'> " . $row['TransitRoute'] . "</label>
                                        </div>
                                    </td>";
                            echo "<td style='text-align:center'>" . $row['TransitType'] . "</td>";
                            echo "<td style='text-align:center'> $" . $row['TransitPrice'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['Total'] . "</td>";
                            echo "<tr>";
                        }
                    }
                    ?>

                </tbody>
            </table>

            <div class="row">

                <div class="col-sm-2">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px;"
                        name="backButton">Back</button>
                </div>
                <div class="col-sm-6 offset-1" style="text-align: right;">
                    <label>Transit Date</label>

                    <input type="date" class="col-sm-6" style="padding: 0;" placeholder="" name="logDateInput">

                </div>

                <div class="col-sm-3">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px;"
                        name="logTransitButton">Log Transit</button>

                </div>
            </div>

        </div>

    </form>

</body>

<script>
$(document).keypress(
    function(event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
</script>

</html>