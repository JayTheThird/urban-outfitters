<?php
include_once("../connection.php");
include_once("../config.php");

session_start();
session_unset();
session_destroy();

header("location:admin_login.php");
