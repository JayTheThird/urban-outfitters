<?php
include_once("../connection.php");
include_once("../config.php");
?>


<div class="site-section site-blocks-2" id="categories">
    <div class="container">
        <!-- Flex container for centering and wrapping items -->
        <div style="display: flex; align-items: center; justify-content: space-evenly; flex-wrap: wrap;">
            <?php
            $category = "SELECT * FROM `product_sub_category` WHERE `is_deleted` = 0";
            $category_query = mysqli_query($conn, $category);
            if (mysqli_num_rows($category_query) > 0) {
                while ($fetched_data = mysqli_fetch_assoc($category_query)) {
            ?>
                    <!-- Card for each category -->
                    <div class="col-sm-12 col-md-6  col-lg-4 mb-5" style="display: flex; justify-content: center;">
                        <a class="block-2-item" href="#" style="display: block; width: 100%; max-width: 300px;">
                            <figure class="image" style="overflow: hidden; border-radius: 10px;">
                                <!-- Corrected the image path -->
                                <img src="../admin/uploaded_images/category/<?php echo $fetched_data['sub_category_image']; ?>" alt="category image not load" class="img-fluid" style="width: 100%; height: auto;">
                            </figure>
                            <div class="text" style="text-align: center; margin-top: 12px;">
                                <span class="text-uppercase">Collections</span>
                                <h3><?php echo $fetched_data['sub_category_name']; ?></h3>
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