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

    <meta http-equiv="refresh" content="3">

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
        <h1 class="h3 mb-3 font-weight-heavy" id="titleOfForm">Manage Site</h1>

        
        <div class="container">


            <div class="row">
                <div class="col-sm-6">

                    <label >Site</label>
                                        <select>
                        <option value="ALL">--ALL--</option>
                    </select>
                </div>


                <div class="col-sm-1 offset-0">
                    <label>Manager</label>
                </div>
                    <div class="col-sm-3 offset-1">
                                        <select>
                        <?php 
                            $result = $conn->query("SELECT Username FROM employee WHERE EmployeeType = 'Manager'");
                            
                            while ($row = $result->fetch()) {
                                echo "<option>" . $row['Username'] . "</option>";
                            }
                        ?>
                    </select>    
            </div>

            <div class="row">
                <div class="col-sm-7 offset-5">
                    <label>Open Everyday</label>

                    <select>
                        <option value="ALL">Yes</option>
                        <option value="ALL">No</option>
                    </select>

<!--                     <input type="text" class="col-sm-4" style="text-align: center;" placeholder="">
                    
                    <label> -- </label>

                    <input type="text" class="col-sm-4"  style="text-align: center;" placeholder=""> -->

                </div>


            <div class="row col-sm-12">

            <div class="col-sm-0 offset-2">
                    <button class="btn btn-sm btn-primary btn-block col-sm-0" style="border-radius: 5px;">Filter</button>
                </div>  

                <div class="col-sm-0 offset-2" style="text-align: right;">
                    <input id ="button" class="btn btn-sm btn-primary btn-block col-sm-0 offset-5"  type="submit" name="button" onclick="filter();" value="Create"/>
                  

                </div>


                <div class="col-sm-0 offset-1">
                    <input id ="button" class="btn btn-sm btn-primary btn-block col-sm-0 offset-7"  type="submit" name="button" onclick="myFunction();" value="Edit"/>
                </div>   
                 <div class="col-sm-0">
                    <input id ="button" class="btn btn-sm btn-primary btn-block offset-10"  type="submit" name="button" onclick="myFunction();" value="Delete"/>
                </div>               
            </div>
            

        </div>            
            </div>




            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Route</th>
                        <th style='text-align:center'>Transport Type</th>
                        <th style='text-align:center'>Price</th>
                        <th style='text-align:center'># Connected Sites</th>
                         <th style='text-align:center'># Transit Loggged</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                        $result = $conn->query("select 
                                                    transit.TransitRoute, 
                                                    transit.TransitType, 
                                                    transit.TransitPrice, 
                                                    count.Total 
                                                from transit inner join (select 
                                                                            sitename, 
                                                                            transitroute, 
                                                                            count(*) as total 
                                                                        from connect 
                                                                        group by transitroute) 
                                                count on transit.transitroute = count.transitroute;");

                        while ($row = $result->fetch()) {
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'> 
                                        <div class='radio'>
                                            <label><input type='radio' id='express' name='optradio'> " . $row['TransitRoute'] . "</label>
                                        </div>
                                    </td>";
                            echo "<td style='text-align:center'>" . $row['TransitType'] . "</td>";
                            echo "<td style='text-align:center'> $" . $row['TransitPrice'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['Total'] . "</td>";
                            echo "<tr>";
                        }
                    ?>

                </tbody>
            </table>





    </form>


</body>



</html>
