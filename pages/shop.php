<!DOCTYPE html>
<html lang="en">

<head>
  <title>Urban Outfitters | Shop</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
  <link rel="stylesheet" href="../fonts/icomoon/style.css">

  <link rel="stylesheet" href="../styles/bootstrap.min.css">
  <link rel="stylesheet" href="../styles/magnific-popup.css">
  <link rel="stylesheet" href="../styles/jquery-ui.css">
  <link rel="stylesheet" href="../styles/owl.carousel.min.css">
  <link rel="stylesheet" href="../styles/owl.theme.default.min.css">


  <link rel="stylesheet" href="../styles/aos.css">

  <link rel="stylesheet" href="../styles/style.css">


</head>

<body>

  <div class="site-wrap">
    <!-- Header -->
    <?php
    include_once('./include/header.php');
    ?>
    <!--  -->

    <!-- navigation -->
    <div class="bg-light py-3">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.html">home</a>
            <span class="mx-2 mb-0">/</span>
            <strong class="text-black">shop</strong>
          </div>
        </div>
      </div>
    </div>
    <!--  -->

    <div class="site-section">
      <div class="container">

        <div class="row mb-5">
          <div class="col-md-9 order-2">

            <!-- Shop All -->
            <div class="row">
              <div class="col-md-12 mb-5">
                <div class="float-md-left mb-4">
                  <h2 class="text-black h5">Shop All</h2>
                </div>
                <div class="d-flex">
                  <div class="dropdown mr-1 ml-md-auto">
                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Latest
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                      <a class="dropdown-item" href="#">Shirts</a>
                      <a class="dropdown-item" href="#">Tshirts</a>
                      <a class="dropdown-item" href="#">Jeans</a>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!--  -->

            <div class="row mb-5">
              <!-- product card -->
              <?php
              include_once('./include/product_card.php');
              ?>


              <!--  pagination -->
              <?php
              include_once('./include/pagination.php');
              ?>

            </div>

          </div>

          <div class="col-md-3 order-1 mb-5 mb-md-0">
            <!-- Categories tile -->
            <div class="border p-4 rounded mb-4">
              <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
              <ul class="list-unstyled mb-0">
                <li class="mb-1"><a href="#" class="d-flex"><span>Shirts </span> <span class="text-black ml-auto">(2,220)</span></a></li>
                <li class="mb-1"><a href="#" class="d-flex"><span>Tshirts</span> <span class="text-black ml-auto">(2,550)</span></a></li>
                <li class="mb-1"><a href="#" class="d-flex"><span>Jeans</span> <span class="text-black ml-auto">(2,124)</span></a></li>
              </ul>
            </div>
            <!--  -->

            <div class="border p-4 rounded mb-4">
              <!--  -->

              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Size</h3>
                <label for="s_sm" class="d-flex">
                  <input type="checkbox" id="s_sm" class="mr-2 mt-1"> <span class="text-black">Small
                    (2,319)</span>
                </label>
                <label for="s_md" class="d-flex">
                  <input type="checkbox" id="s_md" class="mr-2 mt-1"> <span class="text-black">Medium
                    (1,282)</span>
                </label>
                <label for="s_lg" class="d-flex">
                  <input type="checkbox" id="s_lg" class="mr-2 mt-1"> <span class="text-black">Large
                    (1,392)</span>
                </label>
              </div>

              <div class="mb-4">
                <h3 class="mb-3 h6 text-uppercase text-black d-block">Color</h3>
                <a href="#" class="d-flex color-item align-items-center">
                  <span class="bg-danger color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Red
                    (2,429)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center">
                  <span class="bg-success color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Green (2,298)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center">
                  <span class="bg-info color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Blue
                    (1,075)</span>
                </a>
                <a href="#" class="d-flex color-item align-items-center">
                  <span class="bg-primary color d-inline-block rounded-circle mr-2"></span> <span class="text-black">Purple (1,075)</span>
                </a>
              </div>

            </div>
          </div>
        </div>

        <!-- Categories -->
        <div class="row">
          <div class="col-md-12">
            <div class="site-section site-blocks-2">
              <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                  <h2>Categories</h2>
                </div>
              </div>
              <?php
              include_once('./include/categories.php');
              ?>
            </div>
          </div>
        </div>
        <!--  -->

      </div>
    </div>

    <!-- footers -->
    <?php
    include_once('./include/footer.php');
    ?>
    <!--  -->
  </div>

  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/jquery-ui.js"></script>
  <script src="../js/popper.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/owl.carousel.min.js"></script>
  <script src="../js/jquery.magnific-popup.min.js"></script>
  <script src="../js/aos.js"></script>

  <script src="../js/main.js"></script>

</body>

</html>