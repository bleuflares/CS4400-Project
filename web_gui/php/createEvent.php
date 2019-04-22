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
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';

        if (strpos($_SESSION["user_employeeVisitorType"], "Manager") !== false) {
            header('Location: http://localhost/web_gui/php/manageEvent.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';
        }
    }
}

?>

<?php

if (isset($_POST['createButton'])) {


    if (isset($_POST['siteName'])  && !empty($_POST['fname']) && !empty($_POST['price'])
        && !empty($_POST['capacity'])  && !empty($_POST['minStaffReq']) && !empty($_POST['textDescription'])
        && isset($_POST['staffSelect']) && isset($_POST['startDate']) && isset($_POST['endDate'])){
    
        
        if($_POST['endDate'] < $_POST['startDate']){
            echo '<script language="javascript">';
                echo 'alert("Cannot create an event that ends before it starts!.")';
                echo '</script>';
        } else {

            $siteName = $_POST['siteName'];
            $eventName = $_POST['fname'];
            $price = $_POST['price'];
            $capacity = $_POST['capacity'];
            $minStaffReq = $_POST['minStaffReq'];
            $textDescription = $_POST['textDescription'];
            $staffSelect = $_POST['staffSelect'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            
            
         $conn->query("insert into event VALUES('$eventName','$startDate','$siteName','$endDate',$price,$capacity,$minStaffReq,'$textDescription');");
            foreach ($_POST['staffSelect'] as $selectedOption) {
                $result = $conn->query("select user.username from user left join employee on user.username = employee.username
                where concat(firstname,' ',lastname) = '$selectedOption';");
                while ($row = $result->fetch()) {
                    $staffUsername = $row['username'];
                }
                       
                    echo '<script>console.log("LowEvent Input: ' . $selectedOption . '")</script>';
                    $conn->query("insert into assignTo values('$staffUsername', '$eventName','$startDate','$siteName');");
                        
            }
        
            




           
          

        }

    }
}

    if (isset($_POST['textDescription'])) {
        echo '<script>console.log("%c Found Text:", "color:green")</script>';
    }

    if (!empty($_POST['textDescription'])) {
        echo '<script>console.log("%c Found Text:", "color:green")</script>';
    }

    // $test = !isset($_POST['textDescription']) && $_POST['textDescription'] === '';

    // echo htmlspecialchars($_POST['textDescription']);

    // echo '<script>console.log("%cSet? : ' . $test . ' ", "color:green")</script>';


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

    <link rel="stylesheet" href="..\css\_universalStyling.css">


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
                <div class="col-sm-6">
                    <label>Name</label>
                    <?php
                    echo '<input type="text" class="col-sm-6 offset-2" style="padding: 0; margin-left: 2em;" name="fname" value="">';
                    ?>
                </div>

                <div class="col-sm-6 offset-0">
                    <label class=''>Site</label>
                    <select name="siteName">
                        <?php
                        $result = $conn->query("SELECT SiteName FROM Site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['SiteName'] . "</option>";
                        }
                        echo "<option>ALL</option>";
                        ?>
                    </select>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-3">
                    <label>Price</label>
                    <?php
                    echo '<input type="number" class="col-sm-6 offset-0" style="padding: 0;" name="price" value="" min="0">';
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    ?>
                </div>

                <div class="col-sm-3">
                    <label>Capacity</label>
                    <?php
                    echo '<input type="number" class="col-sm-6 offset-0" style="padding: 0;" name="capacity" value="">';
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>Minimum Staff Required</label>
                    <?php
                    echo '<input type="number" class="col-sm-3 offset-0" style="padding: 0;" name="minStaffReq" value="">';
                    // echo '<span style="font-weight: 600; margin-left: 2.25em;"></span>';
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Start Date</label>
                    <?php
                    echo '<input type="date" class="col-sm-6 offset-2" style="padding: 0; margin-left: 2em;" name="startDate" value="">';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>End Date</label>
                    <?php
                    echo '<input type="date" class="col-sm-6 offset-2" style="padding: 0; margin-left: 2em;" name="endDate" value="">';
                    ?>
                </div>

            </div>



            <br>

            <div class="row">
                <div class="col-sm-2 offset-0">
                    <label>Description</label>
                </div>
                <div class="col-sm-4 offset-1">
                    <!-- <textarea name="paragraph_text" cols="50" rows="8" name="textDescription"></textarea>
 -->
                    <input type="text" class="col-sm-3 offset-0" style="padding: 0;" name="textDescription" value="">;

                </div>

            </div>

            <div class="row">
                <label for="exampleFormControlSelect2" style="">Assign Staff</label>

                <select multiple style="display: inline; margin-left: 6em;" class="form-control col-sm-6 offset-1"
                    id="exampleFormControlSelect2" name="staffSelect[]" >
                    <?php

                    // echo '<script>console.log("%cDate ' . $_POST['startDate'] . '", "color:green")</script>';

                    // while (!isset($_POST['startDate']) && !isset($_POST['endDate'])) {
                    //     echo '<script>console.log("%cLooping", "color:red")</script>';
                    //     // usleep(2 * 1000000);
                    // }
                    // echo '<script>console.log("%cStopped", "color:green")</script>';


                    $availableStaffResult = $conn->query("SELECT concat(user.firstName,' ' ,user.lastName) as Name
                                                            from user inner join employee on user.Username = employee.Username where employeeType = 'Staff';");

                    // $startDate = date('Y-m-d', strtotime($_SESSION['manageEvent_eventStartDate']));
                    // $endDate = date('Y-m-d', strtotime($_SESSION['manageEvent_eventEndDate']));

                    // $availableStaffResult = $conn->query("SELECT distinct concat(user.firstName,' ',user.lastName) as Name
                    //                                     from employee left join user on user.username = employee.username
                    //                                     where concat(user.firstName,' ',user.lastName) not in (
                    //                                         select distinct concat(user.firstName,' ',user.lastName) as Name
                    //                                         from employee left join user on user.username = employee.username
                    //                                         left join assignTo on employee.username = assignTo.staffUsername
                    //                                         left join event on event.eventName = assignTo.eventName
                    //                                         and event.startDate = assignTo.startDate
                    //                                         and event.siteName = assignTo.siteName
                    //                                         and (
                    //                                             (event.startDate between '$startDate' and '$endDate')
                    //                                             or (event.endDate between '$startDate' and '$endDate')
                    //                                             or (event.startDate <= '$startDate' and event.endDate >= '$endDate'))
                    //                                     where event.eventName is not null)
                    //                                     and employee.employeeType = 'Staff';");


                    while ($availableStaffDataRow = $availableStaffResult->fetch()) {
                        $availableStaffName = $availableStaffDataRow['Name'];

                        echo "<option>" . $availableStaffName . "</option>";
                    }
                    ?>
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
                <button type="submit" class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;"
                    name="createButton">Create</button>
            </div>
        </div>

    </form>

</body>

<script>
$(document).keypress(
    function(event) {
        if (event.which == '13') {
            event.preventDefault();
        }
    });
</script>

</html>