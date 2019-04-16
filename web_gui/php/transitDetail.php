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

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


    <!-- <script type="text/javascript">

    $(document).ready(function() {
        $('#test').DataTable();
    } );

    </script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>

    <?php
    $result = $conn->query("select  e.*, u.Password,
                                            u.Status,
                                            u.Firstname,
                                            u.Lastname,
                                            u.UserType
                                    from employee e inner join user u
                                    on e.Username = u.Username
                                    where u.Username = '" . $_SESSION["userName"] . "';");

    $row = $result->fetch();

    $username = $row['Username'];

    $siteManaged = $conn->query("select * from site where site.ManagerUsername = '$username';");

    $siteRow = $siteManaged->fetch();

    $emailsResults = $conn->query("select * from useremail ue where ue.Username = '$username';");

    ?>
    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Transit Detail</h1>


        <div class="container">


            <div class="row">
                <div class="col-sm-6">
                    <label>Site Name</label>
                    <?php
                    if ($siteRow) {
                        echo '<span style="font-weight: 600; margin-left: 2.25em;">' .  $siteRow['SiteName'] . '</span>';
                    } else {
                        echo '<span style="font-weight: 600; margin-left: 2.25em;">N/a</span>';
                    }
                    ?>
                </div>


                <div class="col-sm-4 offset-0">
                    <label>Transport Type </label>
                    <select>
                        <option value="ALL">--ALL--</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>
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
                        echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'>
                                        <div class='radio'>
                                            <label><input type='radio' id='express' name='optradio'> " . $row['TransitRoute'] . "</label>
                                        </div>
                                    </td>";
                        echo "<td style='text-align:center'>" . $row['TransitType'] . "</td>";
                        echo "<td style='text-align:center'> $" . $row['TransitPrice'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['Total'] . "</td>";
                        echo "<tr>";
                    }
                    ?>

                </tbody>
            </table>



            <div class="row">

                <div class="col-sm-2">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px;">Back</button>
                </div>
                <div class="col-sm-6 offset-1" style="text-align: right;">
                    <label>Transit Date</label>

                    <input type="date" class="col-sm-6" style="padding: 0;" placeholder="">

                </div>


                <div class="col-sm-3">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px;">Log Transit</button>
                </div>
            </div>


        </div>

    </form>

</body>

</html>