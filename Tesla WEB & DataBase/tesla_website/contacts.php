
<html>
    <head>
        <script>
          //The submitForm() function performs form validation by calling validateName() and validateEmail() functions.
          // If both name and email inputs are valid, it creates a new div element with class "form-details-container"
          // and appends it to the form.
          // It then creates a header element with class "headers3" 
          //and sets its text content to "The form sent successfully with these details:".
          // It creates a paragraph element with class "form-field-details" and appends it to the form details container.
          // It retrieves values from various form fields (first name, last name, email, phone number, and message)
          // and appends them as bulleted list items to the field details paragraph.
          // Finally, if there are validation errors, it displays an alert with the error messages
          // and returns false to prevent form submission.
          function submitForm() {
            var isValidName = validateName();
            var isValidEmail = validateEmail();
            if (isValidName && isValidEmail) {
              var formDetails = document.createElement("div");
              formDetails.setAttribute("class", "form-details-container");
              var header = document.createElement("h1");
              header.setAttribute("class", "headers3");
              header.textContent = "The form sent succesfuly with these details:";
              formDetails.appendChild(header);
              var fieldDetails = document.createElement("p");
              fieldDetails.setAttribute("class", "form-field-details");
              var firstName = document.getElementById("fname").value;
              fieldDetails.innerHTML += "&bull; First Name: " + firstName + "<br>";
              var lastName = document.getElementById("lname").value;
              fieldDetails.innerHTML += "&bull; Last Name: " + lastName + "<br>";
              var email = document.getElementById("mail").value;
              fieldDetails.innerHTML += "&bull; Email: " + email + "<br>";
              var phone = document.getElementById("phone").value;
              fieldDetails.innerHTML += "&bull; Phone Number: " + phone + "<br>";
              var message = document.getElementById("message").value;
              fieldDetails.innerHTML += "&bull; Message: " + message;
              
              formDetails.appendChild(fieldDetails);
              var form = document.querySelector(".formContact");
              form.innerHTML = "";
              form.appendChild(formDetails);
            } else {
              var errorMessage = "";
              if (!isValidName) {
                errorMessage += "Name must be between 5 and 20 characters long.\n";
              }
              if (!isValidEmail) {
                errorMessage += "Please enter a valid email address.\n";
              }
              alert(errorMessage.trim());
            }
            return false;
}
//משתנה בשם "name" מכיל את הערך של שדה השם באלמנט עם המזהה "fname".
//בודקת אם אורך השם קטן מ-5 תווים או גדול מ-20 תווים.
//מחזירה ערך בוליאני "שקר" אם השם אינו תקין.
//מחזירה ערך בוליאני "אמת" אם השם תקין.
function validateName() {
  var name = document.getElementById("fname").value;
  if (name.length < 5 || name.length > 20) {
    
    return false;
  }
  return true;
}
//משתנה בשם "email" מכיל את הערך של שדה האימייל באלמנט עם המזהה "mail".
//בודקת אם סימן השטרודל "@" אינו קיים בכלל בכתובת האימייל או שהוא מופיע יותר מפעם אחת בכתובת.
//מחזירה ערך בוליאני "שקר" אם הכתובת אינה תקינה.
//מחזירה ערך בוליאני "אמת" אם הכתובת תקינה.
function validateEmail() {
  var email = document.getElementById("mail").value;
  if (email.indexOf("@") == -1 || email.indexOf("@") != email.lastIndexOf("@")) {
    
    return false;
  }
  return true;
}
        </script>

        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/loginCSS.css">
        <link rel="stylesheet" href="css/contacts.css">
        <title>Tesla Shop(IL) Contacts</title>
        <img src="photos/teslaLogo.jpg" alt="Main Logo" class="mainLogo">
    </head>
    <br>
    <?php
    include 'navbar_user.php';
?>
    <hr class="separation">
    <body>
        <img src="photos/longteslalogo.jpg" class="minorImgContact2">

        <hr class="separation2">
        <div id="c1" class="headerdivlogin"><h1 class="headers3">Contact Us</h1></div>
        <hr class="separation2">
        <form class="formContact">
            <label for="fname"><i class="fa fa-address-book-o" aria-hidden="true"></i> First Name:</label><br>
            <input type="text" id="fname" name="fname"><br>
            <label for="lname"><i class="fa fa-id-card" aria-hidden="true"></i> Last Name:</label><br>
            <input type="text" id="lname" name="lname"><br>
            <label for="mail"><i class="fa fa-envelope" aria-hidden="true"></i> Email:</label><br>
            <input type="text" id="mail" name="mail"><br>
            <label for="phone"><i class="fa fa-mobile" aria-hidden="true"></i> Phone Number:</label><br>
            <input type="text" id="phone" name="phone"><br>
            <br>
            <textarea id="message" name="message" rows="5" cols="50" style="resize: none;">Type here...</textarea><br>
            <br>
            <div class="topnav2"> 
                <button onclick="submitForm();">Send</button> 
            </div>
            <br>
            <div class="topnav2"> 
                <a href="contacts.html" style="background-color: rgb(130, 0, 26); color: white;">Cancel</a> 
            </div>
            <br>
        </form>
        <hr class="separation2">
        <img src="photos/contact.png" class="minorImgContact">
    </body>
    <hr class="separation">
</html>