<?php
include_once("../connection.php");
include_once("../config.php");
require('config_razorpay.php');
require('../vendor/razorpay/razorpay/Razorpay.php');
session_start();

// Create the Razorpay Order
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

    // Store variables in session
    $_SESSION['new_first_name'] = $first_name;
    $_SESSION['new_last_name'] = $last_name;
    $_SESSION['address'] = $address;
    $_SESSION['optional_address'] = $optional_address;
    $_SESSION['state_name'] = $state_name;
    $_SESSION['city'] = $city;
    $_SESSION['pin_code'] = $pin_code;
    $_SESSION['new_email'] = $email;
    $_SESSION['new_phone'] = $phone;
    $_SESSION['order_notes'] = $order_notes;
    $_SESSION['subtotal'] = $subtotal; // Store subtotal if needed

    $api = new Api($keyId, $keySecret);

    // Make sure the receipt is a string
    $orderData = [
        'receipt'         => '3456', // Ensure this is a string
        'amount'          => $subtotal * 100, // Convert to paise
        'currency'        => 'INR',
        'payment_capture' => 1 // Auto capture
    ];

    $razorpayOrder = $api->order->create($orderData);

    $razorpayOrderId = $razorpayOrder['id'];
    $_SESSION['razorpay_order_id'] = $razorpayOrderId;

    $displayAmount = $amount = $orderData['amount'];

    if ($displayCurrency !== 'INR') {
        $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
        $exchange = json_decode(file_get_contents($url), true);

        $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
    }

    $data = [
        "key"               => $keyId,
        "amount"            => $amount,
        "name"              => "Urban Outfitter's",
        "description"       => "Tron Legacy",
        "image"             => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
        "prefill"           => [
            "name"              => "$first_name " . "$last_name",
            "email"             => "$email",
            "contact"           => "$phone",
        ],
        "notes"             => [
            "address"           => "$address",
            "merchant_order_id" => "12312321",
        ],
        "theme"             => [
            "color"             => "#F37254"
        ],
        "order_id"          => $razorpayOrderId,
    ];

    if ($displayCurrency !== 'INR') {
        $data['display_currency']  = $displayCurrency;
        $data['display_amount']    = $displayAmount;
    }

    $json = json_encode($data);
}
?>

<form action="verify.php" method="POST">
    <script
        src="https://checkout.razorpay.com/v1/checkout.js"
        data-key="<?php echo $data['key'] ?>"
        data-amount="<?php echo $data['amount'] ?>"
        data-currency="INR"
        data-name="<?php echo $data['name'] ?>"
        data-image="<?php echo $data['image'] ?>"
        data-description="<?php echo $data['description'] ?>"
        data-prefill.name="<?php echo $data['prefill']['name'] ?>"
        data-prefill.email="<?php echo $data['prefill']['email'] ?>"
        data-prefill.contact="<?php echo $data['prefill']['contact'] ?>"
        data-notes.shopping_order_id="3456"
        data-order_id="<?php echo $data['order_id'] ?>"
        <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount'] ?>" <?php } ?>
        <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency'] ?>" <?php } ?>>
    </script>
    <input type="hidden" name="shopping_order_id" value="<?php echo $data['order_id'] ?>">
</form>