<?php
include_once("../connection.php");
include_once("../config.php");
?>

<style>
    /* Flex container styling */
    #categories .flex-container {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        flex-wrap: wrap;
        gap: 20px;
    }

    /* Card styling */
    .category-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        max-width: 300px;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-decoration: none;
        color: inherit;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 10px rgba(0, 0, 0, 0.15);
    }

    /* Image styling */
    .category-card .image img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .image img {
        transform: scale(1.05);
    }

    /* Text styling */
    .category-card .text {
        padding: 15px;
        text-align: center;
    }

    .category-card .text span {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        color: #888;
    }

    .category-card .text h3 {
        font-size: 18px;
        margin: 10px 0 0;
        color: #333;
    }
</style>

<div class="site-section site-blocks-2" id="categories">
    <div class="container">
        <div class="flex-container">
            <?php
            $category = "SELECT * FROM `product_sub_category` WHERE `is_deleted` = 0";
            $category_query = mysqli_query($conn, $category);
            if (mysqli_num_rows($category_query) > 0) {
                while ($fetched_data = mysqli_fetch_assoc($category_query)) {
            ?>
                    <a class="category-card" href="#">
                        <div class="image">
                            <img src="../admin/uploaded_images/category/<?php echo $fetched_data['sub_category_image']; ?>" alt="Category image not loaded">
                        </div>
                        <div class="text">
                            <span>Collections</span>
                            <h3><?php echo $fetched_data['sub_category_name']; ?></h3>
                        </div>
                    </a>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>