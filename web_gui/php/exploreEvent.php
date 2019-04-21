<?php
// Start the session
session_start();
$_SESSION['exploreEventFilterButton'] = False;

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

if (isset($_POST['filterButton'])){
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['exploreEventFilterButton'] = True;
    echo '<script>console.log("%c Transit History Filter Session variable set", "color:blue")</script>';

}
if (isset($_POST['transitDetail'])) {
    header('Location: http://localhost/web_gui/php/transitDetail.php');
            exit();



}

if (isset($_POST['eventDetail'])) {

        if (isset($_POST['optRadio'])) {
            $data = explode("_", $_POST['optRadio']);

            echo '<script>console.log("Input: ' . $_POST['optRadio'] . '")</script>';
            echo '<script>console.log("siteName: ' . $data[1] . '")</script>';
        } else {
            echo '<script>console.log("%cCannot View/Edit Event if a specific event is not chosen.", "color:red")</script>';;
        }

        // header('Location: http://localhost/web_gui/php/view_editEvent.php');
             // exit();
    
}

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

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\_universalStyling.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#test').DataTable({
            "stateSave": true

        });

    }); -->
    <!-- </script> -->
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Explore Event</h1>

        <div class="container">
            <div class="row col-sm-12">
                <div class="row">
                <div class="col-sm-0 offset-0">
                        <label class='offset-0'>Name</label>
                        </div>
                        <input type="text" class="form-control col-sm-5 offset-0 width:200px" width:200px
                            id="inputAdress" name="eventName">
                            </div>
              <div class="col-sm-4 offset-0">
                            <label>Description Keyword</label>
                        </div>
                        <input type="text" class="form-control col-sm-3 offset-0 width:200px" width:200px
                            id="inputAdress" name="descriptionKeyword">
                            </div>
                    </div>



                <div class="row">
                                <div class="col-sm-0 offset-0">
                        <label class='offset-0'>Name</label>
                        <select name = "siteName">

                            <?php
                            $result = $conn->query("SELECT SiteName FROM Site");

                            while ($row = $result->fetch()) {
                                echo "<option>" . $row['SiteName'] . "</option>";
                            }
                            ?>
                            echo "<option>ALL</option>";
                        </select>
  
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2 offset-0">
                        <label>Start Date</label>
                    </div>
                    <div class="col-sm-4 offset-0">
                        <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress" name = "startDate">


                    </div>

                    <div class="col-sm-2 offset-0">
                        <label>End Date</label>
                    </div>
                    <div class="col-sm-4 offset-0">
                        <input type="date" class="form-control col-sm-0 offset-0" id="inputAdress" name ="endDate">

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-0 offset-0">
                        <label>Total Visits Range</label>
                    </div>
                    <div class="col-sm-5">

                        <input type="text" class="col-sm-4" style="text-align: center;" placeholder=""name ="lowTotalVisitRange">

                        <label> -- </label>

                        <input type="text" class="col-sm-4" style="text-align: center;" placeholder=""name ="upTotalVisitRange">
                    </div>
                    <div class="row">
                    <div class="col-sm-0 offset-0">
                        <label>Tickets Price Range</label>
                    </div>
                    <div class="col-sm-5">

                        <input type="text" class="col-sm-4" style="text-align: center;" placeholder="" name ="LowTicketsPriceRange">

                        <label> -- </label>

                        <input type="text" class="col-sm-4" style="text-align: center;" placeholder="" name ="upTicketsPriceRange">
                    </div>
                </div>
            </div>

            <div class="row">

                     <div class="col-sm-7 offset-5">
                        <label>Include Visited</label>

                        <select name ="includeVisited">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>

                    </div>



                    <div class="col-sm-7 offset-5">
                        <label>Inlcude Sold Out Event</label>

                        <select name ="includeSoldOutEvents">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>

                    </div>

                <div class="row col-sm-12">

                    <div class="col-sm-0 offset-2">
                        <button class="btn btn-sm btn-primary btn-block col-sm-12" style="width:150px"
                            style="border-radius: 5px;" name ="filterButton">Filter</button>
                    </div>

                    <div class="col-sm-0 offset-2" style="text-align: right;">
                        <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0" type="submit" name="eventDetail"
                            onclick="filter();" value="Event Detail" />
                    </div>


                    <div class="col-sm-0 offset-1">
                        <input id="button" class="btn btn-sm btn-primary btn-block col-sm-0 offset-6" type="submit"
                            name="transitDetail" onclick="myFunction();" value="Transit Detail" />
                    </div>
                </div>
            </div>
        </div>

        <table id="test" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style='text-align:center'>Event Name</th>
                    <th style='text-align:center'>Site Name</th>
                    <th style='text-align:center'>Ticket Price</th>
                    <th style='text-align:center'>Ticket Remaining</th>
                    <th style='text-align:center'>Total Visits</th>
                    <th style='text-align:center'>myVisits Visits</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (($_SESSION['exploreEventFilterButton']) == TRUE) {
                    echo '<script>console.log("GOT TO IF")</script>';

                    if (empty($_POST['eventName'])) {
                        $eventName = "%%";

                    } else {
                        $eventName = $_POST['eventName'];
                    }
                    if (empty($_POST['descriptionKeyword'])) {
                        $descriptionKeyword = "%%";

                    } else {
                        $descriptionKeyword = $_POST['descriptionKeyword'];
                    }
                    

                    if (($_POST['siteName']) == "ALL") {
                        $siteName = "%%";

                    } else {
                        $siteName = $_POST['siteName'];
                    }
                                        
                    if (empty($_POST['startDate'])) {
                        $startDate = "0000-00-00";
                    } else {
                        $startDate = $_POST['startDate'];
                    }

                    if (empty($_POST['endDate'])) {
                        $endDate = "9999-12-31";
                    } else {
                        $endDate = $_POST['startDate'];
                    }

                    if (empty($_POST['lowTotalVisitRange'])) {
                        $lowTotalVisitRange = 0;
                    } else {
                        $lowTotalVisitRange = $_POST['lowTotalVisitRange'];
                    }

                     if (empty($_POST['upTotalVisitRange'])) {
                        $upTotalVisitRange = 9223372036854775807;
                    } else {
                        $upTotalVisitRange = $_POST['upTotalVisitRange'];
                    }

                    if (empty($_POST['lowTicketsPriceRange'])) {
                        $lowTicketsPriceRange = 0;
                    } else {
                        $lowTticketsPriceRange = $_POST['lowTicketsPriceRange'];
                    }
                    
                    if (empty($_POST['upTicketsPriceRange'])) {
                        $upTicketsPriceRange = 9223372036854775807;
                    } else {
                        $upTicketsPriceRange  = $_POST['upTicketsPriceRange'];
                    }
                   

                    $includeVisited = $_POST['includeVisited'];
                    $includeSoldOutEvents = $_POST['includeSoldOutEvents'];
                    $username = $_SESSION["userName"];
                    


                    echo '<script>console.log("SiteName Input: ' . $eventName . '")</script>';
                    echo '<script>console.log("SiteName Input: ' . $descriptionKeyword . '")</script>';
                    echo '<script>console.log("SiteName Input: ' . $siteName . '")</script>';
                    echo '<script>console.log("stateDate Input: ' . $startDate . '")</script>';
                    echo '<script>console.log("endDate Input: ' . $endDate. '")</script>';
                    echo '<script>console.log("lowTotalVisitRange Input: ' . $lowTotalVisitRange . '")</script>';
                    echo '<script>console.log("upTotalVisitRange Input: ' . $upTotalVisitRange . '")</script>';
                    echo '<script>console.log("eventLowCountRange Input: ' . $lowTicketsPriceRange . '")</script>';
                    echo '<script>console.log("eventUpCountRange Input: ' . $upTicketsPriceRange . '")</script>';
                    echo '<script>console.log("includeVisted Input: ' . $includeVisited . '")</script>';
                    echo '<script>console.log("includesoldout Input: ' . $includeSoldOutEvents . '")</script>';

                    #both.
                    if($includeVisited == "No" && $includeSoldOutEvents == "No"){
                        

                    }

                    else if($includeVisited == "No" && $includeSoldOutEvents == "Yes"){
                            //                         select event.eventName, event.siteName, event.eventPrice, event.capacity - count(a.visitorUsername) as ticketsRemaining,
                            // count(a.visitorUsername) as totalVisits, count(b.visitorUsername) as myVisits
                            // from event 
                            // left join visitevent as a on event.eventName = a.eventName 
                            // and event.siteName = a.siteName
                            //                 and event.startDate = a.startDate
                            // left join visitevent as b on event.eventName = b.eventName 
                            // and event.siteName = b.siteName
                            //                 and event.startDate = b.startDate
                            //                 and b.visitorUsername = a.visitorUsername
                            //                 and b.visitorUsername = 'manager2'
                            // where event.eventName like '%Tour%' 
                            // and event.description like '%Trail%'
                            // and event.siteName like 'Inman Park'
                            // and event.startDate >= '0000-00-00'
                            // and event.endDate <= '9999-01-01'
                            // and event.eventPrice between 0 and 100
                            // group by event.eventName, event.siteName having count(a.visitorUsername) between 0 and 100
                            // and count(b.visitorUsername) < 1;

                    } else if ($includeVisited == "Yes" && $includeSoldOutEvents == "No"){


                    }


                    else {$result = $conn->query("SELECT event.eventName, event.siteName, event.eventPrice, event.capacity - count(a.visitorUsername) as ticketsRemaining,
                                        count(a.visitorUsername) as totalVisits, count(b.visitorUsername) as myVisits
                                        from event 
                                        left join visitevent as a on event.eventName = a.eventName 
                                        and event.siteName = a.siteName
                                                        and event.startDate = a.startDate
                                        left join visitevent as b on event.eventName = b.eventName 
                                        and event.siteName = b.siteName
                                                        and event.startDate = b.startDate
                                                        and b.visitorUsername = a.visitorUsername
                                                        and b.visitorUsername = 'manager2'
                                        where event.eventName like '$eventName' 
                                        and event.description like '$descriptionKeyword'
                                        and event.siteName like '$siteName'
                                        and event.startDate >= '$startDate'
                                        and event.endDate <= '$endDate'
                                        and event.eventPrice between $lowTicketsPriceRange and $upTicketsPriceRange
                                        group by event.eventName, event.siteName having count(a.visitorUsername) between $lowTotalVisitRange and $upTotalVisitRange;");
                    }
                 
                    while ($row = $result->fetch()) {
                        $eventName = $row['eventName'];
                        echo "<tr>";
                        echo    "<td style='padding-left:2.4em;'>
                        <div class='radio'>
                        <label><input type='radio' id='express' name='optRadio' value ='$eventName'>" . $row['eventName'] . "</label>
                        </div>
                        </td>";
    
                        echo "<td style='text-align:center'>" . $row['siteName'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['eventPrice'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['ticketsRemaining'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['totalVisits'] . "</td>";
                        echo "<td style='text-align:center'>" . $row['myVisits'] . "</td>";
                        echo "<tr>";
                    }

                    

                } else{
                    $username = $_SESSION["userName"];
                    

                    $result = $conn->query("SELECT event.eventName, event.siteName, event.eventPrice, event.capacity - count(a.visitorUsername) as ticketsRemaining,
                    count(a.visitorUsername) as totalVisits, count(b.visitorUsername) as myVisits
                    from event 
                    left join visitevent as a on event.eventName = a.eventName 
                    and event.siteName = a.siteName
                                       and event.startDate = a.startDate
                    left join visitevent as b on event.eventName = b.eventName 
                    and event.siteName = b.siteName
                                       and event.startDate = b.startDate
                                       and b.visitorUsername = a.visitorUsername
                                       and b.visitorUsername = '$username'
                    group by event.eventName, event.siteName;");
                
                
                while ($row = $result->fetch()) {
                    $eventName = $row['eventName'];
                    

                    echo "<tr>";
                    echo    "<td style='padding-left:2.4em;'>
                    <div class='radio'>
                    <label><input type='radio' id='express' name='optRadio'  value ='$eventName'>" . $row['eventName'] . "</label>
                    </div>
                    </td>";
                    
                    echo "<td style='text-align:center'>" . $row['siteName'] . "</td>";
                    echo "<td style='text-align:center'>" . $row['eventPrice'] . "</td>";
                    echo "<td style='text-align:center'>" . $row['ticketsRemaining'] . "</td>";
                    echo "<td style='text-align:center'>" . $row['totalVisits'] . "</td>";
                    echo "<td style='text-align:center'>" . $row['myVisits'] . "</td>";
                    echo "<tr>";
                }
                }   
                    ?>
            </tbody>
        </table>

        <div class="col-sm-0 offset-6">
            <button class="btn btn-sm btn-primary btn-block col-sm-0  " style=" height:40px;
    width:60px;border-radius: 5px;" name="backButton">Back</button>
        </div>

    </form>

</body>

</html>