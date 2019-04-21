<?php
// Start the session
session_start();

$siteName = $_SESSION["exploreSiteDetailSiteName"];

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

if(isset($_POST['logVisit'])){

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
<!--
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

    ?> -->


    <form class="form-signin" method = "post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Site Detail</h1>


        <div class="container">

            <div class="row">
                <!-- <div class="col-sm-6">
                    <label>First Name</label>
                    <?php
                    echo '<input type="text" class="col-sm-6" style="padding: 0; margin-left: 2em;" value="' . $row['Firstname'] . '">';
                    ?>
                </div> -->

                <div class="col-sm-6">
                    <label>Site</label>
                    <?php
                    echo '<span style="font-weight: 600; margin-left: 2.25em;">' . $siteName . '</span>';
                    ?>
                </div>

                <!-- <div class="col-sm-6">
                    <label>Last Name</label>
                    <?php
                    echo '<input type="text" class="col-sm-6" style="padding: 0; margin-left: 2em;" value="' . $row['Lastname'] . '">'
                    ?>
                </div> -->

                <div class="col-sm-6">
                    <label>Open Everyday</label>
                    <?php
                    $result = $conn->query("SELECT openEveryday FROM site where siteName = '$siteName';");

                    while ($row = $result->fetch()) {
                            echo "<span style='font-weight: 600 ; text-align:center'>" . $row['openEveryday'] . "</span>";
                        }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <label>Address</label>
                    <?php
                    $result = $conn->query("SELECT coalesce(siteAddress,'None') as Address, FROM site where siteName = '$siteName';");

                    while ($row = $result->fetch()) {
                            echo "<span style='font-weight: 600 ; text-align:center'>" . $row['Address'] . "</span>";
                        }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-7">
                    <label>Visit Date</label>
                        <input type="date" class="col-sm-5 offset = 0" style="text-align:center;padding: 0; margin-left: 2em;" name ="actualDateVisited"/>
                </div>
                <div class="col-sm-5">
                    <button class="btn btn-sm btn-primary btn-block col-sm-4" style="border-radius: 5px; margin-left: 0em;"
                        name="logVisit">Log Visit</button>
                </div>

            </div>



        </div>

    </form>

</body>

</html>