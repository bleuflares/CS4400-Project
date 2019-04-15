<?php
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $databaseScheme = "cs4400_testdata";
    global $conn;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$databaseScheme", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
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
    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage User</h1>


        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <label>Username</label>

                    <input type="text" class="col-sm-1" style="text-align: center; margin-left: 0.5\em; padding: 0em;" placeholder="">
                        <label>Type </label>
                    <select style="margin-left: 1em;">
                        <option value="ALL">User</option>
                        <option value="MARTA">Visitor</option>
                        <option value="Bus">Staff</option>
                        <option value="Bike">Manager</option>
                    </select>
                    <label>Status</label>
                    <select style="margin-left: 1em;">
                        <option value="ALL">Approved</option>
                        <option value="MARTA">Pending</option>
                        <option value="Bus">Declined</option>

                    </select>

                </div>


            </div>


            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-3">
                    <button type="submit" class="btn btn-primary" id="backButton">Filter</button>
                    <button type="submit" class="btn btn-primary" id="registerButton">Approve</button>
                    <button type="submit" class="btn btn-primary" id="registerButton">Decline</button>
                </div>




            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Username</th>
                        <th style='text-align:center'>Email Count</th>
                        <th style='text-align:center'>User Type</th>
                        <th style='text-align:center'>Status </th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $result = $conn->query("select 
                                                    user.Username, 
                                                    user.Status, 
                                                    user.UserType, 
                                                    user.Status from USER;
                                                
                                                ;");

                        while ($row = $result->fetch()) {
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'> 
                                        <div class='radio'>
                                            <label><input type='radio' id='express' name='optradio'> " . $row['Username'] . "</label>
                                        </div>
                                    </td>";

                            echo "<td style='text-align:center'> $" . $row['Status'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['UserType'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['Status'] . "</td>";
                            echo "<tr>";
                        }
                    ?>

                </tbody>
            </table>

            <div class="row">
                <div class="col-sm-2 offset-5" >
                        <button class="btn btn-sm btn-primary btn-block" style="border-radius: 5px; margin-left: .25em;">Back</button>
                </div>
            </div>

        </div>

    </form>

</body>

</html>