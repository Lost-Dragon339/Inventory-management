<?php
$connection = mysqli_connect("localhost", "root", "harsh@123", "sys");

if (!$connection) {
    die("Database connection failed");
}


$product_name = $_POST['product_name']; // Set a default value for product_price




// $query = mysqli_query($connection, "INSERT INTO products (product_name, product_price, manufacturer, expiry_date, location) VALUES ('Anda', '$product_price', 'Harsh Ltd.', 'Rack 1 grocery');");
$query = mysqli_query($connection, "delete from products where product_name='$product_name';");

if ($query) {
    // echo "<script type=\"text/javascript\">alert('Successfully!! Added Your Product.')</script>";
    // header('Location: http://localhost/add_product.html');
    echo "<script type=\"text/javascript\"> alert('Successfully Deleted Product.');</script>";
} else {
    echo "Data not inserted";
}
?>