<?php
// Get the current page file name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0">
                <a href="">Home</a>
                <span class="mx-2 mb-0">/</span>
                <strong class="text-black <?php if ($current_page == 'shop.php') {
                                                echo 'active';
                                            } ?>">Shop</strong>


            </div>
        </div>
    </div>
</div>