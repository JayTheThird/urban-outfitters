<?php
// Fetch the total number of products
$total_products_query = "SELECT COUNT(*) AS total FROM `products` WHERE `is_deleted` = 0";
$total_products_result = mysqli_query($conn, $total_products_query);
$total_products_row = mysqli_fetch_assoc($total_products_result);
$total_products = $total_products_row['total'];

// Number of products per page
$products_per_page = 6;

// Calculate the total number of pages
$total_pages = ceil($total_products / $products_per_page);

// Get the current page number from the query string
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
?>

<!-- Pagination -->
<div class="row" data-aos="fade-up">
    <div class="col-md-12 text-center">
        <div class="site-block-27">
            <ul>
                <!-- Previous Page Link -->
                <li>
                    <?php if ($current_page > 1): ?>
                        <a href="?page=<?php echo $current_page - 1; ?>">&lt;</a>
                    <?php else: ?>
                        <span>&lt;</span>
                    <?php endif; ?>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li <?php if ($i == $current_page) echo 'class="active"'; ?>>
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Next Page Link -->
                <li>
                    <?php if ($current_page < $total_pages): ?>
                        <a href="?page=<?php echo $current_page + 1; ?>">&gt;</a>
                    <?php else: ?>
                        <span>&gt;</span>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</div>