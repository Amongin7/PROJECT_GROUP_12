<!--Server side code to handle  Complainant Transfer-->
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['transfer_case']))
		{
            $t_sd_ref = $_POST['t_sd_ref'];
			$t_compt_name=$_POST['t_compt_name'];
			$t_date=$_POST['t_date'];
			$t_destination=$_POST['t_destination'];
            $t_status=$_POST['t_status'];
            
            
            //sql to insert captured values
			$query="INSERT INTO  his_cases   _transfers (t_sd_ref, t_compt_name, t_date, t_destination, t_status) VALUES(?,?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssss', $t_sd_ref, $t_compt_name, $t_date, $t_destination, $t_status);
			$stmt->execute();
			
			if($stmt)
			{
				$success = "Complainant Transferred";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Complainant Transfer-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Cases</a></li>
                                            <li class="breadcrumb-item active">Transfer Cases</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <!--LETS GET DETAILS OF SINGLE Complainant GIVEN THEIR ID-->
                        <?php
                            $sd_ref=$_GET['sd_ref'];
                            $ret="SELECT  * FROM his_cases    WHERE sd_ref=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$sd_ref);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            //$cnt=1;
                            while($row=$res->fetch_object())
                            {
                        ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Complainant Form-->
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <label for="inputEmail4" class="col-form-label">Complainant's Name</label>
                                                    <input type="text" required="required" value="<?php echo $row->compt_fname;?> <?php echo $row->compt_lname;?>" name="t_compt_name" class="form-control" id="inputEmail4" placeholder="Complainant'sFirst Name">
                                                </div>
                                                
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Refferals</label>
                                                    <input type="text" required="required"  name="t_destination" class="form-control" id="inputEmail4" placeholder="Refferal/Transfer destination">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="inputPassword4" class="col-form-label">Transfer Date</label>
                                                    <input required="required" type="date"  name="t_date" class="form-control"  id="inputPassword4" placeholder="DD/MM/YYYY">
                                                </div>
                                                <div class="form-group col-md-6" style="display:none">
                                                    <label for="inputPassword4" class="col-form-label">SD Reference </label>
                                                    <input required="required" type="text"  name="t_sd_ref" value="<?php echo $row->sd_ref;?>" class="form-control"  id="inputPassword4" placeholder="">
                                                </div>
                                            </div>

                                            <div class="form-group" style="display:none">
                                                <label for="inputAddress" class="col-form-label">Transfer Status</label>
                                                <input required="required" type="text" value="Success" class="form-control" name="t_status" id="inputAddress" placeholder="Complainant'sAddresss">
                                            </div>

                                            <button type="submit" name="transfer_case" class="ladda-button btn btn-success" data-style="expand-right">Transfer Complainant</button>

                                        </form>
                                        <!--End Complainant Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <?php  }?>
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

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>