<?php
// Remove Product From Cart
if (isset($_GET['remove_Product_From_Cart'])) {
  $remove_Product_Id = intval($_GET['remove_Product_From_Cart']);

  // First, retrieve the product details from the cart (to know what product to restore stock to)
  $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE `cart_id` = '$remove_Product_Id'");
  if ($cart_query && mysqli_num_rows($cart_query) > 0) {
    $cart_row = mysqli_fetch_assoc($cart_query);
    $product_name = $cart_row['Name'];
    $cart_quantity = $cart_row['Quantity'];

    // Fetch the product in the products table to update the quantity
    $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `product_name` = '$product_name'");
    if ($product_query && mysqli_num_rows($product_query) > 0) {
      $product_row = mysqli_fetch_assoc($product_query);
      $current_stock = $product_row['product_quantity'];

      // Restore the quantity back to the stock
      $new_stock = $current_stock + $cart_quantity;
      mysqli_query($conn, "UPDATE `products` SET `product_quantity` = $new_stock WHERE `product_name` = '$product_name'");
    }

    // Remove the product from the cart
    mysqli_query($conn, "DELETE FROM `cart` WHERE `cart_id` = '$remove_Product_Id'");
    echo "<script>location.replace('cart.php');</script>";
  }
}

// Update Product Quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_id']) && isset($_POST['quantity'])) {
  $cart_id = intval($_POST['cart_id']);
  $new_quantity = intval($_POST['quantity']);

  if ($new_quantity > 0) {
    // Retrieve the product details from the cart
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE `cart_id` = '$cart_id'");
    if ($cart_query && mysqli_num_rows($cart_query) > 0) {
      $cart_row = mysqli_fetch_assoc($cart_query);
      $product_name = $cart_row['Name'];
      $previous_quantity = $cart_row['Quantity'];

      // Fetch the product details from the products table to check the available stock
      $product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `product_name` = '$product_name'");
      if ($product_query && mysqli_num_rows($product_query) > 0) {
        $product_row = mysqli_fetch_assoc($product_query);
        $available_stock = $product_row['product_quantity'];

        // Check if there is enough stock to update the quantity in the cart
        if ($new_quantity <= ($available_stock + $previous_quantity)) {
          // Update the stock in the products table
          $stock_change = $previous_quantity - $new_quantity;
          $new_stock = $available_stock + $stock_change;

          // Update the product stock in the products table
          mysqli_query($conn, "UPDATE `products` SET `product_quantity` = $new_stock WHERE `product_name` = '$product_name'");

          // Update the quantity in the cart
          mysqli_query($conn, "UPDATE `cart` SET `Quantity` = '$new_quantity' WHERE `cart_id` = '$cart_id'");
          echo json_encode(['status' => 'success']);
        } else {
          echo json_encode(['status' => 'error', 'message' => 'Not enough stock available']);
        }
      }
    }
  }
  exit;
}
?>

<div class="row mb-5">
  <div class="col-md-12">
    <div class="site-blocks-table">
      <table class="table">
        <thead>
          <tr>
            <th class="product-thumbnail">Image</th>
            <th class="product-name">Product</th>
            <th class="product-price">Price</th>
            <th class="product-total">Size</th>
            <th class="product-quantity">Quantity</th>
            <th class="product-remove">Remove</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $fetched_products_from_cart = mysqli_query($conn, "SELECT * FROM `cart`");
          if (mysqli_num_rows($fetched_products_from_cart) > 0) {
            while ($row = mysqli_fetch_assoc($fetched_products_from_cart)) {
          ?>
              <tr>
                <!-- product image -->
                <td class="product-thumbnail">
                  <img src="../admin/uploaded_images/product/<?php echo $row['Image']; ?>" alt="Image" class="img-fluid" style="height: 70px; width: 70px; object-fit: cover;">
                </td>
                <!-- product name -->
                <td class="product-name">
                  <h2 class="h5 text-black"><?php echo $row['Name']; ?></h2>
                </td>
                <!-- product price -->
                <td>₹ <?php echo $row['Price']; ?></td>
                <!-- product size -->
                <td><?php echo $row['Size']; ?></td>
                <!-- product quantity -->
                <td style="width: 160px;">
                  <div class="input-group mb-1" style="max-width: 120px;">
                    <div class="input-group-prepend">
                      <button class="btn btn-outline-primary" type="button" onclick="updateQuantity(<?php echo $row['cart_id']; ?>, -1)">−</button>
                    </div>
                    <input type="text" name="quantity" class="form-control text-center" value="<?php echo $row['Quantity']; ?>" id="quantity-<?php echo $row['cart_id']; ?>" readonly>
                    <div class="input-group-append">
                      <button class="btn btn-outline-primary" type="button" onclick="updateQuantity(<?php echo $row['cart_id']; ?>, 1)">+</button>
                    </div>
                  </div>
                </td>
                <!-- remove product -->
                <td>
                  <a href="?remove_Product_From_Cart=<?php echo $row['cart_id']; ?>" class="btn btn-primary btn-sm">X</a>
                </td>
              </tr>
          <?php
            }
          } else {
            echo '<tr><td colspan="6" class="empty-cart-message">Your Cart is Empty!</td></tr>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<style>
  .empty-cart-message {
    text-align: center;
    font-size: 1.5rem;
    color: #ff0000;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
  }
</style>

<script>
  function updateQuantity(cartId, increment) {
    const input = document.getElementById(`quantity-${cartId}`);
    let currentValue = parseInt(input.value);

    currentValue += increment;

    if (currentValue < 1) return;

    input.value = currentValue;

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "cart.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        console.log("Quantity updated");
      }
    };
    xhr.send("cart_id=" + cartId + "&quantity=" + currentValue);
  }
</script>