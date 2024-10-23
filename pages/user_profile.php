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

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="../fonts/icomoon/style.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../styles/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/magnific-popup.css">
    <link rel="stylesheet" href="../styles/jquery-ui.css">
    <link rel="stylesheet" href="../styles/owl.carousel.min.css">
    <link rel="stylesheet" href="../styles/owl.theme.default.min.css">
    <link rel="stylesheet" href="../styles/aos.css">
    <link rel="stylesheet" href="../styles/style.css">

    <style>
        /* General card styling */
        .card {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            /* Softer shadow */
            border-radius: 12px;
            /* Rounded corners */
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        /* Styling for list group items */
        .list-group-item {
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            padding: 15px 20px;
            color: black;
            background-color: transparent;
            /* Ensure no conflicting background */
        }

        .list-group-item:hover {
            background-color: #675af1;
            /* Purple background */
            color: #ffffff !important;
            /* Force white text */
            font-weight: bold;
            border-radius: 8px;
        }

        .list-group-item.active {
            background-color: #7971ea;
            color: #e6e7e9 !important;
            /* Force light gray text */
            font-weight: bold;
            border-radius: 8px;
        }

        /* Badge styles for different statuses */
        .badge {
            display: inline-block;
            padding: 0.5em 1em;
            font-size: 14px;
            font-weight: bold;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 12px;
        }

        /* Specific colors for each status */
        .badge.bg-success {
            background-color: #28a745;
            color: white;
        }

        .badge.bg-warning {
            background-color: #ffc107;
            color: white;
        }

        .badge.bg-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge.bg-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge.bg-secondary {
            background-color: #6c757d;
            color: white;
        }

        /* Ensure alignment and padding for table headers */
        th {
            text-align: center;
            vertical-align: middle;
            padding: 15px;
        }

        /* Ensure alignment and padding for table cells */
        td {
            text-align: center;
            vertical-align: middle;
            padding: 15px;
        }

        /* Spacing and border consistency */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        tbody tr td {
            border-bottom: 1px solid #e9ecef;
        }

        /* Adjust badge minimum width */
        .badge {
            min-width: 90px;
        }

        /* Spacing between rows */
        tr {
            height: 50px;
        }

        /* Animation for content switching */
        .hidden {
            display: none;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Adjustments for Mobile Screens */
        @media (max-width: 768px) {
            .list-group-item {
                font-size: 16px;
                padding: 12px 15px;
            }

            .card {
                margin-bottom: 20px;
            }

            th,
            td {
                font-size: 14px;
                padding: 10px;
            }

            .badge {
                min-width: 70px;
                /* Adjust badge width for mobile */
            }
        }
    </style>
</head>

<body>
    <div class="site-wrap">
        <?php include_once('./include/header.php'); ?>

        <section class="my-5">
            <div class="container">
                <div class="main-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <?php if (isset($_SESSION['user_first_name'], $_SESSION['contact_number'])) { ?>
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <div class="mt-3">
                                                <h4><?php echo $_SESSION['user_first_name']; ?></h4>
                                                <p class="text-secondary mb-1"><?php echo $_SESSION['contact_number']; ?></p>
                                            </div>
                                        </div>

                                        <div class="list-group list-group-flush text-center mt-4">
                                            <a id="profileInfoLink" class="list-group-item list-group-item-action border-0 active">Profile Information</a>
                                            <a id="ordersLink" class="list-group-item list-group-item-action border-0">Orders</a>
                                            <a href="user_logout.php" class="list-group-item list-group-item-action border-0">Logout</a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="list-group list-group-flush text-center mt-4">
                                            <a href="user_login.php" class="list-group-item list-group-item-action border-0">Login</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <!-- Profile Information Section -->
                            <div id="profileSection" class="card">
                                <div class="card-body">
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

                            <!-- Orders Section (Initially Hidden) -->
                            <div id="ordersSection" class="card hidden">
                                <div class="card-body p-0 table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Order ID</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $order_query = "SELECT * FROM `orders` WHERE `user_id` = '$_SESSION[user_id]'";
                                            $order_result = mysqli_query($conn, $order_query);

                                            if (mysqli_num_rows($order_result) > 0) {
                                                while ($row = mysqli_fetch_assoc($order_result)) {
                                                    $order_id = $row['order_id'];
                                                    $cart_item = json_decode($row['cart_item'], true);
                                                    $total_amount = $row['total_amount'];
                                                    $order_status = $row['order_status'];
                                            ?>
                                                    <tr>
                                                        <td><?php echo $order_id; ?></td>
                                                        <td>
                                                            <!-- Display only the first 2 items initially -->
                                                            <?php
                                                            $cart_count = count($cart_item);
                                                            $limit = 2;
                                                            for ($i = 0; $i < min($limit, $cart_count); $i++) {
                                                                echo $cart_item[$i]['name'] . '<br>';
                                                            }

                                                            // Show more link if there are more than 2 items
                                                            if ($cart_count > $limit) { ?>
                                                                <a href="javascript:void(0);" class="show-more" data-target="#order-<?php echo $order_id; ?>">Show More</a>
                                                                <div id="order-<?php echo $order_id; ?>" class="extra-items hidden">
                                                                    <?php
                                                                    // Display the remaining items
                                                                    for ($i = $limit; $i < $cart_count; $i++) {
                                                                        echo $cart_item[$i]['name'] . '<br>';
                                                                    }
                                                                    ?>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            // Display quantity for the first 2 items
                                                            for ($i = 0; $i < min($limit, $cart_count); $i++) {
                                                                echo $cart_item[$i]['quantity'] . '<br>';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>₹ <?php echo $total_amount; ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($order_status) {
                                                                case 'Successful':
                                                                    echo '<span class="badge bg-success">Active</span>';
                                                                    break;
                                                                case 'Pending':
                                                                    echo '<span class="badge bg-warning">Preparing</span>';
                                                                    break;
                                                                case 'Shipped':
                                                                    echo '<span class="badge bg-info">Shipped</span>';
                                                                    break;
                                                                case 'Delivered':
                                                                    echo '<span class="badge bg-success">Delivered</span>';
                                                                    break;
                                                                case 'Cancelled':
                                                                    echo '<span class="badge bg-danger">Cancelled</span>';
                                                                    break;
                                                                default:
                                                                    echo '<span class="badge bg-secondary">Unknown</span>';
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } else {
                                                echo "<tr><td colspan='5'>No orders found.</td></tr>";
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
        </section>

        <!-- footer -->
        <?php include_once('./include/footer.php'); ?>
        <!--  -->
    </div>

    <!-- JS Libraries -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/jquery-ui.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/owl.carousel.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/aos.js"></script>

    <script>
        // JavaScript to toggle visibility between Profile Information and Orders sections
        document.getElementById('profileInfoLink').addEventListener('click', function() {
            document.getElementById('profileSection').classList.remove('hidden');
            document.getElementById('ordersSection').classList.add('hidden');
        });

        document.getElementById('ordersLink').addEventListener('click', function() {
            document.getElementById('ordersSection').classList.remove('hidden');
            document.getElementById('profileSection').classList.add('hidden');
        });

        // JavaScript to toggle active class on click
        const links = document.querySelectorAll('.list-group-item');

        links.forEach(link => {
            link.addEventListener('click', function() {
                // Remove active class from all items
                links.forEach(item => item.classList.remove('active'));
                // Add active class to the clicked item
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>