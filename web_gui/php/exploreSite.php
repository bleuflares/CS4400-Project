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

    <meta http-equiv="refresh" content="3">

    <link rel="stylesheet" href="..\css\_universalStyling.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#test').DataTable({
            "stateSave": true

        });

    });
    </script>
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Explore Site</h1>

        <div class="container">

            <div class="row col-sm-12">
                <div class="row">
                    <div class="col-sm-0 offset-0">
                        <label class='offset-0'>Name</label>
                        <select>
                            <?php
                            $result = $conn->query("SELECT SiteName FROM Site");

                            while ($row = $result->fetch()) {
                                echo "<option>" . $row['SiteName'] . "</option>";
                            }
                            ?>
                        </select>
                        <div class="col-sm-4 offset-1">
                            <label>Description Keyword</label>
                        </div>
                        <input type="text" class="form-control col-sm-1 offset-0 width:200px" width:200px
                            id="inputAdress">

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2 offset-0">
                        <label>Start Date</label>
                    </div>
                    <div class="col-sm-4 offset-0">
                        <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress">

                    </div>


                    <div class="col-sm-2 offset-0">
                        <label>End Date</label>
                    </div>
                    <div class="col-sm-4 offset-0">
                        <input type="date" class="form-control col-sm-0 offset-0" id="inputAdress">

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-0 offset-0">
                        <label>Total Visits Range</label>
                    </div>
                    <div class="col-sm-3">

                        <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                        <label> -- </label>

                        <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">
                    </div>


                    <div class="col-sm-0 offset-0">
                        <label>Event Count Range</label>
                    </div>
                    <div class="col-sm-3">

                        <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                        <label> -- </label>

                        <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 offset-5">
                    <label for="inputLastName" class="label .col-form-label col-sm-6" id="lastNameLabel">Open
                        Everyday</label>
                    <input type="checkbox" class="col-sm-1">

                </div>

                <div class="row col-sm-12">

                    <div class="col-sm-0 offset-2">
                        <button class="btn btn-sm btn-primary btn-block col-sm-12" style="width:150px"
                            style="border-radius: 5px;">Filter</button>
                    </div>

                    <div class="col-sm-0 offset-2" style="text-align: right;">
                        <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit" name="button"
                            onclick="filter();" value="Site Detail" />

                    </div>

                    <div class="col-sm-0 offset-1">
                        <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0 offset-6" type="submit"
                            name="button" onclick="myFunction();" value="Transit Detail" />
                    </div>

                </div>


            </div>
        </div>

        <table id="test" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Site Name</th>
                    <th style='text-align:center'>Event Count</th>
                    <th style='text-align:center'>Total Visits</th>
                    <th style='text-align:center'>My Visits</th>
                </tr>
            </thead>

            <tbody>

            </tbody>
        </table>

        <div class="col-sm-0 offset-6">
            <button class="btn btn-sm btn-primary btn-block col-sm-0  " style=" height:40px;
    width:60px;border-radius: 5px;" name="backButton">Back</button>
        </div>

    </form>

</body>

</html>