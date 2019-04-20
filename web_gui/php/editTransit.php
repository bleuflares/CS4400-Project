<?php
// Start the session
session_start();

$_SESSION['updateButton'] = false;

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

if (isset($_POST['updateButton'])) {
    echo '<script>console.log("Create Button Pushed")</script>';

    $_SESSION['updateButton'] = True;
}


if (($_SESSION['edit']) == true){
    $route = $_SESSION["route"];
    echo '<script>console.log("%cConnection to Data: ' . $_SESSION["route"]. '", "color:green")</script>';

    $result = $conn->query("SELECT transitType, transitPrice from transit where transitRoute = '$route';");

    $row = $result->fetch();
    $transitType = $row['transitType'];
    $transitPrice = $row['transitPrice'];
    echo '<script>console.log("type name : ' . $transitType    . '")</script>';
    echo '<script>console.log("price name : ' . $transitPrice     . '")</script>';


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



    <form class="form-signin" method= "POST">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Edit Transit</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-5">
                    <label>Transport Type</label>

                    <span style="font-weight: 600; margin-left: 1em;" value ="<?php echo $transitType; ?>" ><?php echo $transitType ?></span>

                </div>

                <div class="col-sm-4">
                    <label>Route</label>

                    <input type="text" class="col-sm-4" style="padding: 0; margin-left: 0.5em;" value="<?php echo $route; ?>">

                </div>

                <div class="col-sm-3">
                    <label>Price ($)</label>

                    <input type="text" class="col-sm-5" style="padding: 0; margin-left: 0.5em;" value="<?php echo $transitPrice; ?>">

                </div>
            </div>



            <!-- <div class="form-row">
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
            </div> -->



            <div>

                <label for="exampleFormControlSelect2" style="">Connected Sites</label>

                <select multiple style="display: inline ;" class="form-control col-sm-6 offset-3"
                    id="exampleFormControlSelect2" name = 'connectedSites[]'>
                        <?php
                        $result = $conn->query("SELECT siteName FROM site");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['siteName'] . "</option>";
                        }
                        ?>
                </select>

            </div>


            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary" id="backButton"
                        style="padding-left: 2.5em; padding-right: 2.5em; margin-left: .75em;">Back</button>
                    <button type="submit" class="btn btn-primary" id="registerButton"
                        style="padding-left: 2.5em; padding-right: 2.5em; margin-left: 4em;" name = "updateButton">Edit</button>
                </div>
            </div>

        </div>

    </form>

    <?php
                    if ($_SESSION['updateButton'] == true) {

                        $route2 = $_POST['route'];
                        $price2 = $_POST['price'];
                        if(isset($_POST['connectedSites'])){
                        } else {
                            $connectedSites2 = $_POST['connectedSites'];
                        }

                        if(count($connectedSites) < 2){
                            echo '<script language="javascript">';
                            echo 'alert("You must choose two or more sites!")';
                            echo '</script>';
                        } else{
                             $result = $conn->query("SELECT username from user u inner join site s on u.username = s.managerUsername where concat(firstname, ' ', lastname)='$siteManagerName2';");
                                while ($row = $result->fetch()) {
                                $username2 = $row['username'];
                                }

                        echo '<script>console.log("siteName Input: ' . $siteName . '")</script>';
                        echo '<script>console.log("siteName Input: ' . $siteName2 . '")</script>';


                        echo '<script>console.log("siteZipcodeO Input: ' . $siteZipCode     . '")</script>';
                        echo '<script>console.log("siteZipcodeO Input: ' . $siteZipCode2     . '")</script>';


                        echo '<script>console.log("siteAddressO Input: ' . $siteAddress     . '")</script>';
                         echo '<script>console.log("siteAddressO Input: ' . $siteAddress2     . '")</script>';





                        echo '<script>console.log("openEverydayO Input: ' . $openEveryday     . '")</script>';
                        echo '<script>console.log("openEverydayO Input: ' . $openEveryday2     . '")</script>';


                        echo '<script>console.log("managerUsernameO Input: ' . $managerUsername   . '")</script>';
                        echo '<script>console.log("managerUsernameO Input: ' . $username2   . '")</script>';



                             $result = $conn->query("UPDATE site SET SiteName = '$siteName2', SiteAddress = '$siteAddress2' , SiteZipCode = $siteZipCode2, OpenEveryday = '$openEveryday2' , ManagerUsername = '$username2' WHERE SiteName ='siteName' AND SiteAddress = 'siteAddress'AND SiteZipcode = $siteZipCode AND managerUsername = '$managerUsername' AND OpenEveryday = '$openEveryday';");

                        }
                    }
                    ?>

</body>

</html>