<?php
session_start();
include_once("../connection.php");
include_once("../config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>UO | Cart</title>
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
    <?php include_once('./include/header.php'); ?>

    <!-- Navigation -->
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.html">Home</a>
            <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Cart</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <!-- Cart Details -->
        <?php include_once('./include/cart_details.php'); ?>

        <div class="row">
          <!-- update and back buttons -->
          <div class="col-md-6">
            <div class="row mb-5">
              <div class="col-md-6 mb-3 mb-md-0">
                <!-- <button class="btn btn-primary btn-sm btn-block">Update Cart</button> -->
              </div>
            </div>
            <!--  -->
          </div>
          <!--  -->

          <!-- cart totals -->
          <div class="col-md-6 pl-5">
            <div class="row justify-content-end">
              <div class="col-md-7">
                <div class="row">
                  <div class="col-md-12 text-right border-bottom mb-5">
                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                  </div>
                </div>

                <?php
                if (isset($_SESSION['email'])) {
                  $user_email = $_SESSION['email'];
                  $get_user_id = mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `email` = '$user_email'");

                  if (mysqli_num_rows($get_user_id) > 0) {
                    $user_row = mysqli_fetch_assoc($get_user_id);
                    $user_id = $user_row['uid'];

                    // Fetch all cart items for the logged-in user
                    $cart_query = mysqli_query($conn, "SELECT `Price`, `Quantity` FROM `cart` WHERE `user_id` = $user_id");

                    if (mysqli_num_rows($cart_query) > 0) {
                      $subtotal = 0;  // Initialize subtotal

                      while ($cart_item = mysqli_fetch_assoc($cart_query)) {
                        // Calculate subtotal by accumulating price * quantity for each item
                        $subtotal += $cart_item['Price'] * $cart_item['Quantity'];
                      }

                      // Assuming no extra charges, total is the same as subtotal
                      $total = $subtotal;
                ?>

                      <div class="row mb-3">
                        <div class="col-md-6">
                          <span class="text-black">Subtotal</span>
                        </div>
                        <div class="col-md-6 text-right">
                          <strong class="text-black">₹<?php echo number_format($subtotal, 2); ?></strong>
                        </div>
                      </div>

                      <div class="row mb-5">
                        <div class="col-md-6">
                          <span class="text-black">Total</span>
                        </div>
                        <div class="col-md-6 text-right">
                          <strong class="text-black">₹<?php echo number_format($total, 2); ?></strong>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='checkout.php'">
                            Proceed To Checkout
                          </button>
                        </div>
                      </div>

                <?php
                    } else {
                      echo "<p>No items in your cart.</p>";
                    }
                  } else {
                    echo "<p>User not found.</p>";
                  }
                } else {
                  echo "<p>Please log in to view your cart.</p>";
                }
                ?>

              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Footer -->
    <?php include_once('./include/footer.php'); ?>

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