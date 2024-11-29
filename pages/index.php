<!DOCTYPE html>
<html lang="en">

<head>
    <title>Urban Outfitter's</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link href="../images/favicon.png" rel="icon">
    <link href="../images/favicon.png" rel="apple-touch-icon">

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

        <!-- hero section -->
        <div class="site-blocks-cover" style="background-image: url(../images/banner/main-banner.png);" data-aos="fade">
            <div class="container">
                <div class="row align-items-start align-items-md-center justify-content-end">
                    <div class="col-md-5 text-center text-md-left pt-5 pt-md-0">
                        <h1 class="mb-1">Finding Your Perfect Cloths</h1>
                        <div class="intro-text text-center text-md-left">
                            <p class="mb-2">Style is something each of us already has, all we need to do is find it. </p>
                            <p>
                                <a href="shop.php" class="btn btn-sm btn-primary">Shop Now</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->

        <!-- details -->
        <div class="site-section site-section-sm site-blocks-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-clock-o"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Free Shipping</h2>
                            <p>Enjoy free shipping on all orders across India. Quick and safe delivery to your doorstep, without any hidden charges.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-rotate-right"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Easy Returns</h2>
                            <p>Return within 3 days for a full refund or exchange. Simple, hassle-free, and no questions asked.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon mr-4 align-self-start">
                            <span class="icon-headset"></span>
                        </div>
                        <div class="text">
                            <h2 class="text-uppercase">Customer Support</h2>
                            <p>24/7 customer support via phone, email, or live chat. We're here to help you anytime.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  -->

    <!-- Categories -->
    <?php
    include_once('./include/categories.php');
    ?>
    <!--  -->

    <!-- features products -->
    <?php
    include_once('./include/featured_products.php');
    ?>
    <!--  -->


    <!-- Big Sale! -->
    <div class="site-section block-8" id="big-sale">
        <div class="container">
            <div class="row justify-content-center mb-5">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Urban Outfitter's Big Sale announcement</h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-7 mb-5">
                    <a href="#"><img src="../images/blog_1.jpg" alt="Image placeholder" class="img-fluid rounded"></a>
                </div>
                <div class="col-md-12 col-lg-5 text-center pl-md-5">
                    <h2><a href="#">Get 30% less in all items</a></h2>
                    <p class="post-meta mb-4">
                        By <a href="#">URBAN OUTFITTER'S</a>
                    </p>
                    <p>Get ready to grab the best deals of the season. </P>
                    <P>The countdown is on!</p>

                    <!-- Countdown Timer -->
                    <p id="countdown" class="mb-4"></p>

                    <!-- <p><a href="#" class="btn btn-primary btn-sm">Shop Now</a></p> -->
                </div>
            </div>
        </div>
    </div>

    <!--  -->

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

<!-- Countdown Timer Script -->
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("December 31, 2024 00:00:00").getTime();

    // Update the countdown every 1 second
    var x = setInterval(function() {

        // Get the current date and time
        var now = new Date().getTime();

        // Calculate the time remaining
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes, and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in the "countdown" element
        document.getElementById("countdown").innerHTML = "Sale starts in: " + days + "d " + hours + "h " +
            minutes + "m " + seconds + "s ";

        // If the countdown is over, display a message
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "The sale is live!";
        }
    }, 1000);
</script>

</html>