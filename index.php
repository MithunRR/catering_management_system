<?php
session_start();

include("connection.php");
include("function.php");
$user_data = check_login($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['messege'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $messege = $_POST['messege'];
    
    if (!empty($name) && !empty($email) && !empty($messege)) {
        $query = "INSERT INTO contacts_form (name, email, messege) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $messege);
        mysqli_stmt_execute($stmt);
        
        echo '<script>alert("Form submitted successfully!");</script>';
        header("Location: index.php");
        exit; 
    } else {
        echo '<script>alert("Please enter valid information.");</script>';
    }
}
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
                <li><a href="#home">Home</a></li>
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

    <section class="showcase-area" id="showcase">
        <div class="showcase-container">
            <h1 class="main-title" id="home">WELCOME TO ZAIKA CATERERS</h1>
            <p>A Real Diamond of Catering Industry.</p>
            <a href="#food-menu" class="btn btn-primary">EXPLORE OUR MENU</a>
        </div>
    </section>

    <section id="about">
        <div class="about-wrapper container">
            <div class="about-text">
                <p class="small">About Us</p>
                <h2>Serving Good food</h2>
                <p>
                Looking for a perfect food affair to complement your special 
                occasion? Look no further! Zaika Caterers provide a sumptuous food 
                itinerary to fulfill your each and every catering need. Be it a large, 
                mid or small sized event, our full-range of outdoor and indoor catering
                 services cover complete food preparation and presentation for formal and informal gatherings.
                </p>
            </div>
            <div class="about-img">
                <img src="assset\images\cust_index\about-photo2.jpg" alt="food" />
            </div>
        </div>
    </section>

    <section id="food-menu">
        <h2 class="food-menu-heading">Food Menu</h2>
        <div class="food-menu-container container">
        <?php
        include __DIR__ . '/connection.php';

        $sql = 'SELECT DISTINCT category, images FROM category';
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="food-menu-item" >
                    <div class="food-img">
                        <img style="border: 2px solid black;" src="admin/' . $row['images'] . '" alt="' . $row['images'] . '" />
                    </div>
                    <div class="food-description">
                        <h1 style="font-size:43px;" class="food-title">' . $row['category'] . '</h1>
                        
                        <form action="south_ind.php" method="post">
                            <input type="hidden" name="category" value="' . $row['category'] . '">
                            <button type="submit" class="food-price" style="cursor:pointer; border:none; outline:none; background:none; font-size:25px;">View Menu</button>
                        </form>
                    </div>
                </div>';
            }
        } else {
            echo '<p>No categories found</p>';
        }
        ?>

        </div>
    </section>

    <section id="contact">
        <div class="contact-container container">
            <div class="contact-img">
                <img src="assset\images\cust_index\restraunt2.jpg" alt="" />
            </div>
            <div class="form-container">
                <h2>Contact Us</h2>
                <form action="#" method="post">
                    <input type="text" name="name" placeholder="Your Name" />
                    <input type="email" name="email" placeholder="E-Mail" />
                    <textarea cols="30" name="messege" rows="6" placeholder="Type Your Message"></textarea>
                    <button type="submit" class="btn btn-primary" style="padding-top:11px;padding-bottom:11px;">Submit</button>
                </form>
            </div>
        </div>
    </section>
    <footer id="footer">
        <h2>Zaika &copy; all rights reserved</h2>
    </footer>
    <!-- .................../ JS Code for smooth scrolling /...................... -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="assset/js/script.js"></script>

</html>

</body>

</html>