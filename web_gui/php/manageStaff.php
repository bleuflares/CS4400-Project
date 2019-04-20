<?php
// Start the session
session_start();
  $_SESSION['manageStaffFilterButton'] = false;

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
    $_SESSION['manageStaffFilterButton'] = True;
    echo '<script>console.log("%c Transit History Filter Session variable set", "color:blue")</script>';

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

<?php

if (isset($_POST['filterButton'])) { }


?>




<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

<<<<<<< HEAD
   <!--  <meta http-equiv="refresh" content="3"> -->
=======
    <!-- <meta http-equiv="refresh" content="3"> -->
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf

    <link rel="stylesheet" href="..\css\_universalStyling.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

 <!--    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#test').DataTable({


        });

    });
    </script>


    <script type="text/javascript">
    $(document).ready(function() {
        $('#test').DataTable();
    });
    </script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Staff</h1>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 offset-0">
                    <label class='offset-4'>Site</label>
<<<<<<< HEAD
                    <select name = "siteName">
=======
                    <select name="siteInput">
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf
                        <?php
                        $result = $conn->query("SELECT SiteName FROM Site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['SiteName'] . "</option>";
                        }
                        echo "<option>ALL</option>";
                        ?>
                    </select>
                    <div class="row">
                        <div class="col-sm-0 offset-0">
                            <label>First Name</label>
                        </div>
                        <div class="col-sm-3 offset-0">
<<<<<<< HEAD
                            <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name = "firstName">
=======
                            <input type="text" class="form-control col-sm-0 offset-0" name="fnameInput">
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf

                        </div>


                        <div class="col-sm-2 offset-0">
                            <label>Last Name</label>
                        </div>
                        <div class="col-sm-3 offset-0">
<<<<<<< HEAD
                            <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress" name ="lastName">
=======
                            <input type="text" class="form-control col-sm-0 offset-0" name="lnameInput">
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-0 offset-0">
                            <label>Start Date</label>

<<<<<<< HEAD
                            <input type="date" class="col-sm-0" style="padding: 0;" placeholder="" name = "startDate">
=======
                            <input type="date" class="col-sm-0" style="padding: 0;" name="startDateInput">
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf

                        </div>

                        <div class="col-sm-0 offset-1">
                            <label>End Date</label>

<<<<<<< HEAD
                            <input type="date" class="col-sm-0" style="padding: 0;" placeholder="" name = "endDate">
=======
                            <input type="date" class="col-sm-0" style="padding: 0;" name="endDateInput">
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf

                        </div>
                    </div>

                    <div class="row col-sm-12">

                        <div class="col-sm-0 offset-6">
                            <button class="btn btn-sm btn-primary btn-block col-sm-0  " style=" height:40px;
<<<<<<< HEAD
                             width:60px;border-radius: 5px;" name ="filterButton">Filter</button>
=======
    width:60px;border-radius: 5px;" name="filterButton">Filter</button>
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf
                        </div>

                    </div>
                </div>
            </div>

            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Staff Name</th>
                        <th style='text-align:center'># of Event Shifts Shifts</th>

                    </tr>
                </thead>

                <tbody>

<<<<<<< HEAD
                    <?php

                    if ($_SESSION['manageStaffFilterButton'] == True){
                            echo '<script>console.log("%cSuccessful Filter", "color:blue")</script>';

                    

                        $siteName  = $_POST['siteName'];




                        if (empty($_POST['firstName'])) {
                            $firstName = "%%";

                        } else {
                            $firstName = $_POST['firstName'];
                        }

                        if (empty($_POST['lastName'])) {
                            $lastName = "%%";

                        } else {
                            $lastName = $_POST['firstName'];
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
                echo '<script>console.log("Works Input: ' . $siteName . '")</script>';
                echo '<script>console.log("Works Input: ' . $firstName . '")</script>';
                 echo '<script>console.log("Works Input: ' . $lastName . '")</script>';
                echo '<script>console.log("Works Input: ' . $startDate . '")</script>';
                 echo '<script>console.log("Works Input: ' . $endDate . '")</script>';

                 

                $result = $conn->query("SELECT concat(user.firstname, ' ',user.lastname) as staffName, count(*) as eventShifts
                                            FROM event 
                                            left join assignto on event.eventName = assignTo.eventName
                                            and event.startDate = assignTo.startDate
                                            and event.siteName = assignTo.siteName
                                            left join employee on assignTo.staffUsername = employee.username
                                            left join user on employee.username = user.username
                                            where event.siteName like '$siteName'
                                            and user.firstname like '$firstName'
                                            and user.lastname like '$lastName'
                                            and event.startDate >= '$startDate'
                                            and event.endDate <= '$endDate'
                                            group by user.username
                                            ;");







                    while ($row = $result->fetch()) { 
                           
                        echo "<tr>";
                        echo   "<td style='text-align:center'>" . $row['staffName'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['eventShifts'] . "</td>";
                            

                        echo "<tr>";

                        }

                    }
                    else{$result = $conn->query("SELECT concat(user.firstname, ' ',user.lastname) as staffName, 
                    count(*) as eventShifts
                    FROM event 
                    left join assignto on event.eventName = assignTo.eventName
                    and event.startDate = assignTo.startDate
                    and event.siteName = assignTo.siteName
                    left join employee on assignTo.staffUsername = employee.username
                    left join user on employee.username = user.username
                    group by assignTo.staffUsername;");
=======

                    <!-- else {$result = $conn->query("SELECT c.transitRoute, c.transitType,tt.transitPrice, c.connectedSites,tt.totalRiders
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
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf

                    

                        while ($row = $result->fetch()) { 
                           
                            echo "<tr>";
                            echo   "<td style='text-align:center'>" . $row['staffName'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['eventShifts'] . "</td>";
                            

                            echo "<tr>";

                        }
<<<<<<< HEAD
                    }


                        ?>
            
=======
            } -->
>>>>>>> a7e06bb2098fcc13901c6c86ec50ba1097ef5bdf
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