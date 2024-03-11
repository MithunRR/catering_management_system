<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Cart</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      flex-direction: column;
    }

    table {
      border-collapse: collapse;
      width: 80%;
      margin: 20px;
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
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
      background-color: #4caf50;
      color: #fff;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    .checkout-btn:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <table>
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
      <tr>
        <td>Product 1</td>
        <td>$20.00</td>
        <td class="quantity">
          <button onclick="decreaseQuantity(this)">-</button>
          <input type="text" value="1">
          <button onclick="increaseQuantity(this)">+</button>
        </td>
        <td>$20.00</td>
        <td>Delete</td>
      </tr>
      <!-- Add more rows as needed -->
    </tbody>
  </table>

  <div class="total-row">
    <span>Grand Total: $20.00</span>
  </div>

  <div class="customer-details">
    <h2>Customer Details</h2>
    <input type="text" placeholder="Name">
    <input type="text" placeholder="Mobile Number">
    <input type="text" placeholder="Address">
    <input type="text" placeholder="Plate Count">
    <input type="date" placeholder="Date">
  </div>

  <button class="checkout-btn">Checkout</button>

  <script>
    function increaseQuantity(button) {
      var input = button.previousElementSibling;
      input.value = parseInt(input.value) + 1;
      updateTotal(input);
    }

    function decreaseQuantity(button) {
      var input = button.nextElementSibling;
      if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        updateTotal(input);
      }
    }

    function updateTotal(input) {
      var price = parseFloat(input.parentNode.previousElementSibling.textContent.replace('$', ''));
      var total = price * parseInt(input.value);
      input.parentNode.nextElementSibling.textContent = '$' + total.toFixed(2);
      updateGrandTotal();
    }

    function updateGrandTotal() {
      var totalElements = document.querySelectorAll('.total-row td:last-child');
      var grandTotal = 0;
      totalElements.forEach(function (element) {
        grandTotal += parseFloat(element.textContent.replace('$', ''));
      });
      document.querySelector('.total-row span').textContent = 'Grand Total: $' + grandTotal.toFixed(2);
    }
  </script>
</body>
</html>
