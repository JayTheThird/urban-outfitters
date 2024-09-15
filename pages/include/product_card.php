 <?php
  include_once("../connection.php");
  include_once("../config.php");
  
  // Number of products per page
  $products_per_page = 6;

  // Get the current page number from the query string
  $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

  // Calculate the offset for the SQL query
  $offset = ($current_page - 1) * $products_per_page;

  // Fetch the products for the current page
  $fetched_products = mysqli_query($conn, "SELECT `product_id`, `product_name`, `product_price`, `product_image` FROM `products` WHERE `is_deleted` = 0 LIMIT $products_per_page OFFSET $offset");

  // Check if any products exist
  if (mysqli_num_rows($fetched_products) > 0) {
    while ($row = mysqli_fetch_assoc($fetched_products)) {

  ?>

     <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
       <div class="block-4 text-center border">
         <figure class="block-4-image">
           <a href="shop_single.php?id=<?php echo $row['product_id']; ?>">
             <img src="../admin/uploaded_images/product/<?php echo $row['product_image']; ?>" alt="Image placeholder" class="img-fluid">
           </a>
         </figure>
         <div class="block-4-text p-4">
           <h3><a href="shop_single.php?id=<?php echo $row['product_id']; ?>"><?php echo $row['product_name']; ?></a></h3>
           <p class="mb-0">₹ <?php echo $row['product_price']; ?></p>
         </div>
       </div>
     </div>
 <?php
    }
  } else {
    echo "<p>No products found.</p>";
  }
  ?>