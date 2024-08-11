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
            <h1>Profile</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Users</li>
                    <li class="breadcrumb-item active">Profile</li>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Add Products</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Products</button>
                                </li>

                                <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Delete Products</button>
                                </li>
                            </ul>
                            <!--  -->

                            <div class="tab-content pt-2">
                                <!-- Add Products -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <form>
                                        <!-- Product image -->
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Product Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="assets/img/profile-img.jpg" alt="product image">
                                                <div class="pt-2">
                                                    <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Name -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productName" type="text" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Size -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Size</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productSize" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Price -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Price</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productPrice" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Quantity -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Quantity</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productPrice" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Description  -->
                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Product Description</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="about" class="form-control" id="about" style="height: 100px"></textarea>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Add Products</button>
                                        </div>
                                    </form>

                                </div>
                                <!--  -->

                                <!-- Edit Products -->
                                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                    <form>
                                        <!-- Product image -->
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Product Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="assets/img/profile-img.jpg" alt="product image">
                                                <div class="pt-2">
                                                    <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                                    <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Name -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productName" type="text" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Size -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Size</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productSize" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Price -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Price</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productPrice" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Quantity -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Quantity</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productPrice" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Description  -->
                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Product Description</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="about" class="form-control" id="about" style="height: 100px"></textarea>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Update Products</button>
                                        </div>
                                    </form>

                                </div>
                                <!--  -->

                                <!-- Delete Products -->
                                <div class="tab-pane fade pt-3" id="profile-settings">

                                    <!-- Settings Form -->
                                    <form>

                                        <!-- Product ID -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product ID</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="productSize" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Delete Product</button>
                                        </div>
                                    </form><!-- End settings Form -->

                                </div>
                                <!--  -->



                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>


                </div>
        </section>

        <!-- Top Selling -->
        <div class="col-12">
            <div class="card top-selling overflow-auto">

                <div class="card-body pb-0">
                    <h5 class="card-title">Added Products</h5>

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">image</th>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>101</th>
                                <th scope="row"><a href="#"><img src="../images/products/f1.jpg" alt=""></a></th>
                                <td><a href="#" class="text-primary fw-bold">Linen Shirts</a></td>
                                <td>₹ 64</td>
                                <td class="fw-bold">124</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- End Top Selling -->

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