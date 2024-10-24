<?php
session_start();
if (isset($_SESSION['user_first_name'], $_SESSION['contact_number'])) {
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO - Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../images/favicon.png" rel="icon">
    <link href="../images/favicon.png" rel="apple-touch-icon">

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
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
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
                                            <label for="yourPassword" class="form-label">Password</label>

                                            <input type="password" name="password" class="form-control" id="yourPassword" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Didn't Remember <a href="user_forgot_password.php">Password?</a></p>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
                                        </div>

                                        <div class="col-12">
                                            <p class="small mb-0">Don't have account? <a href="user_signup.php">Create an account</a></p>
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

if (isset($_POST["submit"])) {

    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    // search email if exist or not
    $is_email_exist = "SELECT * FROM `users` WHERE `email` = '$email'";
    $is_email_exist_query = mysqli_query($conn, $is_email_exist);

    $email_count = mysqli_num_rows($is_email_exist_query);

    if ($email_count) {
        // extract user details
        $account_details = mysqli_fetch_assoc($is_email_exist_query);



        // checking user entered password with stored password 
        $original_password = $account_details["password"];
        $password_verify = password_verify($password, $original_password);

        // is password correct then redirect to home page
        if ($password_verify) {

            // Storing values in session
            $_SESSION['user_id'] = $account_details['uid'];
            $_SESSION['user_first_name'] = $account_details['user_first_name'];
            $_SESSION['user_last_name'] = $account_details['user_last_name'];
            $_SESSION['email'] = $account_details['email'];
            $_SESSION['contact_number'] = $account_details['contact_number'];

            echo "<script>alert('login successful'); 
                      location.replace('index.php');
              </script>";
        } else {
            echo "<script>
                    alert('incorrect password');   
              </script>";
        }
    } else {
        // if email not registered 
        echo "<script>alert('$email - not found, Register First!');</script>";
    }
}


?>