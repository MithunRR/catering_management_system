<?php
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($conn);

// Sample order details (replace with your actual order data)
$order_details = array(
    array('Product 1', 20.00, 2),
    array('Product 2', 30.00, 1),
    // Add more products as needed
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zaika - Order Details</title>
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
            padding: 10px;
            width: 100%;
        }

        .order-details-container {
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
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

        .total-row {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="main-container">

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

        <div class="order-details-container" style="margin-top:70px !important;">
            <h2>Order Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total_amount = 0;
                    foreach ($order_details as $item) {
                        $product_name = $item[0];
                        $product_price = $item[1];
                        $quantity = $item[2];
                        $total = $product_price * $quantity;
                        $total_amount += $total;

                        echo "<tr>
                                <td>$product_name</td>
                                <td>$product_price</td>
                                <td>$quantity</td>
                                <td>$total</td>
                            </tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3">Total Amount</td>
                        <td><?php echo $total_amount; ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <footer id="footer">
            <h2>Zaika &copy; all rights reserved</h2>
        </footer>

    </div>

    <!-- JS and jQuery scripts remain the same -->

</body>

</html>
