<?php
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $user_id = $user_data['id'];
    if ($user_data) {
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $cat = $_POST['category'];
        $productPrice = $_POST['product_price'];
        $userId = $user_data['id'];

        $checkQuery = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $checkQuery->bind_param("ii", $userId, $productId);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();

        if ($checkResult->num_rows == 0) {
            $insertQuery = $conn->prepare("INSERT INTO cart (name, price, category, product_id, quantity, user_id) VALUES (?, ?, ?, ?, 1, ?)");
            $insertQuery->bind_param("ssssi", $productName, $productPrice, $cat, $productId, $userId);

            if ($insertQuery->execute()) {
                $_SESSION['added_to_cart'] = true; // Flag to indicate item added to cart
            } else {
                echo '<script>alert("Error adding product to cart: ' . $conn->error . '");</script>';
            }
        } else {
            $updateQuery = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
            $updateQuery->bind_param("ii", $userId, $productId);
            if ($updateQuery->execute()) {
                $_SESSION['added_to_cart'] = true; // Flag to indicate item added to cart
            } else {
                echo '<script>alert("Error updating quantity in the cart: ' . $conn->error . '");</script>';
            }
        }

        $checkQuery->close();
    } else {
        echo '<script>alert("Please login first !");</script>';
        echo '<script>window.location.href = "login.php";</script>'; 
    }
}

// Redirect to avoid duplicate submissions on page reload
// if ($_SESSION['added_to_cart'] ?? false) {
//     unset($_SESSION['added_to_cart']); // Clear the flag
//     header("Location: {$_SERVER['REQUEST_URI']}"); // Redirect to the same page
//     exit;
// }
?>



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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em;
        }

        .product-container {
            max-width: 80%;
            margin: 0 auto;
            /* padding-top: 70px; */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .product {
            width: calc(30% - 20px);
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .product-info {
            overflow: hidden;
        }
        .product-info button {
            padding: 7px 10px;
            cursor: pointer;
            float: right;
            background-color: #ff9933;
            border: 1px solid black;
            border-radius: 3px;
            color: white;
        }
        .product-info button:hover {
            background-color: #ff8000;
        }

        h2 {
            color: #333;
        }

        p {
            color: #666;
        }

        .price {
            color: #e44d26;
            font-size: 1.2rem;
            margin-top: 5px;
        }

        .description {
            margin-top: 10px;
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

    <?php
        if(isset($_POST['category'])) {
            $category = $_POST['category'];
            
            echo '<h1 style="padding-top: 52px !important; text-align: center">' . $category . '</h1>';
            echo '<div class="product-container">';
            
            $result = $conn->query("SELECT * FROM menu_items WHERE category='$category'");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $productName = $row['name'];
                    $productPrice = $row['price'];
                    $cat = $row['category'];
                    echo '<div class="product">';
                    echo '<form action="" method="post">';
                    if ($row['img']) {
                        $imgSrc = 'admin/pages/tables/' . $row['img'];
                        echo '<img  height="180px" width="100%" src="' . $imgSrc . '" alt="' . $productName . '">';
                    }
                    echo '<div class="product-info">';
                    echo '<h2>' . $productName . '</h2>';
                    echo '<p class="price">&#8377;' . $productPrice . '</p>';
                    echo '<button type="submit" name="add_to_cart" class="add-to-cart">Add To Cart</button>';
                    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                    echo '<input type="hidden" name="product_name" value="' . $productName . '">';
                    echo '<input type="hidden" name="category" value="'.$cat.'">';
                    echo '<input type="hidden" name="product_price" value="' . $productPrice . '">';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<h1 style="padding:20px">The menu will be available soon...!</h1>';
            }
            
            echo '</div>';
        } else {
            // If category is not set, redirect back to the previous page
            header("Location: index.php");
            exit();
        }
    ?>

    <footer id="footer">
        <h2>Zaika &copy; all rights reserved</h2>
    </footer>
    <!-- .................../ JS Code for smooth scrolling /...................... -->
    <!-- Your HTML code -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function(){
    $(".add-to-cart-form").submit(function(event){
        event.preventDefault(); // Prevent default form submission
        
        var formData = $(this).serialize(); // Serialize form data
        
        $.ajax({
            type: "POST",
            url: "", // Leave empty to send the request to the same page
            data: formData,
            dataType: "html",
            success: function(response){
                // Update the UI as needed
                $(".product-container").html(response);
                // Redirect to the same page
                window.location.href = window.location.href;
            },
            error: function(xhr, status, error){
                // Error handling for AJAX request
                console.error(xhr.responseText);
            }
        });
    });
});
</script>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assset/js/script.js"></script>

</html>

</body>

</html>