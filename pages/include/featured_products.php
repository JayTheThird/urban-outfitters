<style>
    .site-section {
        padding: 60px 0;
    }


    /* Product Block Styles */
    .block-4 {
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .block-4:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .block-4-image img {
        width: 100%;
        /* Ensures the image spans the container's width */
        height: 300px;
        /* Set a fixed height for uniformity */
        object-fit: contain;
        /* Ensures the image fills the area without distortion */
        border-bottom: 1px solid #ddd;
        border-radius: 8px 8px 0 0;
        /* Rounded top corners only */
    }

    /* Responsive Image Height */
    @media (max-width: 768px) {
        .block-4-image img {
            height: 200px;
        }
    }

    @media (max-width: 480px) {
        .block-4-image img {
            height: 150px;
        }
    }

    .block-4-text {
        padding: 15px;
    }
</style>

<div class="site-section block-3 site-blocks-2 bg-light" id="featured-products">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 site-section-heading text-center pt-4">
                <h2>Featured Products</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="nonloop-block-3 owl-carousel">
                    <?php
                    // Fetch random product
                    $query = "SELECT * FROM `products` ORDER BY RAND() LIMIT 6";
                    $product_query = mysqli_query($conn, $query);

                    if (mysqli_num_rows($product_query) > 0) {
                        while ($fetch_product = mysqli_fetch_assoc($product_query)) {
                    ?>
                            <div class="item">
                                <a href="shop_single.php?id=<?php echo $fetch_product['product_id']; ?>">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="../admin/uploaded_images/product/<?php echo $fetch_product['product_image']; ?>"
                                                alt="<?php echo $fetch_product['product_name']; ?>"
                                                class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a href="shop_single.php?id=<?php echo $fetch_product['product_id']; ?>"><?php echo $fetch_product['product_name']; ?></a></h3>
                                            <br>
                                            <p class="text-primary font-weight-bold">₹ <?php echo $fetch_product['product_price']; ?></p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>