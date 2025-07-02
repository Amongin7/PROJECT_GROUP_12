<?php
    $aid = $_SESSION['ad_id'];
    $ret = "SELECT * FROM his_admin WHERE ad_id=?";
    $stmt = $mysqli->prepare($ret);
    $stmt->bind_param('i', $aid);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_object()) {
?>
<div class="navbar-custom">
    <!-- RIGHT MENU -->
    <ul class="list-unstyled topnav-menu float-right mb-0">

        <!-- Search -->
        <li class="d-none d-sm-block">
            <form class="app-search">
                <div class="app-search-box">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <div class="input-group-append">
                            <button class="btn" type="submit">
                                <i class="fe-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </li>

        <!-- PROFILE DROPDOWN -->
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <!-- <img src="assets/images/users/<?php echo $row->ad_dpic;?>" alt="dpic" class="rounded-circle"> -->
                    <span class="pro-user-name ml-1">
                        <?php echo $row->ad_fname;?> <?php echo $row->ad_lname;?> <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
        <a href="his_admin_logout_partial.php" class="dropdown-item">
            <i class="fe-log-out"></i> Logout
        </a>
    </div>
</li>

    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="his_admin_dashboard.php" class="logo text-center">
            <span class="logo-lg">
                <h2 style="color:orange;">ACRMS</h2>
            </span>
            <span class="logo-sm">
                <h2 style="color:orange; padding-top:25px;">ACRMS</h2>
            </span>
        </a>
    </div>

    <!-- LEFT MENU -->
    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <!-- Sidebar Toggle -->
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>

        <!-- CREATE NEW DROPDOWN -->
        <li class="nav-item dropdown d-none d-lg-block">
            <a class="nav-link dropdown-toggle" href="#" id="createNewDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Create New <i class="mdi mdi-chevron-down"></i>
            </a>
            <div class="dropdown-menu" aria-labelledby="createNewDropdown">
                <a class="dropdown-item" href="his_admin_add_Staff.php">
                    <i class="fe-users mr-1"></i> Staff
                </a>
                <a class="dropdown-item" href="his_admin_register_Case.php">
                    <i class="fe-activity mr-1"></i> Case File
                </a>
                <a class="dropdown-item" href="his_admin_add_supplier.php">
                    <i class="fe-shopping-cart mr-1"></i> Supplier
                </a>
            </div>
        </li>
    </ul>
</div>
<?php } ?>
