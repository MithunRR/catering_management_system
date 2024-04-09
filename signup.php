<?php
session_start();
include("connection.php");
include("function.php");

if (isset($_SESSION['mo_no'])) {
    header("Location: index.php");
    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $f_name = $_POST['f_name'];
    $mo_no = $_POST['mo_no'];
    $password = $_POST['password'];

    if (!empty($mo_no) && !empty($password)) {
        $query = "INSERT INTO users (f_name, mo_no, pass) VALUES ('$f_name', '$mo_no', '$password')";
        mysqli_query($conn, $query);
        header("Location: login.php");
        die;
    } else {
        echo "Please enter valid information";
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
      margin: 62px auto;
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
            <li><a href="login.php">Login</a></li>
          </ul>
          <h1 class="logo">Zaika</h1>
      </div>
    </nav>
  </div>

  <div class="signup-container">
    
    <form class="signup-form" action="#" method="post">
      <h2>Signup</h2>
      <br>
      <div class="form-group">
        <label for="f_name">Full Name:</label>
        <input type="text" id="f_name" name="f_name" required>
      </div>
      <div class="form-group">
        <label for="mo_no">Mobile Number:</label>
        <input type="tel" id="mo_no" name="mo_no" maxlength="10" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <button style="margin-bottom: 10px;" type="submit" name="submit">Sign Up</button>
        <a href="login.html">Already have an account</a>
      </div>
    </form>
  </div>
</div>



</body>
</html>
