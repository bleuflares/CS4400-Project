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

// echo '<script>console.log("BOOL' . $_POST['zipInput'] . ')</script>';

if (isset($_POST['backButton'])) {

    header('location: http://localhost/web_gui/php/manageSite.php');
    exit();
}

?>

<?php

if (isset($_POST['createButton'])) {

    if (
        isset($_POST['nameInput'])  && !empty($_POST['zipInput'])
        && !empty($_POST['managerInput']) && !empty($_POST['openInput'])
    ) {


        echo '<script>console.log("%cSuccessful Creation", "color:green")</script>';

        echo '<script>console.log("Name Input: ' . $_POST['nameInput'] . '")</script>';
        echo '<script>console.log("Zip Input: ' . $_POST['zipInput'] . '")</script>';
        echo '<script>console.log("address Input: ' . $_POST['addressInput'] . '")</script>';
        echo '<script>console.log("manager Input: ' . $_POST['managerInput'] . '")</script>';
        echo '<script>console.log("open Input: ' . $_POST['openInput'] . '")</script>';

        $nameInput = $_POST['nameInput'];
        $zipInput = $_POST['zipInput'];
        $managerInput = $_POST['managerInput'];
        $openInput = $_POST['openInput'];
        if (!empty($_POST['addressInput'])) {
            $addressInput = $_POST['addressInput'];
        } else {
            $addressInput = "";
        }

        $result = $conn->query("SELECT username from user u inner join site s on u.username = s.managerUsername where concat(firstname, ' ', lastname)='$managerInput';");
        while ($row = $result->fetch()) {
            $username = $row['username'];
        }

        echo '<script>console.log("got Username")</script>';

        $result = $conn->query("INSERT into site VALUES('$nameInput', '$addressInput', '$zipInput', '$openInput', '$username')");
        echo '<script language="javascript">';
        echo 'alert("Successful Creation of Site!")';
        echo '</script>';

        // $result = $conn->query("INSERT into site VALUES(".$_POST['nameInput'].", ".$_POST['addressInput'].", ".$_POST['zipInput']", ".$_POST['openInput'].", ".$_POST['managerInput'].")");


    } else {
        echo '<script language="javascript">';
        echo 'alert("Failed to create of site because there are fields that are empty!")';
        echo '</script>';

        echo '<script>console.log("%cFailed Creation", "color:red")</script>';
    }
}

?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\registerEmployeeVisitor.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>


<body>

    <form class="form-signin" method="post">

        <h1 class="mb-3 font-weight-heavy" id="titleOfForm">Create Site</h3>

            <div class="form-row">

                <!-- <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address"
                    autofocus> -->

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4" id="firstNameLabel">Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputFirstName" name="nameInput">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-4" id="lastNameLabel" name="zipInput"
                        value="j">Zipcode</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputLastName" name="zipInput" pattern='^\+?\d{5}'
                            placeholder="5 digits">
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-12">
                    <label for="inputFirstName" class="label .col-form-label col-sm-0 offset-0"
                        id="firstNameLabel">Address</label>


                    <input type="text" class="form-control col-sm-9 offset-1" id="inputAdress" name="addressInput">

                </div>



            </div>




            <div class="form-group row">

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4"
                        id="firstNameLabel">Manager</label>
                    <select class="col-sm-6" style="margin-left: 1em;" name="managerInput">
                        <?php
                        $result = $conn->query("SELECT concat(firstname, ' ', lastname) AS name FROM user u 
                                                INNER Join site s on
                                                u.username = s.managerUsername
                                                where managerUsername != '$managerUsername'");

                        while ($row = $result->fetch()) {
                            echo "<option>" . $row['name'] . "</option>";
                        };


                        ?>

                    </select>

                </div>


                <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-6" id="lastNameLabel">Open
                        Everyday</label>
                    <select style="margin-left: 1em;" name="openInput">
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>

                    </select>
                </div>

            </div>



            <div class="form-row">'
                <div class="form-group row col-sm-12">
                    <button type="submit" class="btn btn-primary offset-1" id="backButton"
                        name="backButton">Back</button>
                    <button type="submit" class="btn btn-primary offset-7" id="createButton"
                        name="createButton">Create</button>
                </div>
            </div>


    </form>

    <script type="text/javascript">
    </script>

</body>


</html>