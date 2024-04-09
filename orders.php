<?php
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($conn);

// Fetch all customers for the particular user_id
$sql_customers = "SELECT * FROM customers WHERE user_id = ? ORDER BY id DESC";
$stmt_customers = $conn->prepare($sql_customers);
$stmt_customers->bind_param("i", $user_data['id']);
$stmt_customers->execute();
$result_customers = $stmt_customers->get_result();

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

        th,
        td {
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

        <div style="margin-top: 70px !important; width:100%">

        <?php
        // Loop through each customer
        while ($customer_row = $result_customers->fetch_assoc()) {
            $customer_id = $customer_row['id'];
            $name = $customer_row['name'];
            $mo_no = $customer_row['mo_no'];
            $address = $customer_row['address'];
            $count = $customer_row['count'];

            // Fetch order details for this customer
            $sql_orders = "SELECT * FROM orders WHERE customer_id = ?";
            $stmt_orders = $conn->prepare($sql_orders);
            $stmt_orders->bind_param("i", $customer_id);
            $stmt_orders->execute();
            $result_orders = $stmt_orders->get_result();
        ?>
            <div class="order-details-container" style="margin: auto; margin-top: 7px !important;">

                <h2>Order Details - <?php echo $customer_id ?> </h2>
                <p>Date: <?php echo date('d-m-Y'); ?></p>
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
                        // Display order details for this customer
                        $total_amount = 0;
                        while ($order_row = $result_orders->fetch_assoc()) {
                            $product_name = $order_row['product_name'];
                            $product_price = $order_row['price'];
                            $quantity = $order_row['quantity'];
                            $total = $product_price * $quantity;
                            $total_amount += $total;

                            echo "<tr>
                                    <td>$product_name</td>
                                    <td> &#8377;$product_price</td>
                                    <td>$quantity</td>
                                    <td> &#8377;$total</td>
                                </tr>";
                        }
                        ?>
                        <tr style="border-bottom: 2px solid black" class="total-row">
                            <td colspan="4">Total Amount: &#8377;<?php echo $total_amount; ?></td>
                        </tr>
                    </tbody>
                </table>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Address</th>
                        <th>Plate Count</th>
                    </tr>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $mo_no; ?></td>
                        <td><?php echo $address; ?></td>
                        <td><?php echo $count; ?></td>
                    </tr>
                </table>
            </div>
            <br>
        <?php
        } // End of customer loop
        ?>

        </div>


        <footer id="footer">
            <h2>Zaika &copy; all rights reserved</h2>
        </footer>

    </div>

    <!-- JS and jQuery scripts remain the same -->

</body>

</html>
