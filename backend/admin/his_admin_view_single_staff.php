<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
?>

<!DOCTYPE html>
    <html lang="en">

    <?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
             <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
                <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <!--Get Details Of A Single User And Display Them Here-->
            <?php
                $staff_id=$_GET['staff_id'];
                $ret="SELECT  * FROM his_staff WHERE staff_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$staff_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                $staff_number=$_GET['staff_number'];
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Staff</a></li>
                                            <li class="breadcrumb-item active">View Staff</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->staff_fname;?> <?php echo $row->staff_lname;?>'s Profile</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-6 col-xl-6">
                                <div class="card-box text-center">
                                    <img src="<?php echo $row->staff_dpic;?>" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image">

                                    
                                    <div class="text-centre mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ml-2"><?php echo $row->staff_fname;?> <?php echo $row->staff_lname;?></span></p>
                                       <p class="text-muted mb-2 font-13"><strong>Department :</strong> <span class="ml-2"><?php echo $row->staff_dept;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Force Number/Rank :</strong> <span class="ml-2"><?php echo $row->staff_number;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ml-2"><?php echo $row->staff_email;?></span></p>


                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                           
                                        <?php
                                            $sd_ref =$_GET['staff_number'];
                                            $ret="SELECT * FROM his_suspects WHERE suspect_sd_ref = '$sd_ref'";
                                            $stmt= $mysqli->prepare($ret) ;
                                            // $stmt->bind_param('i',$sd_ref );
                                            $stmt->execute() ;//ok
                                            $res=$stmt->get_result();
                                            //$cnt=1;
                                            
                                            while($row=$res->fetch_object())
                                                {
                                            $mysqlDateTime = $row->vit_daterec; //trim timestamp to date

                                        ?>
                                            <!-- <tbody>
                                                <tr>
                                                    <td><?php echo $row->suspect_name;?></td>
                                                    <td><?php echo $row->suspect_gender;?></td>
                                                    <td><?php echo $row->arresting_officer;?></td>
                                                    <td><?php echo $row->arrest_date;?></td>
                                                    <td><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></td>
                                                </tr>
                                            </tbody>
                                                -->
                                        <?php }?>
                                    </table>
                                    </div>
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