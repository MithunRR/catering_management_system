<?php
include __DIR__ . '/../../../connection.php';
include __DIR__ . '/../../../function.php';

// Post / Add items to menu items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["item_name"])) {
    $name = $_POST['item_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];

    $target_dir = "uploads/";
    $img = $target_dir . basename($_FILES["item_image"]["name"]);
    move_uploaded_file($_FILES["item_image"]["tmp_name"], $img);

    $sql = "INSERT INTO menu_items (name, category, price, descr, img) 
            VALUES ('$name', '$category', '$price', '$desc', '$img')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("location: basic-table.php");

    $conn->close();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_name"])) {
  $item_id = $_POST['item_id'];
  $name = $_POST['update_name'];
  $category = $_POST['category'];
  $price = $_POST['price'];
  $desc = $_POST['desc'];

  // Get the current data of the item from the database
  $currentDataQuery = "SELECT name, category, price, descr, img FROM menu_items WHERE id = $item_id";
  $result = mysqli_query($conn, $currentDataQuery);
  $currentData = mysqli_fetch_assoc($result);

  if ($name != $currentData['name'] ||
      $category != $currentData['category'] ||
      $price != $currentData['price'] ||
      $desc != $currentData['descr'] ) {
      $target_dir = "uploads/";
      $img = $target_dir . basename($_FILES["item_image"]["name"]);
      move_uploaded_file($_FILES["item_image"]["tmp_name"], $img);

      $stmt = $conn->prepare("UPDATE menu_items SET name=?, category=?, price=?, descr=?, img=? WHERE id=?");
      $stmt->bind_param("ssdssi", $name, $category, $price, $desc, $img, $item_id);

      if ($stmt->execute()) {
          echo "Record updated successfully";
      } else {
          echo "Error: " . $stmt->error;
      }

      $stmt->close();
  } else {
      echo "No changes were made.";
  }

  $conn->close();

  header("location: basic-table.php");
  exit();
}




// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//   $item_id = mysqli_real_escape_string($conn, $_POST["item_id"]);
  
//   $delete_query = "DELETE FROM menu_items WHERE id = '$item_id'";
//   }
//   // header("location: basic-table.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = mysqli_real_escape_string($conn, $_POST["item_id"]);

    $delete_query = "DELETE FROM menu_items WHERE id = '$item_id'";
    
    // Execute the delete query
    if (mysqli_query($conn, $delete_query)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
    header("location: basic-table.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Zaika Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../images/favicon.png" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_navbar.php -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo me-5" href="../../index.php"><img src="http://localhost/Catering/assset/images/cust_index/zaika_logo.png" class="me-2" alt="logo"/></a>
        <a class="navbar-brand brand-logo-mini" href="../../index.php"><img src="http://localhost/Catering/assset/images/cust_index/zaika_logo.png" alt="logo"/></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-2">
          <li class="nav-item nav-search d-none d-lg-block">
            <div class="input-group">
              <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                  <i class="ti-search"></i>
                </span>
              </div>
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown me-1">
            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
              <i class="ti-email mx-0"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                    <img src="../../images/faces/face4.jpg" alt="image" class="profile-pic">
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal">David Grey
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    The meeting is cancelled
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                    <img src="../../images/faces/face2.jpg" alt="image" class="profile-pic">
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal">Tim Cook
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    New product launch
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                    <img src="../../images/faces/face3.jpg" alt="image" class="profile-pic">
                </div>
                <div class="item-content flex-grow">
                  <h6 class="ellipsis font-weight-normal"> Johnson
                  </h6>
                  <p class="font-weight-light small-text text-muted mb-0">
                    Upcoming board meeting
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
              <i class="ti-bell mx-0"></i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="notificationDropdown">
              <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                  <div class="item-icon bg-success">
                    <i class="ti-info-alt mx-0"></i>
                  </div>
                </div>
                <div class="item-content">
                  <h6 class="font-weight-normal">Application Error</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Just now
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                  <div class="item-icon bg-warning">
                    <i class="ti-settings mx-0"></i>
                  </div>
                </div>
                <div class="item-content">
                  <h6 class="font-weight-normal">Settings</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    Private message
                  </p>
                </div>
              </a>
              <a class="dropdown-item">
                <div class="item-thumbnail">
                  <div class="item-icon bg-info">
                    <i class="ti-user mx-0"></i>
                  </div>
                </div>
                <div class="item-content">
                  <h6 class="font-weight-normal">New user registration</h6>
                  <p class="font-weight-light small-text mb-0 text-muted">
                    2 days ago
                  </p>
                </div>
              </a>
            </div>
          </li>
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img src="../../images/faces/face28.jpg" alt="profile"/>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="ti-settings text-primary"></i>
                Settings
              </a>
              <a class="dropdown-item">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="ti-view-list"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:../../partials/_sidebar.php -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="../../index.php">
              <i class="ti-shield menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/forms/basic_elements.php">
              <i class="ti-layout-list-post menu-icon"></i>
              <span class="menu-title">Form elements</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/charts/chartjs.php">
              <i class="ti-pie-chart menu-icon"></i>
              <span class="menu-title">Charts</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/tables/basic-table.php">
              <i class="ti-view-list-alt menu-icon fa fa-cutlery" aria-hidden="true"></i>
              <span class="menu-title">Menu</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <i class="ti-user menu-icon"></i>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.php"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login-2.php"> Login 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.php"> Register </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register-2.php"> Register 2 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/lock-screen.php"> Lockscreen </a></li>
              </ul>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <h4 class="font-weight-bold mb-0">Menu Items</h4>
                </div>
                <div>
                    <button type="button" style="display: block;" id="addItemFormBtn" onclick="addItemForm()" class="btn btn-primary btn-icon-text btn-rounded">
                      Add Items
                    </button>
                    <button type="button" style="display: none;" id="addItemFormCsBtn" onclick="addItemFormHide()" class="btn btn-danger btn-icon-text btn-rounded">
                      Close
                    </button>
                </div>
              </div>
            </div>
          </div>
          

          <div class="col-12 grid-margin stretch-card" id="addItemForm" style="display: none;">
            <div class="card">
              <div class="card-body">

                <form class="forms-sample" action="basic-table.php" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="exampleInputName1">Item Name</label>
                    <input required style="height: 10px !important;" type="text" class="form-control" id="item_name" name="item_name" placeholder="Item Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleSelectGender">Category</label>
                      <select required class="form-control" id="category" name="category">
                        <option style="height: 10px !important;">Rice</option>
                        <option style="height: 10px !important;">Dal</option>
                        <option style="height: 10px !important;">Roti/Paratha/Bread</option>
                        <option style="height: 10px !important;">Main Course</option>
                        <option style="height: 10px !important;">Curries</option>
                        <option style="height: 10px !important;">Sweet</option>
                        <option style="height: 10px !important;">Chat</option>

                      </select>
                    </div>
                  <div class="form-group">
                    <label>Upload Image</label>
                    <input required style="height: 10px !important;" type="file" name="item_image" id="fileToUpload" class="file-upload-default">
                    <div class="input-group col-xs-12">
                      <input style="height: 10px !important;" type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                      <span style="height: 10px !important;" class="input-group-append">
                        <button style="height: 10px !important; padding:14px !important; margin-bottom:5px !important" class="file-upload-browse btn btn-primary" type="button"><i class="fa fa-upload" aria-hidden="true"></i></button>
                      </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputCity1">Price</label>
                    <input required style="height: 10px !important;" type="text" class="form-control" name="price" id="price" placeholder="Price">
                  </div>
                  <div class="form-group">
                    <label for="exampleTextarea1">Discription</label>
                    <textarea required style="height: 20px !important;" class="form-control" id="desc" name="desc" rows="4"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary me-2">Submit</button>
                  <!-- <button class="" onclick="cancelUpdate()">Cancel</button> -->
                </form>

              </div>
            </div>
          </div>

          <?php
          include __DIR__ . '/../../../connection.php';

          $sql = "SELECT * FROM menu_items";
          $rice_cat_data = mysqli_query($conn, $sql);
          $rice_row = mysqli_num_rows($rice_cat_data);

          if ($rice_row > 0) {
              $counter = 1;
              while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)) {
                $item_id = $rice_row_no['id'];
                $item_name = $rice_row_no['name'];
                $category = isset($rice_row_no['category']) ? $rice_row_no['category'] : ''; // Check if 'category' key exists
                $img = isset($rice_row_no['img']) ? $rice_row_no['img'] : ''; // Check if 'img' key exists
                $desc = isset($rice_row_no['descr']) ? $rice_row_no['descr'] : ''; // Check if 'descr' key exists
                $price = $rice_row_no['price'];
                  // echo $item_id;
                  // echo ' <div class="col-12 grid-margin stretch-card" id="updateItemForm" style="display: none;">
                  echo '<div class="col-12 grid-margin stretch-card" id="updateItemForm_' . $item_id . '" style="display: none;">
                      <div class="card">
                          <div class="card-body">
                              <button style="float:right; background-color:red; color:white; border:1px solid red; width:5%;" onclick="cancelUpdateForm('.$item_id.')"> X </button>
                              <form class="forms-sample" action="basic-table.php" method="post" enctype="multipart/form-data">
                                  Update Item
                                  <div class="form-group">
                                      <label for="exampleInputName1">Item Name</label>
                                      <input value="'.$item_name.'" style="height: 10px !important;" type="text" class="form-control" id="update_name" name="update_name" placeholder="Item Name">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleSelectGender">Category</label>
                                      <select value="'.$item_name.'" class="form-control" id="category" name="category">
                                          <option style="height: 10px !important;">Rice</option>
                                          <option style="height: 10px !important;">Dal</option>
                                          <option style="height: 10px !important;">Roti/Paratha/Bread</option>
                                          <option style="height: 10px !important;">Main Course</option>
                                          <option style="height: 10px !important;">Curries</option>
                                          <option style="height: 10px !important;">Sweet</option>
                                          <option style="height: 10px !important;">Chat</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label>Upload Image</label>
                                      <input value="'.$item_name.'" style="height: 10px !important;" type="file" name="item_image" id="fileToUpload" class="file-upload-default">
                                      <div class="input-group col-xs-12">
                                          <input style="height: 10px !important;" type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                          <input type="hidden" name="item_id" value="' . $item_id . '">
                                          <span style="height: 10px !important;" class="input-group-append">
                                              <button style="height: 10px !important; padding:14px !important; margin-bottom:5px !important" class="file-upload-browse btn btn-primary" type="button"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                          </span>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputCity1">Price</label>
                                      <input value="'.$price.'" style="height: 10px !important;" type="text" class="form-control" name="price" id="price" placeholder="Price">
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleTextarea1">Description</label>
                                      <input value="'.$desc.'" style="height: 20px !important;" class="form-control" id="desc" name="desc" rows="4" >
                                  </div>
                                  <button type="submit" class="btn btn-primary me-2">Submit</button>
                              </form>
                          </div>
                      </div>
                  </div>';
              }
              } else {
                  echo '<td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                  echo ' Category is empty, please add menu items ! ';
                  echo '</td>';
              }
              ?>




          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Rice</h4>
                  <div class="table-responsive pt-1">
                    <table class="table table-bordered">
                      <thead>
                        <tr style="padding: 5px 5px !important">
                          <th>
                            Sr.No.
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Edit
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody class="pt-1">
                      <?php 
                        include __DIR__ . '/../../../connection.php';
                        $sql = "SELECT id, name, price FROM menu_items WHERE category='Rice'";
                        $rice_cat_data = mysqli_query($conn, $sql);
                        $rice_row = mysqli_num_rows($rice_cat_data);
                        if($rice_row>0){
                          $counter = 1;
                          while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)){
                            $item_id = $rice_row_no['id'];
                           echo '<tr style="padding: 5px 5px !important">';
                           echo '  <td>' . $counter++ . '</td>';
                          echo '  <td>'.$rice_row_no['name'].'</td>';
                          echo '  <td>'.$rice_row_no['price'].'</td>';
                          echo '  <td style="width: 5%;">';
                          // echo '    <button type="button" onclick="updateItemForm(); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '    <button type="button" onclick="updateItemForm(' . $item_id . '); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '      <i style="font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                          echo '    </button>';
                          echo '  </td>';
                          echo '  <td style="width: 5%;">';
                          echo '    <form method="post" action="basic-table.php">';
                          echo '      <input type="hidden" name="item_id" value="' . $item_id . '">';
                          echo '      <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(255, 0, 0);">';
                          echo '        <i style="font-size: 20px;" class="fa fa-trash" aria-hidden="true"></i>';
                          echo '      </button>';
                          echo '    </form>';
                          echo '  </td>';
                          echo '</tr>';
                          }
                        }
                        else{
                            echo '  <td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                             echo ' Category is empty, please add menu items ! ';
                             echo '  </td>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Dal</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Sr.No.
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Edit
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        include __DIR__ . '/../../../connection.php';
                        $sql = "SELECT id, name, price FROM menu_items WHERE category='Dal'";
                        $rice_cat_data = mysqli_query($conn, $sql);
                        $rice_row = mysqli_num_rows($rice_cat_data);
                        if($rice_row>0){
                          $counter = 1;
                          while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)){
                            $item_id = $rice_row_no['id'];
                           echo '<tr style="padding: 5px 5px !important">';
                           echo '  <td>' . $counter++ . '</td>';
                          echo '  <td>'.$rice_row_no['name'].'</td>';
                          echo '  <td>'.$rice_row_no['price'].'</td>';
                          echo '  <td style="width: 5%;">';
                          // echo '    <button type="button" onclick="updateItemForm(); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '    <button type="button" onclick="updateItemForm(' . $item_id . '); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';

                          echo '      <i style="font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                          echo '    </button>';
                          echo '  </td>';
                          echo '  <td style="width: 5%;">';
                          echo '    <form method="post" action="basic-table.php">';
                          echo '      <input type="hidden" name="item_id" value="' . $item_id . '">';
                          echo '      <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(255, 0, 0);">';
                          echo '        <i style="font-size: 20px;" class="fa fa-trash" aria-hidden="true"></i>';
                          echo '      </button>';
                          echo '    </form>';
                          echo '  </td>';
                          echo '</tr>';
                          }
                        }
                        else{
                            echo '  <td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                             echo ' Category is empty, please add menu items ! ';
                             echo '  </td>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Roti/Paratha/Bread</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Sr.No.
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Edit
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        include __DIR__ . '/../../../connection.php';
                        $sql = "SELECT id, name, price FROM menu_items WHERE category='Roti/Paratha/Bread'";
                        $rice_cat_data = mysqli_query($conn, $sql);
                        $rice_row = mysqli_num_rows($rice_cat_data);
                        if($rice_row>0){
                          $counter = 1;
                          while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)){
                            $item_id = $rice_row_no['id'];
                           echo '<tr style="padding: 5px 5px !important">';
                           echo '  <td>' . $counter++ . '</td>';
                          echo '  <td>'.$rice_row_no['name'].'</td>';
                          echo '  <td>'.$rice_row_no['price'].'</td>';
                          echo '  <td style="width: 5%;">';
                          // echo '    <button type="button" onclick="updateItemForm(); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '    <button type="button" onclick="updateItemForm(' . $item_id . '); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';

                          echo '      <i style="font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                          echo '    </button>';
                          echo '  </td>';
                          echo '  <td style="width: 5%;">';
                          echo '    <form method="post" action="basic-table.php">';
                          echo '      <input type="hidden" name="item_id" value="' . $item_id . '">';
                          echo '      <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(255, 0, 0);">';
                          echo '        <i style="font-size: 20px;" class="fa fa-trash" aria-hidden="true"></i>';
                          echo '      </button>';
                          echo '    </form>';
                          echo '  </td>';
                          echo '</tr>';
                          }
                        }
                        else{
                            echo '  <td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                             echo ' Category is empty, please add menu items ! ';
                             echo '  </td>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Main Course Special</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Sr.No.
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Edit
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        include __DIR__ . '/../../../connection.php';
                        $sql = "SELECT id, name, price FROM menu_items WHERE category='Main Course'";
                        $rice_cat_data = mysqli_query($conn, $sql);
                        $rice_row = mysqli_num_rows($rice_cat_data);
                        if($rice_row>0){
                          $counter = 1;
                          while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)){
                            $item_id = $rice_row_no['id'];
                           echo '<tr style="padding: 5px 5px !important">';
                           echo '  <td>' . $counter++ . '</td>';
                          echo '  <td>'.$rice_row_no['name'].'</td>';
                          echo '  <td>'.$rice_row_no['price'].'</td>';
                          echo '  <td style="width: 5%;">';
                          // echo '    <button type="button" onclick="updateItemForm(); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '    <button type="button" onclick="updateItemForm(' . $item_id . '); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';

                          echo '      <i style="font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                          echo '    </button>';
                          echo '  </td>';
                          echo '  <td style="width: 5%;">';
                          echo '    <form method="post" action="basic-table.php">';
                          echo '      <input type="hidden" name="item_id" value="' . $item_id . '">';
                          echo '      <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(255, 0, 0);">';
                          echo '        <i style="font-size: 20px;" class="fa fa-trash" aria-hidden="true"></i>';
                          echo '      </button>';
                          echo '    </form>';
                          echo '  </td>';
                          echo '</tr>';
                          }
                        }
                        else{
                            echo '  <td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                             echo ' Category is empty, please add menu items ! ';
                             echo '  </td>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Curries</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Sr.No.
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Edit
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        include __DIR__ . '/../../../connection.php';
                        $sql = "SELECT id, name, price FROM menu_items WHERE category='Curries'";
                        $rice_cat_data = mysqli_query($conn, $sql);
                        $rice_row = mysqli_num_rows($rice_cat_data);
                        if($rice_row>0){
                          $counter = 1;
                          while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)){
                            $item_id = $rice_row_no['id'];
                           echo '<tr style="padding: 5px 5px !important">';
                           echo '  <td>' . $counter++ . '</td>';
                          echo '  <td>'.$rice_row_no['name'].'</td>';
                          echo '  <td>'.$rice_row_no['price'].'</td>';
                          echo '  <td style="width: 5%;">';
                          // echo '    <button type="button" onclick="updateItemForm(); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '    <button type="button" onclick="updateItemForm(' . $item_id . '); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';

                          echo '      <i style="font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                          echo '    </button>';
                          echo '  </td>';
                          echo '  <td style="width: 5%;">';
                          echo '    <form method="post" action="basic-table.php">';
                          echo '      <input type="hidden" name="item_id" value="' . $item_id . '">';
                          echo '      <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(255, 0, 0);">';
                          echo '        <i style="font-size: 20px;" class="fa fa-trash" aria-hidden="true"></i>';
                          echo '      </button>';
                          echo '    </form>';
                          echo '  </td>';
                          echo '</tr>';
                          }
                        }
                        else{
                            echo '  <td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                             echo ' Category is empty, please add menu items ! ';
                             echo '  </td>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Sweet</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Sr.No.
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Edit
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        include __DIR__ . '/../../../connection.php';
                        $sql = "SELECT id, name, price FROM menu_items WHERE category='Sweet'";
                        $rice_cat_data = mysqli_query($conn, $sql);
                        $rice_row = mysqli_num_rows($rice_cat_data);
                        if($rice_row>0){
                          $counter = 1;
                          while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)){
                            $item_id = $rice_row_no['id'];
                           echo '<tr style="padding: 5px 5px !important">';
                           echo '  <td>' . $counter++ . '</td>';
                          echo '  <td>'.$rice_row_no['name'].'</td>';
                          echo '  <td>'.$rice_row_no['price'].'</td>';
                          echo '  <td style="width: 5%;">';
                          // echo '    <button type="button" onclick="updateItemForm(); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '    <button type="button" onclick="updateItemForm(' . $item_id . '); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';

                          echo '      <i style="font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                          echo '    </button>';
                          echo '  </td>';
                          echo '  <td style="width: 5%;">';
                          echo '    <form method="post" action="basic-table.php">';
                          echo '      <input type="hidden" name="item_id" value="' . $item_id . '">';
                          echo '      <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(255, 0, 0);">';
                          echo '        <i style="font-size: 20px;" class="fa fa-trash" aria-hidden="true"></i>';
                          echo '      </button>';
                          echo '    </form>';
                          echo '  </td>';
                          echo '</tr>';
                          }
                        }
                        else{
                            echo '  <td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                             echo ' Category is empty, please add menu items ! ';
                             echo '  </td>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Chat</h4>
                  <div class="table-responsive pt-3">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Sr.No.
                          </th>
                          <th>
                            Name
                          </th>
                          <th>
                            Price
                          </th>
                          <th>
                            Edit
                          </th>
                          <th>
                            Delete
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                        include __DIR__ . '/../../../connection.php';
                        $sql = "SELECT id, name, price FROM menu_items WHERE category='Chat'";
                        $rice_cat_data = mysqli_query($conn, $sql);
                        $rice_row = mysqli_num_rows($rice_cat_data);
                        if($rice_row>0){
                          $counter = 1;
                          while ($rice_row_no = mysqli_fetch_assoc($rice_cat_data)){
                            $item_id = $rice_row_no['id'];
                           echo '<tr style="padding: 5px 5px !important">';
                           echo '  <td>' . $counter++ . '</td>';
                          echo '  <td>'.$rice_row_no['name'].'</td>';
                          echo '  <td>'.$rice_row_no['price'].'</td>';
                          echo '  <td style="width: 5%;">';
                          // echo '    <button type="button" onclick="updateItemForm(); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';
                          echo '    <button type="button" onclick="updateItemForm(' . $item_id . '); scrollToTop();" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(0, 136, 255);">';

                          echo '      <i style="font-size: 20px;" class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                          echo '    </button>';
                          echo '  </td>';
                          echo '  <td style="width: 5%;">';
                          echo '    <form method="post" action="basic-table.php">';
                          echo '      <input type="hidden" name="item_id" value="' . $item_id . '">';
                          echo '      <button type="submit" onclick="return confirm(\'Are you sure you want to delete this item?\')" style="padding: 5px; border-radius:5px;border:none;outline:none; background-color:white; color:rgb(255, 0, 0);">';
                          echo '        <i style="font-size: 20px;" class="fa fa-trash" aria-hidden="true"></i>';
                          echo '      </button>';
                          echo '    </form>';
                          echo '  </td>';
                          echo '</tr>';
                          }
                        }
                        else{
                            echo '  <td style="padding:10px 0; text-align:center; font-size:16px" colspan=5>';
                             echo ' Category is empty, please add menu items ! ';
                             echo '  </td>';
                        }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.php -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <a href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2021</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Only the best <a href="https://www.bootstrapdash.com/" target="_blank"> Bootstrap dashboard </a> templates</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <script src="../../js/todolist.js"></script>
  <script src="tablejs.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->
  <script src="../../js/file-upload.js"></script>
</body>

</html>
