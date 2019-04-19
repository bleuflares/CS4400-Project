<?php
// Start the session
session_start();
$_SESSION['updateButton'] = False;

echo '<script>console.log("manager Input: ' . $_SESSION['siteName']     . '")</script>';


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

if (isset($_POST['back'])){
    echo '<script>console.log("%cSuccessful  Push", "color:blue")</script>';
}
if (isset($_POST['updateButton'])){
     echo '<script>console.log("%cSuccessful  Push", "color:blue")</script>';

   $_SESSION['updateButton'] = True;


}



?>


<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 
    <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\registerEmployeeVisitor.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

<?php

 if (isset($_SESSION['siteName'])){
    $siteName = $_SESSION['siteName'];

    $result = $conn->query("SELECT siteName, siteAddress, siteZipcode,openEveryday, managerUsername, concat(firstname, ' ', lastname) AS name  from site s
        inner join user u
        on s.managerUsername = u.userName
        where siteName = '$siteName';");

    echo '<script>console.log("Query : ' . $_SESSION['siteName']     . '")</script>';

    $row = $result->fetch();

    $siteAddress = $row['siteAddress'];
    $siteZipCode = $row['siteZipcode'];
    $managerUsername = $row['managerUsername'];
    $openEveryday = $row['openEveryday'];
    $name = $row['name'];




}

    ?>

    <form class="form-signin" method="post">

        <h1 class="mb-3 font-weight-heavy" id="titleOfForm">Edit Site</h3>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4" id="firstNameLabel">Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputFirstName" value="<?php echo $siteName; ?>" name ="siteName">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-4" id="lastNameLabel">Zipcode</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputLastName"
                                pattern='^\+?\d{5}' placeholder="5 digits"value="<?php echo $siteZipCode; ?>" name = "siteZipCode">                    
                            </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-12">
                    <label for="inputFirstName" class="label .col-form-label col-sm-0 offset-0"
                        id="firstNameLabel">Address</label>


                    <input type="text" class="form-control col-sm-9 offset-1" id="inputAdress" value="<?php echo $siteAddress; ?>" name = "siteAddress">

                </div>


            </div>




            <div class="form-group row">

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4"
                        id="firstNameLabel">Manager</label>
                    <select class="col-sm-6" style="margin-left: 1em;" name = "siteManagerName">
                        <option value='<?php echo $name;?>'><?php echo $name;?></option>

                        <?php
                        $result = $conn->query("SELECT concat(firstname, ' ', lastname) AS name FROM user u 
                                                INNER Join site s on
                                                u.username = s.managerUsername
                                                where managerUsername != '$managerUsername'");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['name'] . "</option>";
                        };
                        ?>



                        <option value="No">Option2</option>

                    </select>

                </div>


                <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-6" id="lastNameLabel">Open
                        Everyday</label>
                    <select style="margin-left: 1em;" name= "openEveryday">
                        <option value='<?php echo $openEveryday;?>'><?php echo $openEveryday;?></option>

                        <?php
                        $result = $conn->query("SELECT Distinct openEveryday from site where openEveryday != '$openEveryday'");


                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['openEveryday'] . "</option>";
                        };
                        ?>

                    </select>
                </div>

            </div>



            <div class="form-row">
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary offset-0" id="backButton" name = "back">Back</button>
                    <button type="submit" class="btn btn-primary offset-6" id="registerButton" name ="updateButton">Update</button>
                </div>
            </div>
            </form>

            <?php
                    if ($_SESSION['updateButton'] == true) {

                        $siteName2 = $_POST['siteName'];
                        $siteZipCode2 = $_POST['siteZipCode'];
                        if(isset($_POST['siteAddress'])){
                            $siteAddress2 = $_POST['siteAddress'];
                        } else{
                            $siteAddress2 = "";
                        }




                        
                        $siteManagerName2 = $_POST['siteManagerName'];

                        $openEveryday2 =  $_POST['openEveryday'];

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
                    ?>

    

    <script type="text/javascript">
    </script>

</body>


</html>