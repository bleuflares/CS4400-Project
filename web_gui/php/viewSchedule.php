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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Event</h1>


        <div class="container">
            <div class="row">
                <div class="col-sm-3 offset-0">
                    <label>Event Name</label>
                </div>
                    <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>


                <div class="col-sm-4 offset-0">
                    <label>Description Keyword</label>
                </div>
                    <div class="col-sm-2 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 offset-0">
                    <label>Start Date</label>
                </div>
                    <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>


                <div class="col-sm-3 offset-0">
                    <label>End Date</label>
                </div>
                    <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>
            </div>

            <div class="row col-sm-12">

            <div class="col-sm-0 offset-2">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Filter</button>
                </div>
                <div class="col-sm-0 offset-5">
                    <input id ="button" class="btn btn-sm btn-primary btn-block col-sm-"  type="submit" name="button" onclick="myFunction();" value="View Event"/>
                </div>
            </div>


        </div>
            </div>




            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Event Name</th>
                        <th style='text-align:center'>Site Name</th>
                        <th style='text-align:center'>Start Date</th>
                        <th style='text-align:center'>End Date</th>
                        <th style='text-align:center'>Staff Count</th>
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


        </div>
            </div>




    </form>


</body>



</html>