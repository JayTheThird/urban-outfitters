<?php
include_once("../connection.php");
include_once("../config.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use FPDF;

require('../vendor/autoload.php');

// Function to generate the PDF invoice
function generatePDFInvoice($orderId, $paymentId, $date, $amount, $first_name, $last_name, $address, $optional_address, $city, $state, $pin_code, $cart_items)
{
    $pdf = new FPDF();
    $pdf->AddPage();

    // Set a title with larger bold font
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, 'Invoice', 0, 1, 'C');
    $pdf->Ln(5);

    // Customer and Order Information
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 8, "Order ID: $orderId", 0, 0);
    $pdf->Cell(90, 8, "Payment ID: $paymentId", 0, 1, 'R');
    $pdf->Cell(100, 8, "Date: $date", 0, 0);
    $pdf->Cell(90, 8, "Amount Paid: ₹$amount", 0, 1, 'R');
    $pdf->Ln(5);

    // Customer details
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(190, 10, 'Customer Information', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(190, 8, "$first_name $last_name\n$address, $optional_address\n$city, $state - $pin_code", 0, 1);
    $pdf->Ln(5);

    // Items section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(190, 10, 'Items Ordered', 0, 1, 'L');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(80, 8, 'Item Name', 1);
    $pdf->Cell(30, 8, 'Quantity', 1);
    $pdf->Cell(30, 8, 'Price', 1);
    $pdf->Cell(50, 8, 'Total', 1, 1);

    $pdf->SetFont('Arial', '', 10);
    foreach ($cart_items as $item) {
        $total_item_price = $item['quantity'] * $item['price'];
        $pdf->Cell(80, 8, $item['name'], 1);
        $pdf->Cell(30, 8, $item['quantity'], 1);
        $pdf->Cell(30, 8, number_format($item['price'], 2), 1);
        $pdf->Cell(50, 8, number_format($total_item_price, 2), 1, 1);
    }

    // Final total amount
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(160, 8, 'Total Amount:', 0, 0, 'R');
    $pdf->Cell(30, 8, "₹ $amount", 0, 1, 'R');

    // Save PDF to a file
    $pdf_filename = "../admin/uploaded_images/invoices/invoice_$orderId.pdf";
    $pdf->Output($pdf_filename, 'F');
    return $pdf_filename;  // Return the path to the PDF file
}


// Function to send confirmation email with PDF invoice
function sendOrderConfirmationEmail($email, $first_name, $last_name, $razorpayOrderId, $razorpayPaymentId, $amount, $address, $optional_address, $city, $state_name, $pin_code, $cart_items, $pdf_filename)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'urbanoutfittersg25@gmail.com';
        $mail->Password = 'neeaymsxupnfmlow';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('urbanoutfittersg25@gmail.com', "Urban Outfitter's");
        $mail->addAddress($email);

        // Inline CSS styling for the email content
        $mail->isHTML(true);
        $mail->Subject = 'Order Placed Successfully';
        $mail->Body = "
            <div style='line-height: 1.7; color: #8c92a0; font-weight: 300; font-size: 16px; font-family: Arial, sans-serif;'>
                <h1 style='color: #4CAF50;'>Order Confirmation</h1>
                <p>Thank you for your order. Your order details are as follows:</p>
                <p><strong>Order ID:</strong> $razorpayOrderId</p>
                <p><strong>Payment ID:</strong> $razorpayPaymentId</p>
                <p><strong>Amount Paid:</strong> ₹$amount</p>
                <p><strong>Customer Name:</strong> $first_name $last_name</p>
                <p><strong>Shipping Address:</strong> $address, $optional_address, $city, $state_name - $pin_code</p>
                <h2 style='color: #333;'>Items Ordered:</h2>
                <table style='width: 100%; border-collapse: collapse;'>
                    <tr style='background-color: #e6e7e9;'>
                        <th style='border: 1px solid #ddd; padding: 8px;'>Item Name</th>
                        <th style='border: 1px solid #ddd; padding: 8px;'>Quantity</th>
                        <th style='border: 1px solid #ddd; padding: 8px;'>Price</th>
                    </tr>";

        // Loop through the cart items and display them in the email
        foreach ($cart_items as $item) {
            $mail->Body .= "
                <tr>
                    <td style='border: 1px solid #ddd; padding: 8px;'>{$item['name']}</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>{$item['quantity']}</td>
                    <td style='border: 1px solid #ddd; padding: 8px;'>₹{$item['price']}</td>
                </tr>";
        }

        $mail->Body .= "
                </table>
                <p><strong>Total Amount Paid: ₹$amount</strong></p>
                <p style='color: #000;'>Thank you for shopping with Urban Outfitter's!</p>
            </div>";

        // Attach PDF invoice
        $mail->addAttachment($pdf_filename);

        // Send email
        $mail->send();
        echo "Order confirmation email sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}



// Payment processing
if (!empty($_POST['razorpay_payment_id'])) {
    $first_name = $_SESSION['new_first_name'];
    $last_name = $_SESSION['new_last_name'];
    $address = $_SESSION['address'];
    $optional_address = $_SESSION['optional_address'] ?? 'N/A';
    $state_name = $_SESSION['state_name'];
    $city = $_SESSION['city'];
    $pin_code = $_SESSION['pin_code'];
    $email = $_SESSION['new_email'];
    $phone = $_SESSION['new_phone'];
    $razorpayOrderId = $_SESSION['razorpay_order_id'];
    $razorpayPaymentId = $_POST['razorpay_payment_id'];
    $date = date('Y-m-d H:i:s');
    $amount = 0;

    // Retrieve user information
    $user_email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT `uid` FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user_id = $result->fetch_assoc()['uid'];

        // Retrieve cart items
        $stmt = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_query = $stmt->get_result();

        if ($cart_query && $cart_query->num_rows > 0) {
            $cart_items = [];
            while ($row = $cart_query->fetch_assoc()) {
                $item_total = $row['Price'] * $row['Quantity'];
                $amount += $item_total;
                $cart_items[] = [
                    'name' => $row['Name'],
                    'quantity' => $row['Quantity'],
                    'price' => $row['Price']
                ];
            }

            // Generate PDF invoice
            $pdf_filename = generatePDFInvoice($razorpayOrderId, $razorpayPaymentId, $date, $amount, $first_name, $last_name, $address, $optional_address, $city, $state_name, $pin_code, $cart_items);

            // Send order confirmation email
            sendOrderConfirmationEmail($email, $first_name, $last_name, $razorpayOrderId, $razorpayPaymentId, $amount, $address, $optional_address, $city, $state_name, $pin_code, $cart_items, $pdf_filename);

            // Clear cart
            $stmt = $conn->prepare("DELETE FROM `cart` WHERE `user_id` = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            // Redirect to thank you page
            echo "<script>location.replace('thankyou.php');</script>";
        } else {
            echo "Error: No items found in the cart.";
        }
    } else {
        echo "Error: User not found.";
    }
} else {
    echo "Payment Failed";
}
