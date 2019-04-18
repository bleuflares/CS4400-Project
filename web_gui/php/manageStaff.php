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

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="refresh" content="3">

    <link rel="stylesheet" href="..\css\_universalStyling.css">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
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
    </script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Staff</h1>

        <div class="container">
            <div class="row">
                <div class="col-sm-12 offset-0">
                    <label class='offset-4'>Site</label>
                    <select>
                        <?php
                        $result = $conn->query("SELECT SiteName FROM Site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['SiteName'] . "</option>";
                        }
                        ?>
                    </select>
                    <div class="row">
                        <div class="col-sm-0 offset-0">
                            <label>First Name</label>
                        </div>
                        <div class="col-sm-3 offset-0">
                            <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                        </div>


                        <div class="col-sm-2 offset-0">
                            <label>Last Name</label>
                        </div>
                        <div class="col-sm-3 offset-0">
                            <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-0 offset-0">
                            <label>Start Date</label>

                            <input type="date" class="col-sm-0" style="padding: 0;" placeholder="">

                        </div>

                        <div class="col-sm-0 offset-1">
                            <label>End Date</label>

                            <input type="date" class="col-sm-0" style="padding: 0;" placeholder="">

                        </div>
                    </div>

                    <div class="row col-sm-12">

                        <div class="col-sm-0 offset-6">
                            <button class="btn btn-sm btn-primary btn-block col-sm-0  " style=" height:40px;
    width:60px;border-radius: 5px;">Filter</button>
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