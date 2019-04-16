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


    <link rel="stylesheet" href="..\css\_universalStyling.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#table1').DataTable({
            // "stateSave": true

        });

    });
    </script>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Transit History</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-5">
                    <label>Transport Type </label>
                    <select style="margin-left: 1em;">
                        <option value="ALL">--ALL--</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>
                </div>

                <div class="col-sm-7 ">
                    <label>Contain Site</label>
                    <select style="margin-left: 1em;">
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
                        placeholder="">

                    <label style="margin-left: 0.5em;">Start Date</label>

                    <input type="date" class="unstyled col-sm-3" style="padding: 0; margin-left: 0.5em;" placeholder="">

                    <label style="margin-left: 0.5em;">End Date</label>

                    <input type="date" class="col-sm-3" style="padding: 0; margin-left: 0.5em;" placeholder="">
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 offset-4">
                    <button class="btn btn-sm btn-primary btn-block"
                        style="border-radius: 5px; margin-left: 2em;">Filter</button>
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
                    ?>

                </tbody>
            </table>

            <div class="row">
                <div class="col-sm-2 offset-5">
                    <button class="btn btn-sm btn-primary btn-block"
                        style="border-radius: 5px; margin-left: .25em;">Back</button>
                </div>
            </div>

        </div>

    </form>

</body>

</html>