<?php
// Start the session
session_start();
$_SESSION['deleteButton'] = false;

$_SESSION['transitHistoryFilter'] = false;




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
// filter button
if (isset($_POST['filterButton'])) {
    echo '<script>console.log("%cSuccessful Filter Button Push", "color:blue")</script>';
    $_SESSION['transitHistoryFilter'] = True;
    echo '<script>console.log("%c Transit History Filter Session variable set", "color:blue")</script>';
}

?>


<?php
// edit button
if (isset($_POST['edit'])) {
    if (isset($_POST['optRadio'])) {

        $siteName = $_POST['optRadio'];

        $_SESSION["manageSite_siteName"] = $siteName;

        echo '<script>console.log("manager Input: ' . $siteName     . '")</script>';
        echo '<script>console.log("session Input: ' . $_SESSION['manageSite_siteName']     . '")</script>';

        header('Location: http://localhost/web_gui/php/editSite.php');
        exit();
    } else {
        echo '<script language="javascript">';
        echo 'alert("No Site Selected!")';
        echo '</script>';
    }
}

?>

<?php
// delete Button
if (isset($_POST['delete'])) {

    echo '<script>console.log("%cSuccessful Delete Button Push", "color:blue")</script>';



    $siteName = $_POST['optRadio'];

    echo '<script>console.log("%cGrabbed the right site name: "' . $siteName . '", "color:green")</script>';

    $result = $conn->query("SELECT siteName, siteAddress, siteZipCode, openEveryday, managerusername from site WHERE siteName = '$siteName';");


    $row = $result->fetch();

    $siteAddress = $row['siteAddress'];
    $siteZipcode = $row['siteZipCode'];
    $openEveryday = $row['openEveryday'];
    $managerusername = $row['managerusername'];


    echo '<script>console.log("%c address ' . $siteAddress . '", "color:green")</script>';
    echo '<script>console.log("%c zip ' . $siteZipcode . '", "color:green")</script>';
    echo '<script>console.log("%c openEveryday ' . $openEveryday . '", "color:green")</script>';
    echo '<script>console.log("%c manageruser ' . $managerusername . '", "color:green")</script>';


    $result = $conn->query("Delete from site
                            Where
                            siteName = '$siteName'
                            AND
                            siteAddress = '$siteAddress'
                            AND siteZipcode = '$siteZipcode'
                            AND openEveryday = '$openEveryday'
                            AND managerusername = '$managerusername';");

    // $_SESSION['deleteButton'] == false;

    echo '<script language="javascript">';
    echo 'alert("Successful Delete of Site!")';
    echo '</script>';
}

?>

<?php

// create Button
if (isset($_POST['create'])) {


    header('Location: http://localhost/web_gui/php/createSite.php');
    exit();
}


?>

<?php

// Navigation of Back Button
if (isset($_POST['backButton'])) {

    $userType  = $_SESSION["userType"];

    if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
        echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';
        // $employeeType = $_SESSION["user_employeeType"];

        if (strpos($_SESSION["user_employeeType"], "Admin") !== false) {
            header('Location: http://localhost/web_gui/php/administratorFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin.", "color:red")</script>';;
        }
    } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
        echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';


        if (strpos($_SESSION["user_employeeVisitorType"], "Admin") !== false) {
            header('Location: http://localhost/web_gui/php/administratorVisitorFunctionality.php');
            exit();
        } else {
            echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are NOT a Admin.", "color:red")</script>';;
        }
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--
    <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\_universalStyling.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Site</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-6">

                    <label>Site</label>
                    <select name="site">
                        <option value="ALL">ALL</option>
                        <?php
                        $result = $conn->query("SELECT siteName FROM site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['siteName'] . "</option>";
                        }
                        ?>

                    </select>
                </div>


                <div class="col-sm-1 offset-0">
                    <label>Manager</label>
                </div>
                <div class="col-sm-3 offset-1">

                    <select name="manager">
                        <option value="ALL">ALL</option>
                        <?php
                        $result = $conn->query("SELECT  concat(FirstName, ' ', LastName) as Username
                                                from site s
                                                inner join user u on
                                                s.managerUserName = u.userName;
                                                        ");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['Username'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-sm-7 offset-5">
                        <label>Open Everyday</label>

                        <select name="openEveryday">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>

                    </div>


                    <div class="row col-sm-12">

                        <div class="col-sm-3">
                            <button class="btn btn-sm btn-primary btn-block"  name="filterButton">Filter</button>
                        </div>

                        <div class="col-sm-3" >
                            <input id="button" class="btn btn-sm btn-primary btn-block" type="submit" name="create" onclick="filter();" value="Create" />

                        </div>

                        <div class="col-sm-3">
                            <input id="button" class="btn btn-sm btn-primary btn-block" type="submit" name="edit" value="Edit" />
                        </div>

                        <div class="col-sm-3">
                            <input id="button" class="btn btn-sm btn-primary btn-block" type="submit" name="delete" value="Delete" />
                        </div>
                    </div>

                </div>
            </div>

            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Name</th>
                        <th style='text-align:center'>Manager</th>
                        <th style='text-align:center'>Open Everyday</th>
                    </tr>
                </thead>

                <tbody>
                    <?php

                    if ($_SESSION['transitHistoryFilter'] == true) {

                        $openEveryday  = $_POST['openEveryday'];

                        if ($_POST['site'] == "ALL") {
                            $site = "%%";
                        } else {
                            $site = $_POST['site'];
                        }
                        if ($_POST['manager'] == "ALL") {
                            $manager  = "%%";
                        } else {
                            $manager = $_POST['manager'];
                        }




                        echo '<script>console.log("siteName Input: ' . $site . '")</script>';
                        echo '<script>console.log("manager Input: ' . $manager     . '")</script>';
                        echo '<script>console.log("openEveryday Input: ' . $openEveryday . '")</script>';

                        $result = $conn->query("SELECT  s.siteName, concat(FirstName, ' ', LastName) as manager, s.openEveryday
                                from site s
                                inner join user u on
                                s.managerUserName  = u.userName
                                where s.siteName like '$site'
                                And  concat(FirstName, ' ', LastName) like '$manager'
                                And s.OpenEveryday = '$openEveryday';");


                        while ($row = $result->fetch()) {
                            $value = $row['siteName'];
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'>
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['siteName'] . "</label>
                                    </div>
                                    </td>";
                            echo "<td style='text-align:center'>" . $row['manager'] . "</td>";
                            echo "<td style='text-align:center'> " . $row['openEveryday'] . "</td>";

                            //     while ($row = $result->fetch()) {
                            //     echo "<tr>";
                            //     echo "<td style='text-align:center'>" . $row['siteName'] . "</td>";
                            //     echo "<td style='text-align:center'>" . $row['manager'] . "</td>";
                            //     echo "<td style='text-align:center'>" . $row['openEveryday'] . "</td>";

                            //     echo "<tr>";

                            // }
                            $_SESSION['transitHistoryFilter'] = false;

                            echo '<script>console.log("%cSuccessful Delete Button Push", "color:blue")</script>';
                        }
                    } else {
                        $result = $conn->query("SELECT  s.siteName, concat(FirstName, ' ', LastName) as manager, s.openEveryday
                                                from site s
                                                inner join user u on
                                                s.managerUserName = u.userName;");


                        while ($row = $result->fetch()) {
                            $value = $row['siteName'];
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'>
                                    <div class='radio'>
                                    <label><input type='radio' id='express' name='optRadio' value ='$value'>" . $row['siteName'] . "</label>
                                    </div>
                                    </td>";
                            echo "<td style='text-align:center'>" . $row['manager'] . "</td>";
                            echo "<td style='text-align:center'> " . $row['openEveryday'] . "</td>";
                        }
                    }

                    ?>



                </tbody>
            </table>

            <div class="row">
                <div class="col-sm-3 offset-4">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px; margin-left: 1.5em;" name="backButton">Back</button>
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