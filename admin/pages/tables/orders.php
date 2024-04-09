<?php
include __DIR__ . '/../../../connection.php';
include __DIR__ . '/../../../function.php';

date_default_timezone_set('Asia/Kolkata');

// Post / Add items to menu items
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["item_name"])) {
    $name = $_POST['item_name'];
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $price = $_POST['price'];
    $desc = $_POST['desc'];

    $target_dir = "uploads/";
    $img = $target_dir . basename($_FILES["item_image"]["name"]);
    move_uploaded_file($_FILES["item_image"]["tmp_name"], $img);

    $sql = "INSERT INTO menu_items (name, category, subcategory, price, descr, img) 
            VALUES ('$name', '$category', '$subcategory', '$price', '$desc', '$img')";

    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("location: basic-table.php");

    $conn->close();
}

// Upadate menu items 
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_name"])) {
  $item_id = $_POST['item_id'];
  $name = $_POST['update_name'];
  $category = $_POST['category'];
  $subcategory = $_POST['subcategory'];
  $price = $_POST['price'];
  $desc = $_POST['desc'];

  // Get the current data of the item from the database
  $currentDataQuery = "SELECT name, category, subcategory, price, descr FROM menu_items WHERE id = $item_id";
  $result = mysqli_query($conn, $currentDataQuery);
  $currentData = mysqli_fetch_assoc($result);

  if ($name != $currentData['name'] ||
    $category != $currentData['category'] ||
    $subcategory != $currentData['subcategory'] ||
    $price != $currentData['price'] ||
    $desc != $currentData['descr']) {
    $stmt = $conn->prepare("UPDATE menu_items SET name=?, category=?, subcategory=?, price=?, descr=? WHERE id=?");
    $stmt->bind_param("ssdssi", $name, $category, $subcategory, $price, $desc, $img, $item_id);

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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Zaika Admin</title>
  <link rel="stylesheet" href="../../vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css">
  <link rel="stylesheet" href="../../css/style.css">
  <link rel="shortcut icon" href="../../images/favicon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<style>
    select option {
        font-size: 16px;
        
    }
    .form-group option{
      padding: 40px 0;
    }
</style>

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
            <a class="nav-link" href="basic-table.php">
            <i class="ti-view-list-alt menu-icon fa fa-cutlery" aria-hidden="true"></i>
              <span class="menu-title">Menu</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../../pages/tables/orders.php">
            <i class="ti-view-list-alt menu-icon fa fa-cart-arrow-down" aria-hidden="true"></i>
              <span class="menu-title">Orders</span>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link" href="../../pages/tables/contacts.php">
              <i class="ti-view-list-alt menu-icon fa fa-commenting" aria-hidden="true"></i>
              <span class="menu-title">Contacts</span>
            </a>
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
                  <h4 class="font-weight-bold mb-0">Orders </h4>
                </div>
              </div>
            </div>
          </div>
        

          <div class="row">
          <?php
            $sqlCustomers = "SELECT * FROM customers ORDER BY id DESC";
            $resultCustomers = $conn->query($sqlCustomers);
            if ($resultCustomers->num_rows > 0) {
                while ($customerRow = $resultCustomers->fetch_assoc()) {
                    $customerId = $customerRow['id'];
                    $customerName = $customerRow['name'];
                    $mobileNumber = $customerRow['mo_no'];
                    $address = $customerRow['address'];
                    $plateCount = $customerRow['count'];
                    $user_id = $customerRow['user_id'];
                    $orderDate = date('d-m-Y', strtotime($customerRow['date']));
                    $date = date('d-m-Y  h:m', strtotime($customerRow['order_date']));
                    $sqlOrders = "SELECT * FROM orders WHERE customer_id = $customerId";
                    $resultOrders = $conn->query($sqlOrders);

                    $totalPrice = 0;
                    echo '<div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                <table style="width:100%">
                                  <tr style="width:100%">
                                    <th class="card-title"> Name : ' . $customerName . '</th>
                                    <th class="card-title" style="text-align:center"> Mobile Number : ' . $mobileNumber . '</th>
                                    <th class="card-title" style="text-align:right"> Plate Count : ' . $plateCount . '</th>
                                  </tr>
                                  <tr style="width:100%;">
                                    <th class="card-title" > Date : ' . $orderDate . '</th>
                                    <th class="card-title" style="text-align:center"> Cust. Id : '.$customerId.'</th>
                                    <th class="card-title" style="text-align:right"> User Id : '.$user_id.'</th>
                                  </tr>
                                  <tr style="width:100%">
                                    <th class="card-title"> Address : ' . $address . '</th>
                                    <th class="card-title" style="text-align:center"> </th>
                                    <th class="card-title" style="text-align:right"> Order Date : '.$date.'</th>
                                  </tr>
                                </table>';
                    echo '<div class="table-responsive pt-1">';
                    echo '<table class="table table-bordered">';
                    echo '<thead>';
                    echo '<tr style="padding: 5px 5px !important">';
                    echo '<th>Sr.No.</th>';
                    echo '<th>Product Name</th>';
                    echo '<th>Category</th>';
                    echo '<th>Price</th>';
                    echo '<th>Quantity</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody class="pt-1">';
                    if ($resultOrders->num_rows > 0) {
                        $counter = 1;
                        while ($row = $resultOrders->fetch_assoc()) {
                            $productName = $row['product_name'];
                            $productCat = $row['category'];
                            $productPrice = $row['price'];
                            $quantity = $row['quantity'];
                            echo '<tr style="padding: 5px 5px !important">';
                            echo '<td>' . $counter++ . '</td>';
                            echo '<td>' . $productName . '</td>';
                            echo '<td>' . $productCat . '</td>';
                            echo '<td>' . $productPrice . '</td>';
                            echo '<td>' . $quantity . '</td>';
                            echo '</tr>';

                            $totalPrice += ($productPrice * $quantity);
                        }
                    }
                    echo '</tbody>';
                    echo '</table><br>';
                    echo '<table style="width:100%">';
                    echo '<tr><th colspan="4" style="text-align:left">Total : ' . $totalPrice . '</th>';
                    $totalPrice *= $plateCount;
                    echo '<th colspan="4" style="text-align:right">'.$plateCount.' x Total : ' . $totalPrice . '</th></tr>';
                    echo '</table>';
                    echo '</div>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<h1 style="text-align:center; margin:auto;">No categories found</h1>';
            }
            ?>
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


   <!-- ////// AJAX to fetch subcategory in the category -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
       $(document).ready(function(){
           $('#category').change(function(){
               var category = $(this).val();
               $.ajax({
                   url: 'subcategories.php', // PHP url
                   type: 'GET',
                   data: {category: category},
                   success:function(data){
                       $('#subcategory').html(data);
                       $('#subcategory1').html(data);
                   }
               });
           });
       });
   </script>
   <!-- ////////////////////////////////////////////////////////////// -->
</body>

</html>