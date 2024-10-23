<?php
include_once("../connection.php");
include_once("../config.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('../vendor/autoload.php');
require('../vendor/setasign/fpdf/fpdf.php'); // Make sure to include the FPDF file if not autoloaded

// Function to generate the PDF invoice

function generatePDFInvoice($orderId, $paymentId, $date, $amount, $first_name, $last_name, $address, $optional_address, $city, $state, $pin_code, $cart_items, $razorpayOrderId)
{
    $pdf = new FPDF(); // Create an instance of FPDF
    $pdf->AddPage();

    // Title
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(190, 10, 'Invoice', 0, 1, 'C');
    $pdf->Ln(5);

    // Order and Customer Info
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(100, 8, "Order ID: $orderId", 0, 0);
    $pdf->Cell(90, 8, "Payment ID: $paymentId", 0, 1, 'R');
    $pdf->Cell(100, 8, "Date: $date", 0, 0);
    $pdf->Cell(90, 8, "Amount Paid: Rs $amount", 0, 1, 'R');
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

    // Final total
    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(160, 8, 'Total Amount:', 0, 0, 'R');
    $pdf->Cell(30, 8, "Rs $amount", 0, 1, 'R');

    // Footer
    $pdf->SetY(-15);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->Cell(0, 10, 'Thank you for your business!', 0, 0, 'C');

    // Save PDF to file
    $pdf_filename = "../admin/uploaded_images/invoices/invoice_$razorpayOrderId.pdf";
    $pdf->Output($pdf_filename, 'F');
    return $pdf_filename;
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

        $mail->isHTML(true);
        $mail->Subject = 'Order Placed Successfully';
        $mail->Body = "
            <div style='font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;'>
                <div style='max-width: 600px; margin: auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);'>
                    <h1 style='color: #333;'>Order Confirmation</h1>
                    <p style='font-size: 16px;'>Thank you for your order, <strong>$first_name $last_name</strong></p>
                    <p><strong>Order ID:</strong> $razorpayOrderId</p>
                    <p><strong>Payment ID:</strong> $razorpayPaymentId</p>
                    <p><strong>Amount Paid:</strong> ₹$amount</p>
                    <h2 style='color: #666;'>Delivery Address:</h2>
                    <p style='margin: 0;'>$address, $optional_address<br>$city, $state_name - $pin_code</p>
                    <h2 style='color: #666;'>Items Ordered:</h2>
                    <table style='border-collapse: collapse; width: 100%; margin-top: 10px;'>
                        <thead>
                            <tr style='background-color: #f2f2f2;'>
                                <th style='border: 1px solid #ddd; padding: 10px; text-align: left;'>Item Name</th>
                                <th style='border: 1px solid #ddd; padding: 10px; text-align: left;'>Quantity</th>
                                <th style='border: 1px solid #ddd; padding: 10px; text-align: left;'>Price</th>
                            </tr>
                        </thead>
                        <tbody>";

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
                <p style='font-size: 16px; font-weight: bold; margin-top: 10px;'><strong>Total:</strong> ₹$amount</p>
            </div>
        </div>";

        // Attach the PDF invoice
        $mail->addAttachment($pdf_filename);

        // Send the email
        $mail->send();
        echo "Order confirmation email sent!";
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}


// Store order with cart items as JSON
function addOrderToDB(
    $conn,
    $user_id,
    $first_name,
    $last_name,
    $address,
    $optional_address,
    $state_name,
    $city,
    $pin_code,
    $email,
    $phone,
    $order_notes,
    $razorpayOrderId,
    $razorpayPaymentId,
    $amount,
    $date,
    $order_status,
    $cart_items
) {
    // Encode cart items to JSON format
    $cart_json = json_encode($cart_items);

    // Prepare SQL query with all the required fields including 'order_notes'
    $order_query = "INSERT INTO orders (
        user_id, first_name, last_name, address, optional_address, state, 
        city, pin_code, email, phone, order_notes, razorpay_order_id, 
        razorpay_payment_id, total_amount, cart_item, payment_date, order_status
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($order_query);

    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param(
        'issssssssssssdsss',
        $user_id,
        $first_name,
        $last_name,
        $address,
        $optional_address,
        $state_name,
        $city,
        $pin_code,
        $email,
        $phone,
        $order_notes,
        $razorpayOrderId,
        $razorpayPaymentId,
        $amount,
        $cart_json,
        $date,
        $order_status
    );

    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    // Return the ID of the inserted order
    return $stmt->insert_id;
}


// Payment handling
if (!empty($_POST['razorpay_payment_id'])) {
    // Retrieve session data
    $first_name = $_SESSION['new_first_name'];
    $last_name = $_SESSION['new_last_name'];
    $address = $_SESSION['address'];
    $optional_address = isset($_SESSION['optional_address']) ? $_SESSION['optional_address'] :  "N/A";
    $order_notes = isset($_SESSION['order_notes']) ? $_SESSION['order_notes'] : 'N/A';
    $state_name = $_SESSION['state_name'];
    $city = $_SESSION['city'];
    $pin_code = $_SESSION['pin_code'];
    $email = $_SESSION['new_email'];
    $phone = $_SESSION['new_phone'];
    $razorpayOrderId = $_SESSION['razorpay_order_id'];
    $razorpayPaymentId = $_POST['razorpay_payment_id'];
    $date = date('Y-m-d H:i:s');
    $amount = 0;

    $user_email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT uid FROM users WHERE email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $user_id = $stmt->get_result()->fetch_assoc()['uid'];

    $cart_items = [];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $amount += $row['Price'] * $row['Quantity'];
        $cart_items[] = [
            'name' => $row['Name'],
            'quantity' => $row['Quantity'],
            'price' => $row['Price']
        ];
    }

    // Add order to database
    $order_id = addOrderToDB(
        $conn,
        $user_id,
        $first_name,
        $last_name,
        $address,
        $optional_address,
        $state_name,
        $city,
        $pin_code,
        $email,
        $phone,
        $order_notes,
        $razorpayOrderId,
        $razorpayPaymentId,
        $amount,
        $date,
        'Successful',
        $cart_items
    );

    // Generate PDF Invoice
    $pdf_filename = generatePDFInvoice($order_id, $razorpayPaymentId, $date, $amount, $first_name, $last_name, $address, $optional_address, $city, $state_name, $pin_code, $cart_items, $razorpayOrderId);

    // Send Confirmation Email with Invoice
    sendOrderConfirmationEmail($email, $first_name, $last_name, $razorpayOrderId, $razorpayPaymentId, $amount, $address, $optional_address, $city, $state_name, $pin_code, $cart_items, $pdf_filename);

    // Clear Cart after Successful Order
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Redirect to thank you page
    echo "<script>location.replace('thankyou.php');</script>";
} else {
    echo "<script>location.replace('payment_failed.php');</script>";
}
