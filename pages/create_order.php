<?php
session_start();
include_once("../connection.php");
include_once("../config.php");

require('../vendor/autoload.php');

use Razorpay\Api\Api;

// Check if form data is posted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get posted data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['main_address'];
    $optional_address = $_POST['optional_address'];
    $state_name = $_POST['state_name'];
    $city = $_POST['c_state_country'];
    $pin_code = $_POST['c_postal_zip'];
    $email = $_POST['c_email_address'];
    $phone = $_POST['c_phone'];
    $order_notes = $_POST['order_notes'];

    // Calculate order total
    $subtotal = 0;
    $user_email = $_SESSION['email'];
    $get_user_id = mysqli_query($conn, "SELECT `uid` FROM `users` WHERE `email` = '$user_email'");

    if ($get_user_id && mysqli_num_rows($get_user_id) > 0) {
        $user_row = mysqli_fetch_assoc($get_user_id);
        $user_id = $user_row['uid'];

        // Fetch cart items for the logged-in user
        $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE `user_id` = $user_id");

        if ($cart_query && mysqli_num_rows($cart_query) > 0) {
            while ($fetch_data = mysqli_fetch_assoc($cart_query)) {
                $subtotal += $fetch_data['Price'] * $fetch_data['Quantity'];
            }
        } else {
            echo "Error: Cart is empty.";
            exit();
        }
    } else {
        echo "Error: User not found.";
        exit();
    }

    // Check if subtotal is valid
    if ($subtotal <= 0) {
        echo "Error: Subtotal is invalid.";
        exit();
    }

    // Razorpay API setup
    $api_key = getenv('rzp_test_aIaZfY4HFI1m8R');  // Store your API key securely
    $api_secret = getenv('sCHzyQAQLQIbRzIGUIc4qsGn');  // Store your API secret securely

    $api = new Api($api_key, $api_secret);

    try {
        // Create Razorpay order
        $orderData = [
            'amount' => $subtotal * 100, // Amount in paise
            'currency' => 'INR',
            'receipt' => 'receipt#1',
            'payment_capture' => 1
        ];

        $razorpayOrder = $api->order->create($orderData);
        echo json_encode($razorpayOrder);
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }
}
