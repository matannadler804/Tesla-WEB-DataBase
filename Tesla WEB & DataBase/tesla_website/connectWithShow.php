<?php
$con=mysqli_connect("localhost","root","1234","tesladb");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
  $result = mysqli_query($con,"SELECT * FROM Product");
echo "<table border='1'>
<tr>
<th>ID</th>
<th>Name</th>
 <th>Price</th>
 <th>Color</th>
 <th>Weight</th>
 <th>Image</th>
 <th>Quantity</th>
</tr>";

 while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['ID'] . "</td>";
echo "<td>" . $row['Name'] . "</td>";
echo "<td>" . $row['Price'] . "</td>";
echo "<td>" . $row['Color'] . "</td>";
echo "<td>" . $row['Weight'] . "</td>";
echo "<td>" . $row['Image'] . "</td>";
echo "<td>" . $row['Quantity'] . "</td>";
echo "</tr>";
}
echo "</table>";
echo"<br>";
$result2 = mysqli_query($con,"SELECT * FROM Users");

echo "<table border='1'>
<tr>
<th>FirstName</th>
<th>LastName</th>
 <th>Email</th>
 <th>ID</th>
 <th>Password</th>
 <th>Date</th>
</tr>";

while($row = mysqli_fetch_array($result2))
{
echo "<tr>";
echo "<td>" . $row['FirstName'] . "</td>";
echo "<td>" . $row['LastName'] . "</td>";
echo "<td>" . $row['Email'] . "</td>";
echo "<td>" . $row['ID'] . "</td>";
echo "<td>" . $row['Password'] . "</td>";
echo "<td>" . $row['Date'] . "</td>";
echo "</tr>";
}
echo "</table>";
echo"<br>";
$result3 = mysqli_query($con,"SELECT * FROM Cart");

echo "<table border='1'>
<tr>
<th>productID</th>
<th>userID</th>
 <th>Quantity</th>
</tr>";

while($row = mysqli_fetch_array($result3))
{
echo "<tr>";
echo "<td>" . $row['productID'] . "</td>";
echo "<td>" . $row['userID'] . "</td>";
echo "<td>" . $row['Quantity'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>
</body>
</html>