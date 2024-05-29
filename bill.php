<!DOCTYPE html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Billing System</title>
  <link rel="stylesheet" href="cssfile.css">
 
</head>

  <body style="background-image: url('bg1.webp');">
  <div class="header">
    <frame>
        <center><a href="main.php"><img src="HEADER.png"></a></center>
</frame>
</div>


<select class="btn" onchange="window.location.href=this.value;">
<option value="" class="btn">Inventory</option>  
<option value="vieinv.html"> View Inventory</option>   
<option value="add_product.html"> Add Product</option>   
<option value="delp.php">Delete Product</option>
</select>
<select class="btn" onchange="window.location.href=this.value;">
<option value="" class="btn">Billing</option>    
    
<option value="disct.php">Apply Discount</option>    
<option value="bill.php">Generate Bill</option>
</select>
<button type="button" class="btn"><a href="logout.php">Logout</a></button>
<div class="wrap">
<div class="search">
   <input type="text" class="searchTerm" placeholder="What are you looking for?">
   <button type="submit" class="searchButton">
     <i class="fa fa-search"></i>
  </button>
</div>
</div>
<center>

  <script>
    function addProductRow() {
      var productRow = document.createElement('div');
      productRow.className = 'product-row';

      var productIdLabel = document.createElement('label');
      productIdLabel.textContent = 'Product ID:';
      productRow.appendChild(productIdLabel);

      var productIdInput = document.createElement('input');
      productIdInput.type = 'text';
      productIdInput.name = 'product_id[]';
      productIdInput.required = true;
      productRow.appendChild(productIdInput);

      var quantityLabel = document.createElement('label');
      quantityLabel.textContent = 'Quantity:';
      productRow.appendChild(quantityLabel);

      var quantityInput = document.createElement('input');
      quantityInput.type = 'number';
      quantityInput.name = 'quantity[]';
      quantityInput.required = true;
      productRow.appendChild(quantityInput);

      var removeButton = document.createElement('button');
      removeButton.textContent = 'Remove Product';
      removeButton.addEventListener('click', function() {
        productRow.parentElement.removeChild(productRow);
      });
      productRow.appendChild(removeButton);

      document.getElementById('product-rows').appendChild(productRow);
    }
  </script>

  <div class="container">
    <h1>Billing System</h1>

    <form action="bill.php" method="post" id="billing-form">
      <div id="product-rows">
        <div class="product-row">
        <label for="custID">Customer ID:</label>
        <input type="number" id="custID" name="custID" required><br>
          <label for="product_id1">Product ID:</label>
          <input type="text" id="product_id1" name="product_id[]" required>

          <label for="quantity1">Quantity:</label>
          <input type="number" id="quantity1" name="quantity[]" required>
        </div>
      </div>

      <button type="button" onclick="addProductRow()" style="background-color: #1fd1f9;">Add Product</button>
      <input type="checkbox" id="membershipCardYes" name="membershipCard" value="yes"> <label for="membershipCardYes">Membership Card</label>
      <input type="checkbox" id="occasionalEvent" name="occasionalEvent" value="yes"> <label for="occasionalEvent">Occasional Event</label>
      <input type="submit" style="background-color: #1fd1f9;" value="Generate Bill">
    </form>
  </div>
  </center>
</body>
</html>


<?php
$db = mysqli_connect("localhost", "root", "harsh@123", "sys");

if (!$db) {
  die("Database connection failed");
}


$expiryDate = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : [];
function calculateProductAge($expiryDate) {
  $expiryDate = new DateTime($expiryDate);
  $today = new DateTime(date('Y-m-d'));

  $diff = $today->diff($expiryDate);

  return $diff->days;
}

function generateTransactionId() {
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $transactionId = '';

  for ($i = 0; $i < 5; $i++) {
    $transactionId .= $characters[rand(0, $charactersLength - 1)];
  }

  return $transactionId;
}

$product_ids = isset($_POST['product_id']) ? $_POST['product_id'] : [];
$quantities = isset($_POST['quantity']) ? $_POST['quantity'] : [];
$transaction_ids = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : [];


$total_price = 0;

$membershipDiscount = 0;
$occasionalDiscount = 0;
$expiringProductDiscount = 0;
$flatDiscount = 0;
$grandTotal = 0;
$flag = 0;
$sumPrice = 0;

// if membershipDiscount is checked
if (isset($_POST['membershipCard']) && $_POST['membershipCard'] == 'yes') {
  $membershipDiscount = 2;
  $flag = 1;
}
// if occasionalDiscount is checked
if($flag == 0){
  if (isset($_POST['occasionalEvent']) && $_POST['occasionalEvent'] == 'yes') {
    $occasionalDiscount = rand(5, 10);
    $flag = 1;
  }
}
// TO calculate expiring product discount for each products
for ($i = 0; $i < count($product_ids); $i++) {
  $product_id = $product_ids[$i];
  $quantity = $quantities[$i];
  

  // Retrieve product information for product
  $sql = "SELECT product_name, product_price, product_type, expiry_date FROM products WHERE product_id = ?";
  $stmt = mysqli_prepare($db, $sql);
  mysqli_stmt_bind_param($stmt, "i", $product_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $product_name = $row['product_name'];
    $product_price = $row['product_price'];
    $product_type = $row['product_type'];
    $expiry_date = $row['expiry_date'];

  

    // Calculate total discount
    $totalDiscount = max($membershipDiscount, $occasionalDiscount, $expiringProductDiscount);

    // Calculate discounted price
    $discountedPrice = $product_price * (1 - $totalDiscount / 100);

    // Calculate total price with quantity
    $totalPrice = $discountedPrice * $quantity;

    // Add to total price
    $total_price += $totalPrice;

    // Display product details and discounts
    echo "<p>Product Name: $product_name</p>";
    echo "<p>Quantity: $quantity</p>";
    echo "<p>Original Price: $$product_price</p>";
    $sumPrice = $sumPrice + ($product_price * $quantity);
    if ($expiringProductDiscount > 0) {
      echo "<p>Expiring Product Discount: -$expiringProductDiscount%</p>";
    }

    if ($occasionalDiscount > 0) {
      echo "<p>Occasional Event Discount: -$occasionalDiscount%</p>";
    }

    if ($membershipDiscount > 0) {
      echo "<p>Membership Discount: -$membershipDiscount%</p>";
    }

    echo "<p>Discounted Price: $$discountedPrice</p>";
    echo "<p>Total Price: $$totalPrice</p>";
    echo "<hr>";

    // Update discount amount in sales_transactions table
    $query1 = "UPDATE sales_transactions SET discount_amount = ? WHERE transaction_id = ?";
    $stmt1 = mysqli_prepare($db, $query1);
    mysqli_stmt_bind_param($stmt1, "di", $totalDiscount, $transaction_id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
  } else {
    echo "<p>Product with ID $product_id not found.</p>";
  }
}

// Apply flat discount if total price is above RS500
if($flag == 0){
  if ($total_price > 500) {
    $flatDiscount = 5;
  }
}
// Calculate final total price with flat discount
$finalTotalPrice = $total_price * (1 - $flatDiscount / 100);

// Display grand total
echo "<h2><center>Grand Total: $$finalTotalPrice</center></h2>";

$transaction_id = generateTransactionId();
$discAmt = $sumPrice - $finalTotalPrice;

$transDate = date("Y-m-d");

if (!isset($_POST['custID'])) {
  $_POST['custID'] = (int)'';
}

$customerId = (int)$_POST['custID'];



$query2 = mysqli_query($db, "INSERT INTO sales_transactions (transaction_date,customer_id, total_amount, discount_amount, transaction_id) VALUES ('$transDate','$customerId','$finalTotalPrice','$discAmt','$transaction_id');");

// Close database connection
mysqli_close($db);
?>




