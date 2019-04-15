<?php
// Start the session
session_start();

// Set session variables
$_SESSION["serverName"] = "localhost";
$_SESSION["databaseUserName"] = "root";
$_SESSION["databasePassword"] = "1234";
$_SESSION["databaseScheme"] = "cs4400_testdata";

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

if (isset($_POST['submit'])  && !empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $user_userEmail_Result = $conn->query("SELECT u.*, ue.Email 
                        FROM user AS u INNER JOIN useremail AS ue 
                        ON u.Username = ue.Username
                        WHERE ue.Email = '" . $email . "' AND u.Password = '" . $password . "';");

    if ($user_userEmail_Result->rowCount() > 0) {
        $_SESSION["logged_in"] = true;
        $_SESSION["userEmail"] = $email;
        $_SESSION["userPassword"] = $password;

        echo '<script>console.log("%cSuccessful Login", "color:green")</script>';

        $row = $user_userEmail_Result->fetch();

        $userType  = $row["UserType"];

        if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
            echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';

            $user_userEmail_Result = $conn->query("SELECT u.*, ue.Email 
                            FROM user AS u INNER JOIN useremail AS ue 
                            ON u.Username = ue.Username
                            WHERE ue.Email = '" . $email . "' AND u.Password = '" . $password . "';");
        } else if (strpos($userType, "Employee") === false && strpos($userType, "Visitor") !== false) {
            echo '<script>console.log("%cUser is ONLY a VISITOR", "color:blue")</script>';

            header('Location: http://localhost/web_gui/php/visitorFunctionality.php');
            exit();
        } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
            echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';
        } else if (strpos($userType, "User") !== false) {
            echo '<script>console.log("%cUser is JUST a USER", "color:blue")</script>';

            header('Location: http://localhost/web_gui/php/userFunctionality.php');
            exit();
        }

        // header('Location: http://localhost/web_gui/php/manageProfile.php');
        // exit;

    } else {
        echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
        echo '<script language="javascript">';
        echo 'alert("INVALID username/password")';
        echo '</script>';
    }
} else {
    echo '<script>console.log("Please fill in valid email and password")</script>';;
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\userLogin.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" Z
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

</head>


<body>

    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Atlanta Beltline Login</h1>

        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" autofocus>

        <input type="password" id="inputPassword" name="password" class="form-control" pattern=".{8,25}"
            placeholder="Password. At least 8 characters">

        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Login</button>
                </div>

                <div class="col-md-6">
                    <a class="btn btn-lg btn-primary btn-block" href="./registerNavigation.php">Register </a>
                </div>

            </div>
        </div>

    </form>

</body>


<script>
// $(document).keypress(
//     function(event) {
//         if (event.which == '13') {
//             event.preventDefault();
//         }
//     });
</script>

</html>