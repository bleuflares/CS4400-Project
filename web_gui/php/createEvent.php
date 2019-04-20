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
            header('Location: http://localhost/web_gui/php/manageEvent.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';

        if (strpos($_SESSION["user_employeeVisitorType"], "Manager") !== false) {
            header('Location: http://localhost/web_gui/php/manageEvent.php');
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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Create Event</h1>


        <div class="container">


            <div class="row">
                <div class="col-sm-12">
                    <label>Name</label>
                    <?php
                    echo '<input type="text" class="col-sm-8 offset-2" style="padding: 0; margin-left: 2em;" name="fname" value="">';
                    ?>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-3">
                    <label>Price</label>
                    <?php
                    echo '<input type="text" class="col-sm-3 offset-0" style="padding: 0; margin-left: 2em;" name="price" value="">';
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    ?>
                </div>

                <div class="col-sm-3">
                    <label>Capacity</label>
                    <?php
                    echo '<input type="text" class="col-sm-3 offset-0" style="padding: 0; margin-left: 2em;" name="price" value="">';
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>Minimum Staff Required</label>
                    <?php
                    echo '<input type="text" class="col-sm-3 offset-0" style="padding: 0; margin-left: 2em;" name="price" value="">';
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Start Date</label>
                    <?php
                    echo '<input type="text" class="col-sm-4 offset-2" style="padding: 0; margin-left: 2em;" name="price" value="">';
                    echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>End Date</label>
                    <?php
                    echo '<input type="text" class="col-sm-4 offset-2" style="padding: 0; margin-left: 2em;" name="price" value="">';
                    // if ($siteRow) {
                    //     echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    // } else {
                    //     echo '<span style="font-weight: 600; margin-left: 2.25em;">N/a</span>';
                    // }
                    ?>
                </div>

            </div>



            <br>

            <div class="row">
                <div class="col-sm-2 offset-0">
                    <label>Description</label>
                </div>
                <div class="col-sm-4 offset-1">
                    <textarea name="paragraph_text" cols="50" rows="8"></textarea>

                </div>

            </div>

            <div class="row">
                <label for="exampleFormControlSelect2" style="">Assign Staff</label>

                <select multiple style="display: inline; margin-left: 6em;" class="form-control col-sm-6 offset-1"
                    id="exampleFormControlSelect2">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>

            </div>


            <br>


        </div>

        <br>


        <div class="row">
            <div class="col-sm-2 offset-2">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;"
                    name="backButton">Back</button>
            </div>
            <div class="col-sm-2 offset-4">
                <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Create</button>
            </div>
        </div>

    </form>

</body>

</html>