<?php
session_start();
    
include("connection.php");
include("function.php");

$user_data = check_login($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    //$name = $_POST['name'];
    $mo_no = $_POST['mo_no'];
    $pass = $_POST['pass'];
    if (!empty($mo_no) && !empty($pass)){
        $query = "select * from users where mo_no = '$mo_no' limit 1";
        $result = mysqli_query($conn, $query);
        if ($result){
            if ($result && mysqli_num_rows($result) > 0){
                $user_data = mysqli_fetch_assoc($result);
                if ($user_data['pass'] === $pass){
                    $_SESSION['mo_no'] = $user_data['mo_no'];
                    header("Location: index.php");
                    die;
                }
            }
        }

        echo "Please enter valid informantion";
    }
    else{
        echo "Please enter valid informantion";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assset/css/style.css" />
  <style>
    .navbar{
      margin: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      align-items: center;
      justify-content: center;
    }

    .signup-container {
      
      padding: 20px;
      border-radius: 8px;
      display: flex;
      width: 300px;
      text-align: center;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      margin:auto;
      
    }

    .signup-container h2 {
      color: #333;
    }

    .signup-form {
      background-color: #fff;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 300px;
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin: 70px auto;
    }

    .form-group {
      margin-bottom: 15px;
      width: 100%;
    }

    .form-group label {
      font-weight: bold;
      margin-bottom: 5px;
      width: 100%;
    }

    .form-group input, 
    .form-group button {
      width: calc(100% - 20px); /* Subtracting the total padding (8px * 2) and border (1px * 2) */
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box; /* Include padding and border in the width calculation */
    }

    .form-group button {
      margin-top: 10px;
      background-color: #3498db;
      color: #fff;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }

    .form-group button:hover {
      background-color: #2980b9;
    }
  </style>
  <title>Signup Form</title>
</head>
<body>

<div class="main-container">
  <div class="navbar">
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
            <li><a href="#food">Category</a></li>
            <li><a href="#food-menu">Menu</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="signup.php">Signup</a></li>
          </ul>
          <h1 class="logo">RS</h1>
      </div>
    </nav>
  </div>

  <div class="signup-container">
    
    <form class="signup-form" action="#" method="post">
      <h2>Login</h2>
      <br>
      <div class="form-group">
        <label for="mo_no">Mobile Number:</label>
        <input type="tel" id="mo_no" name="mo_no" maxlength="10" required>
      </div>
      <div class="form-group">
        <label for="pass">Password:</label>
        <input type="pass" id="pass" name="pass" required>
      </div>
      <div class="form-group">
        <button style="margin-bottom: 10px;" type="submit" name="submit">Login</button>
        <a href="signup.html">Don't have an account</a>
      </div>
    </form>
  </div>
</div>



</body>
</html>
