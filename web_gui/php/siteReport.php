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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Site Report</h1>


        <div class="container">
            <div class="row">
                <div class="col-sm-2 offset-0">
                    <label>Start Date</label>
                </div>
                    <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>


                <div class="col-sm-2 offset-0">
                    <label>End Date</label>
                </div>
                    <div class="col-sm-4 offset-0">
                    <input type="Date" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-0 offset-1">
                    <label>Event Count Range</label>
                </div>
                    <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1"  style="text-align: center;" placeholder="">
                </div>


               <div class="col-sm-0 offset-0">
                    <label>Staff Count Range</label>
                </div>
                    <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1"  style="text-align: center;" placeholder="">
                </div>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-0 offset-1">
                    <label>Total Visits Range</label>
                </div>
                    <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1"  style="text-align: center;" placeholder="">
                </div>


               <div class="col-sm-0 offset-0">
                    <label>Total Revenue Range</label>
                </div>
                    <div class="col-sm-3">

                    <input type="text" class="col-sm-1" style="text-align: center;" placeholder="">

                    <label> -- </label>

                    <input type="text" class="col-sm-1"  style="text-align: center;" placeholder="">
                </div>

                </div>
            </div>

            <div class="row col-sm-12">

            <div class="col-sm-0 offset-2">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Filter</button>
                </div>
                <div class="col-sm-0 offset-7">
                    <input id ="button" class="btn btn-sm btn-primary btn-block col-sm-"  type="submit" name="button" onclick="myFunction();" value="Daily Detail"/>
                </div>
            </div>


        </div>
            </div>




            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Date</th>
                        <th style='text-align:center'>Event Count</th>
                        <th style='text-align:center'>Staff Count</th>
                        <th style='text-align:center'>Total Visits</th>
                         <th style='text-align:center'>Total Revenue ($)</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>

            <div class="container">
            <div class="col-sm-2 offset-5">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Back</button>
                </div>
            </div>

    </form>


</body>



</html>