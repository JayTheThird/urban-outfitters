<?php
include_once("../connection.php");
include_once("../config.php");
session_start();

unset($_SESSION['user_first_name']);
unset($_SESSION['user_last_name']);
unset($_SESSION['email']);
unset($_SESSION['contact_number']);
// unset($_SESSION['UserID']);

header('location:index.php');

// this is test
