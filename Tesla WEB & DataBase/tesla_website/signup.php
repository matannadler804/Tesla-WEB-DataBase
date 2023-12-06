<html>
<head>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/loginCSS.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>Tesla Shop(IL) Sign Up</title>
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
    <script>
        // Client-side validation
        window.addEventListener('DOMContentLoaded', (event) => {
            const form = document.querySelector('.formSignUp');
            form.addEventListener('submit', (event) => {
                const firstNameInput = document.getElementById('fname');
                const lastNameInput = document.getElementById('lname');
                const birthdateInput = document.getElementById('bdate');
                let valid = true;
                if (firstNameInput.value.trim() === '') {
                    document.getElementById('fnameError').textContent = 'Please enter your first name.';
                    valid = false;
                }
                if (lastNameInput.value.trim() === '') {
                    document.getElementById('lnameError').textContent = 'Please enter your last name.';
                    valid = false;
                }
                if (birthdateInput.value.trim() === '') {
                    document.getElementById('bdateError').textContent = 'Please enter your birth date.';
                    valid = false;
                }
                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</head>

<body>
<?php
    include 'navbar_user.php';
?>
    <hr class="separation">
    <div class="headerdiv1">
        <h1 class="headers3">Sign-Up Form</h1>
    </div>
    <hr class="separation1">
    <form class="formSignUp" action="register.php" method="POST">
        <br>
        <img src="photos/register.png" class="iconImg">
        <br>
        <p1 class="headers2">Personal Information:</p1>
        <br><br>
        <label for="fname"><i class="fa fa-address-book-o" aria-hidden="true"></i> First Name:</label><br>
        <input type="text" id="fname" name="fname" required>
        <span class="error" id="fnameError"></span><br>

        <label for="lname"><i class="fa fa-id-card" aria-hidden="true"></i> Last Name:</label><br>
        <input type="text" id="lname" name="lname" required>
        <span class="error" id="lnameError"></span><br>

        <br>
        <label for="mail"><i class="fa fa-envelope" aria-hidden="true"></i> Email:</label><br>
        <input type="text" id="mail" name="mail" required> <br>
        <br>
        <label for="bdate"><i class="fa fa-calendar" aria-hidden="true"></i> Birth Date:</label><br>
        <input type="date" id="bdate" name="bdate" required>
        <span class="error" id="bdateError"></span>
        <br>
        <br>
        <br>
        <p1 class="headers2">Website Information:</p1>
        <br><br>
        <label for="userid"><i class="fa fa-user" aria-hidden="true"></i> ID:</label><br>
        <input type="text" id="userid" name="userid" required><br>
        <br>
        <label for="password"><i class="fa fa-key" aria-hidden="true"></i> Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        <label for="password2"><i class="fa fa-key" aria-hidden="true"></i> Enter password again:</label><br>
        <input type="password" id="password2" name="password2" required><br>
        <br><br>
        <label for="roboTest"><i class="fa fa-android" aria-hidden="true"></i> I'm not a Robot:</label>
        <input type="checkbox" id="roboTest" name="robotTest">
        <br>
        <img src="photos/robot.jpg" class="tinyiconImg"><br>
        <br>
        <div class="topnav2">
            <button type="submit">Register</button>
        </div>
        <br>
        <div class="topnav2"> 
            <a href="signup.php" style="background-color: rgb(130, 0, 26); color: white;">Cancel</a> 
        </div>
        <br>
    </form>
    
</body>

</html>
