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

<?php

if (isset($_POST['submit'])  && !empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $user_userEmail_Result = $conn->query("SELECT u.*, ue.Email 
                        FROM user AS u INNER JOIN useremail AS ue 
                        ON u.Username = ue.Username
                        WHERE ue.Email = '" . $email . "' AND u.Password = '" . $password . "';");

    if ($user_userEmail_Result->rowCount() > 0) {

        echo '<script>console.log("%cSuccessful Login", "color:green")</script>';

        $row = $user_userEmail_Result->fetch();


        $_SESSION["logged_in"] = true;
        $_SESSION["userEmail"] = $email;
        $_SESSION["userPassword"] = $password;
        $_SESSION["userName"] = $row["Username"];
        $_SESSION["userStatus"] = $row["Status"];
        $_SESSION["userFirstname"] = $row["Firstname"];
        $_SESSION["userLastname"] = $row["Lastname"];
        $_SESSION["userType"] = $row["UserType"];


        $userType  = $_SESSION["userType"];

        if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
            echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';

            $employeeData_Result = $conn->query("SELECT * FROM employee AS e WHERE e.Username = '" . $_SESSION["userName"] . "';");

            // Make sure Employee is in DB
            if ($employeeData_Result->rowCount() > 0) {

                $employee_rowData = $employeeData_Result->fetch();

                $_SESSION["user_employeeID"] = $employee_rowData["EmployeeID"];
                $_SESSION["user_employeePhone"] = $employee_rowData["Phone"];
                $_SESSION["user_employeeAddress"] = $employee_rowData["EmployeeAddress"];
                $_SESSION["user_employeeCity"] = $employee_rowData["EmployeeCity"];
                $_SESSION["user_employeeState"] = $employee_rowData["EmployeeState"];
                $_SESSION["user_employeeZipcode"] = $employee_rowData["EmployeeZipcode"];
                $_SESSION["user_employeeType"] = $employee_rowData["EmployeeType"];

                if (strpos($_SESSION["user_employeeType"], "Admin") !== false) {
                    header('Location: http://localhost/web_gui/php/administratorFunctionality.php');
                    exit();
                } else if (strpos($_SESSION["user_employeeType"], "Manager") !== false) {
                    header('Location: http://localhost/web_gui/php/managerFunctionality.php');
                    exit();
                } else if (strpos($_SESSION["user_employeeType"], "Staff") !== false) {
                    header('Location: http://localhost/web_gui/php/staffFunctionality.php');
                    exit();
                } else {
                    echo '<script>console.log("%cUser is EMPLOYEE, BUT they are NOT a Admin, Manager, or Staff", "color:red")</script>';;
                }
            } else {
                echo '<script>console.log("%cUser is EMPLOYEE, BUT they are not in the EMPLOYEE TABLE", "color:red")</script>';;
            }
        } else if (strpos($userType, "Employee") === false && strpos($userType, "Visitor") !== false) {
            echo '<script>console.log("%cUser is ONLY a VISITOR", "color:blue")</script>';
            header('Location: http://localhost/web_gui/php/visitorFunctionality.php');
            exit();
        } else if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") !== false) {
            echo '<script>console.log("%cUser is BOTH an EMPLOYEE and VISITOR", "color:blue")</script>';

            $employeeVisitorData_Result = $conn->query("SELECT * FROM employee AS e WHERE e.Username = '" . $_SESSION["userName"] . "';");

            // Make sure Employee is in DB
            if ($employeeVisitorData_Result->rowCount() > 0) {

                $employeeVisitor_rowData = $employeeVisitorData_Result->fetch();

                $_SESSION["user_employeeVisitorID"] = $employeeVisitor_rowData["EmployeeID"];
                $_SESSION["user_employeeVisitorPhone"] = $employeeVisitor_rowData["Phone"];
                $_SESSION["user_employeeVisitorAddress"] = $employeeVisitor_rowData["EmployeeAddress"];
                $_SESSION["user_employeeVisitorCity"] = $employeeVisitor_rowData["EmployeeCity"];
                $_SESSION["user_employeeVisitorState"] = $employeeVisitor_rowData["EmployeeState"];
                $_SESSION["user_employeeVisitorZipcode"] = $employeeVisitor_rowData["EmployeeZipcode"];
                $_SESSION["user_employeeVisitorType"] = $employeeVisitor_rowData["EmployeeType"];


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
            } else {
                echo '<script>console.log("%cUser is EMPLOYEE and VISITOR, BUT they are not in the EMPLOYEE TABLE", "color:red")</script>';;
            }
        } else if (strpos($userType, "User") !== false) {
            echo '<script>console.log("%cUser is JUST a USER", "color:blue")</script>';

            header('Location: http://localhost/web_gui/php/userFunctionality.php');
            exit();
        }
    } else {
        echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
        echo '<script language="javascript">';
        echo 'alert("INVALID username/password")';
        echo '</script>';
    }
} else {
    echo '<script>console.log("%cPlease fill in valid email and password", "color:red")</script>';;
    $_SESSION["logged_in"] = false;
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