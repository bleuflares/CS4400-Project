<!DOCTYPE html>
<html>

<!-- style="border:red 1px solid;" -->

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="refresh" content="3">

    <link rel="stylesheet" href="..\css\registerUser.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <form class="form-signin">

        <h1 class="mb-3 font-weight-heavy" id="titleOfForm">Register User</h3>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputFirstName" class="label .col-form-label col-sm-4" id="firstNameLabel">First
                        Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputFirstName">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputLastName" class="label .col-form-label col-sm-4" id="lastNameLabel">Last
                        Name</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputLastName">
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputUsername" class="label .col-form-label col-sm-4"
                        id="userNameLabel">Username</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="inputUsername">
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-6">
                    <label for="inputPassword" class="label .col-form-label col-sm-4"
                        id="passwordLabel">Password</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputPassword">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputConfirmPassword" class="label .col-form-label col-sm-4"
                        id="confirmPasswordLabel">Confirm Password</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputConfirmPassword">
                    </div>
                </div>

            </div>


            <div class="form-row">

                <div class="form-group row col-sm-12">
                    <label for="inputEmail" class="label .col-form-label col-sm-2" id="emailLabel">Email</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputEmail">
                    </div>

                    <button type="submit" class="btn btn-outline-dark">Add</button>
                </div>

            </div>

            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary" id="backButton">Back</button>
                    <button type="submit" class="btn btn-primary" id="registerButton">Register</button>
                </div>
            </div>


    </form>

    <script type="text/javascript">
    </script>

<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "project";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "INSERT INTO users (Username, Firstname, Lastname, Status, Password, UserType)
    VALUES (:userNameLabel, :firstNameLabel, :lastNameLabel, :'Active', :passwordLabel, :confirmPasswordLabel, :emailLabel)";
    // use exec() because no results are returned
    $conn->exec($sql);
    echo "New record created successfully";
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
?>
</body>


</html>