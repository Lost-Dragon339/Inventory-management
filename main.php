<?php
  session_start();
  if (!isset($_SESSION['user_id'])) {
      echo "User not logged in. Redirecting to login page.";
      header('Location: login.html');
      exit();
  }  
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GEU Shopping Mart</title>
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
  <h1 class="ab1">About Me</h1>
  <div class="wrap">
    <div class="search">
       <input type="text" class="searchTerm" placeholder="What are you looking for?">
       <button type="submit" class="searchButton">
         <i class="fa fa-search"></i>
      </button>
    </div>
 </div>
 
  

  <p class="ab">Geu Shopping Mart is a large retail chain in India with over 1,00 stores nationwide. It is a subsidiary of Graphic Era Group, one of the largest chaebols in Uttarakhand. Geu Shopping Mart is known for its wide variety of products, competitive prices, and convenient locations. The company operates a variety of store formats, including discount supermarkets, hypermarkets, and department stores. Geu Shopping Mart is a popular shopping destination for Koreans of all ages and income levels.

    Here are some of the things that Geu Shopping Mart is known for:
    
    Wide variety of products: Geu Shopping Mart sells a wide variety of products, including food, groceries, clothing, electronics, and home goods. The company also has a strong focus on fresh produce and offers a variety of organic and locally-sourced products.
    Competitive prices: Geu Shopping Mart is known for its competitive prices. The company often has sales and promotions, and it is a popular choice for shoppers looking to save money on groceries.
    Convenient locations:. The company has stores in both urban and rural areas, and it is also expanding into smaller towns and villages.
    Popular shopping destination: Geu Shopping Mart is a popular shopping destination for Indian of all ages and income levels. The company's stores are often crowded, especially during peak hours.
    Geu Shopping Mart is a major player in the South Korean retail market and is expected to continue to grow in the years to come. The company is well-positioned to compete in the increasingly competitive retail landscape, thanks to its strong brand recognition, wide variety of products, competitive prices, and convenient locations.</p>
      

    <p>&copy; 2023 GEU Shopping Mart</p>
  </body>
</html>


<?php
$connection = mysqli_connect("localhost", "root", "harsh@123", "sys");

if (!$connection) {
    die("Database connection failed");
}

?>

