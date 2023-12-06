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
    // Check if all the required fields are provided
    if (isset($_POST['productID']) && isset($_POST['productName']) && isset($_POST['productPrice']) && isset($_POST['productColor']) && isset($_POST['productWeight']) && isset($_POST['productImage']) && isset($_POST['productQuantity'])) {
        // Sanitize the input
        $productID = $_POST['productID'];
        $productName = $_POST['productName'];
        $productPrice = $_POST['productPrice'];
        $productColor = $_POST['productColor'];
        $productWeight = $_POST['productWeight'];
        $productImage = $_POST['productImage'];
        $productQuantity = $_POST['productQuantity'];

        // Connect to the database
        $con = mysqli_connect("localhost", "root", "1234", "tesladb");
        if (mysqli_connect_errno()) {
            echo json_encode(array('success' => false, 'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()));
            exit();
        }

        // Insert the new product into the products table
        $insertQuery = "INSERT INTO Product (ID, name, price, weight, quantity) VALUES ('$productID', '$productName', $productPrice, $productWeight, $productQuantity)";
        $insertResult = mysqli_query($con, $insertQuery);

        if ($insertResult) {
            // Close the database connection
            mysqli_close($con);
            echo json_encode(array('success' => true));
            exit();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to add the product.'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Missing required fields.'));
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Unauthorized access.'));
}
?>
