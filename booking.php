<?php
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zaika</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assset/css/style.css" />

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        nav.navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            background-color: #fff; /* Adjust the background color as needed */
        }

        #footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        table {
          border-collapse: collapse;
          width: 80%;
          margin: 20px;
          background-color: #fff;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
          padding: 15px;
          text-align: left;
          border-bottom: 1px solid #ddd;
        }

        th {
          background-color: #f2f2f2;
        }

        .quantity input {
          width: 30px;
          text-align: center;
        }

        .quantity button {
          background-color: #4caf50;
          color: #fff;
          border: none;
          padding: 5px 10px;
          cursor: pointer;
        }

        .quantity button:hover {
          background-color: #45a049;
        }

        .total-row {
          font-weight: bold;
        }

        .customer-details {
          width: 80%;
          margin: 20px;
        }

        .customer-details input {
          width: 100%;
          padding: 10px;
          margin-bottom: 10px;
        }

        .checkout-btn {
          background-color: #ff884d;
          color: #000;
          border: none;
          padding: 16px 20px;
          margin-top:20px;
          font-size: 16px;
          font-weight: bold;
          cursor: pointer;
          border-top: 1px solid black;
        }

        .checkout-btn:hover {
          background-color: #ff7733;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-container container">
            <input type="checkbox" name="" id="">
            <div class="hamburger-lines">
                <span class="line line1"></span>
                <span class="line line2"></span>
                <span class="line line3"></span>
            </div>
            <ul class="menu-items">
                <li><a href="index.php">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#food">Trending</a></li>
                <li><a href="#food-menu">Menu</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="orders.php">Bookings</a></li>
                <li><a href="booking.php">Cart</a></li>
                <?php
                if ($user_data) {
                    echo '<li>Hi, ' . $user_data['f_name'] . '.</li>';
                    echo '<li><a href="logout.php" style="color:red">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="signup.php">Signup</a></li>';
                }
                ?>
                
            </ul>
            <h1 class="logo">Zaika</h1>
        </div>
    </nav>
    
    <table style="margin:70px auto 20px auto !important;">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Product 1</td>
                <td>$20.00</td>
                <td class="quantity">
                <button onclick="decreaseQuantity(this)">-</button>
                <input type="text" value="1">
                <button onclick="increaseQuantity(this)">+</button>
                </td>
                <td>$20.00</td>
                <td><button style="cursor:pointer; color:red; font-size:16px; border:none; width:30px; height:30px; background:none;">
                        <i class="ti-view-list-alt menu-icon fa fa-trash" aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
        <!-- Add more rows as needed -->
        </tbody>
    </table>

  <div class="total-row" style="margin:10px auto !important;">
    <span>Grand Total: $20.00</span>
  </div>

  <div class="customer-details" style="margin:10px auto !important;">
        <h2>Customer Details</h2>
        <input type="text" placeholder="Name">
        <input type="text" placeholder="Mobile Number">
        <input type="text" placeholder="Address">
        <input type="text" placeholder="Plate Count">
        <input type="date" placeholder="Date">
  </div>

  <button class="checkout-btn">Place Order</button>


    <footer id="footer">
        <h2 style="font-size: 25px !important; padding:10px">Zaika &copy; all rights reserved</h2>
    </footer>
    <!-- .................../ JS Code for smooth scrolling /...................... -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assset/js/script.js"></script>

    <script>
    function increaseQuantity(button) {
      var input = button.previousElementSibling;
      input.value = parseInt(input.value) + 1;
      updateTotal(input);
    }

    function decreaseQuantity(button) {
      var input = button.nextElementSibling;
      if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        updateTotal(input);
      }
    }

    function updateTotal(input) {
      var price = parseFloat(input.parentNode.previousElementSibling.textContent.replace('$', ''));
      var total = price * parseInt(input.value);
      input.parentNode.nextElementSibling.textContent = '$' + total.toFixed(2);
      updateGrandTotal();
    }

    function updateGrandTotal() {
      var totalElements = document.querySelectorAll('.total-row td:last-child');
      var grandTotal = 0;
      totalElements.forEach(function (element) {
        grandTotal += parseFloat(element.textContent.replace('$', ''));
      });
      document.querySelector('.total-row span').textContent = 'Grand Total: $' + grandTotal.toFixed(2);
    }
  </script>

</html>

</body>

</html>