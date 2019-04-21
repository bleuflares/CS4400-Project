<?php
// Start the session
session_start();

$siteName = $_SESSION["exploreSiteDetailSiteName"];
$_SESSION['transitDetailFilter'] = False;
$_SESSION["transitDetailLogTransit"] = False;

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
    echo '<script>console.log("Log Transit Pushed")</script>';
    $filter  = $_SESSION["transitDetailFilter"] = TRUE;
    echo '<script>console.log("Log Transit Variable Created")</script>';

}

if (isset($_POST['logTransitButton'])){
    echo '<script>console.log("Filter Button Pushed")</script>';
    if (isset($_POST['optRadio'])) {
        $data = explode("_", $_POST['optRadio']);
       $username= $_SESSION['userName'];

       if(empty($_POST['transitDateButton'])){
            echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
            echo '<script language="javascript">';
            echo 'alert("Must choose a Transit date to log Transit")';
            echo '</script>';
       } else{
       $transitDate = $_POST['transitDateButton'];
       }

       $result = $conn->query("SELECT exists (select username from taketransit where username ='james.smith' AND transittype ='MARTA' AND transitDate ='1212-12-12') as seeIfTaken;");
       
       
       while ($row = $result->fetch()) {
        $taken = $row['seeIfTaken'];
       }
        

        if($taken == 1){
            unset($_POST['logTransitButton']);
            echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
            echo '<script language="javascript">';
            echo 'alert("Already taken this method of transport today")';
            echo '</script>';

        } else {




        echo '<script>console.log("Input: ' . $_POST['optRadio'] . '")</script>';
        echo '<script>console.log("Transit Route: ' . $data[0] . '")</script>';
        echo '<script>console.log("Transit Type: ' . $data[1] . '")</script>';
        echo '<script>console.log("Transit Price: ' . $data[2] . '")</script>';
        echo '<script>console.log("Transit sites Connected: ' . $data[3] . '")</script>';
        echo '<script>console.log("username Connected: ' . $username . '")</script>';
        echo '<script>console.log("Transit date Connected: ' . $transitDate . '")</script>';
        $type = $data[1];
        $route = $data[0];
        echo '<script>console.log("Transit date Route: ' . $route . '")</script>';
        echo '<script>console.log("Transit date type: ' . $type . '")</script>';


        

        $result = $conn->query("INSERT into taketransit (username, transitType, transitRoute, transitDate) VALUES ('$username' , '$type', '$route','$transitDate');");

    
        }
} else {
    echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
echo '<script language="javascript">';
echo 'alert("Must choose a Transit to log Transit")';
echo '</script>';
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

    <?php


    ?>
    <form class="form-signin" method ='Post'>
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Transit Detail</h1>


        <div class="container">


            <div class="row">
                <div class="col-sm-6">
                    <label>Site Name</label>
                    <?php
                   
                        echo '<span style="font-weight: 600; margin-left: 2.25em;">' .  $siteName . '</span>';
                   
                    
                    ?>
                </div>


                <div class="col-sm-4 offset-0">
                    <label>Transport Type </label>
                    <select name = "transportType">
                        <option value="ALL">--ALL--</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px;" name = "filterButton">Filter</button>
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


                    
                if (($_SESSION['transitDetailFilter']) == TRUE) {

                    if ($_POST['transportType'] == "ALL") {
                        $transportType = "%%";

                    } else {
                        $transportType = $_POST['transportType'];
                    }

                    $result = $conn->query("SELECT transit.transitRoute, transit.transitType, transit.transitPrice, connect.connectedSites, takeTransit.totalRiders
                    from transit
                    left join (select transitRoute, 
                                count(*) as connectedSites 
                                from connect group by transitRoute) as connect
                                on transit.transitRoute = connect.transitRoute
                    left join (select transitRoute, 
                                    count(*) as totalRiders 
                                    from taketransit group by transitRoute) as takeTransit
                                on transit.transitRoute = takeTransit.transitRoute
                    where transitType like '$transportType';");


                        while ($row = $result->fetch()) { 
                            $value = $row['transitRoute'] . "_" . $row['transitType']. "_" . $row['transitPrice']. "_". $row['transitRoute'];
                            echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'> 
                        <div class='radio'>
                        <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['transitRoute'] . "</label>
                        </div>
                        </td>";
                        echo "<td style='text-align:center'>" . $row['transitType'] . "</td>";
                        echo "<td style='text-align:center'> $" . $row['transitPrice'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['connectedSites'] . "</td>";
                        echo "<tr>";

}
}




                    else{$result = $conn->query("SELECT c.transitRoute, c.transitType,tt.transitPrice, c.connectedSites
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

                    while ($row = $result->fetch()) {
                        $value = $row['transitRoute'] . "_" . $row['transitType']. "_" . $row['transitPrice']. "_". $row['transitRoute'];
                        echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'>
                                        <div class='radio'>
                                            <label><input type='radio' id='express' name='optRadio' value ='$value'> " . $row['transitRoute'] . "</label>
                                        </div>
                                    </td>";
                        echo "<td style='text-align:center'>" . $row['transitType'] . "</td>";
                        echo "<td style='text-align:center'> $" . $row['transitPrice'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['connectedSites'] . "</td>";
                        echo "<tr>";
                    }
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

                    <input type="date" class="col-sm-6" style="padding: 0;" placeholder="" name ="transitDateButton">

                </div>


                <div class="col-sm-3">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px;" name = "logTransitButton">Log Transit</button>
                </div>
            </div>


        </div>

    </form>

</body>

</html>