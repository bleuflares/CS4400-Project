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

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\visitorFunctionality.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>

    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Visitor Functionality</h1>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary btn-block" type="userOnly" href="./exploreEvent.php">Explore
                        Event</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary btn-block" type="visitorOnly" href="./exploreSite.php">Explore
                        Site</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary btn-block" type="employeeOnly" href="./visitHistory.php">View
                        Visit History</a>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary btn-block" type="employeeVisitor" href="./takeTransit.php">Take
                        Transit</a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary btn-block" type="back" href="./transitHistory.php"
                        href="./transitHistory.php">View Transit
                        History</a>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-lg btn-primary btn-block" type="back" href="./userLogin.php">Back</a>
                </div>
            </div>


        </div>

    </form>

</body>

</html>