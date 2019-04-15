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



            <div class="row">

                <div class="col-sm-12">

                        <label class="col-sm-0">Site</label>
                    <select style="margin-left: 0em;">
                        <option value="ALL">--ALL--</option>
               
                    </select>
                    <label>Manager</label>
                    <select style="margin-left: 0em;">
                        <option value="ALL">--ALL--</option>


                    </select>

                </div>
            <div class="row">
                <div class="col-sm-12 offset-10">
                        <label>Open Everyday</label>
                    <select style="margin-left: 1em;">
                        <option value="Yes">Yes</option>
                         <option value="No">No</option>
               
                    </select>


                    </select>

                </div>

            </div>


            <div class="form-row">'
                <div class="form-group row col-sm-12">
                    <button type="submit" class="btn btn-primary offset-2" id="backButton">Filter</button>
                    <button type="submit" class="btn btn-primary offset-1" id="registerButton">Create</button>
                    <button type="submit" class="btn btn-primary offset-1" id="registerButton">Edit</button>
                    <button type="submit" class="btn btn-primary offset-1" id="registerButton">Delete</button>
                </div>




            <table id="test" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th style='text-align:center'>Name</th>
                        <th style='text-align:center'>Manager</th>
                        <th style='text-align:center'>Site</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $result = $conn->query("select 
                                                    site.Sitename, 
                                                    site.ManagerUsername,
                                                    site.OpenEveryday from site
                                                    
                                                
                                                ;");

                        while ($row = $result->fetch()) {
                            echo "<tr>";
                            echo    "<td style='padding-left:2.4em;'> 
                                        <div class='radio'>
                                            <label><input type='radio' id='express' name='optradio'> " . $row['Sitename'] . "</label>
                                        </div>
                                    </td>";

                            echo "<td style='text-align:center'> " . $row['ManagerUsername'] . "</td>";
                            echo "<td style='text-align:center'>" . $row['OpenEveryday'] . "</td>";
                         
                            echo "<tr>";
                        }
                    ?>

                </tbody>
            </table>


            <div class="form-row">'
                <div class="form-group row col-sm-12 offset-11">
                    <button type="submit" class="btn btn-primary" id="backButton">Back</button>
                   
               
            </div>
            </div>

        </div>

    </form>

</body>

</html>