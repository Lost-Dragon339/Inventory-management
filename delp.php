
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Product</title>
  <link rel="stylesheet" href="cssfile.css">
 
</head>

  <body style="background-image: url('bg1.webp');">
  <div class="header">
    <frame>
        <center><a href="main.html"><img src="HEADER.png"></a></center>
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

 <form action="" method="post" >
    <div class="del"><label for="product_name" >Product Name</label>
        <input type="text" id="product_name" name="product_name" required class="del1">
        <br></div>
        <input class="btn-16" type="submit" value="Delete Product">
      </form>
 
</body>

</html>

<?php
  $connection = mysqli_connect("localhost", "root", "harsh@123", "sys");

  if (!$connection) {
      die("Database connection failed");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $product_name = $_POST['product_name'];

      $query = mysqli_query($connection, "delete from products where product_name='$product_name';");

      if ($query) {
          echo "<script type=\"text/javascript\"> alert('Successfully Deleted Product.');</script>";
      } else {
          echo "Data not deleted";
      }
  }
?>
