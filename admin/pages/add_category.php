<?php
session_start();
include_once("../connection.php");
include_once("../config.php");


if (!isset($_SESSION['admin_name'])) {
    header("location:admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>UO - Admin - Add Category</title>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Add Category</button>
                                </li>

                                <!-- <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Category</button>
                                </li> -->

                            </ul>
                            <!--  -->

                            <div class="tab-content pt-2">
                                <!-- Add Category -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <form method="post" action="sub_category_impl.php" enctype="multipart/form-data">
                                        <!-- Category image -->
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Category Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="pt-2">
                                                    <input type="file" name="category_image" id="">
                                                </div>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Category type -->
                                        <div class="row mb-3">
                                            <label for="category_type" class="col-md-4 col-lg-3 col-form-label">Category Type</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="category_type" id="categoryType" class="form-control">
                                                    <option selected>Select Category</option>
                                                    <?php
                                                    $category_select = "SELECT * FROM `product_category`";
                                                    $query = mysqli_query($conn, $category_select);

                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $category_Id  = $row['category_id'];
                                                        $category = $row['category'];

                                                        echo " <option value=$category_Id>$category</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Sub category type -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Sub Category</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="sub_category" type="text" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary" name="submit">Add Category</button>
                                        </div>
                                    </form>
                                </div>
                                <!--  -->
                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>


                </div>
        </section>

        <!-- Category Display -->
        <div class="col-12">
            <div class="card top-selling overflow-auto">

                <div class="card-body pb-0">
                    <h5 class="card-title">Added Categories</h5>

                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">IMAGE</th>
                                <th scope="col">CATEGORY TYPE</th>
                                <th scope="col">SUB CATEGORY</th>
                                <th scope="col">EDIT</th>
                                <th scope="col">REMOVE</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // 
                            $selected_categories = mysqli_query($conn, "SELECT product_sub_category.*, product_category.category 
                                            FROM product_sub_category 
                                            JOIN product_category ON product_sub_category.category_id = product_category.category_id
                                            WHERE product_sub_category.is_deleted = 0");


                            if (mysqli_num_rows($selected_categories) > 0) {
                                while ($row = mysqli_fetch_assoc($selected_categories)) {
                            ?>
                                    <tr>
                                        <th><?php echo $row['sub_category_id']; ?></th>
                                        <th scope="row"><img src="../uploaded_images/category/<?php echo $row['sub_category_image']; ?>" alt="Category Image not load" style="height: 70px; width: 70px;"></th>
                                        <td><?php echo $row['category']; ?></td> <!-- Display category name instead of ID -->
                                        <td><?php echo $row['sub_category_name']; ?></td>
                                        <td>
                                            <a href="./update_category.php?edit=<?php echo $row['sub_category_id']; ?>" style="height: 50px;">
                                                <i class='bx bx-edit bx-sm'></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="./add_category.php?delete=<?php echo $row['sub_category_id']; ?>" style="height: 50px;">
                                                <i class='bx bx-message-square-x bx-sm'></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>

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

<!-- for delete sub categories -->
<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Fetch the image file name associated with this subcategory
    $result = mysqli_query($conn, "SELECT `sub_category_image` FROM `product_sub_category` WHERE `sub_category_id` = $id");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imageFileName = $row['sub_category_image'];

        // Define the path to the image file
        $imagePath = __DIR__ . "/../uploaded_images/category/" . $imageFileName;

        // Delete the image file from the server
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Set is_deleted to 1 instead of deleting the row
    mysqli_query($conn, "UPDATE `product_sub_category` SET `is_deleted` = 1 WHERE `sub_category_id` = $id") or die('Query Failed');

    echo "<script>
            location.replace('add_category.php');
        </script>";
}
?>