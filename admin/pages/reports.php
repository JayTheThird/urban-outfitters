<?php
session_start();
include_once("../connection.php");
include_once("../config.php");

if (!isset($_SESSION['admin_name'])) {
    header("location:admin_login.php");
    exit();
}

require_once('/xampp/htdocs/urban-outfitters/vendor/setasign/fpdf/fpdf.php');

// Reusable function to generate PDFs
function generatePDF($title, $headers, $data, $filename)
{
    $pdf = new FPDF();
    // Change to A3 size (297mm x 420mm)
    $pdf->AddPage('P', 'A3');
    $pdf->SetFont('Arial', 'B', 14);

    // Title
    $pdf->Cell(190, 15, $title, 0, 1, 'C');

    // Table headers
    $pdf->SetFont('Arial', 'B', 12);
    foreach ($headers as $header) {
        // Set header background color
        $pdf->SetFillColor(200, 220, 255); // Light blue background
        $pdf->Cell($header['width'], 10, $header['label'], 1, 0, 'C', true); // Bold, centered, with background
    }
    $pdf->Ln();

    // Table body
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(245, 245, 245); // Light gray for row alternation
    $fill = false; // For alternating row colors

    foreach ($data as $row) {
        foreach ($row as $index => $cell) {
            $align = isset($headers[$index]['align']) ? $headers[$index]['align'] : 'C'; // Default center alignment
            $pdf->Cell($headers[$index]['width'], 10, $cell, 1, 0, $align, $fill);
        }
        $pdf->Ln();
        $fill = !$fill; // Toggle the fill for alternate row colors
    }

    // Output the PDF to download
    $pdf->Output('D', $filename); // 'D' forces download of the file
}



// Reusable function to execute a query and return the result as an array
function fetchData($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// order report
if (isset($_POST['pastDate']) && isset($_POST['presentDate'])) {
    $past_date = $_POST['pastDate'];
    $present_date = $_POST['presentDate'];

    // Adjust the present date to include the full day (23:59:59)
    $present_date_end = $present_date . ' 23:59:59';

    // Modify the query to take the time into account
    $order_query = "SELECT `order_id`, `total_amount`, `cart_item`, `payment_date`, `order_status` 
                    FROM `orders` 
                    WHERE `payment_date` BETWEEN '$past_date' AND '$present_date_end'";

    $order_data = fetchData($order_query);

    // Parse cart items and format the data for the table
    $order_table_data = [];
    foreach ($order_data as $row) {
        $cart_items = json_decode($row['cart_item'], true);
        $cart_item_names = [];
        if (is_array($cart_items)) {
            foreach ($cart_items as $item) {
                $cart_item_names[] = $item['name'] ?? '';
            }
        }
        $order_table_data[] = [
            $row['order_id'],
            'Rs ' . number_format($row['total_amount'], 2),
            implode(', ', $cart_item_names),
            $row['payment_date'],
            $row['order_status']
        ];
    }

    // Define headers for the order report
    $order_headers = [
        ['label' => 'Order ID', 'width' => 20],
        ['label' => 'Total Amount', 'width' => 30, 'align' => 'R'],
        ['label' => 'Cart Items', 'width' => 70],
        ['label' => 'Payment Date', 'width' => 40],
        ['label' => 'Status', 'width' => 30]
    ];

    // Generate the PDF
    generatePDF('Order Report between ' . $past_date . ' and ' . $present_date . ' (full day)', $order_headers, $order_table_data, 'Order_Report_' . $past_date . ' to ' . $present_date . '.pdf');
}

// Order Report Logic
if (isset($_POST['pastDate']) && isset($_POST['presentDate'])) {
    $past_date = $_POST['pastDate'];
    $present_date = $_POST['presentDate'];

    // Adjust the present date to include the full day (23:59:59)
    $present_date_end = $present_date . ' 23:59:59';

    // Modify the query to take the time into account
    $order_query = "SELECT `order_id`, `total_amount`, `cart_item`, `payment_date`, `order_status` 
                    FROM `orders` 
                    WHERE `payment_date` BETWEEN '$past_date' AND '$present_date_end'";

    $order_data = fetchData($order_query);

    // Parse cart items and format the data for the table
    $order_table_data = [];
    foreach ($order_data as $row) {
        $cart_items = json_decode($row['cart_item'], true);
        $cart_item_names = [];
        if (is_array($cart_items)) {
            foreach ($cart_items as $item) {
                $cart_item_names[] = $item['name'] ?? '';
            }
        }
        $order_table_data[] = [
            $row['order_id'],
            'Rs ' . number_format($row['total_amount'], 2),
            implode(', ', $cart_item_names),
            $row['payment_date'],
            $row['order_status']
        ];
    }

    // Define headers for the order report
    $order_headers = [
        ['label' => 'Order ID', 'width' => 20],
        ['label' => 'Total Amount', 'width' => 30, 'align' => 'R'],
        ['label' => 'Cart Items', 'width' => 70],
        ['label' => 'Payment Date', 'width' => 40],
        ['label' => 'Status', 'width' => 30]
    ];

    // Generate the PDF
    generatePDF('Order Report between ' . $past_date . ' and ' . $present_date . ' (full day)', $order_headers, $order_table_data, 'Order_Report_' . $past_date . ' to ' . $present_date . '.pdf');
}


// Product Report Logic
if (isset($_POST['productPastDate']) && isset($_POST['productPresentDate'])) {
    $product_past_date = $_POST['productPastDate'];
    $product_present_date = $_POST['productPresentDate'];

    $product_query = "SELECT `product_id`, `product_name`, `product_price`, `product_quantity`, `added_date` 
                      FROM `products` 
                      WHERE `added_date` BETWEEN '$product_past_date' AND '$product_present_date'";
    $product_data = fetchData($product_query);

    // Format the data for the table
    $product_table_data = [];
    foreach ($product_data as $row) {
        $product_table_data[] = [
            $row['product_id'],
            $row['product_name'],
            'Rs ' . number_format($row['product_price'], 2),
            $row['product_quantity'],
            $row['added_date']
        ];
    }

    // Define headers for the product report
    $product_headers = [
        ['label' => 'Product ID', 'width' => 30],
        ['label' => 'Product Name', 'width' => 70],
        ['label' => 'Price', 'width' => 30, 'align' => 'R'],
        ['label' => 'Quantity', 'width' => 30],
        ['label' => 'Added Date', 'width' => 30]
    ];

    // Generate the PDF
    generatePDF('Product Report between ' . $product_past_date . ' and ' . $product_present_date, $product_headers, $product_table_data, 'Product_Report' . $product_past_date . ' to ' . $product_present_date . '.pdf');
}

// Customer Report Logic
if (isset($_POST['customerPastDate']) && isset($_POST['customerPresentDate'])) {
    $customer_past_date = $_POST['customerPastDate'];
    $customer_present_date = $_POST['customerPresentDate'];

    $customer_query = "SELECT `uid`, `user_first_name`, `user_last_name`, `email`, `contact_number`, `token_expire` 
                       FROM `users` 
                       WHERE `token_expire` BETWEEN '$customer_past_date' AND '$customer_present_date'";
    $customer_data = fetchData($customer_query);

    // Format the data for the table
    $customer_table_data = [];
    foreach ($customer_data as $row) {
        $customer_table_data[] = [
            $row['uid'],
            $row['user_first_name'],
            $row['user_last_name'],
            $row['email'],
            $row['contact_number']
        ];
    }

    // Define headers for the customer report
    $customer_headers = [
        ['label' => 'User ID', 'width' => 20],
        ['label' => 'First Name', 'width' => 40],
        ['label' => 'Last Name', 'width' => 40],
        ['label' => 'Email', 'width' => 50],
        ['label' => 'Contact Number', 'width' => 40]
    ];

    // Generate the PDF
    generatePDF('Customer Report between ' . $customer_past_date . ' and ' . $customer_present_date, $customer_headers, $customer_table_data, 'Customer_Report' . $customer_past_date . ' to ' . $customer_present_date . '.pdf');
}

// Close the connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO - Admin - Add Products</title>
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

    <!-- Template Main CSS   File -->
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

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Reports</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="Admin_index.php">Home</a></li>
                    <li class="breadcrumb-item">Reports</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">

                <div class="col-xl-12">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Order Reports</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Product Reports</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Customer Reports</button>
                                </li>
                            </ul>
                            <!--  -->

                            <div class="tab-content pt-2">

                                <!-- Order Reports -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <form method="POST">
                                        <!-- Order Past Date -->
                                        <div class="row mb-3">
                                            <label for="pastDate" class="col-md-4 col-lg-3 col-form-label">Past Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="pastDate" type="date" class="form-control" id="pastDate" required max="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>

                                        <!-- Order Present Date -->
                                        <div class="row mb-3">
                                            <label for="presentDate" class="col-md-4 col-lg-3 col-form-label">Present Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="presentDate" type="date" class="form-control" id="presentDate" required max="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Generate Reports</button>
                                        </div>
                                    </form>
                                </div>
                                <!--  -->

                                <!-- Product Reports -->
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <form method="POST">
                                        <!-- Product Past Date -->
                                        <div class="row mb-3">
                                            <label for="productPastDate" class="col-md-4 col-lg-3 col-form-label">Past Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productPastDate" type="date" class="form-control" id="productPastDate" required max="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <!-- Product Present Date -->
                                        <div class="row mb-3">
                                            <label for="productPresentDate" class="col-md-4 col-lg-3 col-form-label">Present Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productPresentDate" type="date" class="form-control" id="productPresentDate" required max="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Generate Reports</button>
                                        </div>
                                    </form>
                                </div>

                                <!--  -->


                                <!-- Customer Reports -->
                                <div class="tab-pane fade pt-3" id="profile-settings">
                                    <form method="POST">
                                        <!-- Customer Past Date -->
                                        <div class="row mb-3">
                                            <label for="customerPastDate" class="col-md-4 col-lg-3 col-form-label">Past Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="customerPastDate" type="date" class="form-control" id="customerPastDate" required max="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <!-- Customer Present Date -->
                                        <div class="row mb-3">
                                            <label for="customerPresentDate" class="col-md-4 col-lg-3 col-form-label">Present Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="customerPresentDate" type="date" class="form-control" id="customerPresentDate" required max="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Generate Reports</button>
                                        </div>
                                    </form>
                                </div>
                                <!--  -->

                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
        </section>



    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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