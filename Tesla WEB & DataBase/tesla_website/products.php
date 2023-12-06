<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // User is not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$userID = $_SESSION["user_id"];

// Check if user is logged out
if (isset($_SESSION["logout_success"]) && $_SESSION["logout_success"]) {
    // Display logout message
    echo "<script>alert('Logout successful!');</script>";
    // Unset the session variable to prevent displaying the message again on page refresh
    unset($_SESSION["logout_success"]);
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Connect to the database
$con = mysqli_connect("localhost", "root", "1234", "tesladb");
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <style id="dynamicStyle"></style>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/productsStyle.css">
    <title>Tesla Shop(IL) Products</title>
    <img src="photos/teslaLogo.jpg" alt="Main Logo" class="mainLogo">
</head>
<br>
<?php
    include 'navbar_user.php';
?>
<hr class="separation">
<body>
    <h1 class="headers1">Our Shop:</h1>
    <p class="mainInfo">Welcome to our shop<br>
    Here you can find all Tesla Type vehicles in our disposal<br>
    <br></p>
    <hr class="separation">
    <button onclick="toggleHighestPricedCar()">Show Highest-Priced Car</button>
    <button onclick="changeStyle()">Change Style</button>
    <br>
    <div id="carDetails"></div>
</body>
<br>
<body class="mainInfo">
    <table class="mainInfo" id="carTable">
        <thead>
            <tr>
                <th>Car ID</th>
                <th>Car Name</th>
                <th>Price</th>
                <th>Color</th>
                <th>Weight</th>
                <th>Image</th>
                <th>Button</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="carDetails"></div>
</body>
<br>
<hr class="separation">
<script>
    // Sample array of car objects
    const cars = [
        { id: 1, name: 'Tesla Model Y', price: 300000, color: 'red', weight: '2000kg', image: 'photos/TeslaY.jpg', button: '<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>' },
        { id: 2, name: 'Tesla Model X', price: 333000, color: 'blue', weight: '2500kg', image: 'photos/carsForSale/TeslaX.jpg', button: '<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>' },
        { id: 3, name: 'Tesla Model 3', price: 200000, color: 'green', weight: '1800kg', image: 'photos/carsForSale/Model3.jpg', button: '<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>' },
        { id: 4, name: 'Tesla Model S', price: 500000, color: 'yellow', weight: '3000kg', image: 'photos/carsForSale/ModelS.png', button: '<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>' },
        { id: 5, name: 'Tesla Semi Truck', price: 650000, color: 'white', weight: '12,000kg', image: 'photos/carsForSale/TeslaSemi.jpg', button: '<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>' },
        { id: 6, name: 'Tesla Cybertruck', price: 240000, color: 'grey', weight: '2700kg', image: 'photos/carsForSale/Cyber.jpg', button: '<div class="cart-action"><input type="text" class="product-quantity" name="quantity" value="1" size="2" /><input type="submit" value="Add to Cart" class="btnAddAction" /></div>' },
    ];

    // Sort the array of cars by price in ascending order
    cars.sort((a, b) => a.price - b.price);

    // Loop through the array of cars and create a new row for each car
    // ...

// Loop through the array of cars and create a new row for each car
const tbody = document.querySelector('#carTable tbody');
cars.forEach(car => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>${car.id}</td>
        <td>${car.name}</td>
        <td>${car.price}</td>
        <td>${car.color}</td>
        <td>${car.weight}</td>
        <td><img src="${car.image}" alt="${car.name}" style="max-width: 200px;"></td>
        <td>${car.button}</td>
    `;
    const addButton = tr.querySelector('.btnAddAction');
    addButton.addEventListener('click', () => {
        if (isLoggedIn()) {
            addToCart(car.id, addButton);
        } else {
            alert('Please log in to add items to the cart.');
        }
    });
    tbody.appendChild(tr);
});

function addToCart(productID, button) {
    if (!isLoggedIn()) {
        alert('Please log in to add items to the cart.');
        return;
    }

    // Get the quantity value from the input field
    const quantityInput = button.previousElementSibling;
    const quantity = parseInt(quantityInput.value);

    // Validate the quantity
    if (isNaN(quantity) || quantity <= 0) {
        alert('Please enter a valid quantity.');
        return;
    }

    // Create the request payload
    const payload = {
        product_id: productID,
        quantity: quantity
    };

    // Send the request to the server
    fetch('addToCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
        .then(response => response.text()) // change to response.text()
        .then(data => {
            console.log(data); // log the response to the console
            // Handle the response from the server
            try {
                const jsonData = JSON.parse(data);
                if (jsonData.success) {
                    alert('Product added to cart successfully.');
                } else {
                    alert('Failed to add product to cart: ' + jsonData.message);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error);
                alert('An error occurred while adding the product to cart.');
            }
        })
        .catch(error => {
            console.log('Error:', error);
            alert('An error occurred while adding the product to cart.');
        });
}


// ...



    function isLoggedIn() {
        
        return true; 
    }

    function toggleHighestPricedCar() {
        const carTable = document.querySelector('#carTable');
        const rows = carTable.querySelectorAll('tr');
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const priceCell = cells[2];
            priceCell.classList.toggle('hidden');
        });
    }

    function changeStyle() {
        const dynamicStyle = document.querySelector('#dynamicStyle');
        dynamicStyle.textContent = `
            body {
                background-color: lightgray;
                font-family: Arial, sans-serif;
            }
            .mainInfo {
                color: darkblue;
            }
            .headers1 {
                text-align: center;
                font-size: 28px;
            }
            .separation {
                margin-top: 50px;
                margin-bottom: 50px;
            }
            .hidden {
                display: none;
            }
        `;
    }
</script>
</html>
