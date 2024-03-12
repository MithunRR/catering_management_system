<?php
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($conn);

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
                <li><a href="#contact">Bookings</a></li>
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
    echo '<h1 style="padding-top: 52px !important; text-align: center">Sweets</h1>';
    echo '<div class="product-container">';
    $result = $conn->query("SELECT * FROM menu_items WHERE category='Sweet'");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product">';
            if ($row['img']) {
                $imgSrc = 'admin/pages/tables/' . $row['img'];
                echo '<img src="' . $imgSrc . '" alt="' . $row['name'] . '">';
            }
            echo '<div class="product-info">';
            echo '<h2>' . $row['name'] . '</h2>';
            echo '<p class="price">$' . $row['price'] . '</p>';
            // echo '<p class="description">' . $row['descr'] . '</p>';
            echo '<button>Add To Cart</button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'No products found.';
    }
    // $conn->close();
    echo '</div>';

    $conn->close();
    ?>

    <footer id="footer">
        <h2>Zaika &copy; all rights reserved</h2>
    </footer>
    <!-- .................../ JS Code for smooth scrolling /...................... -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assset/js/script.js"></script>

</html>

</body>

</html>