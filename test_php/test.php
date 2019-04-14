<?php
$servername = "localhost";
$username = "root";
$password = "1234";
global $conn;
try {
   $conn = new PDO("mysql:host=$servername;dbname=company", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }



echo "<table border='1'>
<tr>
<th>Fname</th>
<th>lname</th>
<th>ssn</th>
<th>bdate</th>
<th>address</th>
<th>sex</th>
<th>salary</th>
<th>supersnn</th>
<th>dno</th>

</tr>";

$result = $conn->query("SELECT * FROM employee");
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
echo "</table>";


?>