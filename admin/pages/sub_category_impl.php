<?php
include_once("../connection.php");
include_once("../config.php");

if (isset($_POST['submit'])) {

    $added_date = date("Y/m/d");
    $main_category_id = $_POST['category_type'];
    $sub_category = $_POST['sub_category'];

    // Check if a new image is uploaded
    $filename = '';
    if (isset($_FILES["category_image"]) && !empty($_FILES["category_image"]["name"])) {
        $filename = time() . '-' . $_FILES["category_image"]["name"];
        $temp_name =  $_FILES["category_image"]["tmp_name"];
        $folder = __DIR__ . "/../uploaded_images/category/" . $filename;

        // Check if the directory exists, if not create it
        if (!file_exists(dirname($folder))) {
            mkdir(dirname($folder), 0777, true);
        }

        // Try to move the uploaded file
        if (move_uploaded_file($temp_name, $folder)) {
            if (!empty($main_category_id) && !empty($sub_category)) {
                $add_sub_category = "INSERT INTO `product_sub_category`(`category_id`, `sub_category_name`, `sub_category_image`, `date`) VALUES ('$main_category_id','$sub_category','$filename','$added_date')";

                $sub_category_query = mysqli_query($conn, $add_sub_category);

                if ($sub_category_query) {
                    $_POST = array(); // Clear the POST array after successful insertion
                    echo "<script>
                        alert('Done!!');
                        location.replace('add_category.php');
                        </script>";
                } else {
                    echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Fill the input First!!');
                    location.replace('add_category.php');
                    </script>";
            }
        } else {
            echo "<script>alert('Failed to move uploaded file.');</script>";
        }
    } else {
        echo "<script>alert('No image uploaded.');</script>";
    }
}
