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
            <h1>Add Products</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin_index.php">Home</a></li>
                    <li class="breadcrumb-item active">Add Products</li>
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

                            </ul>
                            <!--  -->

                            <div class="tab-content pt-2">
                                <!-- Add Products -->
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <form method="post" action="add_products_impl.php" enctype="multipart/form-data">
                                        <!-- Product image -->
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Product Image</label>
                                            <div class="col-md-8 col-lg-9">
                                                <div class="pt-2">
                                                    <input type="file" name="product_image" id="product_image">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Product Name -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Name</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="product_name" type="text" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Category type -->
                                        <div class="row mb-3">
                                            <label for="category_type" class="col-md-4 col-lg-3 col-form-label">Category Type</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select name="category_type" id="categoryType" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <?php
                                                    $category_select = "SELECT * FROM `product_sub_category` WHERE `is_deleted` = 0";
                                                    $query = mysqli_query($conn, $category_select);

                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                        $sub_category_id = $row['sub_category_id'];
                                                        $sub_category_name = $row['sub_category_name'];

                                                        echo "<option value=$sub_category_id>$sub_category_name</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Size -->
                                        <div class="row mb-3">
                                            <label for="category_type" class="col-md-4 col-lg-3 col-form-label">Product Size</label>
                                            <div class="col-md-8 col-lg-9">
                                                <!-- Category Selection -->
                                                <select name="product_category" id="productCategory" class="form-control">
                                                    <option value="">Select Category</option>
                                                    <option value="top">Top Wear</option>
                                                    <option value="bottom">Bottom Wear</option>
                                                </select>
                                                <br>
                                                <!-- Size Selection -->
                                                <select name="product_size[]" id="productSize" class="form-control" multiple>
                                                    <!-- Options will be populated based on category selection -->
                                                </select>


                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Price -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Product Price</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="product_price" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Quantity -->
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Quantity</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="product_quantity" type="number" class="form-control" id="fullName" value="">
                                            </div>
                                        </div>
                                        <!--  -->

                                        <!-- Product Description  -->
                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Product Description</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="product_description" class="form-control" id="about" style="height: 100px"></textarea>
                                            </div>
                                        </div>
                                        <!--  -->

                                        <div class="text-center">
                                            <button type="submit" name="submit" class="btn btn-primary">Add Products</button>
                                        </div>
                                    </form>
                                </div>
                                <!--  -->
                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>


                </div>
        </section>

        <!-- Added Products -->
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
                                <th scope="col">Added Date</th>
                                <th scope="col">EDIT</th>
                                <th scope="col">REMOVE</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $product_display = mysqli_query($conn, "SELECT `product_id`, `product_image`, `product_name`, `product_price`, `added_date` FROM `products` WHERE `is_deleted` = 0");
                            if (mysqli_num_rows($product_display) > 0) {
                                while ($fetched_data =  mysqli_fetch_assoc($product_display)) {
                            ?>
                                    <tr>
                                        <th><?php echo $fetched_data['product_id']; ?></th>
                                        <th scope="row"><img src="../uploaded_images/product/<?php echo $fetched_data['product_image']; ?>" alt="Category Image not load" style="height: 70px; width: 70px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);"></th>
                                        <td><?php echo $fetched_data['product_name']; ?></td>
                                        <td><?php echo $fetched_data['product_price']; ?></td>
                                        <td><?php echo $fetched_data['added_date']; ?></td>
                                        <td>
                                            <a href="./update_products.php?edit=<?php echo $fetched_data['product_id']; ?>" style="height: 50px;">
                                                <i class='bx bx-edit bx-sm'></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="./add_products.php?delete=<?php echo $fetched_data['product_id']; ?>" style="height: 50px;">
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

<!-- for delete Products -->
<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Fetch the image file name associated with this subcategory
    $result = mysqli_query($conn, "SELECT `product_image` FROM `products` WHERE `product_id` = $id");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imageFileName = $row['product_image'];

        // Define the path to the image file
        $imagePath = __DIR__ . "/../uploaded_images/product/" . $imageFileName;

        // Delete the image file from the server
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    // Set is_deleted to 1 instead of deleting the row (updating the products table)
    mysqli_query($conn, "UPDATE `products` SET `is_deleted` = 1 WHERE `product_id` = $id") or die('Query Failed');

    echo "<script>
            location.replace('add_products.php');
        </script>";
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
            top: [{
                    value: 'S',
                    text: 'S'
                },
                {
                    value: 'M',
                    text: 'M'
                },
                {
                    value: 'L',
                    text: 'L'
                },
                {
                    value: 'XL',
                    text: 'XL'
                },
                {
                    value: 'XXL',
                    text: 'XXL'
                }
            ],
            bottom: [{
                    value: '28',
                    text: '28'
                },
                {
                    value: '30',
                    text: '30'
                },
                {
                    value: '32',
                    text: '32'
                },
                {
                    value: '34',
                    text: '34'
                },
                {
                    value: '36',
                    text: '36'
                },
                {
                    value: '38',
                    text: '38'
                }
            ]
        };

        // Populate size options based on category
        if (sizes[category]) {
            sizes[category].forEach(function(size) {
                const option = document.createElement('option');
                option.value = size.value;
                option.text = size.text;
                sizeSelect.appendChild(option);
            });
        }
    });
</script>