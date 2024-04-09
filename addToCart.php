<?php
session_start();

include("connection.php");
include("function.php");

// Check if the user is logged in
$user_data = check_login($conn);
if (!$user_data) {
    echo json_encode(array("status" => "error", "message" => "Please login first !"));
    exit();
}

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $cat = $_POST['category'];
    $productPrice = $_POST['product_price'];
    $userId = $user_data['id'];

    // Check if the product is already in the cart
    $checkQuery = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $checkQuery->bind_param("ii", $userId, $productId);
    $checkQuery->execute();
    $checkResult = $checkQuery->get_result();

    if ($checkResult->num_rows == 0) {
        // If the product is not in the cart, insert it with quantity 1
        $insertQuery = $conn->prepare("INSERT INTO cart (name, price, category, product_id, quantity, user_id) VALUES (?, ?, ?, ?, 1, ?)");
        $insertQuery->bind_param("ssssi", $productName, $productPrice, $cat, $productId, $userId);

        if ($insertQuery->execute()) {
            echo json_encode(array("status" => "success", "message" => "Product added to cart successfully."));
            exit();
        } else {
            echo json_encode(array("status" => "error", "message" => "Error adding product to cart: " . $conn->error));
            exit();
        }
    } else {
        // If the product is already in the cart, increase the quantity by 1
        $updateQuery = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $updateQuery->bind_param("ii", $userId, $productId);
        if ($updateQuery->execute()) {
            echo json_encode(array("status" => "success", "message" => "Quantity increased for the product in the cart."));
            exit();
        } else {
            echo json_encode(array("status" => "error", "message" => "Error updating quantity in the cart: " . $conn->error));
            exit();
        }
    }

    $checkQuery->close();
}
?>
