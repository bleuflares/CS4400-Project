<?php
// Start the session
session_start();

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
                                    where u.FirstName = 'James';");

    $row = $result->fetch();

    $username = $row['Username'];

    $siteManaged = $conn->query("select * from site where site.ManagerUsername = '$username';");

    $siteRow = $siteManaged->fetch();

    $emailsResults = $conn->query("select * from useremail ue where ue.Username = '$username';");

    ?>


    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Profile</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-6">
                    <label>First Name</label>
                    <?php
                    echo '<input type="text" class="col-sm-6" style="padding: 0; margin-left: 2em;" value="' . $row['Firstname'] . '">';
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>Last Name</label>
                    <?php
                    echo '<input type="text" class="col-sm-6" style="padding: 0; margin-left: 2em;" value="' . $row['Lastname'] . '">'
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Username</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $row['Username'] . '</span>';
                    ?>
                </div>

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
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <label>Employee ID</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 1.15em;">' . $row['EmployeeID'] . '</span>'
                    ?>
                </div>

                <div class="col-sm-6">
                    <label>Phone</label>
                    <?php
                    echo '<input type="tel" class="col-sm-6" style="padding: 0; margin-left: 3.85em;" value="' . $row['Phone'] . '">'
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-9">
                    <label>Address</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 3.15em;">'
                        . $row['EmployeeAddress'] . ', '
                        . $row['EmployeeCity'] . ', '
                        . $row['EmployeeState'] . ' '
                        . $row['EmployeeZipcode'] .
                        '</span>'
                    ?>
                </div>
            </div>


            <div class="form-row">
                <div class="form-group row col-sm-12">
                    <label for="inputEmail" class="label .col-form-label col-sm-2" id="emailLabel">Email</label>

                    <?php
                    $currEmail = $emailsResults->fetch();

                    echo '<div class="col-sm-8">';
                    echo '<span class="col-sm-8">' . $currEmail['Email'] . '</span>';
                    echo '</div>';
                    echo '<button type="submit" class="btn btn-outline-dark">Remove</button>';
                    while ($currEmail = $emailsResults->fetch()) {
                        echo '<div class="col-sm-10">';
                        echo '<span class="col-sm-8" style="margin-left: 6.5em;">' . $currEmail['Email'] . '</span>';
                        echo '</div>';
                        echo '<button type="submit" class="btn btn-outline-dark">Remove</button>';
                    }
                    ?>

                </div>

            </div>

            <div class="row">
                <div class="col-sm-4 offset-5">

                    <?php
                    if (strpos($row['UserType'], "Visit") !== false) {
                        echo '<input type="checkbox" class="col-sm-1" 
                            style="text-align: center; margin-left: 0.5em; padding: 0em;" placeholder="" checked>';
                    } else {
                        echo '<input type="checkbox" class="col-sm-1" 
                            style="text-align: center; margin-left: 0.5em; padding: 0em;" placeholder="">';
                    }

                    echo '<label>Visitor Account</label>';
                    ?>

                </div>
            </div>


            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary" id="backButton"
                        style="padding-left: 2.5em; padding-right: 2.5em; margin-left: .5em;">Update</button>
                    <button type="submit" class="btn btn-primary" id="registerButton"
                        style="padding-left: 3.25em; padding-right: 3.25em; margin-left: 4em;">Back</button>
                </div>
            </div>

        </div>

    </form>

</body>

</html>