<?php
// Retrieve the user ID and product ID from the request body
$data = json_decode(file_get_contents('php://input'), true);
$userID = $data['user_id'];
$productID = $data['product_id'];

// Connect to the database
$con = mysqli_connect("localhost", "root", "1234", "tesladb");
if (mysqli_connect_errno()) {
    echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
    exit();
}

// Remove the product from the cart
$query = "DELETE FROM Cart WHERE userID = '$userID' AND productID = '$productID'";
if (mysqli_query($con, $query)) {
    echo json_encode(array('success' => true, 'message' => 'Product removed from Cart successfully.'));
} else {
    echo json_encode(array('success' => false, 'message' => 'Failed to remove the product from Cart: ' . mysqli_error($con)));
}

// Close the database connection
mysqli_close($con);
?>
