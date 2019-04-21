<?php
// Start the session
session_start();
$_SESSION['exploreSiteFilter'] = False;

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

if (isset($_POST['siteDetailButton'])) {
    echo '<script>console.log("Site Detail Button clicked ")</script>';
    if (isset($_POST['optRadio'])) {
        $data = explode("_", $_POST['optRadio']);

        echo '<script>console.log("Input: ' . $_POST['optRadio'] . '")</script>';
        echo '<script>console.log("eventName: ' . $data[0] . '")</script>';


        $_SESSION["exploreSiteDetailSiteName"]= $data[0];
        $test =$_SESSION["exploreSiteDetailSiteName"];
        echo '<script>console.log("Sitedetail ' . $test . '")</script>';
        // $_SESSION["toEventDetailSiteName"]= $data[1];
        // $_SESSION["toEventDetailStartDate"]= $data[2];
        // $_SESSION["toEventDetailEndDate"]= $data[3];

        
    // header('Location: http://localhost/web_gui/php/visitorEventDetail.php');
    //      exit();
    } else {
        echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
    echo '<script language="javascript">';
    echo 'alert("Must choose a Site to view Site Details")';
    echo '</script>';
    }

   

}


if (isset($_POST['siteTransitButton'])) {
    echo '<script>console.log("Site Detail Button clicked ")</script>';
    if (isset($_POST['optRadio'])) {
        $data = explode("_", $_POST['optRadio']);

        echo '<script>console.log("Input: ' . $_POST['optRadio'] . '")</script>';
        echo '<script>console.log("eventName: ' . $data[0] . '")</script>';


        $_SESSION["exploreSiteTransitName"]= $data[0];
        $test =$_SESSION["exploreSiteTransitName"];
        echo '<script>console.log("Transit ' . $test . '")</script>';
        
        // $_SESSION["toEventDetailSiteName"]= $data[1];
        // $_SESSION["toEventDetailStartDate"]= $data[2];
        // $_SESSION["toEventDetailEndDate"]= $data[3];

        
    header('Location: http://localhost/web_gui/php/TransitDetail.php');
         exit();
    } else {
        echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
    echo '<script language="javascript">';
    echo 'alert("Must choose a Transit view Transit Details")';
    echo '</script>';
    }

   

}



?>




<?php


if (isset($_POST['filterButton'])) {
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['exploreSiteFilter'] = True;
    echo '<script>console.log("%c Transit History Filter Session variable set", "color:blue")</script>';
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



    <link rel="stylesheet" href="..\css\_universalStyling.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Explore Site</h1>

        <div class="container">

            <div class="row col-sm-12">
                <div class="row">
                    <div class="col-sm-0 offset-0">
                        <label class='offset-0'>Name</label>
                        <select name = "siteName">
                        <option value="ALL">ALL</option>
                            <?php
                            $result = $conn->query("SELECT SiteName FROM Site");

                            while ($row = $result->fetch()) {
                                echo "<option>" . $row['SiteName'] . "</option>";
                            }
                            ?>
                        </select>
                        <div class="row">
                        <div class="col-sm-5 offset-1">
                            <label>Description Keyword</label>
                        </div>
                        <input type="text" class="form-control col-sm-4 offset-0 width:200px" width:200px
                            id="inputAdress" name = "descriptionKeyword">

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
                        <input type="date" class="form-control col-sm-0 offset-0" id="inputAdress" name = "endDate">

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-0 offset-0">
                        <label>Total Visits Range</label>
                    </div>
                    <div class="col-sm-5">

                        <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name = "lowtTotalVisitsRange">

                        <label> -- </label>

                        <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name ="upTotalVisitsRange">
                    </div>

                    <div class="row">
                    <div class="col-sm-0 offset-1">
                        <label>Event Count Range</label>
                    </div>
                    <div class="col-sm-5">

                        <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name ="lowEventCountRange">

                        <label> -- </label>

                        <input type="number" class="col-sm-4" style="text-align: center;" placeholder="" name = "upEventCountRange">
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-4 offset-5">
                    <label for="inputLastName" class="label .col-form-label col-sm-6" id="lastNameLabel">Open
                        Everyday</label>
                        <select name ="openEveryday">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>

                </div>

                <div class="row col-sm-12">

                    <div class="col-sm-0 offset-0">
                        <button class="btn btn-sm btn-primary btn-block col-sm-8" style="width:150px"
                            style="border-radius: 5px;" name = "filterButton">Filter</button>
                    </div>

                    <div class="col-sm-5 offset-2" style="text-align: right;">
                    <button class="btn btn-sm btn-primary btn-block col-sm-8" style="width:150px"
                            style="border-radius: 5px;" name = "siteDetailButton">Site Detail</button>

                    </div>

                    <div class="col-sm-0 offset-1">
                    <button class="btn btn-sm btn-primary btn-block col-sm-8" style="width:150px"
                            style="border-radius: 5px;" name = "siteTransitButton">Transit Detail</button>
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
            <?php
            if (($_SESSION['exploreSiteFilter']) == TRUE) {

                $username =  $_SESSION["userName"];

                if ($_POST['siteName'] == "ALL") {
                            $siteName = "%%";

                } else {
                    $siteName = $_POST['siteName'];
                }

                if (empty($_POST['descriptionKeyword'])) {
                    $descriptionKeyword = "%%";
                } else {
                    $descriptionKeyword = '%' . $_POST['descriptionKeyword'] . '%';
                }

                if (empty($_POST['startDate'])) {
                    $startDate = "0000-00-00";
                } else {
                    $startDate = $_POST['startDate'];
                }

                if (empty($_POST['endDate'])) {
                    $endDate = "9999-12-12";
                } else {
                    $endDate = $_POST['endDate'];
                }

                if (empty($_POST['"lowtTotalVisitsRange"'])) {
                    $lowtTotalVisitsRange = 0;
                } else {
                    $lowtTotalVisitsRange = $_POST['lowtTotalVisitsRange'];
                }

                if (empty($_POST['upTotalVisitsRange'])) {
                    $upTotalVisitsRange = 9223372036854775807;
                } else {
                    $upTotalVisitsRange = $_POST['upTotalVisitsRange'];
                }
                if (empty($_POST['lowEventCountRange'])) {
                    $lowEventCountRange = 0;
                } else {
                    $lowEventCountRange = $_POST['lowEventCountRange'];
                }

                if (empty($_POST['upEventCountRange'])) {
                    $upEventCountRange = 9223372036854775807;
                } else {
                    $upEventCountRange = $_POST['upEventCountRange'];
                }

               $openEveryday = $_POST['openEveryday'];



               echo '<script>console.log("userName Input: ' . $username . '")</script>';
               echo '<script>console.log("SiteName Input: ' . $siteName . '")</script>';
               echo '<script>console.log("DEscription Input: ' . $descriptionKeyword . '")</script>';
               echo '<script>console.log("stateDate Input: ' . $startDate . '")</script>';
               echo '<script>console.log("endDate Input: ' . $endDate. '")</script>';
               echo '<script>console.log("lowTotalVisitRange Input: ' . $lowtTotalVisitsRange . '")</script>';
               echo '<script>console.log("upTotalVisitRange Input: ' . $upTotalVisitsRange . '")</script>';
               echo '<script>console.log("upEvent Input: ' . $upEventCountRange . '")</script>';
               echo '<script>console.log("LowEvent Input: ' . $lowEventCountRange . '")</script>';



                $result = $conn->query("SELECT sites.siteName, eventCount.eventCount, totalVisits.totalVisits, coalesce(myVisits.myVisits + siteVisits.siteVisits, myVisits.myVisits, siteVisits.siteVisits, 0) as myVisits from
                                        (select siteName from site
                                        where openEveryday like '$openEveryday' group by siteName) as sites left join
                                        (select siteName, count(visitorUsername) as totalVisits from visitevent
                                        where visitEventDate between $lowtTotalVisitsRange and $upTotalVisitsRange group by siteName) as totalVisits on sites.siteName = totalVisits.siteName left join
                                        (select siteName, count(visitorUsername) as myVisits from visitevent
                                        where visitorUsername = '$username' and visitEventDate between $lowtTotalVisitsRange and $upTotalVisitsRange group by siteName) as myVisits on sites.siteName = myVisits.siteName left join
                                        (select siteName, count(eventName) as eventCount from event
                                        where (startDate between '$startDate' and '$endDate' or endDate between '$startDate' and '$endDate') and description like '$descriptionKeyword' group by siteName) as eventCount on sites.siteName = eventCount.siteName left join
                                        (select *, count(*) as siteVisits from visitSite
                                        where visitorUsername = '$username' and visitSiteDate between '$startDate' and '$endDate' group by siteName) as siteVisits on siteVisits.siteName = sites.siteName
                                        where sites.siteName like '$siteName'
                                        AND eventCount.eventCount between $lowEventCountRange and $upEventCountRange
                                        group by sites.siteName, eventCount.eventCount, totalVisits.totalVisits;");




                while ($row = $result->fetch()) {
                $value = $row['siteName'];

                echo "<tr>";
                echo    "<td style='padding-left:2.4em;'>
                            <div class='radio'>
                            <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['siteName'] . "</label>
                            </div>
                            </td>";

                echo "<td style='text-align:center'> " . $row['eventCount'] . "</td>";
                echo "<td style='text-align:center'> " . $row['totalVisits'] . "</td>";
                echo "<td style='text-align:center'> " . $row['myVisits'] . "</td>";
            }


            }else{

                $result = $conn->query("SELECT sites.siteName, eventCount.eventCount, totalVisits.totalVisits, coalesce(myVisits.myVisits + siteVisits.siteVisits, myVisits.myVisits, siteVisits.siteVisits, 0) as myVisits from
                (select siteName from site group by siteName) as sites left join
                (select siteName, count(visitorUsername) as totalVisits from visitevent group by siteName) as totalVisits on sites.siteName = totalVisits.siteName left join
                (select siteName, count(visitorUsername) as myVisits from visitevent where visitorUsername = 'mary.smith' group by siteName) as myVisits on sites.siteName = myVisits.siteName left join
                (select siteName, count(eventName) as eventCount from event group by siteName) as eventCount on sites.siteName = eventCount.siteName left join
                (select *, count(*) as siteVisits from visitSite where visitorUsername = 'mary.smith' and visitSiteDate between '0000-00-00' and '9999-12-12' group by siteName) as siteVisits on siteVisits.siteName = sites.siteName
                group by sites.siteName, eventCount.eventCount, totalVisits.totalVisits;");
                while ($row = $result->fetch()) {
                    $value = $row['siteName'];
                    echo "<tr>";
                    echo    "<td style='padding-left:2.4em;'>
                                <div class='radio'>
                                <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['siteName'] . "</label>
                                </div>
                                </td>";

                    echo "<td style='text-align:center'> " . $row['eventCount'] . "</td>";
                    echo "<td style='text-align:center'> " . $row['totalVisits'] . "</td>";
                    echo "<td style='text-align:center'> " . $row['myVisits'] . "</td>";
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