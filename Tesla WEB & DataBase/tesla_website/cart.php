<?php
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
?>
<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Tesla Shop(IL) About Us</title>
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

// Get the user ID from the session
$userID = $_SESSION["user_id"];

// Check if user is logged out
if (isset($_SESSION["logout_success"]) && $_SESSION["logout_success"]) {
    // Display logout message
    echo "<script>alert('Logout successful!');</script>";
    // Unset the session variable to prevent displaying the message again on page refresh
    unset($_SESSION["logout_success"]);
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Connect to the database
$con = mysqli_connect("localhost", "root", "1234", "tesladb");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}

// Retrieve the user's cart from the database
$query = "SELECT * FROM Cart WHERE userID = '$userID'";
$result = mysqli_query($con, $query);

// Check if there are any items in the cart
if (mysqli_num_rows($result) > 0) {
    echo "<h2>User ID: $userID Cart</h2>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Product ID</th>";
    echo "<th>Quantity</th>";
    echo "<th>Action</th>"; // Add a new column for the action buttons
    echo "</tr>";

    // Loop through the cart items and display them in a table
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['productID'] . "</td>";
        echo "<td>" . $row['Quantity'] . "</td>";
        echo "<td><button onclick='addToOrder(" . $row['productID'] . ")'>Add to Order</button> <button onclick='removeFromCart(" . $row['productID'] . ")'>Remove from Cart</button></td>"; // Add the buttons column
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<h2>No items in the cart</h2>";
}


?>
<script>
function addToOrder(productID) {
    // Send a request to the server to add the product to the Order database
    fetch('addOrder.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_id: <?php echo $userID; ?>, product_id: productID })
    })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server
            if (data.success) {
                alert('Product added to Order successfully.');
                // Optionally, you can reload the page to update the cart contents
                location.reload();
            } else {
                alert('Failed to add the product to Order: ' + data.message);
            }
        })
        .catch(error => {
            console.log('Error:', error);
            alert('An error occurred while adding the product to Order.');
        });
}

function removeFromCart(productID) {
    // Send a request to the server to remove the product from the Cart database
    fetch('removeFromCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user_id: <?php echo $userID; ?>, product_id: productID })
    })
        .then(response => response.json())
        .then(data => {
            // Handle the response from the server
            if (data.success) {
                alert('Product removed from Cart successfully.');
                // Optionally, you can reload the page to update the cart contents
                location.reload();
            } else {
                alert('Failed to remove the product from Cart: ' + data.message);
            }
        })
        .catch(error => {
            console.log('Error:', error);
            alert('An error occurred while removing the product from Cart.');
        });
}
</script>
<hr class="separation">
<?php
// Close the database connection
mysqli_close($con);
?>
</html>
