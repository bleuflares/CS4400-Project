<?php

// Start the session
session_start();

$eventName =$_SESSION['eventName_dailyDetail'] = $data[0];
$siteReport = $_SESSION['siteReport_dailyDetail'] = $data[1];
$visits= $_SESSION['visits_dailyDetail'] = $data[2];
$revenue = $_SESSION['Rev_dailyDetail'] = $data[3];

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

    <meta http-equiv="refresh" content="3">

    <link rel="stylesheet" href="..\css\_universalStyling.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#test1').DataTable({
            "stateSave": true

        });

    });
    </script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Daily Detail</h1>








        </div>
        </div>




        <table id="test1" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Event Name</th>
                    <th style='text-align:center'>Staff count</th>
                    <th style='text-align:center'>Visits</th>
                    <th style='text-align:center'>Revenue ($)</th>

                </tr>
            </thead>

            <tbody>
            <?php

        $result = $conn->query("");


                    while ($row = $result->fetch()) {
                            
                          
                            
                            echo "<td style='text-align:center'>" . $row['eventName'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['staffCount'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['Visits'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['Revenue'] . "</td>";
                            echo "<tr>";
                        }
            
            ?>
            </tbody>



        </table>



        <div class="col-sm-0 offset-6">
            <button class="btn btn-sm btn-primary btn-block col-sm-0  " style=" height:40px;
    width:60px;border-radius: 5px;">Back</button>
        </div>

    </form>


</body>



</html>