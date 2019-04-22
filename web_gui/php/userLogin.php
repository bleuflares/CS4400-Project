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

$result = $conn->query("SELECT username,password from user;");

while ($row = $result->fetch()) {
    $password = $row['password'];
    $username = $row['username'];

    $passwordLength = strlen($password);
    echo '<script>console.log("%cPassword Lengths: ' . $passwordLength . '", "color:green")</script>';

    if ($passwordLength <= 25) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $conn->query("UPDATE user SET password = '$hashedPassword' WHERE username ='$username';");

        echo '<script>console.log("%cPassword HASHED: ' . $hashedPassword . '", "color:green")</script>';
    }
}


?>

<?php

if (isset($_POST['submit'])  && !empty($_POST['email']) && !empty($_POST['password'])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword  = password_hash($password, PASSWORD_BCRYPT);
    echo '<script>console.log("%cPassword HASHED: ' . $hashedPassword . '", "color:green")</script>';

    // $user_userEmail_Result = $conn->query("SELECT u.*, ue.Email
    //                     FROM user AS u INNER JOIN useremail AS ue
    //                     ON u.Username = ue.Username
    //                     WHERE ue.Email = '" . $email . "' AND u.Password = '" . $hashedPassword . "';");

    $user_userEmail_Result = $conn->query("SELECT u.*, ue.Email
                        FROM user AS u INNER JOIN useremail AS ue
                        ON u.Username = ue.Username
                        WHERE ue.Email = '" . $email . "';");



    if ($user_userEmail_Result->rowCount() > 0) {

        $row = $user_userEmail_Result->fetch();

        $dbHashPassword = $row['Password'];

        $validPassword = password_verify($password, $dbHashPassword);

        echo '<script>console.log("%cPassword HASHED: ' . $validPassword . '", "color:red")</script>';


        if ($validPassword) {
            $_SESSION["userEmail"] = $email;
            $_SESSION["userPassword"] = $hashedPassword;
            $_SESSION["userName"] = $row["Username"];
            $_SESSION["userStatus"] = $row["Status"];
            $_SESSION["userFirstname"] = $row["Firstname"];
            $_SESSION["userLastname"] = $row["Lastname"];
            $_SESSION["userType"] = $row["userType"];

            $userStatus = $row["Status"];

            if (strpos($userStatus, "Approved") !== false) {

                $_SESSION["logged_in"] = true;


                echo '<script>console.log("%cSuccessful Login", "color:green")</script>';

                $conn->query("drop table if exists dates;
                            create table dates(
                            day date not null,
                            primary key(day)
                            );

insert into dates values('2019-02-01'),('2019-02-02'),('2019-02-03'),('2019-02-04'),('2019-02-05'),('2019-02-06'),
                        ('2019-02-07'),('2019-02-08'),('2019-02-09'),('2019-02-10'),('2019-02-11'),('2019-02-12'),
                        ('2019-02-13'),('2019-02-14'),('2019-02-15'),('2019-02-16'),('2019-02-17'),('2019-02-18'),
                        ('2019-02-19'),('2019-02-20'),('2019-02-21'),('2019-02-22'),('2019-02-23'),('2019-02-24'),
                        ('2019-02-25'),('2019-02-26'),('2019-02-27'),('2019-02-28'),('2019-03-01'),('2019-03-02'),
                        ('2019-03-03'),('2019-03-04');");




                $userType  = $_SESSION["userType"];

                if (strpos($userType, "Employee") !== false && strpos($userType, "Visitor") === false) {
                    echo '<script>console.log("%cUser is EMPLOYEE", "color:blue")</script>';

                    $employeeData_Result = $conn->query("SELECT * FROM employee AS e
                                                        WHERE e.Username = '" . $_SESSION["userName"] . "';");

                    // Make sure Employee is in DB
                    if ($employeeData_Result->rowCount() > 0) {

                        $employee_rowData = $employeeData_Result->fetch();

                        $_SESSION["user_employeeID"] = $employee_rowData["EmployeeID"];
                        $_SESSION["user_employeePhone"] = $employee_rowData["Phone"];
                        $_SESSION["user_employeeAddress"] = $employee_rowData["employeeAddress"];
                        $_SESSION["user_employeeCity"] = $employee_rowData["employeeCity"];
                        $_SESSION["user_employeeState"] = $employee_rowData["employeeState"];
                        $_SESSION["user_employeeZipcode"] = $employee_rowData["employeeZipcode"];
                        $_SESSION["user_employeeType"] = $employee_rowData["employeeType"];

                        // CLEARING OUT OTHER SESSION VARIABLES
                        $_SESSION["user_employeeVisitorID"] = "";
                        $_SESSION["user_employeeVisitorPhone"] = "";
                        $_SESSION["user_employeeVisitorAddress"] = "";
                        $_SESSION["user_employeeVisitorCity"] = "";
                        $_SESSION["user_employeeVisitorState"] = "";
                        $_SESSION["user_employeeVisitorZipcode"] = "";
                        $_SESSION["user_employeeVisitorType"] = "";

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
                        $_SESSION["user_employeeVisitorAddress"] = $employeeVisitor_rowData["employeeAddress"];
                        $_SESSION["user_employeeVisitorCity"] = $employeeVisitor_rowData["employeeCity"];
                        $_SESSION["user_employeeVisitorState"] = $employeeVisitor_rowData["employeeState"];
                        $_SESSION["user_employeeVisitorZipcode"] = $employeeVisitor_rowData["employeeZipcode"];
                        $_SESSION["user_employeeVisitorType"] = $employeeVisitor_rowData["employeeType"];

                        // CLEARING OUT OTHER SESSION VARIABLES
                        $_SESSION["user_employeeID"] = "";
                        $_SESSION["user_employeePhone"] = "";
                        $_SESSION["user_employeeAddress"] = "";
                        $_SESSION["user_employeeCity"] = "";
                        $_SESSION["user_employeeState"] = "";
                        $_SESSION["user_employeeZipcode"] = "";
                        $_SESSION["user_employeeType"] = "";


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
                echo 'alert("User status is still pending/declined")';
                echo '</script>';
            }
        } else {
            echo '<script>console.log("%cINVALID username/password", "color:red")</script>';
            echo '<script language="javascript">';
            echo 'alert("INVALID username/password")';
            echo '</script>';
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