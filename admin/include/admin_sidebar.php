<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_index.php') ? 'active' : ''; ?>" href="admin_index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <!--  -->

        <!-- Orders -->
        <li class="nav-item">
            <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'orders.php') ? 'active' : ''; ?>" href="orders.php">
                <i class='bx bx-cart'></i><span>Orders</span></i>
            </a>
        </li>
        <!--  -->

        <!-- Add Categories -->
        <li class="nav-item">
            <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'add_category.php') ? 'active' : ''; ?>" href="add_category.php">
                <i class='bx bx-message-square-add'></i><span>Add Categories</span></i>
            </a>
        </li>
        <!--  -->

        <!-- Add Products -->
        <li class="nav-item">
            <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'add_products.php') ? 'active' : ''; ?>" href="add_products.php">
                <i class='bx bx-message-square-add'></i><span>Add Products</span></i>
            </a>
        </li>
        <!--  -->

        <!-- Returns/Replace Products -->
            <!-- <li class="nav-item">
                <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'returns_replace.php') ? 'active' : ''; ?>" href="returns_replace.php">
                    <i class='bx bx-rotate-left'></i><span>Returns/Replace Products</span></i>
                </a>
            </li> -->
        <!--  -->

        <!-- Reports -->
        <li class="nav-item">
            <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'reports.php') ? 'active' : ''; ?>" href="reports.php">
                <i class="bi bi-menu-button-wide"></i><span>Reports</span></i>
            </a>
        </li>
        <!--  -->



        <!-- Profile -->
        <li class="nav-item">
            <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_profile.php') ? 'active' : ''; ?>" href="admin_profile.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li>
        <!--  -->


    </ul>
</aside>