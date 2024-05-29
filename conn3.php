<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inventory</title>
  <link rel="stylesheet" href="cssfile.css">
 
</head>

  <body  class="tenz" style="background-image: url('bg1.webp');">
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
   
<option value="disct.html">Apply Discount</option>    
<option value="bill.php">Generate Bill</option>
</select>
<button type="button" class="btn"><a href="logout.php">Logout</a></button>

</body>
</html>
<?php

  
$db = mysqli_connect("localhost", "root", "harsh@123", "sys");

if (!$db) {
    die("Database connection failed");
}
// Store the SQL query string in a variable
$sql = "SELECT product_id, product_name, product_price, manufacturer, expiry_date, product_type, location FROM products";

// Prepare the query
$stmt = $db->prepare($sql);

// Execute the query
$stmt->execute();

// Get the query result
$result = $stmt->get_result();

// Display the table data
echo "<table border='1' style='text-align: center; margin: 0 auto; background-color: rgb(123, 212, 247); margin-top: 50px;'>";
echo "<tr>";
echo "<th>Product ID</th>";
echo "<th>Product Name</th>";
echo "<th>Product Price</th>";
echo "<th>Manufacturer</th>";
echo "<th>Expiry Date</th>";
echo "<th>Product Type</th>";
echo "<th>Location</th>";
echo "</tr>";

while ($row = $result->fetch_assoc()) {
echo "<tr>";
echo "<td>" . $row['product_id'] . "</td>";
echo "<td>" . $row['product_name'] . "</td>";
echo "<td>" . $row['product_price'] . "</td>";
echo "<td>" . $row['manufacturer'] . "</td>";
echo "<td>" . $row['expiry_date'] . "</td>";
echo "<td>" . $row['product_type'] . "</td>";
echo "<td>" . $row['location'] . "</td>";
echo "</tr>";
}

echo "</table>";



$db->close();

?>

