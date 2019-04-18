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
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Site</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-6">

                    <label>Site</label>
                    <select>
                        <option value="ALL">--ALL--</option>
                    </select>
                </div>


                <div class="col-sm-1 offset-0">
                    <label>Manager</label>
                </div>
                <div class="col-sm-3 offset-1">
                    <select>
                        <?php
                        $result = $conn->query("SELECT Username FROM employee WHERE EmployeeType = 'Manager'");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['Username'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-sm-7 offset-5">
                        <label>Open Everyday</label>

                        <select>
                            <option value="ALL">Yes</option>
                            <option value="ALL">No</option>
                        </select>

                    </div>


                    <div class="row col-sm-12">

                        <div class="col-sm-0 offset-2">
                            <button class="btn btn-sm btn-primary btn-block col-sm-0"
                                style="border-radius: 5px;">Filter</button>
                        </div>

                        <div class="col-sm-0 offset-2" style="text-align: right;">
                            <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0 offset-5" type="submit"
                                name="button" onclick="filter();" value="Create" />


                        </div>


                        <div class="col-sm-0 offset-1">
                            <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0 offset-7" type="submit"
                                name="button" onclick="myFunction();" value="Edit" />
                        </div>
                        <div class="col-sm-0">
                            <input id="button" class="btn btn-sm btn-primary btn-block offset-10" type="submit"
                                name="button" onclick="myFunction();" value="Delete" />
                        </div>
                    </div>

                </div>
            </div>

            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Name</th>
                        <th style='text-align:center'>Manager</th>
                        <th style='text-align:center'>Open Everyday</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
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

                    while ($row = $result->fetch()) { }
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