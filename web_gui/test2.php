<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
          
            table, th, td{

            	border: 1px solid black;


            }
            td{
            	text-align: center;
            }
            th{
            	background-color: #008000;
  				color: white;
            }
            tr:hover {background-color: #f5f5f5;}


        </style>
        <script>
        </script>
        <title>

        </title>
    </head>
    <body>
    	<h1>
            All Employees
            </h1>
        <?php
$servername = "localhost";
$username = "root";
$password = "1234";
global $conn;
try {
   $conn = new PDO("mysql:host=$servername;dbname=company", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
            $result = $conn->query("SELECT * FROM employee");
        ?>

        <table class=>
            <tr class="header">
                <th>fname</th>
                <th>lname</th>
                <th>ssn</th>
                <th>bdate</th>
                <th>address</th>
                <th>sex</th>
                <th>salary</th>
                <th>superssn</th>
                <th>dno</th>
                

            </tr>
            <?php
              
               while ($row = $result->fetch()) {
    


echo "<tr>";

echo "<td>" . $row['fname'] . "</td>";
echo "<td>" . $row['lname'] . "</td>";
echo "<td>" . $row['ssn'] . "</td>";
echo "<td>" . $row['bdate'] . "</td>";
echo "<td>" . $row['address'] . "</td>";
echo "<td>" . $row['sex'] . "</td>";
echo "<td>" . $row['salary'] . "</td>";
echo "<td>" . $row['superssn'] . "</td>";
echo "<td>" . $row['dno'] . "</td>";

echo "</tr>";
}

            ?>
        </table>
    </body>
</html>