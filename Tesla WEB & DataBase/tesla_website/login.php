<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Retrieve the user ID and password from the form submission
  $userID = $_POST["ID"];
  $password = $_POST["Password"];

  // Connect to the database
  $con = mysqli_connect("localhost", "root", "1234", "tesladb");
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    return false;
  }

  // Prepare the SQL query to retrieve the user with the provided ID
  $query = "SELECT * FROM Users WHERE ID = '$userID' LIMIT 1";

  $result = mysqli_query($con, $query);
  $user = mysqli_fetch_assoc($result);

  // Check if the user exists and the password is correct
  if ($password == $user["Password"]) {
    // Start a new session
    session_start();

    // Set a flag to indicate login success
    $loginSuccess = true;

    // Store the user ID in the session, so the cart will see each user's cart
    $_SESSION["user_id"] = $user["ID"];

    // Create a new cart for the user if it doesn't already exist
    if (!isset($_SESSION["cart"])) {
      $_SESSION["cart"] = array();
    }

    // Store the success message in a session variable
    $_SESSION["login_success"] = true;

    // Redirect to the home page after the login worked
    header("Location: home.php");
    exit();
  } else {
    // Invalid user ID or password because the details are wrong
    echo "<script>alert('Incorrect user ID or password.');</script>";
  }

  // Close the database connection
  mysqli_close($con);
}
?>

<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/loginCSS.css">
    <title>Tesla Shop(IL) Login</title>
    <img src="photos/teslaLogo.jpg" alt="Main Logo" class="mainLogo">
</head>
<br>
<?php
  include 'navbar_user.php';

?>
<hr class="separation">
<body>
    <img src="photos/teslaLogin.png" class="minorImg2">
    <br>
    <div class="headerdivlogin">
        <h1 class="headers3">Sign-In</h1>
    </div>
    <hr class="separation2">

    <?php if (isset($loginSuccess) && $loginSuccess) : ?>
    <script>
        alert("Login successful!"); // Display success message
        window.location.href = "home.php"; // Redirect to home page
    </script>
    <?php elseif (isset($loginSuccess) && !$loginSuccess) : ?>
    <script>
        alert("Incorrect user ID or password."); // Display error message
    </script>
    <?php endif; ?>

    <form class="form" method="POST" action="login.php" id="loginForm">
    <!-- Your existing form fields -->
    <br>
    <label for="ID"><i class="fa fa-address-book-o" aria-hidden="true"></i> User ID:</label><br>
    <input type="text" id="ID" name="ID">
    <br>
    <label for="Password"><i class="fa fa-key" aria-hidden="true"></i> Password:</label><br>
    <input type="password" id="Password" name="Password">
    <br>
    <br>
    <label for="checkIn">
        <i class="fa fa-star" aria-hidden="true"> Remember me</i>
        <input type="checkbox" id="checkIn" name="checkIn">
    </label>
    <div class="topnav2"> 
        <button type="submit">Sign-In</button> 
        <button type="button" onclick="logout()">Logout</button>
    </div>
    <input type="hidden" id="logoutAction" name="action" value="">
</form>

<script>
    function logout() {
        document.getElementById("logoutAction").value = "logout";
        document.getElementById("loginForm").action = "logout.php";
        document.getElementById("loginForm").submit();
    }
</script>

    <br>
    <div class="topnav2"> 
        <a href="home.html" style="background-color: rgb(130, 0, 26); color: white;">Cancel</a> 
    </div>
    <br>
    <hr class="separation2">
    <br>
    <img src="photos/teslaDrivingLogin.png" class="minorImg">
</body>
<hr class="separation">
</html>
