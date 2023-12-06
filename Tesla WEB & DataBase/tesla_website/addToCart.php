<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // User is not logged in, return an error response
    echo json_encode(array('success' => false, 'message' => 'User is not logged in.'));
    exit();
}

// Get the user ID from the session
$userID = $_SESSION["user_id"];

// Get the product ID and quantity from the request payload
$data = json_decode(file_get_contents('php://input'), true);
$productID = $data['product_id'];
$quantity = $data['quantity'];

// Connect to the database
$con = mysqli_connect("localhost", "root", "1234", "tesladb");
if (mysqli_connect_errno()) {
    // Failed to connect to the database, return an error response
    echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit();
}

// Prepare the query to insert the product into the user's cart
$query = "INSERT INTO cart (productID, userID, Quantity) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, 'iii', $productID, $userID, $quantity);

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    // Product added to cart successfully, return a success response
    echo json_encode(array('success' => true));
} else {
    // Failed to add product to cart, return an error response
    $error_message = 'Failed to add product to cart: ' . mysqli_stmt_error($stmt);
    error_log($error_message); // Log the error message to the PHP error log
    echo json_encode(array('success' => false, 'message' => $error_message));
}

// Close the statement and database connection
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
