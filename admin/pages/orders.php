<?php

session_start();
include_once("../connection.php");
include_once("../config.php");


if (!isset($_SESSION['admin_name'])) {
    header("location:admin_login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO - Admin - Home Page</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets//vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">


</head>

<body>

    <!--  Header -->
    <?php
    include_once('../include/admin_header.php');
    ?>
    <!--  -->

    <!-- Sidebar -->
    <?php
    include_once('../include/admin_sidebar.php');
    ?>
    <!-- -->

    <!-- Dashboard -->
    <main id="main" class="main">

        <!-- title -->
        <div class="pagetitle">
            <h1>Order</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">order</li>
                </ol>
            </nav>
        </div>
        <!--  -->


        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-15">
                    <div class="row">

                        <!-- Recent Sales -->
                        <div class="col-12">
                            <div class="card recent-sales overflow-auto">
                                <div class="card-body">
                                    <h5 class="card-title">Orders queue</h5>

                                    <table class="table table-borderless datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Product Name With Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $order_query = "SELECT `order_id`, `cart_item`, `total_amount`, `payment_date`, `order_status` FROM `orders`";
                                            $order_result = mysqli_query($conn, $order_query);

                                            if (mysqli_num_rows($order_result) > 0) {
                                            ?>

                                                <?php
                                                while ($order_row = mysqli_fetch_assoc($order_result)) {
                                                    $order_id = $order_row['order_id'];
                                                    $cart_item = json_decode($order_row['cart_item'], true); // Decode JSON
                                                    $total_amount = $order_row['total_amount'];
                                                    $payment_date = $order_row['payment_date'];
                                                    $order_status = $order_row['order_status'];

                                                    // Build the product display string with truncation logic
                                                    $product_display = "";
                                                    $product_count = count($cart_item);

                                                    foreach ($cart_item as $index => $item) {
                                                        if ($index < 2) {  // Display only first 2 products
                                                            $product_display .= $item['name'] . "(" . $item['quantity'] . "), ";
                                                        }
                                                    }
                                                    $product_display = rtrim($product_display, ", "); // Remove trailing comma

                                                    // Add '...' if more than 2 products exist
                                                    if ($product_count > 2) {
                                                        $product_display .= ", ...";
                                                    }
                                                ?>
                                                    <form action="" method="get">
                                                        <tr>
                                                            <th scope="row"><a><?php echo $order_id; ?></a></th>
                                                            <td scope="row"><a href="order_details.php?id=<?php echo $order_id; ?>"><?php echo $product_display; ?></a></td>
                                                            <td><?php echo "₹" . number_format($total_amount, 2); ?></td>
                                                            <td><?php echo $payment_date; ?></td>
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
                                                                    case 'Preparing':
                                                                        echo '<span class="badge bg-warning">Preparing</span>';
                                                                        break;
                                                                    default:
                                                                        echo '<span class="badge bg-secondary">Unknown</span>';
                                                                        break;
                                                                }
                                                                ?>
                                                            </td>

                                                        </tr>
                                                    </form>
                                                <?php
                                                }
                                                ?>

                                            <?php
                                            } else {
                                                echo "<tbody><tr><td colspan='5'>No orders found</td></tr></tbody>";
                                            }
                                            ?>

                                        </tbody>


                                    </table>

                                </div>

                            </div>
                        </div><!-- End Recent Sales -->


                    </div>
                </div><!-- End Left side columns -->
            </div>
        </section>

    </main><!-- End #main -->



    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>


</body>

</html>