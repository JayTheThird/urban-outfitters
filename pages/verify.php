<?php
include_once("../connection.php");
include_once("../config.php");
session_start();

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
            while ($fetch_data = $cart_query->fetch_assoc()) {
                $total = $fetch_data['Price'] * $fetch_data['Quantity'];
                $cart_items[] = [
                    'name' => $fetch_data['Name'],
                    'quantity' => $fetch_data['Quantity'],
                    'price' => $fetch_data['Price'] // Assuming you want price

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

                echo "<script>location.replace('thankyou.php');</script>";
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
