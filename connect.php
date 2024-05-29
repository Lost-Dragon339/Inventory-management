<?php
$connection = mysqli_connect("localhost", "root", "harsh@123", "sys");

if (!$connection) {
    die("Database connection failed");
}

$product_id = $_POST['product_id']; // Set a default value for product_price
$product_name = $_POST['product_name']; // Set a default value for product_price
$product_price = $_POST['product_price']; // Set a default value for product_price
$manufacturer = $_POST['manufacturer']; // Set a default value for product_price
$expiry_date = $_POST['expiry_date']; // Set a default value for product_price
$product_type = $_POST['product_type']; // Set a default value for product_price
$location = $_POST['location']; // Set a default value for product_price
if (empty($product_price)) { // Check if product_price is empty
    $product_price = 0.00; // Assign a default value if it is empty
}

// $query = mysqli_query($connection, "INSERT INTO products (product_name, product_price, manufacturer, expiry_date, location) VALUES ('Anda', '$product_price', 'Harsh Ltd.', 'Rack 1 grocery');");
$query = mysqli_query($connection, "INSERT INTO products (product_id, product_name, product_price, manufacturer, expiry_date,product_type,location) VALUES ('$product_id','$product_name', '$product_price', '$manufacturer','$expiry_date', '$product_type','$location');");

if ($query) {
    // echo "<script type=\"text/javascript\">alert('Successfully!! Added Your Product.')</script>";
    // header('Location: http://localhost/add_product.html');
    echo "<script type=\"text/javascript\"> alert('Successfully Added Product.'); window.location.href = 'http://localhost/add_product.html'; </script>";
} else {
    echo "Data not inserted";
}
