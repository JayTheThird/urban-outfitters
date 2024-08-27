<?php

$conn = mysqli_connect("localhost", "root", "", "urban-outfitters");

if (mysqli_connect_error()) {
    echo "<script>alert('cannot connect database');</script>";
    exit();
}
