<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO - Admin - Add Products</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets//vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS   File -->
    <link href="../assets/css/style.css" rel="stylesheet">


</head>

<body>

    <!--  Header -->
    <?php
    include_once('../include/admin_header.php');
    ?>
    <!--  -->

    <!-- Sidebar -->
    <?php
    include_once('../include/admin_sidebar.php');
    ?>
    <!-- -->

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Reports</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">reports</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">

                <div class="col-xl-12">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Order Reports</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Product Reports</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Customer Reports</button>
                                </li>
                            </ul>
                            <!--  -->

                            <div class="tab-content pt-2">
                                <!-- Order products -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <form>

                                        <!--Order Past Date -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Past Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productName" type="date" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Order Date -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Present Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productSize" type="date" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Generate Reports</button>
                                        </div>
                                    </form>

                                </div>
                                <!--  -->

                                <!-- Edit Products -->
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <form>

                                        <!--Product Past Date -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Past Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productName" type="date" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Present Date -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Present Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productSize" type="date" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Generate Reports</button>
                                        </div>
                                    </form>


                                </div>
                                <!--  -->

                                <!-- Customer Reports -->
                                <div class="tab-pane fade pt-3" id="profile-settings">

                                    <form>

                                        <!--Customer Past Date -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Past Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productName" type="date" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Customer Present Date -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Present Date</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productSize" type="date" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Generate Reports</button>
                                        </div>
                                    </form>
                                </div>
                                <!--  -->
                            </div><!-- End Bordered Tabs -->
                        </div>
                    </div>
                </div>
        </section>



    </main>

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