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

    <title>UO - Admin - Update Products</title>
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
            <h1>Update Products</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="add_products.php">Add Products</a></li>
                    <li class="breadcrumb-item active">Update Products</li>
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
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Update Products</button>
                                </li>

                            </ul>
                            <!--  -->

                            <div class="tab-content pt-2">
                                <!-- Add Products -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <?php
                                    if (isset($_GET['edit'])) {
                                        $product_edit_Id = $_GET['edit'];
                                        $product_edit = "SELECT * FROM `products` WHERE `product_id` = $product_edit_Id";
                                        $product_query = mysqli_query($conn, $product_edit);

                                        if (mysqli_num_rows($product_query) > 0) {
                                            while ($fetched_data = mysqli_fetch_assoc($product_query)) {
                                    ?>
                                                <form method="post" action="" enctype="multipart/form-data">

                                                    <input type="hidden" name="old_product_image" value="<?php echo $fetched_data['product_image']; ?>">
                                                    <input type="hidden" name="updated_product_id" value="<?php echo $fetched_data['product_id']; ?>">

                                                    <!-- Product old image -->
                                                    <div class="row mb-3">
                                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Product Old Image</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <img src="../uploaded_images/product/<?php echo $fetched_data['product_image']; ?>" alt="Image not found" height="200" width="200">
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Product new image -->
                                                    <div class="row mb-3">
                                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Product New Image</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <div class="pt-2">
                                                                <input type="file" name="updated_product_image" id="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Product Name -->
                                                    <div class="row mb-3">
                                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Name</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="updated_product_name" type="text" class="form-control" id="fullName" value="<?php echo $fetched_data['product_name']; ?>">
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Category type -->
                                                    <div class="row mb-3">
                                                        <label for="category_type" class="col-md-4 col-lg-3 col-form-label">Category Type</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <select name="updated_category_type" id="categoryType" class="form-control">
                                                                <option disabled>Select Category</option>
                                                                <?php
                                                                $category_select = "SELECT * FROM `product_sub_category` WHERE `is_deleted` = 0";
                                                                $query = mysqli_query($conn, $category_select);

                                                                while ($row = mysqli_fetch_assoc($query)) {
                                                                    $sub_category_id = $row['sub_category_id'];
                                                                    $sub_category_name = $row['sub_category_name'];
                                                                    // Check if this category matches the selected category
                                                                    $selected = ($sub_category_id == $fetched_data['sub_category_id']) ? 'selected' : '';
                                                                    echo "<option value='$sub_category_id' $selected>$sub_category_name</option>";
                                                                }
                                                                ?>
                                                            </select>

                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Product Size -->
                                                    <div class="row mb-3">
                                                        <label for="product_size" class="col-md-4 col-lg-3 col-form-label">Product Size</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <!-- Category Selection -->
                                                            <select name="updated_product_size[]" id="productSize" class="form-control" multiple>
                                                                <?php
                                                                // Fetch the sizes from the database as an array
                                                                $selected_sizes = json_decode($fetched_data['product_sizes'], true); // Decode JSON if it's stored as JSON format
                                                                if (!$selected_sizes) {
                                                                    $selected_sizes = explode(',', $fetched_data['product_sizes']); // Fallback if it's a comma-separated string
                                                                }

                                                                // Define available sizes for top wear
                                                                $top_sizes = ['S', 'M', 'L', 'XL', 'XXL'];

                                                                // Define available sizes for bottom wear
                                                                $bottom_sizes = ['28', '30', '32', '34', '36', '38'];

                                                                // Display top sizes
                                                                echo "<optgroup label='Top Wear'>";
                                                                foreach ($top_sizes as $size) {
                                                                    // Check if the size was selected previously
                                                                    $is_selected = in_array($size, $selected_sizes) ? 'selected' : '';
                                                                    echo "<option value='$size' $is_selected>$size</option>";
                                                                }
                                                                echo "</optgroup>";

                                                                // Display bottom sizes
                                                                echo "<optgroup label='Bottom Wear'>";
                                                                foreach ($bottom_sizes as $size) {
                                                                    // Check if the size was selected previously
                                                                    $is_selected = in_array($size, $selected_sizes) ? 'selected' : '';
                                                                    echo "<option value='$size' $is_selected>$size</option>";
                                                                }
                                                                echo "</optgroup>";
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--  -->
                                                    <?php
                                                    var_dump($fetched_data['product_sizes']);

                                                    ?>
                                                    <!--  -->

                                                    <!--  -->

                                                    <!-- Product Price -->
                                                    <div class="row mb-3">
                                                        <label for="product_price" class="col-md-4 col-lg-3 col-form-label">Product Price</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="updated_product_price" type="number" class="form-control" id="productPrice" value="<?php echo $fetched_data['product_price']; ?>">
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Quantity -->
                                                    <div class="row mb-3">
                                                        <label for="product_quantity" class="col-md-4 col-lg-3 col-form-label">Quantity</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input name="updated_product_quantity" type="number" class="form-control" id="productQuantity" value="<?php echo $fetched_data['product_quantity']; ?>">
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <!-- Product Description -->
                                                    <div class="row mb-3">
                                                        <label for="product_description" class="col-md-4 col-lg-3 col-form-label">Product Description</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <textarea name="updated_product_description" class="form-control" id="productDescription" style="height: 100px"><?php echo $fetched_data['product_description']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <!--  -->

                                                    <div class="text-center">
                                                        <button type="submit" class="btn btn-primary" name="update">Update Product</button>
                                                    </div>
                                                </form>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <!--  -->
                            </div>
                            <!--  -->


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
    $updated_product_id = $_POST['updated_product_id'];
    $updated_product_name = $_POST['updated_product_name'];
    $updated_category_type = $_POST['updated_category_type'];
    $updated_product_price = $_POST['updated_product_price'];
    $updated_product_size = json_encode($_POST['updated_product_size']); // Convert array to JSON
    $updated_product_quantity = $_POST['updated_product_quantity'];
    $updated_product_description = $_POST['updated_product_description'];
    $updated_date = date("Y/m/d");

    // Old image file name
    $old_product_image_name = $_POST["old_product_image"];
    $old_product_image_path = "../uploaded_images/product/" . $old_product_image_name;

    // Initialize the filename variable with the old image name
    $filename = $old_product_image_name;

    // Check if a new image has been uploaded
    if (!empty($_FILES["updated_product_image"]["name"])) {
        // Generate a unique filename for the new image using the current time
        $filename = time() . '-' . $_FILES["updated_product_image"]["name"];
        $temp_name = $_FILES["updated_product_image"]["tmp_name"];
        $folder = "../uploaded_images/product/" . $filename;

        if (move_uploaded_file($temp_name, $folder)) {
            // Check if the old image exists, then delete it
            if (file_exists($old_product_image_path)) {
                unlink($old_product_image_path);
            }
        } else {
            echo "Failed to upload new image.";
            exit();
        }
    }

    // Update product details in the database
    $update_product = mysqli_query($conn, "UPDATE `products` SET 
        `sub_category_id`='$updated_category_type',
        `product_name`='$updated_product_name',
        `product_image`='$filename',
        `product_price`='$updated_product_price',
        `product_sizes`='$updated_product_size', -- JSON data
        `product_quantity`='$updated_product_quantity',
        `product_description`='$updated_product_description',
        `added_date`='$updated_date'
        WHERE `product_id`='$updated_product_id'");

    // Check if the update was successful
    if ($update_product) {
        echo "<script>
            location.replace('add_products.php');
        </script>";
    } else {
        // If the update fails, display an error message
        echo "Failed to update the product.";
    }
}
?>

<script>
    document.getElementById('productCategory').addEventListener('change', function() {
        const category = this.value;
        const sizeSelect = document.getElementById('productSize');

        // Clear existing options
        sizeSelect.innerHTML = '';

        // Define size options
        const sizes = {
            top: ['S', 'M', 'L', 'XL', 'XXL'],
            bottom: ['28', '30', '32', '34', '36', '38']
        };

        // Populate size options based on category
        if (sizes[category]) {
            sizes[category].forEach(function(size) {
                const option = document.createElement('option');
                option.value = size;
                option.text = size;
                sizeSelect.appendChild(option);
            });
        }
    });
</script>