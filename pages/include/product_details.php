<?php

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $product_query = "SELECT * FROM `products` WHERE `product_id` = $product_id";
    $result = mysqli_query($conn, $product_query);
    $row = mysqli_fetch_assoc($result);

    $product_image = $row['product_image'];
    $product_name = $row['product_name'];
    $product_price = $row['product_price'];
    $product_description = $row['product_description'];
    $product_sizes = $row['product_sizes'];

    // Decode the product sizes JSON string
    $product_sizes_array = json_decode($product_sizes);
}

// Add to Cart
if (isset($_POST['addToCart'])) {
    // Check if the user is logged in by checking if the session has 'email'
    if (isset($_SESSION['email'])) {
        // Get the email from the session
        $user_email = $_SESSION['email'];

        // Fetch user ID from the database using the stored email
        $get_user_id = mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `email` = '$user_email'");

        if (mysqli_num_rows($get_user_id) > 0) {
            // User ID found
            $user_row = mysqli_fetch_assoc($get_user_id);
            $user_id = $user_row['uid'];  // Extract the user ID

            // Proceed with adding to cart
            $Product_ID = $product_id;
            $Product_Name = $product_name;
            $Product_Price = $product_price;
            $Product_Image = $product_image;
            $Product_Size = $_POST['product_size'];
            $Product_Quantity = $_POST['productQuantity'];

            // Check if the product already exists in the cart for the logged-in user
            $Select_Cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE `Name` = '$Product_Name' AND `user_id` = '$user_id'");

            if (mysqli_num_rows($Select_Cart) > 0) {
                // Product already in cart
                echo "<script>
                        alert('Product already added to the cart');
                    </script>";
            } else {
                // Insert the product into the cart for the logged-in user
                $insert_Product = mysqli_query($conn, "INSERT INTO `cart`(`Name`, `Price`, `Image`, `Quantity`, `Size`, `user_id`) 
                VALUES ('$Product_Name', '$Product_Price', '$Product_Image', '$Product_Quantity', '$Product_Size', '$user_id')");

                if ($insert_Product) {
                    echo "<script>
                            alert('Product added to cart');
                        </script>";
                } else {
                    echo "<script>
                            alert('Error adding product to cart');
                        </script>";
                }
            }
        } else {
            // User ID not found (email not found in the database)
            echo "<script>
                    alert('User not found');
                    window.location.href = 'user_login.php'; 
                </script>";
        }
    } else {
        // User is not logged in, redirect to login page
        echo "<script>
                alert('You need to log in first');
                window.location.href = 'user_login.php'; 
            </script>";
    }
}



?>

<div class="site-section">
    <form method="post">
        <div class="container">
            <div class="row">

                <!-- Product Image -->
                <div class="col-md-6">
                    <img src="../admin/uploaded_images/product/<?php echo $product_image ?>" alt="Product Image" class="img-fluid">
                </div>

                <div class="col-md-6">
                    <!-- Product Name -->
                    <h2 class="text-black"><?php echo $product_name; ?></h2>

                    <!-- Product Description -->
                    <p><?php echo $product_description; ?></p>

                    <!-- Product Price -->
                    <p><strong class="text-primary h4">₹ <?php echo $product_price; ?></strong></p>

                    <!-- Product Sizes -->
                    <div class="mb-1 d-flex">
                        <?php if (!empty($product_sizes_array)): ?>
                            <?php foreach ($product_sizes_array as $size): ?>
                                <label class="d-flex mr-3 mb-3">
                                    <input type="radio" name="shop-sizes" class="mr-2" value="<?php echo $size; ?>" onchange="updateSelectedSize('<?php echo $size; ?>')">
                                    <span class="d-inline-block text-black"><?php echo $size; ?></span>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No sizes available</p>
                        <?php endif; ?>
                    </div>
                    <!-- product size -->
                    <input type="hidden" name="product_size" id="selectedSize">

                    <!-- Quantity Selector -->
                    <div class="mb-5">
                        <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                            </div>
                            <input type="text" class="form-control text-center" value="1" name="productQuantity" aria-label="Quantity" aria-describedby="button-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                            </div>
                        </div>
                    </div>

                    <!-- Add to Cart Button -->
                    <p><button type="submit" class="buy-now btn btn-sm btn-primary" name="addToCart">Add To Cart</button></p>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- update hidden field with selected size -->
<script>
    function updateSelectedSize(size) {
        document.getElementById('selectedSize').value = size;
    }
</script>