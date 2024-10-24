<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO | Forgot Password</title>
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

    <?php

    include_once("../connection.php");
    include_once("../config.php");

    if (isset($_GET['email']) && isset($_GET['reset_token'])) {
        date_default_timezone_set('Asia/Kolkata');
        $Date = date("y-m-d");

        $query = "SELECT * FROM `users` WHERE `email` = '$_GET[email]' AND `token` = '$_GET[reset_token]' AND `token_expire` = '$Date'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                echo " 
                <div class='container'>
    <section class='section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4'>
        <div class='container'>
            <div class='row justify-content-center'>
                <div class='col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center'>           
                <div class='card mb-3'>
      <div class='card-body'>
          <div class='pt-1 pb-1'>
              <h5 class='card-title text-center pb-0 fs-4'>Update Your Password</h5>
          </div>
          <form class='row g-3 needs-validation' method='post' novalidate>
             <div class='col-12'>
     <label for='yourUsername' class='form-label'>Email</label>
     <div class='input-group has-validation'>
         <span class='input-group-text' id='inputGroupPrepend'>@</span>
         <input type='email' name='email' class='form-control' id='yourUsername' value='$_GET[email]' required readonly>
     </div>
 </div>

              <div class='col-12'>
                  <label for='yourUsername' class='form-label'>password</label>
                  <input type='password' name='password' class='form-control' id='yourPassword'   required>
                  <div class='invalid-feedback'>Please enter your password!</div>
              </div>
        
              <div class='col-12'>
                  <button class='btn btn-primary w-100' type='submit' name='submit'>Update</button>
              </div>
                        </form>
                    </div>
                </div>
             </div>
            </div>
        </div>
    </section>
</div>";
            } else {
                echo '<script>
                alert("invalid or Expired Link");
                window.location.href = "User_login.php";
            </script>';
            }
        } else {
            echo '<script>
            alert("Server Down Try Again letter");
            window.location.href = "User_login.php";
        </script>';
        }
    }


    ?>


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

if (isset($_POST['submit'])) {
    // echo 'clicked';

    $password = $_POST['password'];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Query
    $password_update = "UPDATE `users` SET `password`='$password_hashed',`token`= NULL,`token_expire`= NULL WHERE `email` = '$_POST[email]'";

    if (mysqli_query($conn, $password_update)) {
        echo '<script>
            alert("Password Successfully Updated");
            window.location.href = "User_login.php";
        </script>';
    } else {
        echo '<script>
            alert("Server Down Try Again letter");
            window.location.href = "User_login.php";
        </script>';
    }
}



?>