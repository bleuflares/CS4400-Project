
<?php
error_reporting(E_ERROR| E_PARSE);
// Start the session
session_start();
$_SESSION['createButton'] = False;

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
 if (isset($_SESSION['route'])){
    $route = $_SESSION['route'];
    echo '<script>console.log("route name : ' . $route     . '")</script>';

    $result = $conn->query("SELECT transitPrice from transit where transitRoute = '$route';");

    $row = $result->fetch();

    $transitPrice = $row['transitPrice'];
    echo '<script>console.log("route name : ' . $transitPrice     . '")</script>';

}

if (isset($_POST['createButton'])) {
    echo '<script>console.log("Create Button Pushed")</script>';

    $_SESSION['createButton'] = True;

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


    <form class="form-signin" method = Post>
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Create Transit</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-5">
                    <label>Transport Type</label>
                    <select name = "transportType">
                        <option value="ALL">--ALL--</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>

                </div>

                <div class="col-sm-4">
                    <label>Route</label>
                    <input type="text" class="form-control" id="inputFirstName" value="<?php echo $route; ?>" name ="route">
                    </div>

                <div class="col-sm-3">
                    <label>Price ($)</label>

                    <input type="text" class="form-control" id="inputFirstName" value="<?php echo $transitPrice; ?>" name ="transitPrice">

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
                        style="padding-left: 2.5em; padding-right: 2.5em; margin-left: 4em;" name = "createButton">Create</button>
                </div>
            </div>

        </div>

    </form>



    <?php
        if($_SESSION['createButton'] == True){

             if(isset($_POST['connectedSites'])){
             } else {
                $connectedSites = $_POST['connectedSites'];
             }
             $transportType = $_POST['transportType'];
             $route = $_POST['route'];
             $transitPrice = $_POST['transitPrice'];

            if(count($connectedSites) > 1){
                $result =$conn->query("SELECT EXISTS(SELECT * FROM transit WHERE transitType ='$transportType' and transitRoute = '$route') as answer;");
                    while ($row = $result->fetch()) {
                            $answer = $row['answer'];
                }

                if($answer == '1')
                {
                    echo '<script language="javascript">';
                    echo 'alert("This is not a unique transport type and route!")';
                    echo '</script>';
                } else{
                    if($conn->query("INSERT into transit values('$transportType','$route','$transitPrice');")) {
                        for ($i = 0 ; $i < count($connectedSites); $i++) {
                            $temp = $connectedSites[$i];
                            echo '<script>console.log("connected Sites : ' .
                            $temp. '")</script>';
                            $conn->query("INSERT into connect values('$temp','$transportType','$route');");
                        }
                    }

                }
            } else{
                 echo '<script language="javascript">';
                echo 'alert("Less than two sites selected!")';
                echo '</script>';
            }

        // $counter = 0
        // foreach($connectedSites as $array_values){
        // $connectedSites[counter] = $array_values
        // $counter++
        // }



        // $connectedSites = $_POST['connectedSites'];
        // echo '<script>console.log("connected Sites : ' .
        // $connectedSites[0]. '")</script>';


        }

    ?>

</body>

