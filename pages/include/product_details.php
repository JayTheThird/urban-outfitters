<?php
include_once("../connection.php");
include_once("../config.php");

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
?>

<div class="site-section">
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
                                <input type="radio" name="shop-sizes" class="mr-2" value="<?php echo $size; ?>">
                                <span class="d-inline-block text-black"><?php echo $size; ?></span>
                            </label>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No sizes available</p>
                    <?php endif; ?>
                </div>

                <!-- Quantity Selector -->
                <div class="mb-5">
                    <div class="input-group mb-3" style="max-width: 120px;">
                        <div class="input-group-prepend">
                            <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                        </div>
                        <input type="text" class="form-control text-center" value="1" placeholder="" aria-label="Quantity" aria-describedby="button-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <p><a href="cart.php" class="buy-now btn btn-sm btn-primary">Add To Cart</a></p>
            </div>
        </div>
    </div>
</div>