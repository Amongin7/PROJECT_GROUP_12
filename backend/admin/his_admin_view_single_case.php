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
                $sd_ref=$_GET['sd_ref'];
                $compt_id=$_GET['compt_id'];
                $ret="SELECT  * FROM his_cases WHERE compt_id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('i',$compt_id);
                $stmt->execute() ;//ok
                $res=$stmt->get_result();
                //$cnt=1;
                while($row=$res->fetch_object())
            {
                $mysqlDateTime = $row->compt_date_joined;
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Cases</a></li>
                                            <li class="breadcrumb-item active">View Cases</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"><?php echo $row->compt_fname;?> <?php echo $row->compt_lname;?>'s </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-lg-4 col-xl-4">
                                <div class="card-box text-center">
                                    <!-- <img src="assets/images/users/.png" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image"> -->

                                    
                                    <div class="text-left mt-3">
                                        
                                        <p class="text-muted mb-2 font-13"><strong>Name of Complainant :</strong> <span class="ml-2"><?php echo $row->compt_fname;?> <?php echo $row->compt_lname;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Phone Number :</strong><span class="ml-2"><?php echo $row->compt_phone;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Nature of Offence :</strong> <span class="ml-2"><?php echo $row->compt_addr;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Date of Occurence :</strong> <span class="ml-2"><?php echo $row->date_occur;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Victim(s) :</strong> <span class="ml-2"><?php echo $row->victim;?></span></p>
                                        <p class="text-muted mb-2 font-13"><strong>Details :</strong> <span class="ml-2"><?php echo $row->offence_details;?></span></p>
                                        <hr>
                                        <p class="text-muted mb-2 font-13"><strong>Date Recorded :</strong> <span class="ml-2"><?php echo date("d/m/Y - h:m", strtotime($mysqlDateTime));?></span></p>
                                        <hr>




                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                            
                            <?php }?>
                            <div class="col-lg-8 col-xl-8">
                                <div class="card-box">
                                    <ul class="nav nav-pills navtab-bg nav-justified">
                                        <li class="nav-item">
                                            <a href="#aboutme" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                                Exhibits
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#timeline" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                                 Suspects 
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                                Witnesses
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- History-->
                                    <div class="tab-content">
                                        <div class="tab-pane show active" id="aboutme">
                                             <ul class="list-unstyled timeline-sm">
                                                <?php
                                                    $xbt_sd_ref =$_GET['sd_ref'];
                                                    $ret="SELECT  * FROM his_exhibit WHERE xbt_sd_ref ='$xbt_sd_ref'";
                                                    $stmt= $mysqli->prepare($ret) ;
                                                    // $stmt->bind_param('i',$xbt_sd_ref );
                                                    $stmt->execute() ;//ok
                                                    $res=$stmt->get_result();
                                                    //$cnt=1;
                                                    
                                                    while($row=$res->fetch_object())
                                                        {
                                                    $mysqlDateTime = $row->xbt_date; //trim timestamp to date

                                                ?>
                                                    <li class="timeline-sm-item">
                                                        <span class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></span>
                                                        <h5 class="mt-0 mb-1"><?php echo $row->xbt_offence_details;?></h5>
                                                        <p class="text-muted mt-2">
                                                            <?php echo $row->xbt_desc;?>
                                                        </p>

                                                    </li>
                                                <?php }?>
                                            </ul>
                                           
                                        </div> <!-- end tab-pane -->
                                        <!-- end Exhibits section content -->

                                        <div class="tab-pane show " id="timeline">
                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Name of Suspect</th>
                                                            <th>Gender</th>
                                                            <th>Arresting Officer</th>
                                                            <th>Place of Arrest</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                        $sd_ref =$_GET['sd_ref'];
                                                        $ret="SELECT  * FROM his_suspects WHERE suspect_sd_ref ='$sd_ref'";
                                                        $stmt= $mysqli->prepare($ret) ;
                                                        // $stmt->bind_param('i',$sd_ref );
                                                        $stmt->execute() ;//ok
                                                        $res=$stmt->get_result();
                                                        //$cnt=1;
                                                        
                                                        while($row=$res->fetch_object())
                                                            {
                                                        $mysqlDateTime = $row->suspect_arrest_date; //trim timestamp to date

                                                    ?>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $row->suspect_name;?></td>
                                                                <td><?php echo $row->suspect_gender;?></td>
                                                                <td><?php echo $row->suspect_arresting_officer;?></td>
                                                                <td><?php echo $row->suspect_arrest_date;?></td>
                                                                <td><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></td>
                                                            </tr>
                                                        </tbody>
                                                    <?php }?>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- end Details content-->

                                        <div class="tab-pane" id="settings">
                                            <ul class="list-unstyled timeline-sm">
                                                <?php
                                                    $wit_sd_ref =$_GET['sd_ref'];
                                                    $ret="SELECT  * FROM his_witness WHERE wit_sd_ref  = '$wit_sd_ref'";
                                                    $stmt= $mysqli->prepare($ret) ;
                                                    // $stmt->bind_param('i',$wit_sd_ref);
                                                    $stmt->execute() ;//ok
                                                    $res=$stmt->get_result();
                                                    //$cnt=1;
                                                    
                                                    while($row=$res->fetch_object())
                                                        {
                                                    //$mysqlDateTime = $row->wit_date_rec; //trim timestamp to date

                                                ?>
                                                    <li class="timeline-sm-item">
                                                        <!-- <span class="timeline-sm-date"><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></span> -->
                                                        <h3 class="mt-0 mb-1"><?php echo $row->wit_offence_details;?></h3>
                                                        <hr>
                                                        <h5>
                                                           Witnesses of the 
                                                        </h5>
                                                        
                                                        <p class="text-muted mt-2">
                                                            <?php echo $row->wit_witness;?>
                                                        </p>
                                                        <hr>
                                                        <h5>
                                                           Witness Reports/Statements
                                                        </h5>
                                                        
                                                        <p class="text-muted mt-2">
                                                            <?php echo $row->wit_witness_reports;?>
                                                        </p>
                                                        <hr>

                                                    </li>
                                                <?php }?>
                                            </ul>
                                        </div>
                                        </div>
                                        <!-- end lab records content-->

                                    </div> <!-- end tab-content -->
                                </div> <!-- end card-box-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

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