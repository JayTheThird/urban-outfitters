<?php
include_once("../connection.php");
include_once("../config.php");
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('../vendor/autoload.php');

$success = true;
$error = "Payment Failed";

// Check if Razorpay payment ID is present
if (!empty($_POST['razorpay_payment_id'])) {
    // Simulate payment verification success for this plain PHP version
}

if ($success) {
    // Retrieve session variables
    $first_name = $_SESSION['new_first_name'];
    $last_name = $_SESSION['new_last_name'];
    $address = $_SESSION['address'];

    // Check if optional_address and order_notes are NULL or empty
    $optional_address = !empty($_SESSION['optional_address']) ? $_SESSION['optional_address'] : 'N/A';
    $order_notes = !empty($_SESSION['order_notes']) ? $_SESSION['order_notes'] : 'N/A';

    $state_name = $_SESSION['state_name'];
    $city = $_SESSION['city'];
    $pin_code = $_SESSION['pin_code'];
    $email = $_SESSION['new_email'];
    $phone = $_SESSION['new_phone'];
    $razorpayOrderId = $_SESSION['razorpay_order_id'];
    $razorpayPaymentId = $_POST['razorpay_payment_id'];
    $amount;
    $date = date('Y-m-d H:i:s');

    // Get user email from session
    $user_email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT `uid` FROM `users` WHERE `email` = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user_row = $result->fetch_assoc();
        $user_id = $user_row['uid'];

        // Fetch cart items for the logged-in user
        $stmt = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $cart_query = $stmt->get_result();

        if ($cart_query && $cart_query->num_rows > 0) {
            $cart_items = [];
            $total = 0;
            while ($fetch_data = $cart_query->fetch_assoc()) {
                $item_total = $fetch_data['Price'] * $fetch_data['Quantity'];
                $total += $item_total;
                $cart_items[] = [
                    'name' => $fetch_data['Name'],
                    'quantity' => $fetch_data['Quantity'],
                    'price' => $fetch_data['Price']
                ];
            }

            // Serialize cart items to JSON
            $cart_items_json = json_encode($cart_items);
            $amount = $total;

            // Save the order details to the database
            $insert_order_query = "INSERT INTO orders (user_id, first_name, last_name, address, optional_address, state, city, pin_code, email, phone, order_notes, razorpay_order_id, razorpay_payment_id, total_amount, payment_date, cart_items) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($insert_order_query);
            $stmt->bind_param("isssssssssssssss", $user_id, $first_name, $last_name, $address, $optional_address, $state_name, $city, $pin_code, $email, $phone, $order_notes, $razorpayOrderId, $razorpayPaymentId, $amount, $date, $cart_items_json);

            if ($stmt->execute()) {
                // Clear cart after successful order
                $stmt = $conn->prepare("DELETE FROM `cart` WHERE `user_id` = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();

                // Send an order confirmation email to the user
                try {
                    $mail = new PHPMailer(true);

                    $mail->SMTPDebug = SMTP::DEBUG_OFF;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'urbanoutfittersg25@gmail.com';
                    $mail->Password   = 'neeaymsxupnfmlow';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    //Recipients
                    $mail->setFrom('urbanoutfittersg25@gmail.com', "Urban Outfitter's");
                    $mail->addAddress($email);

                    // Email Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Order Placed Successfully';

                    // Generate email body with CSS and order details
                    $email_message_body = "
                        <div style='font-family: Arial, sans-serif;'>
                            <div style='background-color: #f4f4f4; padding: 20px;'>
                                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>
                                    <h1 style='color: #333333; text-align: center;'>Thank you for your order!</h1>
                                    <p style='font-size: 16px; color: #555555;'>Hello <strong>$first_name $last_name</strong>,</p>
                                    <p style='font-size: 16px; color: #555555;'>Your order has been successfully placed. Here are the details:</p>
                                    
                                    <h2 style='color: #333333; border-bottom: 1px solid #ddd; padding-bottom: 10px;'>Order Details:</h2>
                                    <p style='font-size: 16px; color: #555555;'><strong>Order ID:</strong> $razorpayOrderId</p>
                                    <p style='font-size: 16px; color: #555555;'><strong>Payment ID:</strong> $razorpayPaymentId</p>
                                    <p style='font-size: 16px; color: #555555;'><strong>Amount Paid:</strong> $$amount</p>
                                    
                                    <h2 style='color: #333333; border-bottom: 1px solid #ddd; padding-bottom: 10px;'>Shipping Address:</h2>
                                    <p style='font-size: 16px; color: #555555;'>$address, $optional_address, $city, $state_name - $pin_code</p>
                                    
                                    <h2 style='color: #333333; border-bottom: 1px solid #ddd; padding-bottom: 10px;'>Items Ordered:</h2>
                                    <ul style='font-size: 16px; color: #555555;'>";

                    // Add items to the email body
                    foreach ($cart_items as $item) {
                        $email_message_body .= "<li>{$item['name']} - Quantity: {$item['quantity']} - Price: {$item['price']}</li>";
                    }

                    $email_message_body .= "</ul>
                                </div>
                            </div>
                        </div>";

                    // Set email body
                    $mail->Body = $email_message_body;

                    // Send the email
                    $mail->send();

                    echo "<script>location.replace('thankyou.php');</script>";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error: Could not place order.";
            }
        } else {
            echo "Error: No items found in the cart.";
        }
    } else {
        echo "Error: User not found.";
    }
} else {
    // Payment failed
    echo $error;
}
