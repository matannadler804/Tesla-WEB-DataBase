<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // User is not logged in, return an error response
    echo json_encode(array('success' => false, 'message' => 'User is not logged in.'));
    exit();
}

// Get the user ID from the session
$userID = $_SESSION["user_id"];

// Connect to the database
$con = mysqli_connect("localhost", "root", "1234", "tesladb");
if (mysqli_connect_errno()) {
    // Failed to connect to the database, return an error response
    echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit();
}

// Prepare the query to fetch the user's cart
$query = "SELECT c.*, p.name, p.price FROM cart c
          INNER JOIN products p ON c.product_id = p.product_id
          WHERE c.user_id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'i', $userID);

// Execute the query
mysqli_stmt_execute($stmt);

// Get the result set
$result = mysqli_stmt_get_result($stmt);

// Fetch the cart items into an array
$cart = array();
while ($row = mysqli_fetch_assoc($result)) {
    $cart[] = $row;
}

// Return the cart as a JSON response
echo json_encode(array('success' => true, 'cart' => $cart));

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
