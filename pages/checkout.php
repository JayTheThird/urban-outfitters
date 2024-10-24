<?php
session_start();
include_once("../connection.php");
include_once("../config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>UO | Checkout</title>
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
<style>
  .cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    /* background-color: #f9f9f9; */
    border-radius: 8px;
    overflow: hidden;
    /* box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); */
  }

  .cart-table thead {
    background-color: #7971ea;
    color: white;
  }

  .cart-table th,
  .cart-table td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
  }

  /* 
  .cart-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
  } */

  /* .cart-table tbody tr:hover {
    background-color: #e0e0e0;
    transition: background-color 0.3s ease;
  } */

  .cart-table td {
    font-size: 16px;
    color: #333;
  }
</style>

<body>

  <div class="site-wrap">
    <!-- Header -->
    <?php
    include_once('./include/header.php');
    ?>
    <!--  -->

    <!-- Navigation -->
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <a href="cart.html">Cart</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Checkout</strong></div>
        </div>
      </div>
    </div>
    <!--  -->


    <div class="site-section">
      <div class="container">
        <form action="pay.php" method="post">

          <!-- Product Preview -->
          <div class="row mb-5">
            <div class="col-md-12">
              <div class="border p-4 rounded" role="alert">
                <table class="cart-table">
                  <thead>
                    <tr>
                      <th>Products</th>
                      <th>Size</th>
                      <th>Price</th>
                      <th>Quantity</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (isset($_SESSION['email'])) {
                      $user_email = $_SESSION['email'];
                      $get_user_id = mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `email` = '$user_email'");

                      if (mysqli_num_rows($get_user_id) > 0) {
                        $user_row = mysqli_fetch_assoc($get_user_id);
                        $user_id = $user_row['uid'];

                        // Fetch all cart items for the logged-in user
                        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE `user_id` = $user_id");

                        if (mysqli_num_rows($cart_query) > 0) {
                          $subtotal = 0;
                          while ($fetch_data = mysqli_fetch_assoc($cart_query)) {
                            $subtotal += $fetch_data['Price'] * $fetch_data['Quantity'];
                    ?>
                            <tr>
                              <td><?php echo $fetch_data['Name']; ?></td>
                              <td><?php echo $fetch_data['Size']; ?></td>
                              <td>₹<?php echo $fetch_data['Price']; ?></td>
                              <td><?php echo $fetch_data['Quantity']; ?></td>

                            </tr>
                    <?php
                          }
                        }
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!--  -->

          <!-- Billing Details -->
          <div class="row">

            <div class="col-md-6 mb-5 mb-md-0">
              <h2 class="h3 mb-3 text-black">Billing Details</h2>
              <div class="p-3 p-lg-5 border">

                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_fname" name="first_name" value="<?php echo $_SESSION['user_first_name']; ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_lname" name="last_name" value="<?php echo $_SESSION['user_last_name']; ?>">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_address" name="main_address" placeholder="Street address">
                  </div>
                </div>

                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Apartment, suite, unit etc. (optional)" name="optional_address">
                </div>

                <div class="form-group">
                  <label for="c_state" class="text-black">State <span class="text-danger">*</span></label>
                  <select id="c_state" class="form-control" name="state_name">
                    <option value="">Loading states...</option>
                  </select>
                </div>


                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_state_country" class="text-black">City <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="city" name="c_state_country">
                  </div>
                  <div class="col-md-6">
                    <label for="c_postal_zip" class="text-black">Pin Code <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="pin_code" name="c_postal_zip">
                  </div>
                </div>

                <div class="form-group row mb-5">
                  <div class="col-md-6">
                    <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="email" name="c_email_address" value="<?php echo $_SESSION['email']; ?>">
                  </div>
                  <div class="col-md-6">
                    <label for="c_phone" class="text-black">Phone<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="phone_number" name="c_phone" placeholder="Phone Number" value="<?php echo $_SESSION['contact_number']; ?>">
                  </div>
                </div>


                <!-- Order Notes -->
                <div class="form-group">
                  <label for="c_order_notes" class="text-black">Order Notes</label>
                  <textarea name="order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
                </div>
                <!--  -->

              </div>
            </div>


            <div class="col-md-6">
              <!-- Coupoon Code -->
              <!-- <div class="row mb-5">
                <div class="col-md-12">
                  <h2 class="h3 mb-3 text-black">Coupon Code</h2>
                  <div class="p-3 p-lg-5 border">

                    <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
                    <div class="input-group w-75">
                      <input type="text" class="form-control" id="c_code" placeholder="Coupon Code" aria-label="Coupon Code" aria-describedby="button-addon2">
                      <div class="input-group-append">
                        <button class="btn btn-primary btn-sm" type="button" id="button-addon2">Apply</button>
                      </div>
                    </div>

                  </div>
                </div>
              </div> -->
              <!--  -->

              <!-- Order Summery -->
              <div class="row mb-5">
                <div class="col-md-12">
                  <h2 class="h3 mb-3 text-black">Your Order</h2>
                  <div class="p-3 p-lg-5 border">
                    <table class="table site-block-order-table mb-5">
                      <thead>
                        <tr>
                          <th>Product</th>
                          <th>Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (isset($_SESSION['email'])) {
                          $user_email = $_SESSION['email'];
                          $get_user_id = mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `email` = '$user_email'");

                          if (mysqli_num_rows($get_user_id) > 0) {
                            $user_row = mysqli_fetch_assoc($get_user_id);
                            $user_id = $user_row['uid'];

                            // Fetch all cart items for the logged-in user
                            $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE `user_id` = $user_id");

                            if (mysqli_num_rows($cart_query) > 0) {
                              $subtotal = 0;
                              while ($fetch_data = mysqli_fetch_assoc($cart_query)) {
                                $item_total = $fetch_data['Price'] * $fetch_data['Quantity'];
                                $subtotal += $item_total;
                        ?>
                                <tr>
                                  <td><?php echo $fetch_data['Name']; ?> <strong class="mx-2">x</strong> <?php echo $fetch_data['Quantity']; ?></td>
                                  <td><?php echo "₹ $item_total"; ?></td>
                                </tr>
                              <?php
                              }
                              $total = $subtotal;
                              ?>
                              <tr>
                                <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                                <td class="text-black"><?php echo "₹ $subtotal"; ?></td>
                              </tr>
                              <tr>
                                <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                <td class="text-black font-weight-bold"><strong><?php echo "₹ $total"; ?></strong></td>
                              </tr>
                        <?php
                            }
                          }
                        }
                        ?>
                      </tbody>
                    </table>

                    <!-- Razorpay Payment Section -->
                    <!-- <div class="border p-3 mb-5">
                      <h3 class="h6 mb-0">
                        <a class="d-block" data-toggle="collapse" href="#collapsepaypal" role="button" aria-expanded="false" aria-controls="collapsepaypal">Razorpay</a>
                      </h3>

                      <div class="collapse" id="collapsepaypal">
                        <div class="py-2">
                          <p class="mb-0">Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order won’t be shipped until the funds have cleared in our account.</p>
                        </div>
                      </div>
                    </div> -->

                    <div class="form-group">
                      <button class="btn btn-primary btn-lg py-3 btn-block" type="submit">Place Order</button>
                    </div>


                  </div>
                </div>
              </div>


            </div>
          </div>
          <!--  -->
        </form>
      </div>
    </div>

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

  <!-- indian state api -->
  <script>
    // Fetch Indian states from an API on page load
    document.addEventListener("DOMContentLoaded", function() {
      fetch("https://cdn-api.co-vin.in/api/v2/admin/location/states")
        .then(response => response.json())
        .then(data => {
          const stateDropdown = document.getElementById("c_state");
          stateDropdown.innerHTML = '<option value="">Select a State</option>'; // Reset options

          data.states.forEach(state => {
            const option = document.createElement("option");
            option.value = state.state_name;
            option.textContent = state.state_name;
            stateDropdown.appendChild(option);
          });
        })
        .catch(error => {
          console.error("Error fetching states:", error);
          document.getElementById("c_state").innerHTML =
            '<option value="">Unable to load states</option>';
        });
    });
  </script>


</body>

</html>