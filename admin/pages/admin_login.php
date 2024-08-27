<?php
session_start();
include_once("../connection.php");
include_once("../config.php");


if (isset($_SESSION['admin_name'])) {
    header("location:admin_index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO - Admin - Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets//vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">


</head>

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <!-- title -->
                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="../pages/admin/assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Urban Outfitter's Admin</span>
                                </a>
                            </div>
                            <!--  -->

                            <!-- fields -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-1 pb-1">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                    </div>

                                    <form class="row g-3 needs-validation" method="post" novalidate>
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Admin Name</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="admin_name" class="form-control" id="yourUsername" required>
                                                <div class="invalid-feedback">Please enter Unique Admin Name.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>

                                            <input type="password" name="admin_password" class="form-control" id="yourPassword" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit" name="submit">Login</button>
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
    <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../assets/vendor/echarts/echarts.min.js"></script>
    <script src="../assets/vendor/quill/quill.js"></script>
    <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

</body>

</html>

<?php
// making input felid filter so we can check if entered data is not malicious
function inputFilter($Data)
{
    $Data = trim($Data);
    $Data = stripslashes($Data);
    $Data = htmlentities($Data);
    return $Data;
}

if (isset($_POST['submit'])) {

    # Filtering Data that is Entered By Admins
    $admin_name = inputFilter($_POST['admin_name']);
    $admin_password = inputFilter($_POST['admin_password']);

    # prevent Mysqli injection (ignore Special Symbols)
    $admin_unique_name = mysqli_real_escape_string($conn, $admin_name);
    $admin_password = mysqli_real_escape_string($conn, $admin_password);

    #query Template
    $query = "SELECT * FROM `admin` WHERE `admin_name` = ? AND `password` = ?";

    #prepared Statement
    if ($prepared_Statement = mysqli_prepare($conn, $query)) {

        #Binding Values To Template or Prepared Statement
        mysqli_stmt_bind_param($prepared_Statement, "ss", $admin_name, $admin_password);

        # Executing Prepared Statement
        mysqli_stmt_execute($prepared_Statement);

        # Transferring the Result of Execution in $prepared_Statement 
        mysqli_stmt_store_result($prepared_Statement);

        if (mysqli_stmt_num_rows($prepared_Statement) == 1) {
            // echo "Details Matched";
            $_SESSION['admin_name'] = $admin_name;
            echo "<script>alert('login successful'); 
                      location.replace('admin_index.php');
              </script>";
        } else {
            echo "<script>
              alert('Invalid Details');
            </script>";
        }
        mysqli_stmt_close($prepared_Statement);
    } else {
        echo "<script>
            alert('Can Not be Prepared');
         </script>";
    }
}

?>