  <?php
    include_once("../connection.php");
    include_once("../config.php");

    $select_Rows = mysqli_query($conn, "SELECT * FROM `cart`") or die("Query Failed");
    $row_Count = mysqli_num_rows($select_Rows);

    ?>

  <style>
      .btn-light {
          background: transparent;
          font-size: 18px;
          line-height: 1;
          padding: 0;
      }
  </style>

  <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
          <div class="container">
              <div class="row align-items-center">

                  <?php
                    // $current_page = basename($_SERVER['PHP_SELF']);
                    // if ($current_page == "shop.php") {
                    ?>
                  <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                      <form action="shop.php" method="GET" class="site-block-top-search" id="searchForm">
                          <span class="icon icon-search2"></span>
                          <input
                              type="text"
                              name="search"
                              class="form-control border-0"
                              placeholder="Search"
                              value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                          <button
                              type="button"
                              class="btn btn-light border-0"
                              onclick="clearSearch()"
                              style="position: absolute; right: 10px; top: 10px; cursor: pointer;">
                              ✕
                          </button>
                      </form>
                  </div>


                  <?php
                    // } else {
                    ?>
                  <!-- <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left"> -->
                  <!-- <form action="" class="site-block-top-search">
                              <span class="icon icon-search2"></span>
                              <input type="text" class="form-control border-0" placeholder="Search">
                          </form> -->
                  <!-- </div> -->
                  <?php
                    // }
                    ?>


                  <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                      <div class="site-logo">
                          <a href="index.php" class="js-logo-clone">Urban Outfitter's</a>
                      </div>
                  </div>



                  <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                      <div class="site-top-icons">
                          <ul>
                              <li><a href="user_profile.php"><span class="icon icon-person"></span></a></li>
                              <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
                              <li>
                                  <a href="cart.php" class="site-cart">
                                      <span class="icon icon-shopping_cart"></span>
                                      <span class="count"><?php echo $row_Count; ?></span>
                                  </a>
                              </li>
                              <li class="d-inline-block d-md-none ml-md-0"><a href="#"
                                      class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
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
                      <a href="#category">Category</a>
                      <ul class="dropdown">
                          <li class="<?php if ($current_page == 'jeans.php') {
                                            echo 'active';
                                        } ?>"><a href="jeans.php">Urban Jeans</a></li>
                          <li class="<?php if ($current_page == 'shirt.php') {
                                            echo 'active';
                                        } ?>"><a href="shirt.php">Urban Shirts</a></li>
                          <li class="<?php if ($current_page == 'tshirt.php') {
                                            echo 'active';
                                        } ?>"><a href="tshirt.php">Urban T Shirts</a></li>
                      </ul>
                  </li>
                  <li class="<?php if ($current_page == 'shop.php') {
                                    echo 'active';
                                } ?>"><a href="shop.php">Shop</a></li>
                  <li><a href="#big-sale">Big Sale!</a></li>
                  <li><a href="#">Catalogue</a></li>
                  <li><a href="#featured-products">Featured Products</a></li>
                  <li class="<?php if ($current_page == 'contact.php') {
                                    echo 'active';
                                } ?>"><a href="contact.php">Contact</a></li>
              </ul>
          </div>
      </nav>
  </header>


  <script>
      function clearSearch() {
          const searchInput = document.querySelector('input[name="search"]');
          searchInput.value = ''; // Clear the input value
          document.getElementById('searchForm').submit(); // Submit the form
      }
  </script>