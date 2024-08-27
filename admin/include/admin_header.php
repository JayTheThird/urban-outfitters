<?php

session_start();
?>

<header id="header" class="header fixed-top d-flex align-items-center">
    <!-- title -->
    <div class="d-flex align-items-center justify-content-between">
        <!-- toggle button -->
        <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
        <!--  -->
        <a href="index.php" class="logo d-flex align-items-center">
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <span class="d-none d-lg-block">Urban Outfitter's</span>
        </a>
    </div>
    <!--  -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

                <?php
                if (isset($_SESSION['admin_name'])) {
                ?>
                    <!-- Profile icon -->
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo "$_SESSION[admin_name]"; ?></span>
                    </a>
                    <!--  -->

                    <!-- user name -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo "$_SESSION[admin_name]"; ?></h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="admin_profile.php">
                                <i class="bi bi-person"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="admin_logout.php">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul>
                    <!--  -->

                <?php
                }
                ?>
            </li>
            <Nav>
        </ul>
        <!--  -->
    </nav>

</header>