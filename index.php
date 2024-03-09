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
    <section id="food">
        <h2>Types of food</h2>
        <div class="food-container container">
            <div class="food-type fruite">
                <div class="img-container">
                    <img src="assset\images\cust_index\food1.jpg" alt="error" />
                    <div class="img-content">
                        <h3>Silver Platters</h3>
                        <a href="https://en.wikipedia.org/wiki/Fruit" class="btn btn-primary" target="blank">learn
                            more</a>
                    </div>
                </div>
            </div>
            <div class="food-type vegetable">
                <div class="img-container">
                    <img src="assset\images\cust_index\food2.jpg" alt="error" />
                    <div class="img-content">
                        <h3>Golden Platters</h3>
                        <a href="https://en.wikipedia.org/wiki/Vegetable" class="btn btn-primary" target="blank">learn
                            more</a>
                    </div>
                </div>
            </div>
            <div class="food-type grin">
                <div class="img-container">
                    <img src="assset\images\cust_index\food3.jpg" alt="error" />
                    <div class="img-content">
                        <h3>Platinum Platters</h3>
                        <a href="https://en.wikipedia.org/wiki/Grain" class="btn btn-primary" target="blank">learn
                            more</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="food-menu">
        <h2 class="food-menu-heading">Food Menu</h2>
        <div class="food-menu-container container">
            <div class="food-menu-item">
                <div class="food-img">
                    <img src="assset\images\cust_index\menu1.jpg" alt="" />
                </div>
                <div class="food-description">
                    <h2 class="food-titile">Food Menu Item 1</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non,
                        quae.
                    </p>
                    <p class="food-price"><a href="">View More</a></p>
                </div>
            </div>

            <div class="food-menu-item">
                <div class="food-img">
                    <img src="assset\images\cust_index\menu2.jpg" alt="error" />
                </div>
                <div class="food-description">
                    <h2 class="food-titile">South Indian</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non,
                        quae.
                    </p>
                    <p class="food-price"><a href="">View More</a></p>
                </div>
            </div>
            <div class="food-menu-item">
                <div class="food-img">
                    <img src="assset\images\cust_index\menu3.jpg" alt="" />
                </div>
                <div class="food-description">
                    <h2 class="food-titile">Chinese</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non,
                        quae.
                    </p>
                    <p class="food-price"><a href="">View More</a></p>
                </div>
            </div>
            <div class="food-menu-item">
                <div class="food-img">
                    <img src="assset\images\cust_index\menu4.jpg" alt="" />
                </div>
                <div class="food-description">
                    <h2 class="food-titile">Food Menu Item 4</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non,
                        quae.
                    </p>
                    <p class="food-price"><a href="">View More</a></p>
                </div>
            </div>
            <div class="food-menu-item">
                <div class="food-img">
                    <img src="assset\images\cust_index\menu5.jpg" alt="" />
                </div>
                <div class="food-description">
                    <h2 class="food-titile">Food Menu Item 5</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non,
                        quae.
                    </p>
                    <p class="food-price"><a href="">View More</a></p>
                </div>
            </div>
            <div class="food-menu-item">
                <div class="food-img">
                    <img src="assset\images\cust_index\menu6.jpg" alt="" />
                </div>
                <div class="food-description">
                    <h2 class="food-titile">Food Menu Item 6</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non,
                        quae.
                    </p>
                    <p class="food-price"><a href="">View More</a></p>
                </div>
            </div>
        </div>
    </section>

    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['messege'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $messege = $_POST['messege'];
            
            if (!empty($name) && !empty($email) && !empty($messege)) {
                $query = "INSERT INTO contacts_form (name, email, messege) VALUES ('$name', '$email', '$messege')";
                mysqli_query($conn, $query);
                header("Location: index.php");
                echo '<script>alert("Form submitted successfully!");</script>';
                die;
            } else {
                echo '<script>alert("Please enter valid information.");</script>';
            }
        }
        
    ?>

    <section id="contact">
        <div class="contact-container container">
            <div class="contact-img">
                <img src="https://i.postimg.cc/1XvYM67V/restraunt2.jpg" alt="" />
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