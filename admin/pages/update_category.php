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

    <title>UO - Admin - Update Category</title>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Update Category</button>
                                </li>

                                <!-- <li class="nav-item">
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Category</button>
                                </li> -->

                            </ul>
                            <!--  -->

                            <div class="tab-content pt-2">
                                <!-- Update Category -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <?php
                                    if (isset($_GET['edit'])) {
                                        $category_edit_Id = $_GET['edit'];
                                        $category_edit = "SELECT * FROM `product_sub_category` WHERE `sub_category_id` = $category_edit_Id";
                                        $category_query = mysqli_query($conn, $category_edit);

                                        if (mysqli_num_rows($category_query) > 0) {
                                            while ($fetched_data = mysqli_fetch_assoc($category_query)) {
                                    ?>
                                                <form method="post" action="" enctype="multipart/form-data">

                                                    <input type="hidden" name="old_category_image" value="<?php echo $fetched_data['sub_category_image']; ?>">
                                                    <input type="hidden" name="updated_sub_category_id" value="<?php echo $fetched_data['sub_category_id']; ?>">

                                                    <!-- Category old image -->
                                                    <div class="row mb-3">
                                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Category Old Image</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <img src="../uploaded_images/category/<?php echo $fetched_data['sub_category_image']; ?>" alt="Image not found" height="200" width="200">
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Category new image -->
                                                    <div class="row mb-3">
                                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Category new Image</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <div class="pt-2">
                                                                <input type="file" name="updated_category_image" id="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Category type -->
                                                    <div class="row mb-3">
                                                        <label for="category_type" class="col-md-4 col-lg-3 col-form-label">Category Type</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <select name="updated_category_type" id="categoryType" class="form-control">
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
                                                            <input name="updated_sub_category" type="text" class="form-control" id="fullName" value="<?php echo $fetched_data['sub_category_name']; ?>">
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary" name="update">Update Category</button>
                                                    </div>
                                                </form>
                                    <?php
                                            }
                                        }
                                    }

                                    ?>
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

<?php
if (isset($_POST['update'])) {

    // Retrieve form data
    $updated_sub_category_id = $_POST['updated_sub_category_id'];
    $updated_sub_category = $_POST['updated_sub_category'];
    $updated_category_type = $_POST['updated_category_type'];
    $updated_date = date("Y/m/d"); 

    // Old image file name
    $old_category_image_name = $_POST["old_category_image"]; 
    $old_category_image_path = "../uploaded_images/category/" . $old_category_image_name; 

    // Initialize the filename variable with the old image name
    $filename = $old_category_image_name;

    // Check if a new image has been uploaded
    if (!empty($_FILES["updated_category_image"]["name"])) {
        // Generate a unique filename for the new image using the current time
        $filename = time() . '-' . $_FILES["updated_category_image"]["name"];
        $temp_name = $_FILES["updated_category_image"]["tmp_name"]; 
        $folder = "../uploaded_images/category/" . $filename; 


        if (move_uploaded_file($temp_name, $folder)) {
            // Check if the old image exists, then delete it
            if (file_exists($old_category_image_path)) {
                unlink($old_category_image_path);
            }
        } else {
            echo "Failed to upload new image.";
            exit();
        }
    }


    $update_category = mysqli_query($conn, "UPDATE `product_sub_category` SET `category_id`='$updated_category_type',`sub_category_name`='$updated_sub_category',`sub_category_image`='$filename',`date`='$updated_date' WHERE `sub_category_id`='$updated_sub_category_id'");

    // Check if the update was successful
    if ($update_category) {
        echo "<script>
            location.replace('add_category.php');
        </script>";
    } else {
        // If the update fails, display an error message
        echo "Failed to update the category.";
    }
}
?>