<header class="site-navbar" role="banner">
    <div class="site-navbar-top">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                    <form action="" class="site-block-top-search">
                        <span class="icon icon-search2"></span>
                        <input type="text" class="form-control border-0" placeholder="Search">
                    </form>
                </div>

                <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                    <div class="site-logo">
                        <a href="index.php" class="js-logo-clone">Urban Outfitter's</a>
                    </div>
                </div>

                <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                    <div class="site-top-icons">
                        <ul>
                            <li><a href="user_login.php"><span class="icon icon-person"></span></a></li>
                            <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
                            <li>
                                <a href="cart.html" class="site-cart">
                                    <span class="icon icon-shopping_cart"></span>
                                    <span class="count">0</span>
                                </a>
                            </li>
                            <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
            <?php
            // Get the current page file name
            $current_page = basename($_SERVER['PHP_SELF']);
            ?>
            <ul class="site-menu js-clone-nav d-none d-md-block">
                <li class="<?php if ($current_page == 'index.php') {
                                echo 'active';
                            } ?>"><a href="index.php">Home</a></li>
                <li class="has-children">
                    <a href="#">Category</a>
                    <ul class="dropdown">
                        <li><a href="#categories">Urban Jeans</a></li>
                        <li><a href="#categories">Urban Shirts</a></li>
                        <li><a href="#categories">Urban T Shirts</a></li>
                    </ul>
                </li>
                <li><a href="#big-sale">Big Sale!</a></li>
                <li class="<?php if ($current_page == 'shop.php') {
                                echo 'active';
                            } ?>"><a href="shop.php">Shop</a></li>
                <li><a href="#">Catalogue</a></li>
                <li><a href="#featured-products">New Arrivals</a></li>
                <li class="<?php if ($current_page == 'contact.html') {
                                echo 'active';
                            } ?>"><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>
</header>