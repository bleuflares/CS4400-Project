<?php
// Start the session
session_start();

$_SESSION['manageUser_Filtered'] = false;

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

// Performs a filtering on the Database Results Table 
if (isset($_POST['filterButton'])) {

    echo '<script>console.log("%cSuccessful Filter", "color:green")</script>';
    echo '<script>console.log("user Input: ' . $_POST['usernameInput'] . '")</script>';
    echo '<script>console.log("typeInput Input: ' . $_POST['typeInput'] . '")</script>';
    echo '<script>console.log("statusInput Input: ' . $_POST['statusInput'] . '")</script>';



    echo '<script>console.log("%cFilter ALL", "color:green")</script>';

    if (!empty($_POST['usernameInput'])) {
        $username = $_POST['usernameInput'];
    } else {
        $username = "%%";
    }

    $type = $_POST['typeInput'];
    $status = $_POST['statusInput'];

    if ($type == 'Visitor' || $type == 'User') {

        if ($type == 'User') {
            $type = '%%';
        } else if ($type == 'Visitor') {
            $type = '%Visitor%';
        }
        $result = $conn->query("SELECT u.username, ue.emailCount, u.userType, u.status 
                                from (select username, count(*) as EmailCount from UserEmail group by Username) 
                                as ue inner join (select username, userType, status from User) 
                                as u on ue.Username = u.Username 
                                where u.Username like '$username' and UserType like '$type' and Status like '$status';");
        $_SESSION['manageUser_Filtered_Employee'] = false;
    } else {
        $result = $conn->query("SELECT ue.username, emailCount, status,employeetype 
        from (select username, count(*) as emailCount from UserEmail group by Username) 
        as ue inner join (select u.username, u.status, e.employeeType from User as u inner join Employee as e on u.username = e.Username) 
        as t on ue.Username = t.Username where ue.username LIKE '$username' and status = '$status' and employeetype = '$type';");
        $_SESSION['manageUser_Filtered_Employee'] = true;
    }


    $_SESSION['manageUser_Filtered'] = true;
} else {
    echo '<script>console.log("%cFailed Filter", "color:red")</script>';
}
?>

<?php


// Updating DB by changing User Status to Approved
if (isset($_POST['approveButton']) && isset($_POST['optRadio'])) {

    $selectUsername = $_POST['optRadio'];

    echo '<script language="javascript">';
    echo 'alert("The User selected is: ' . $selectUsername . ' and their status has been set to Approved.")';
    echo '</script>';

    $conn->query("UPDATE user SET STATUS = 'Approved' WHERE user.username = '$selectUsername';");
}

?>

<?php

// Updating DB by changing User Status to Declined
if (isset($_POST['declineButton']) && isset($_POST['optRadio'])) {

    $selectUsername = $_POST['optRadio'];

    // echo '<script language="javascript">';
    // echo 'alert("The User selected is: ' . $selectUsername . ' and their status has been set to declined.")';
    // echo '</script>';


    $result = $conn->query("SELECT username, status from user where user.username = '$selectUsername';");

    $currentSelectedUserRow = $result->fetch();

    echo '<script>console.log("%cCurrent Status of selected user: ' . $currentSelectedUserRow['status'] . '", "color:blue")</script>';

    $currentStatus = $currentSelectedUserRow['status'];

    if (strpos($currentStatus, "Pending") !== false) {
        $conn->query("UPDATE user SET STATUS = 'Declined' WHERE user.username = '$selectUsername';");
    } else {
        echo '<script language="javascript">';
        echo 'alert("Cannot Decline a User who is already Approved or Declined.")';
        echo '</script>';
    }
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

    <!-- <meta http-equiv="refresh" content="3"> -->


    <link rel="stylesheet" href="..\css\_universalStyling.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>


    <!-- <script type="text/javascript">
    $(document).ready(function() {
        var table = $('#table1').DataTable({
            // "stateSave": true

        });

    });
    </script> -->

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage User</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <label>Username</label>

                    <input type="text" class="col-sm-2" style="text-align: center; margin-left: 0.5\em; padding: 0em;"
                        name="usernameInput" placeholder="">
                    <label class="offset-1">Type </label>
                    <select style="margin-left: 1em;" name="typeInput">
                        <option value="User">User</option>
                        <option value="Visitor">Visitor</option>
                        <option value="Staff">Staff</option>
                        <option value="Manager">Manager</option>
                    </select>
                    <label class="offset-1">Status</label>
                    <select style="margin-left: 1em;" name="statusInput">
                        <option value="Approved">Approved</option>
                        <option value="Pending">Pending</option>
                        <option value="Declined">Declined</option>

                    </select>

                </div>


            </div>


            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary" id="backButton" name="filterButton">Filter</button>
                    <button type="submit" class="btn btn-primary" id="registerButton"
                        name="approveButton">Approve</button>
                    <button type="submit" class="btn btn-primary" id="registerButton"
                        name="declineButton">Decline</button>
                </div>




                <table id="table1" class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th style='text-align:center'>Username</th>
                            <th style='text-align:center'>Email Count</th>
                            <th style='text-align:center'>User Type</th>
                            <th style='text-align:center'>Status </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php

                        if ($_SESSION['manageUser_Filtered'] && $_SESSION['manageUser_Filtered_Employee'] == true) {
                            while ($row = $result->fetch()) {
                                echo "<tr >";
                                echo    "<td style='padding-left:2.4em;'> 
                                            <div class='radio'>
                                                <label name ='selectUsername'>
                                                    <input type='radio' id='express' name ='optRadio' value='$username'> " . $row['username'] . "
                                                </label>
                                            </div>
                                        </td>";

                                echo "<td style='text-align:center'>" . $row['emailCount'] . "</td>";
                                echo "<td style='text-align:center'>" . $row['employeeType'] . "</td>";
                                echo "<td style='text-align:center'>" . $row['status'] . "</td>";
                                echo "<tr>";
                            }

                            $_SESSION['manageUser_Filtered'] = false;
                        } else if ($_SESSION['manageUser_Filtered'] && $_SESSION['manageUser_Filtered_Employee'] == false) {

                            while ($row = $result->fetch()) {
                                $username = $row['username'];
                                echo "<tr>";
                                echo    "<td style='padding-left:2.4em;'> 
                                            <div class='radio'>
                                                <label name ='selectUsername'>
                                                    <input type='radio' id='express' name='optRadio' value='$username'> " . $row['username'] . "
                                                </label>
                                            </div>
                                        </td>";

                                echo "<td style='text-align:center'>" . $row['emailCount'] . "</td>";
                                echo "<td style='text-align:center'>" . $row['userType'] . "</td>";
                                echo "<td style='text-align:center'>" . $row['status'] . "</td>";
                                echo "<tr>";
                            }

                            $_SESSION['manageUser_Filtered'] = false;
                        } else {
                            $result = $conn->query("select u.username, ue.emailCount, u.userType, u.status from (select username, count(*) as emailCount from UserEmail group by Username) 
                            as ue inner join (select username, userType, status from User) as u on ue.Username = u.Username;");

                            while ($row = $result->fetch()) {
                                $username = $row['username'];
                                echo "<tr>";
                                echo    "<td style='padding-left:2.4em;'> 
                                            <div class='radio'>
                                                <label name ='selectUsername'>
                                                    <input type='radio' id='express' name='optRadio' value='$username'> " . $row['username'] . "
                                                </label>
                                            </div>
                                        </td>";

                                echo "<td style='text-align:center'>" . $row['emailCount'] . "</td>";
                                echo "<td style='text-align:center'>" . $row['userType'] . "</td>";
                                echo "<td style='text-align:center'>" . $row['status'] . "</td>";
                                echo "<tr>";
                            }
                        }
                        ?>

                    </tbody>
                </table>


            </div>

            <div class="row">
                <div class="col-sm-3 offset-4">
                    <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px; margin-left: 1.5em;"
                        name="backButton">Back</button>
                </div>
            </div>

    </form>

</body>

<script>
// DO NOT DELETE
// $('input:radio').on('click', function(e) {
//     // console.log(e.currentTarget.value);
//     console.log(e.currentTarget.name);

//     var test = e.currentTarget.name;
// });
</script>

</html>