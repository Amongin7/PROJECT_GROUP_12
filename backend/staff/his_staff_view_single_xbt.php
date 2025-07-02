<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $staff_id = $_SESSION['staff_id'];
?>
<!DOCTYPE html>
<html lang="en">
    
<?php include ('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include('assets/inc/nav.php');?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->
            <?php
                $xbt_number=$_GET['xbt_number'];
                $pres_id = $_GET['pres_id'];
                $ret="SELECT  * FROM his_exhibit WHERE xbt_number = ? AND pres_id = ?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('ii',$xbt_number,$pres_id);
                //$stmt->bind_param('i',$pres_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
                {
            ?>

                <div class="content-page">
                    <div class="content">

                        <!-- Start Content-->
                        <div class="container-fluid">
                            
                            <!-- start page title -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="his_staff_dashboard.php">Dashboard</a></li>
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Exhibits</a></li>
                                                <li class="breadcrumb-item active">View Exhibits</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">#<?php echo $row->xbt_number;?></h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 

                            <div class="row">
                                <div class="col-12">
                                    <div class="card-box">
                                        <div class="row">
                                            <div class="col-xl-5">

                                                <div class="tab-content pt-0">

                                                    <div class="tab-pane active show" id="product-1-item">
                                                        <img src="assets/images/users/Complainant.png" alt="" class="img-fluid mx-auto d-block rounded">
                                                    </div>
                            
                                                </div>
                                            </div> <!-- end col -->
                                            <div class="col-xl-7">
                                                <div class="pl-xl-3 mt-3 mt-xl-0">
                                                    <h2 class="mb-3">Complainant's Name : <?php echo $row->xbt_compt_name;?></h2>
                                                    <hr>
                                                    <h3 class="text-danger">Victim(s) : <?php echo $row->xbt_victim;?> </h3>
                                                    <hr>
                                                    <h3 class="text-danger ">SD Reference : <?php echo $row->xbt_sd_ref;?></h3>
                                                    <hr>
                                                    <h3 class="text-danger "> Category : <?php echo $row->xbt_compt_type;?></h3>
                                                    <hr>
                                                    <h3 class="text-danger ">Details of Offence : <?php echo $row->xbt_offence_details;?></h3>
                                                    <hr>
                                                    <h2 class="align-centre">Exhibits</h2>
                                                    <hr>
                                                    <p class="text-muted mb-4">
                                                        <?php echo $row->xbt_desc;?>
                                                    </p>
                                                    <hr>
                                                  
                                                </div>
                                            </div> <!-- end col -->
                                        </div>
                                        <!-- end row -->

                                      

                                    </div> <!-- end card-->
                                </div> <!-- end col-->
                            </div>
                            <!-- end row-->
                            
                        </div> <!-- container -->

                    </div> <!-- content -->

                    <!-- Footer Start -->
                        <?php include('assets/inc/footer.php');?>
                    <!-- end Footer -->

                </div>
            <?php }?>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>