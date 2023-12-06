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

if ($isAdmin) {
    // Check if the product ID and quantity are provided
    if (isset($_POST['ID']) && isset($_POST['quantity'])) {
        // Sanitize the input
        $productID = $_POST['ID'];
        $quantity = $_POST['quantity'];

        // Connect to the database
        $con = mysqli_connect("localhost", "root", "1234", "tesladb");
        if (mysqli_connect_errno()) {
            echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
            exit();
        }

        // Update the product quantity in the products table
        $updateQuery = "UPDATE Product SET quantity = $quantity WHERE ID = '$productID'";
        $updateResult = mysqli_query($con, $updateQuery);

        if ($updateResult) {
            // Close the database connection
            mysqli_close($con);
            echo json_encode(array('success' => true, 'message' => 'Product quantity updated successfully.'));
            exit();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update product quantity.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Missing product ID or quantity.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Unauthorized access.'));
}
?>
