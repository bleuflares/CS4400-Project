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

<<<<<<< HEAD
    <!-- <meta http-equiv="refresh" content="3"> -->

    <link rel="stylesheet" href="..\css\_universalStyling.css">


=======
    <meta http-equiv="refresh" content="3">

    <link rel="stylesheet" href="..\css\_universalStyling.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<<<<<<< HEAD


    <!-- <script type="text/javascript">
=======
      <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#test').DataTable({
        

        });

    });
    </script>


    <script type="text/javascript">
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213

    $(document).ready(function() {
        $('#test').DataTable();
    } );

<<<<<<< HEAD
    </script> -->
=======
    </script>
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
</head>

<body>
    <form class="form-signin">
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Visit History</h1>


        <div class="container">
            <div class="row">
<<<<<<< HEAD
                <div class="col-sm-2 offset-0">
                    <label>Event</label>
                </div>
                <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">
                </div>

                <div class="col-sm-2 offset-1">
                    <label>Site</label>
                </div>
                <div class="col-sm-0 offset-0">
                    <select>
                        <option value="ALL">--ALL--</option>
                        <option value="MARTA">MARTA</option>
                        <option value="Bus">Bus</option>
                        <option value="Bike">Bike</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 offset-0">
                    <label>Start Date</label>
                </div>
                    <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">
=======
                <div class="col-sm-0 offset-0">
                    <label>Event</label>
                </div>
                    <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">

                </div>


                <div class="col-sm-0 offset-1">
                    <label>Site</label>
                    <select>
                        <?php 
                            $result = $conn->query("SELECT SiteName FROM Site");
                            
                            while ($row = $result->fetch()) {
                                echo "<option>" . $row['SiteName'] . "</option>";
                            }
                        ?>
                    </select> 
            </div>

            <div class="row col-sm-12">
                <div class="col-sm-0 offset-0">
                    <label>Start Date</label>

                    <input type="date" class="col-sm-0" style="padding: 0;" placeholder="">
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213

                </div>


<<<<<<< HEAD
                <div class="col-sm-3 offset-0">
                    <label>End Date</label>
                </div>
                    <div class="col-sm-3 offset-0">
                    <input type="text" class="form-control col-sm-0 offset-0" id="inputAdress">
=======

 
                <div class="col-sm-0 offset-1">
                    <label>End Date</label>

                    <input type="date" class="col-sm-0 offset-0" style="padding: 0;" placeholder="">
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213

                </div>
            </div>

<<<<<<< HEAD
            <div class="row col-sm-12">

            <div class="col-sm-2 offset-5">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Filter</button>
                </div>
            </div>
=======


            <div class="row col-sm-12">

            <div class="col-sm-0 offset-6">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0  " style= " height:40px;
    width:60px;border-radius: 5px;">Filter</button>
                </div>

>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213


        </div>
            </div>




            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Date</th>
                        <th style='text-align:center'>Event</th>
                        <th style='text-align:center'>Site</th>
                        <th style='text-align:center'>Price</th>
<<<<<<< HEAD
=======
                        
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213
                    </tr>
                </thead>

                <tbody>

                </tbody>
            </table>

<<<<<<< HEAD
        <div class="container">
            <div class="col-sm-2 offset-5">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Back</button>
                </div>
            </div>
        </div>
=======
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213




    </form>


</body>



<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> ff067d7cd4da87ea8385643e1939bbe0a8dd8213
