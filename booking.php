<?php
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($conn);

if (!$user_data) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['place_order'])) {
      // Retrieve customer details from the form
      $name = $_POST['name'];
      $mo_no = $_POST['mo_no'];
      $address = $_POST['address'];
      $count = $_POST['count'];
      $order_date = $_POST['date'];
      
        // Insert customer details into 'customers' table
        $sql_insert_customer = "INSERT INTO customers (name, mo_no, address, count, date, user_id, order_date) 
                                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt_insert_customer = $conn->prepare($sql_insert_customer);
        $stmt_insert_customer->bind_param("sssssi", $name, $mo_no, $address, $count, $order_date, $user_data['id']);
        $stmt_insert_customer->execute();

        // Get the last inserted customer ID
        $customer_id = $conn->insert_id;

        // Retrieve cart items from the database
        $sql_cart = "SELECT * FROM cart WHERE user_id = ?";
        $stmt_cart = $conn->prepare($sql_cart);
        $stmt_cart->bind_param("i", $user_data['id']);
        $stmt_cart->execute();
        $result_cart = $stmt_cart->get_result();

        // Insert each cart item into 'orders' table
        while ($row_cart = $result_cart->fetch_assoc()) {
            $product_name = $row_cart['name'];
            $price = $row_cart['price'];
            $quantity = $row_cart['quantity'];

            // Insert each order with the customer ID
            $sql_insert_order = "INSERT INTO orders (product_name, price, quantity, user_id, customer_id) 
                                VALUES (?, ?, ?, ?, ?)";
            $stmt_insert_order = $conn->prepare($sql_insert_order);
            $stmt_insert_order->bind_param("ssdii", $product_name, $price, $quantity, $user_data['id'], $customer_id);
            $stmt_insert_order->execute();
        }

      // Clear the cart after placing the order
      $sql_clear_cart = "DELETE FROM cart WHERE user_id = ?";
      $stmt_clear_cart = $conn->prepare($sql_clear_cart);
      $stmt_clear_cart->bind_param("i", $user_data['id']);
      $stmt_clear_cart->execute();

      // Redirect to a success page or display a success message
      header("Location: index.php");
      exit();
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['decrease'])) {
        $cart_id = $_POST['decrease'];
        updateQuantity($conn, $cart_id, -1);
    }
    if (isset($_POST['increase'])) {
        $cart_id = $_POST['increase'];
        updateQuantity($conn, $cart_id, 1);
    }
    if (isset($_POST['delete'])) {
        $cart_id = $_POST['delete'];
        deleteCartItem($conn, $cart_id);
    }
}

function updateQuantity($conn, $cart_id, $change) {
    $sql_select = "SELECT quantity FROM cart WHERE id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param("i", $cart_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $quantity = $row['quantity'] + $change;
        if ($quantity < 1) {
            $quantity = 1;
        }
        $sql_update = "UPDATE cart SET quantity = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $quantity, $cart_id);
        $stmt_update->execute();
    }
}

function deleteCartItem($conn, $cart_id) {
    $sql_delete = "DELETE FROM cart WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $cart_id);
    $stmt_delete->execute();
}
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

        th,
        td {
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
            margin-top: 20px;
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

    <form method="post">
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
            <?php
            $grandTotal = 0;
            $userId = $user_data['id'];
            $sql = "SELECT * FROM cart WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cart_id = $row['id'];
                    $productName = $row['name'];
                    $productPrice = $row['price'];
                    $quantity = $row['quantity'];
                    $total = $productPrice * $quantity;
                    $grandTotal += $total;
                    echo '<tr>
                            <td>' . $productName . '</td>
                            <td>&#8377;' . $productPrice . '</td>
                            <td class="quantity">
                              <form method="post">
                                <button type="submit" name="decrease" value="' . $cart_id . '">-</button>
                                <input type="text" value="' . $quantity . '" readonly>
                                <button type="submit" name="increase" value="' . $cart_id . '">+</button>
                              </form>
                            </td>
                            <td>&#8377;' . $total . '</td>
                            <td>
                                <button type="submit" name="delete" value="' . $cart_id . '"
                                    style="cursor:pointer; color:red; font-size:16px; border:none; width:30px; height:30px; background:none;">
                                    <i class="ti-view-list-alt menu-icon fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </td>
                          </tr>';
                }
              }
            ?>
            </tbody>
        </table>
    </form>

    <div class="total-row" style="text-align:center; margin:10px auto !important;">
        <span>Grand Total: &#8377;<?php echo number_format($grandTotal, 2); ?></span>
    </div>
    
    <form action="" method="post">
      <div class="customer-details" style="margin:10px auto !important;">
          <h2>Customer Details</h2>
          <input type="text" name="name" placeholder="Name">
          <input type="text" name="mo_no" placeholder="Mobile Number">
          <input type="text" name="address" placeholder="Address">
          <input type="text" name="count" placeholder="Plate Count">
          <?php date_default_timezone_set('Asia/Kolkata'); ?>
          <input type="date" name="date" placeholder="Date" min="<?php echo date('Y-m-d'); ?>">
      </div>
      <button type="submit" name="place_order" style="text-align:center; width:100%" class="checkout-btn">Place Order</button>
  </form>

    <footer id="footer">
        <h2 style="font-size: 25px !important; padding:10px">Zaika &copy; all rights reserved</h2>
    </footer>
    <!-- .................../ JS Code for smooth scrolling /...................... -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assset/js/script.js"></script>

    <script>
    </script>

</html>

</body>

</html>

 