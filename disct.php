<?php

// Connect to the database
$db = mysqli_connect("localhost", "root", "harsh@123", "sys");

// Check connection
if (!$db) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Prepare the SQL query
$sql = "UPDATE products SET product_price = product_price * 0.95 WHERE product_type IN ('grocery', 'bakery', 'raw_flesh', 'prepared_food','Produce') AND DATEDIFF(expiry_date, CURRENT_DATE) <= 5";

// Execute the query
if (mysqli_query($db, $sql)) {
    echo "<script type=\"text/javascript\"> alert('Successfully Applied Discount.'); window.location.href = 'http://localhost/main.php'; </script>";

} else {
    echo "Failed to update prices.";
}

// Close the database connection
mysqli_close($db);


?>
