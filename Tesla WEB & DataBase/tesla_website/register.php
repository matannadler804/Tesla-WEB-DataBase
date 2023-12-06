<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Retrieve the form data and perform basic validation
  $firstName = validateInput($_POST["fname"]);
  $lastName = validateInput($_POST["lname"]);
  $email = validateInput($_POST["mail"]);
  $birthdate = validateInput($_POST["bdate"]);
  $userid = validateInput($_POST["userid"]);
  $password = validateInput($_POST["password"]);

  // Validate and sanitize the form data
  $errors = array();

  if (empty($firstName)) {
    $errors["fnameError"] = "Please enter your first name.";
  }

  if (empty($lastName)) {
    $errors["lnameError"] = "Please enter your last name.";
  }

  if (empty($email)) {
    $errors["emailError"] = "Please enter your email address.";
  }

  if (empty($birthdate)) {
    $errors["bdateError"] = "Please enter your birth date.";
  }

  if (empty($userid)) {
    $errors["useridError"] = "Please enter your user ID.";
  }

  if (empty($password)) {
    $errors["passwordError"] = "Please enter your password.";
  }

  if (!empty($errors)) {
    // Display the errors on the registration form
    foreach ($errors as $errorId => $errorMessage) {
      echo "<script>document.getElementById('$errorId').innerHTML = '$errorMessage';</script>";
    }
    exit();
  }

  // Sanitize the form data to prevent SQL injection
  $firstName = sanitizeInput($firstName);
  $lastName = sanitizeInput($lastName);
  $email = sanitizeInput($email);
  $birthdate = sanitizeInput($birthdate);
  $userid = sanitizeInput($userid);
  $password = sanitizeInput($password);

  // Connect to the database
  $con = mysqli_connect("localhost", "root", "1234", "tesladb");
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    return false;
  }

  // Prepare the SQL query to insert the user details into the database
  $query = "INSERT INTO Users (FirstName, LastName, Email, ID, Password, Date) VALUES ('$firstName', '$lastName', '$email', '$userid', '$password', '$birthdate')";

  // Execute the query
  if (mysqli_query($con, $query)) {
    // User registration successful
    $_SESSION["registrationSuccess"] = true;
    header("Location: login.php");
    exit();
  } else {
    echo "<script>alert('Failed to register.');</script>";
  }

  // Close the database connection
  mysqli_close($con);
}

// Function to validate input data
function validateInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Function to sanitize input data
function sanitizeInput($data) {
  $con = mysqli_connect("localhost", "root", "1234", "tesladb");
  $data = mysqli_real_escape_string($con, $data);
  mysqli_close($con);
  return $data;
}
?>
