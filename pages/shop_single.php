<?php
session_start();

include_once("../connection.php");
include_once("../config.php");

if (isset($_GET['id'])) {
  $product_id = $_GET['id'];
  $product_query = "SELECT * FROM `products` WHERE `product_id` = $product_id";
  $result = mysqli_query($conn, $product_query);
  $row = mysqli_fetch_assoc($result);

  $product_name = $row['product_name'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>UO | Shop</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Favicons -->
  <link href="../images/favicon.png" rel="icon">
  <link href="../images/favicon.png" rel="apple-touch-icon">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">

  <link rel="stylesheet" href="../styles/bootstrap.min.css">
  <link rel="stylesheet" href="../styles/magnific-popup.css">
  <link rel="stylesheet" href="../styles/jquery-ui.css">
  <link rel="stylesheet" href="../styles/owl.carousel.min.css">
  <link rel="stylesheet" href="../styles/owl.theme.default.min.css">


  <link rel="stylesheet" href="../styles/aos.css">

  <link rel="stylesheet" href="../styles/style.css">


</head>

<body>

  <div class="site-wrap">
    <!-- Header -->
    <?php
    include_once('./include/header.php');
    ?>
    <!--  -->


    <!-- navigation -->
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="shop.php">Shop</a> <span class="mx-2 mb-0">/</span> <strong class="text-black"><?php echo $product_name; ?></strong></div>
        </div>
      </div>
    </div>
    <!--  -->

    <!-- product  -->
    <?php
    include_once('./include/product_details.php');
    ?>
    <!--  -->
  </div>




  <!-- features products -->
  <?php
  include_once('./include/featured_products.php');
  ?>
  <!--  -->

  <!-- footers -->
  <?php
  include_once('./include/footer.php');
  ?>
  <!--  -->
  </div>

  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.magnific-popup.min.js"></script>
  <script src="../js/aos.js"></script>

  <script src="../js/main.js"></script>

</body>

</html>