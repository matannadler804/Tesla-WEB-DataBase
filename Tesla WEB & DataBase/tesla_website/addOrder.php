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

// Check if there are any items in the cart for the user
$cartQuery = "SELECT * FROM Cart WHERE userID = '$userID'";
$cartResult = mysqli_query($con, $cartQuery);

if (mysqli_num_rows($cartResult) > 0) {
    // Start a transaction for atomicity
    mysqli_autocommit($con, false);

    // Insert the cart items into the Order database
    $orderQuery = "INSERT INTO `Order` (userID, productID, Quantity) SELECT '$userID', productID, Quantity FROM Cart WHERE userID = '$userID'";
    $orderResult = mysqli_query($con, $orderQuery);

    if ($orderResult) {
        // Delete the cart items after adding them to the Order database
        $deleteQuery = "DELETE FROM Cart WHERE userID = '$userID'";
        $deleteResult = mysqli_query($con, $deleteQuery);

        if ($deleteResult) {
            // Commit the transaction
            mysqli_commit($con);

            // Close the database connection
            mysqli_close($con);

            // Return a success response
            echo json_encode(array('success' => true));
            exit();
        }
    }

    // Rollback the transaction if any error occurred
    mysqli_rollback($con);
}

// Close the database connection
mysqli_close($con);

// No items in the cart or error occurred, return an error response
echo json_encode(array('success' => false, 'message' => 'Failed to add products to Order.'));
?>
