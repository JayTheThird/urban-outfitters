<?php
include_once("../connection.php");
include_once("../config.php");
if (isset($_POST['submit'])) {
    $added_date = date("Y/m/d");
    $product_name = $_POST['product_name'];
    $sub_category_id = $_POST['category_type'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_description = $_POST['product_description'];
    $product_sizes = $_POST['product_size'];

    // Handle image upload
    $filename = '';
    if (isset($_FILES["product_image"]) && !empty($_FILES["product_image"]["name"])) {
        $filename = time() . '-' . $_FILES["product_image"]["name"];
        $temp_name = $_FILES["product_image"]["tmp_name"];
        $folder = __DIR__ . "/../uploaded_images/product/" . $filename;

        // Check if directory exists, if not create it
        if (!file_exists(dirname($folder))) {
            mkdir(dirname($folder), 0777, true);
        }

        if (move_uploaded_file($temp_name, $folder)) {
            // Ensure all required fields are filled, including the category being selected
            if (!empty($product_name) && !empty($sub_category_id) && $sub_category_id != '' && !empty($product_price) && !empty($product_quantity) && !empty($product_description)) {

                // Insert into products table
                $add_product = "INSERT INTO products(sub_category_id, product_name, product_price, product_quantity, product_description, product_image, added_date) 
                                VALUES ('$sub_category_id', '$product_name', '$product_price', '$product_quantity', '$product_description', '$filename', '$added_date')";
                $product_query = mysqli_query($conn, $add_product);

                if ($product_query) {
                    $product_id = mysqli_insert_id($conn); // Get the last inserted product ID

                    // Insert each product size into the product_sizes table
                    foreach ($product_sizes as $size) {
                        $add_size = "INSERT INTO product_sizes(product_id, product_size) VALUES ('$product_id', '$size')";
                        mysqli_query($conn, $add_size);
                    }

                    echo "<script>
                        alert('Product added successfully!');
                        location.replace('add_products.php');
                        </script>";
                } else {
                    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Please fill in all required fields!');</script>";
            }
        } else {
            echo "<script>alert('Failed to move uploaded file.');</script>";
        }
    } else {
        echo "<script>alert('No image uploaded.');</script>";
    }
}