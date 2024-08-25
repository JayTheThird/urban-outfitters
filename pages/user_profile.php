<?php
include_once("../connection.php");
include_once("../config.php");
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>UA - Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="../fonts/icomoon/style.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/magnific-popup.css">
    <link rel="stylesheet" href="../styles/jquery-ui.css">
    <link rel="stylesheet" href="../styles/owl.carousel.min.css">
    <link rel="stylesheet" href="../styles/owl.theme.default.min.css">
    <link rel="stylesheet" href="../styles/aos.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="../styles/style.css">

    <!-- Inline Styles -->
    <style>
        /* Profile Information Section */
        .card-body h5 {
            font-weight: bold;
            /* Make the Profile Information heading bold */
        }

        .card-body p {
            font-weight: 500;
            /* Set a medium weight for paragraph text */
        }

        .card-body p strong {
            font-weight: bold;
            /* Ensure strong elements are bold */
        }

        /* List Group Items */
        .list-group-item {
            font-weight: 600;
            /* Medium-bold weight for list items */
        }

        .list-group-item.active {
            font-weight: 700;
            /* Bold weight for the active list item */
        }

        /* Other Elements */
        .modal-content h2 {
            font-weight: bold;
            /* Bold the modal title */
        }

        .button_div button {
            font-weight: bold;
            /* Bold the button text */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .modal-content {
                padding: 10px 0 !important;
                width: 95% !important;
                height: 700px;
                overflow: auto;
            }

            .close {
                margin-right: 10px;
            }

            .card-body p {
                font-weight: 400;
                /* Adjust font weight for mobile */
            }
        }
    </style>
</head>

<body>
    <div class="site-wrap">
        <!-- Header -->
        <?php include_once('./include/header.php'); ?>

        <!-- Main Content -->
        <section class="my-5">
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    if (isset($_SESSION['user_first_name'], $_SESSION['contact_number'])) {
                                    ?>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <div class="mt-3">
                                                <h4><?php echo " $_SESSION[user_first_name]"; ?></h4>
                                                <p class="text-secondary mb-1"><?php echo " $_SESSION[contact_number]"; ?></p>
                                            </div>
                                        </div>
                                        <div class="list-group list-group-flush text-center mt-4">
                                            <a href="#" class="list-group-item list-group-item-action border-0 active">Profile Information</a>
                                            <a href="user_logout.php" class="list-group-item list-group-item-action border-0">Logout</a>
                                        </div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <div class="mt-3">
                                                <h4>--</h4>
                                                <p class="text-secondary mb-1">--</p>
                                                <p class="text-muted font-size-sm">--</p>
                                            </div>
                                        </div>
                                        <div class="list-group list-group-flush text-center mt-4">
                                            <a href="#" class="list-group-item list-group-item-action border-0 active">Profile Information</a>
                                            <a href="user_login.php" class="list-group-item list-group-item-action border-0">Login</a>
                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>

                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div id="orderDetails" class="order_card"></div>
                            <div id="profileDetails" class="card">
                                <?php
                                if (isset($_SESSION['user_first_name'], $_SESSION['email'], $_SESSION['contact_number'])) {
                                ?>
                                    <div class="card-body">
                                        <h5>Profile Information</h5>
                                        <p><strong>Name:</strong> <?php echo "$_SESSION[user_first_name] $_SESSION[user_last_name] "; ?></p>
                                        <p><strong>Email Address:</strong> <?php echo "$_SESSION[email]"; ?></p>
                                        <p><strong>Contact:</strong> +91 <?php echo "$_SESSION[contact_number]"; ?></p>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="card-body">
                                        <h5>Profile Information</h5>
                                        <p><strong>Name:</strong> --</p>
                                        <p><strong>Email Address:</strong> --</p>
                                        <p><strong>Contact:</strong>--</p>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <?php include_once('./include/footer.php'); ?>
    </div>

    <!-- JS Libraries -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/aos.js"></script>

    <!-- Main JS -->
    <script src="../js/main.js"></script>
</body>

</html>