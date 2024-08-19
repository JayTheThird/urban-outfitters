<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>UO - Registration</title>
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
              <div class="card">
                <div class="card-body">
                  <div class="pt-1 pb-1">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                  </div>

                  <form class="row g-3 needs-validation" method="post" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">First name</label>
                      <input type="text" name="first_name" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your first name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Last name</label>
                      <input type="text" name="last_name" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please, enter your Last name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Contact Number</label>
                      <input type="number" name="contact_number" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please, enter contact number!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter a valid Email adddress!</div>

                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit" name="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="user_login.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>


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

if (isset($_POST['submit']) && isset($_POST['terms'])) {

  // getting textfield values into variables
  $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
  $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
  $contact_number = mysqli_real_escape_string($conn, $_POST['contact_number']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $email_message_body = "
  <head>
  <style>
    @import url(https://cdn.jsdelivr.net/npm/@xz/fonts@1/serve/hk-grotesk.min.css);

    body {
        font-size: 16px;
        background: #f6f6f5;
        font-family: 'HK Grotesk', sans-serif;
    }

    p {
        margin-top: 20px;
        margin-bottom: 24px;
        line-height: 1.5;
        text-align: justify;
    }

    table {
        width: 100%;
    }

    a {
        color: #000000;
        font-weight: 600;
    }

    img {
        width: 100%;
        height: auto;
    }

    .wrapper {
        width: 100%;
        max-width: 567px;
        margin: 32px auto;
    }

    .header {
        padding: 24px 32px;
    }

    .content {
        padding: 20px 32px;
        background-color: #ffffff;
    }

    .footer {
        padding: 20px 32px 24px;
        background-color: #000000;
        color: #ffffff;
        font-size: 14px;
        font-weight: 300;
        line-height: 1.6;
    }

    .footer a {
        font-weight: 600;
        text-decoration: none;
        color: #ffffff;
    }

    a.underline {
        text-decoration: underline;
    }

    a.call-to-action {
        background: #7971ea;
        color: #ffffff;
        padding: 16px 67px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600px;
    }

    .delivery-logo {
        width: 200px;
    }

    .borderless-logo {
        width: 75%;
        max-width: 178px;
    }

    .social-icon {
        width: 16px;
        height: 16px;
        margin-left: 4px;
        text-align: right;
    }

    .social-icons td {
        text-align: right;
    }

    .text-lg {
        font-size: 24px;
    }

    .font-bold {
        font-weight: 600px;
    }
</style>
  </head>
<body>
<div class='wrapper'>
    <div class='content'>
        <table>
            <tr>
                <td>
                    <p>Hello $first_name $last_name </p>
                    <p>Congratulations! You just created a new Account with us.</p>
                </td>
            </tr>
            <tr>
                <td>
                    <a class='call-to-action' href='http://localhost/urban-outfitters/pages/index.php'>Start browsing</a>
                </td>
            </tr>
            <tr>
                <td>
                    <p>If you don't know why you got this email, please get in touch with us here.</p>
                    <p>
                        Best regards, <br />
                        Urban Outfitters.
                    </p>
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
";



  // password hashed
  $password_hash = password_hash($password, PASSWORD_DEFAULT);

  // search email if exist or not
  $is_email_exist = "SELECT * FROM `users` WHERE `email` = '$email'";
  $is_email_exist_query = mysqli_query($conn, $is_email_exist);

  $email_count = mysqli_num_rows($is_email_exist_query);

  if ($email_count > 0) {
    echo "<script>alert('email already exist, do login instead');</script>";
  } else {

    try {
      // if no email found then 
      $create_user = "INSERT INTO `users`(`user_first_name`, `user_last_name`, `email`, `contact_number`, `password`) VALUES ('$first_name','$last_name','$email','$contact_number','$password_hash')";

      $create_user_query = mysqli_query($conn, $create_user);

      // sending email
      $mail = new PHPMailer(true);

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
      $mail->Subject = 'Welcome to UO Family';
      $mail->Body    = $email_message_body;

      $mail->send();

      if ($create_user) {
        echo "<script>alert('registration successful'); 
                      location.replace('user_login.php');
                      </script>";
      } else {
        echo "<script>alert('unexpected event occurred, please try again some time');</script>";
      }
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
