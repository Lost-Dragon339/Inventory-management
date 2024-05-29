<?php
$db = mysqli_connect("localhost", "root", "M@@chud@0", "sys");

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

$product_ids = isset($_POST['product_id']) ? $_POST['product_id'] : [];
$quantities = isset($_POST['quantity']) ? $_POST['quantity'] : [];
$transaction_ids = isset($_POST['transaction_id']) ? $_POST['transaction_id'] : [];

$total_price = 0;

$membershipDiscount = 0;
$occasionalDiscount = 0;
$expiringProductDiscount = 0;
$flatDiscount = 0;
$grandTotal = 0;

// Check if membership discount is applicable
if (isset($_POST['membershipCard']) && $_POST['membershipCard'] == 'yes') {
  $membershipDiscount = 2;
}

// Check if occasional discount is applicable
if (isset($_POST['occasionalEvent'])) {
  $occasionalDiscount = rand(5, 10);
}

// Calculate expiring product discount for each product
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

    // Calculate product discount based on product type and age
    if (in_array($product_type, ['grocery', 'bakery', 'raw_flesh', 'prepared_food'])) {
      $product_age = calculateProductAge($expiry_date);

      if ($product_age <= 5) {
        $expiringProductDiscount = 5;
      }
    }

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
if ($total_price > 500) {
  $flatDiscount = 5;
}

// Calculate final total price with flat discount
$finalTotalPrice = $total_price * (1 - $flatDiscount / 100);

// Display grand total
echo "<h2>Grand Total: $$finalTotalPrice</h2>";

// Close database connection
mysqli_close($db);
?>