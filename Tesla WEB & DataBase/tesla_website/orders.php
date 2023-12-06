<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
?>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Tesla Shop(IL) Orders</title>
    <img src="photos/teslaLogo.jpg" alt="Main Logo" class="mainLogo">
</head>
<br>
<?php
include 'navbar_user.php';
?>
<hr class="separation">
<body>

</body>
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Get the user ID and role from the session
$userID = $_SESSION["user_id"];
$userRole = isset($_SESSION["user_role"]) ? $_SESSION["user_role"] : '';

// Check if the user is an admin
$isAdmin = ($userID == 1);

// Connect to the database
$con = mysqli_connect("localhost", "root", "1234", "tesladb");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

if ($isAdmin) {
    // Admin user, retrieve all orders
    $orderQuery = "SELECT *
                   FROM `Order`";
    $title = "All The Users Orders";

    // Add product form
echo "<h2>Add Product</h2>";
echo "<form action='addProduct.php' method='POST'>";
echo "<label for='productID'>Product ID:</label>";
echo "<input type='text' id='productID' name='productID' required><br>";
echo "<label for='productName'>Product Name:</label>";
echo "<input type='text' id='productName' name='productName' required><br>";
echo "<label for='productPrice'>Product Price:</label>";
echo "<input type='number' id='productPrice' name='productPrice' step='0.01' required><br>";
echo "<label for='productColor'>Product Color:</label>";
echo "<input type='text' id='productColor' name='productColor' required><br>";
echo "<label for='productWeight'>Product Weight:</label>";
echo "<input type='number' id='productWeight' name='productWeight' step='0.01' required><br>";
echo "<label for='productImage'>Product Image:</label>";
echo "<input type='text' id='productImage' name='productImage' required><br>";
echo "<label for='productQuantity'>Product Quantity in Stock:</label>";
echo "<input type='number' id='productQuantity' name='productQuantity' required><br>";
echo "<input type='submit' value='Add Product'>";
echo "</form>";


    echo "<br>";

    // Update product quantity form
    echo "<h2>Update Product Quantity</h2>";
echo "<form action='updateProductQuantity.php' method='POST'>";
echo "<label for='productID'>Product ID:</label>";
echo "<input type='text' id='productID' name='ID' required><br>";
echo "<label for='productQuantity'>Product Quantity:</label>";
echo "<input type='number' id='productQuantity' name='quantity' required><br>";
echo "<input type='submit' value='Update Quantity'>";
echo "</form>";

} else {
    // Regular user, retrieve only their own orders
    $orderQuery = "SELECT *
                   FROM `Order`
                   WHERE userID = '$userID'";
    $title = "Past Orders";
}

$orderResult = mysqli_query($con, $orderQuery);

// Check if there are any orders
if ($orderResult) {
    if (mysqli_num_rows($orderResult) > 0) {
        echo "<h2>$title</h2>";
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Order ID</th>";
        echo "<th>User ID</th>";
        echo "<th>Product ID</th>";
        echo "<th>Quantity</th>";
        echo "</tr>";

        // Loop through the orders and display them in a table
        while ($orderRow = mysqli_fetch_assoc($orderResult)) {
            echo "<tr>";
            echo "<td>" . $orderRow['orderID'] . "</td>";
            echo "<td>" . $orderRow['userID'] . "</td>";
            echo "<td>" . $orderRow['productID'] . "</td>";
            echo "<td>" . $orderRow['Quantity'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<h2>No orders found</h2>";
    }
} else {
    echo "Query error: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);

?>
</html>
