<?php

session_start();
include_once("../connection.php");
include_once("../config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('/xampp/htdocs/urban-outfitters/vendor/autoload.php');

if (!isset($_SESSION['admin_name'])) {
    header("location:admin_login.php");
    exit();
}

// Escape order_id to prevent SQL injection
$order_id = mysqli_real_escape_string($conn, $_GET['id']);

// Fetch order details
$order_query = "SELECT * FROM `orders` WHERE `order_id` = '$order_id'";
$order_result = mysqli_query($conn, $order_query);
$row = mysqli_fetch_assoc($order_result);

if ($row) {
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $address = $row['address'];
    $optional_address = $row['optional_address'];
    $state = $row['state'];
    $city = $row['city'];
    $pin_code = $row['pin_code'];
    $email = $row['email'];
    $phone = $row['phone'];
    $order_notes = $row['order_notes'];
    $razorpay_order_id = $row['razorpay_order_id'];
    $razorpay_payment_id = $row['razorpay_payment_id'];
    $total_amount = $row['total_amount'];
    $payment_date = $row['payment_date'];
    $order_status = $row['order_status'];

    // Decode the cart items
    $cart_item = json_decode($row['cart_item'], true);
} else {
    echo "Order not found!";
    exit();
}

function sendOrderStatusEmail(
    $email,
    $first_name,
    $last_name,
    $razorpayOrderId,
    $razorpayPaymentId,
    $amount,
    $address,
    $optional_address,
    $city,
    $state_name,
    $pin_code,
    $cart_items,
    $status
) {
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'urbanoutfittersg25@gmail.com';
        $mail->Password = 'neeaymsxupnfmlow';  // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email sender and recipient
        $mail->setFrom('urbanoutfittersg25@gmail.com', "Urban Outfitter's");
        $mail->addAddress($email);

        // Customize subject and message based on status
        $subject = "Your Order is $status!";
        $greeting = "Hello, <strong>$first_name $last_name</strong>!";
        $status_message = getStatusMessage($status);

        // Email formatting (HTML)
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background: #ffffff; 
                            padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);'>
                    <h1 style='color: #333;'>$subject</h1>
                    <p style='font-size: 16px;'>$greeting</p>
                    <p>$status_message</p>

                    <h2 style='color: #666;'>Order Summary</h2>
                    <p><strong>Order ID:</strong> $razorpayOrderId</p>
                    <p><strong>Payment ID:</strong> $razorpayPaymentId</p>
                    <p><strong>Total Amount Paid:</strong> ₹$amount</p>

                    <h2 style='color: #666;'>Delivery Address:</h2>
                    <p>$address, $optional_address<br>$city, $state_name - $pin_code</p>

                    <h2 style='color: #666;'>Items Ordered:</h2>
                    <table style='border-collapse: collapse; width: 100%; margin-top: 10px;'>
                        <thead>
                            <tr style='background-color: #f2f2f2;'>
                                <th style='border: 1px solid #ddd; padding: 10px;'>Item Name</th>
                                <th style='border: 1px solid #ddd; padding: 10px;'>Quantity</th>
                                <th style='border: 1px solid #ddd; padding: 10px;'>Price</th>
                            </tr>
                        </thead>
                        <tbody>";

        // Add cart items dynamically
        foreach ($cart_items as $item) {
            $mail->Body .= "
                <tr>
                    <td style='border: 1px solid #ddd; padding: 10px;'>{$item['name']}</td>
                    <td style='border: 1px solid #ddd; padding: 10px;'>{$item['quantity']}</td>
                    <td style='border: 1px solid #ddd; padding: 10px;'>₹{$item['price']}</td>
                </tr>";
        }

        $mail->Body .= "
                        </tbody>
                    </table>
                    <p style='font-size: 16px; font-weight: bold; margin-top: 10px;'>Total: ₹$amount</p>
                </div>
            </div>";


        // Send the email
        $mail->send();
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

// Helper function to return status-specific messages
function getStatusMessage($status)
{
    switch ($status) {
        case 'Shipped':
            return "🚚 Good news! Your order has been shipped and is on its way.";
        case 'Delivered':
            return "🎉 Hurray! Your order has been successfully delivered.";
        case 'Cancelled':
            return "❌ We're sorry! Your order has been cancelled.";
        case 'Preparing':
            return "🛠️ Hang tight! Your order is being prepared and will be ready soon.";
        default:
            return "ℹ️ Your order status has been updated.";
    }
}





// Order Status Update
if (isset($_POST['submit'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['order_status']);

    // Update order status in the database
    $update_query = "UPDATE `orders` SET `order_status` = '$new_status' WHERE `order_id` = '$order_id'";
    if (mysqli_query($conn, $update_query)) {

        // Send the status update email
        sendOrderStatusEmail(
            $email,
            $first_name,
            $last_name,
            $razorpay_order_id,
            $razorpay_payment_id,
            $total_amount,
            $address,
            $optional_address,
            $city,
            $state,
            $pin_code,
            $cart_item,
            $new_status
        );


        echo "<script>  window.location.href = 'order_details.php?id=$order_id';</script>";
    } else {
        echo "Error updating order status: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>UO - Admin - Order Details</title>
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

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Order Details</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="orders.php">Order</a></li>
                    <li class="breadcrumb-item active">Order Details</li>
                </ol>
            </nav>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body pt-3">
                            <h5 class="card-title">Order Information</h5>

                            <!-- Display Order Items -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Products</label>
                                <div class="col-md-8 col-lg-9">
                                    <?php
                                    foreach ($cart_item as $item) {
                                        echo "<p><strong>Product:</strong> " . htmlspecialchars($item['name']) .
                                            " | <strong>Quantity:</strong> " . htmlspecialchars($item['quantity']) . "</p>";
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Customer Information -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Customer Name</label>
                                <div class="col-md-8 col-lg-9">
                                    <p><?php echo htmlspecialchars($first_name) . " " . htmlspecialchars($last_name); ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Address -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Address</label>
                                <div class="col-md-8 col-lg-9">
                                    <p>
                                        <?php
                                        echo htmlspecialchars($address);
                                        if (!empty($optional_address)) echo ", " . htmlspecialchars($optional_address);
                                        echo ", " . htmlspecialchars($city) . ", " . htmlspecialchars($state) . " - " . htmlspecialchars($pin_code);
                                        ?>
                                    </p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Email -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Email</label>
                                <div class="col-md-8 col-lg-9">
                                    <p><?php echo htmlspecialchars($email); ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Phone -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                <div class="col-md-8 col-lg-9">
                                    <p><?php echo htmlspecialchars($phone); ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Order Notes -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Order Notes</label>
                                <div class="col-md-8 col-lg-9">
                                    <p><?php echo !empty($order_notes) ? htmlspecialchars($order_notes) : "N/A"; ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Payment Details -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Payment ID</label>
                                <div class="col-md-8 col-lg-9">
                                    <p><?php echo htmlspecialchars($razorpay_payment_id); ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Total Amount -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Total Amount</label>
                                <div class="col-md-8 col-lg-9">
                                    <p>₹<?php echo number_format($total_amount, 2); ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Order Status -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Order Status</label>
                                <div class="col-md-8 col-lg-9">
                                    <p><?php echo htmlspecialchars($order_status); ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <!-- Payment Date -->
                            <div class="row mb-3">
                                <label class="col-md-4 col-lg-3 col-form-label">Payment Date</label>
                                <div class="col-md-8 col-lg-9">
                                    <p><?php echo $payment_date; ?></p>
                                </div>
                            </div>
                            <!--  -->

                            <form action="" method="post">
                                <!-- Order Status Type Update -->
                                <div class="row mb-3">
                                    <label for="order_status" class="col-md-4 col-lg-3 col-form-label">Order Status</label>
                                    <div class="col-md-8 col-lg-9">
                                        <select name="order_status" id="order_status" class="form-control" required>
                                            <option value="">Select Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Preparing">Preparing</option>
                                            <option value="Shipped">Shipped</option>
                                            <option value="Delivered">Delivered</option>
                                            <option value="Cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>

                                <!--  -->

                                <div class="text-center">
                                    <button type="submit" name="submit" class="btn btn-primary">Update Order Status</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

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