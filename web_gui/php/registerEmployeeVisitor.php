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

    <link rel="stylesheet" href="..\css\registerEmployeeVisitor.css">


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <form class="form-signin">

        <h1 class="mb-3 font-weight-heavy" id="titleOfForm">Register Employee-Visitor</h3>

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

                <div class="form-group row col-sm-6">
                    <label for="userTypeSelect" class="label .col-form-label col-sm-4" id="userTypeLabel">User
                        Type</label>

                    <div class="col-sm-8">
                        <select id="userTypeSelect" class="form-control">
                            <option selected>Manager</option>
                            <option>Staff</option>
                        </select>
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

                <div class="form-group row col-sm-6">
                    <label for="inputPassword" class="label .col-form-label col-sm-4" id="passwordLabel">Phone</label>

                    <div class="col-sm-8">
                        <input type="tel" class="form-control" id="inputPassword">
                    </div>
                </div>

                <div class="form-group row col-sm-6">
                    <label for="inputConfirmPassword" class="label .col-form-label col-sm-4"
                        id="confirmPasswordLabel">Address</label>

                    <div class="col-sm-8">
                        <input type="password" class="form-control" id="inputConfirmPassword">
                    </div>
                </div>

            </div>

            <div class="form-row">

                <div class="form-group row col-sm-4">
                    <label for="inputCity" class="label .col-form-label col-sm-2">City</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="inputCity">
                    </div>
                </div>

                <div class="form-group row col-sm-3 offset-1">
                    <label for="inputState" class="label .col-form-label col-sm-3">State</label>

                    <div class="col-sm-9">
                        <select id="inputState" class="form-control">
                            <option value="AK">AK</option>
                            <option value="AL">AL</option>
                            <option value="AR">AR</option>
                            <option value="AZ">AZ</option>
                            <option value="CA">CA</option>
                            <option value="CO">CO</option>
                            <option value="CT">CT</option>
                            <option value="DC">DC</option>
                            <option value="DE">DE</option>
                            <option value="FL">FL</option>
                            <option value="GA">GA</option>
                            <option value="HI">HI</option>
                            <option value="IA">IA</option>
                            <option value="ID">ID</option>
                            <option value="IL">IL</option>
                            <option value="IN">IN</option>
                            <option value="KS">KS</option>
                            <option value="KY">KY</option>
                            <option value="LA">LA</option>
                            <option value="MA">MA</option>
                            <option value="MD">MD</option>
                            <option value="ME">ME</option>
                            <option value="MI">MI</option>
                            <option value="MN">MN</option>
                            <option value="MO">MO</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="NC">NC</option>
                            <option value="ND">ND</option>
                            <option value="NE">NE</option>
                            <option value="NH">NH</option>
                            <option value="NJ">NJ</option>
                            <option value="NM">NM</option>
                            <option value="NV">NV</option>
                            <option value="NY">NY</option>
                            <option value="OH">OH</option>
                            <option value="OK">OK</option>
                            <option value="OR">OR</option>
                            <option value="PA">PA</option>
                            <option value="PR">PR</option>
                            <option value="RI">RI</option>
                            <option value="SC">SC</option>
                            <option value="SD">SD</option>
                            <option value="TN">TN</option>
                            <option value="TX">TX</option>
                            <option value="UT">UT</option>
                            <option value="VA">VA</option>
                            <option value="VT">VT</option>
                            <option value="WA">WA</option>
                            <option value="WI">WI</option>
                            <option value="WV">WV</option>
                            <option value="WY">WY</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row col-sm-3 offset-1">
                    <label for="inputZip" class="label .col-form-label col-sm-2">Zip</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputZip">
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

</body>


</html>