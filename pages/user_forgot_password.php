<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO - Forgot Password</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../admin/assets/img/favicon.png" rel="icon">
    <link href="../admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../admin/assets/css/style.css" rel="stylesheet">


</head>

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <!-- fields -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-1 pb-1">
                                        <h5 class="card-title text-center pb-0 fs-4">Change Password</h5>
                                    </div>

                                    <form class="row g-3 needs-validation" method="post" novalidate>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="email" name="email" class="form-control" id="yourUsername" required>
                                                <div class="invalid-feedback">Please enter your email.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <p class="small mb-0">Remember Password <a href="user_login.php">Wan't to go back?</a></p>
                                        </div>


                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit" name="submit">Send Email</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <!--  -->


                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../admin/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../admin/assets/vendor/echarts/echarts.min.js"></script>
    <script src="../admin/assets/vendor/quill/quill.js"></script>
    <script src="../admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../admin/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../admin/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../admin/assets/js/main.js"></script>

</body>

</html>

<?php
include_once("../connection.php");
include_once("../config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require('../vendor/autoload.php');

// Send mail
function sendMail($email, $reset_token)
{
    $Subject = "Password Reset Link From Urban Outfitter's";
    $Body = "We Got a Request From you to Reset Your Password <br> Click The Link Below : <br> <a href='http://localhost/urban-outfitters/pages/user_update_password.php?email=$email&reset_token=$reset_token'>Reset Password</a>";
    //Load Composer's autoloader


    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
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

        //Content
        $mail->isHTML(true);
        $mail->Subject = $Subject;
        $mail->Body = $Body;


        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST["submit"])) {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);


    // search email if exist or not
    $is_email_exist = "SELECT * FROM `users` WHERE `email` = '$email'";
    $is_email_exist_query = mysqli_query($conn, $is_email_exist);



    if ($is_email_exist_query) {
        if (mysqli_num_rows($is_email_exist_query) == 1) {
            // email found
            $reset_token = bin2hex(random_bytes(16));
            date_default_timezone_set('Asia/Kolkata');
            $reset_date = date("y-m-d");

            // update query
            $password_update = "UPDATE `users` SET `token`='$reset_token', `token_expire`='$reset_date' WHERE `email`='$email'";

            if (mysqli_query($conn, $password_update) && sendMail($email, $reset_token)) {
                echo
                '<script>
                        alert("Server Down Try Again letter");
                        window.location.href = "user_login.php";
                    </script>';
            } else {
                echo
                '<script>
                        alert("Password Reset Link Send To mail");
                        window.location.href = "user_login.php";
                    </script>';
            }
        } else {
            echo '<script>
                    alert("Email Not Found!");
                    window.location.href = "user_login.php";
                </script>';
        }
    } else {
        echo '<script>
                alert("Can Not Run Query");
                window.location.href = "user_login.php";
            </script>';
    }
}


?>