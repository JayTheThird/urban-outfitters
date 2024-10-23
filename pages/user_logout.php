<?php
session_start();

include_once("../connection.php");
include_once("../config.php");

unset($_SESSION['user_id']);
unset($_SESSION['user_first_name']);
unset($_SESSION['user_last_name']);
unset($_SESSION['email']);
unset($_SESSION['contact_number']);


header('location:index.php');
