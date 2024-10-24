<?php
include_once("../connection.php");
include_once("../config.php");

$products_per_page = 6;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $products_per_page;

// Prepare search filter
$search_filter = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $search_term = mysqli_real_escape_string($conn, $_GET['search']);
  $search_filter = " AND (`product_name` LIKE '%$search_term%' OR `product_description` LIKE '%$search_term%')";
}

// Prepare size filter
$size_filter = '';
if (isset($_GET['size']) && !empty($_GET['size'])) {
  $sizes = $_GET['size'];
  $size_conditions = array_map(function ($size) {
    return "`product_sizes` LIKE '%$size%'";
  }, $sizes);
  $size_filter = " AND (" . implode(" OR ", $size_conditions) . ")";
}

// Fetch the products with search and size filters
$query = "SELECT `product_id`, `product_name`, `product_price`, `product_image`, `product_sizes`
          FROM `products`
          WHERE `is_deleted` = 0 $search_filter $size_filter
          LIMIT $products_per_page OFFSET $offset";

$fetched_products = mysqli_query($conn, $query);

// Check if products exist
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