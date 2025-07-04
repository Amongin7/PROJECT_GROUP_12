<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
?>
<!DOCTYPE html>
<html lang="en">
    
    <!--Head Code-->
    <?php include("assets/inc/head.php");?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include('assets/inc/sidebar.php');?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    
                                    <h4 class="page-title">Automatic Crime Record Management System Dashboard</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        

                        <div class="row">
                            <!--Start s-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="mdi mdi-checkbook font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    //code for summing up number of out s 
                                                    $result ="SELECT count(*) FROM his_cases";
                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($Criminal);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $Criminal;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Cases Registered</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                            <!--End Out s-->


                            <!--Start Disciplinary-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="mdi mdi-account-question-outline   font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    //code for summing up number of in / admitted  s 
                                                    $result ="SELECT count(*) FROM his_cases WHERE compt_type = 'Disciplinary' ";
                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($in);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $in;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Disciplinary Cases</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                            <!--End Disciplinary-->

                            <!--Start Staffs-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="mdi mdi-account-multiple font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    //code for summing up number of Staffs in the certain destination 
                                                    $result ="SELECT count(*) FROM his_staff ";
                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($staff);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $staff;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Station Staff</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                            <!--End Staffs-->
                        
                        </div>

                        <div class="row">

                        <!--Start Suppliers-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="fas fa-user-tag font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    /*code for summing up number of suppliers whom supply eqipments, 
                                                     *pharms or any other equipments
                                                     */ 
                                                    $result ="SELECT count(*) FROM his_suspects ";
                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($supplier);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <?php

                                                $query = "SELECT COUNT(*) FROM his_suspects WHERE suspect_arrest_date <= NOW() - INTERVAL 48 HOUR";

                                                $stmt = $mysqli->prepare($query);

                                                if ($stmt) {
                                                    $stmt->execute();
                                                    $stmt->bind_result($count);
                                                    $stmt->fetch();
                                                    $stmt->close();

                                                    //echo "Number of suspects arrested more than 48 hours ago: " . $count;
                                                } else {
                                                    // Handle errors if the statement couldn't be prepared
                                                    echo "Query preparation failed: " . $mysqli->error;
                                                }
                                                ?>

                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $supplier;?></span></h3>
                                                <p class="text-muted mb-1">
                                                 No. of Suspects
                                                                        
                                                </p>
                                                <p class="text-muted mb-1">
                                                
                                                     <?php echo "<span style='color:red;'>Over 48 Hours: $count </span>"; ?>
                                                                         
                                                </p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col--> 
                            <!--End Suppliers-->  

                            <!--Start Station Equipments-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="mdi mdi-pistol font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    /* 
                                                     * code for summing up number of assets,
                                                     */ 
                                                    $result ="SELECT count(*) FROM his_cases WHERE compt_type = 'Criminal' ";
                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($assets);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $assets;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate">Criminal Cases</p>
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                            <!--End Station Equipments-->

                            <!--Start Eqpts-->
                            <div class="col-md-6 col-xl-4">
                                <div class="widget-rounded-circle card-box">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="avatar-lg rounded-circle bg-soft-primary border-primary border">
                                                <i class="mdi mdi-motorbike font-22 avatar-title text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-right">
                                                <?php
                                                    /* 
                                                     * code for summing up number of eqpts,
                                                     */ 
                                                    $result ="SELECT count(*) FROM his_cases WHERE compt_type = 'Civil' ";                                                    $stmt = $mysqli->prepare($result);
                                                    $stmt->execute();
                                                    $stmt->bind_result($amr);
                                                    $stmt->fetch();
                                                    $stmt->close();
                                                ?>
                                                <h3 class="text-dark mt-1"><span data-plugin="counterup"><?php echo $amr;?></span></h3>
                                                <p class="text-muted mb-1 text-truncate"></p>Civil Cases
                                            </div>
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end widget-rounded-circle-->
                            </div> <!-- end col-->
                            <!--End Eqpts-->

                        </div>
                        

                        
                        <!--Recently Employed Staffs-->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card-box">
                                    <h4 class="header-title mb-3">Station Staff</h4>

                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-centered m-0">

                                            <thead class="thead-light">
                                                <tr>
                                                    <th colspan="2">Picture</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Directorate</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <?php
                                                $ret="SELECT * FROM his_staff ORDER BY RAND() LIMIT 10 "; 
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                                while($row=$res->fetch_object())
                                                {
                                            ?>
                                            <tbody>
                                                <tr>
                                                    <td style="width: 36px;">
                                                        <img src="<?php echo $row->staff_dpic;?>" alt="img" title="contact-img" class="rounded-circle avatar-sm" />
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->staff_fname;?> <?php echo $row->staff_lname;?>
                                                    </td>    
                                                    <td>
                                                        <?php echo $row->staff_email;?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row->staff_dept;?>
                                                    </td>
                                                    <td>
                                                        <a href="his_admin_view_single_staff.php?staff_id=<?php echo $row->staff_id;?>&&staff_number=<?php echo $row->staff_number;?>" class="btn btn-xs btn-primary"><i class="mdi mdi-eye"></i> View</a>
                                                    </td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
                                                </tr>
                                            </tbody>
                                            <?php }?>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->                                                                                                                                                                                                                                         
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-right">
                    <i class="dripicons-cross noti-icon"></i>
                </a>
                <h5 class="m-0 text-white">Settings</h5>
            </div>
            <div class="slimscroll-menu">
                <!-- User box -->
                <div class="user-box">
                    <div class="user-img">
                        <img src="assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                        <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                    </div>
            
                    <h5><a href="javascript: void(0);">PJT - 12 GRP</a> </h5>
                    <p class="text-muted mb-0"><small>Admin Head</small></p>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h5 class="pl-3">Basic Settings</h5>
                <hr class="mb-0" />

                <div class="p-3">
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox1" type="checkbox" checked>
                        <label for="Rcheckbox1">
                            Notifications
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox2" type="checkbox" checked>
                        <label for="Rcheckbox2">
                            API Access
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox3" type="checkbox">
                        <label for="Rcheckbox3">
                            Auto Updates
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-2">
                        <input id="Rcheckbox4" type="checkbox" checked>
                        <label for="Rcheckbox4">
                            Online Status
                        </label>
                    </div>
                    <div class="checkbox checkbox-primary mb-0">
                        <input id="Rcheckbox5" type="checkbox" checked>
                        <label for="Rcheckbox5">
                            Auto Payout
                        </label>
                    </div>
                </div>

                <!-- Timeline -->
                <hr class="mt-0" />
                <h5 class="px-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
                <hr class="mb-0" />
                <div class="p-3">
                    <div class="inbox-widget">
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-2.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tom</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-3.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text"></p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-4.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kura</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                        </div>

                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-5.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shadik</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="assets/images/users/user-6.jpg" class="rounded-circle" alt=""></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adam</a></p>
                            <p class="inbox-item-text"></p>
                        </div>
                    </div> <!-- end inbox-widget -->
                </div> <!-- end .p-3-->

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Supplier js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- Plugins js-->
        <script src="assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
        <script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.time.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.tooltip.min.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.selection.js"></script>
        <script src="assets/libs/flot-charts/jquery.flot.crosshair.js"></script>

        <!-- Dashboar 1 init js-->
        <script src="assets/js/pages/dashboard-1.init.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>
        
    
<?php if(isset($success)) { ?>
<script>
    setTimeout(() => {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '<?php echo addslashes($success); ?>',
            timer: 2000,
            showConfirmButton: false
        });
    }, 100);
</script>
<?php } ?>

<?php if(isset($err)) { ?>
<script>
    setTimeout(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo addslashes($err); ?>',
            timer: 2000,
            showConfirmButton: false
        });
    }, 100);
</script>
<?php } ?>

</body>

</html>