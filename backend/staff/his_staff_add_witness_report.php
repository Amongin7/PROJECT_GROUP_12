<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['add__wit_result']))
		{
			$wit_compt_name = $_POST['wit_compt_name'];
			$wit_offence_details = $_POST['wit_offence_details'];
            $wit_sd_ref  = $_POST['wit_sd_ref'];
            $wit_witness = $_POST['wit_witness'];
            $id  = $_GET['id'];
            $wit_compt_results = $_POST['wit_compt_results'];
           
			$query="UPDATE   his_witness  SET wit_compt_name=?, wit_offence_details=?, wit_sd_ref=?, wit_witness=?, wit_compt_results=? WHERE  id = ? ";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('ssssss', $wit_compt_name, $wit_offence_details, $wit_sd_ref, $wit_witness, $wit_compt_results, $id);
			$stmt->execute();
			/*
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = " Witness Reports Addded";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End  Registration-->
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
            <?php
                $id = $_GET['id'];
                $ret="SELECT  * FROM his_witness WHERE id=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$id);
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
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Witness Reports</a></li>
                                                <li class="breadcrumb-item active">Add Witness Report</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Add Witness Report</h4>
                                    </div>
                                </div>
                            </div>     
                            <!-- end page title --> 
                            <!-- Form row -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="header-title">Fill all fields</h4>
                                            <!--Add  Form-->
                                            <form method="post">
                                                <div class="form-row">

                                                    <div class="form-group col-md-6">
                                                        <label for="inputEmail4" class="col-form-label">Complainant's Name</label>
                                                        <input type="text" required="required" readonly name="wit_compt_name" value="<?php echo $row->wit_compt_name;?>" class="form-control" id="inputEmail4" placeholder="Complainant's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Details of Offence</label>
                                                        <input required="required" type="text" readonly name="wit_offence_details" value="<?php echo $row->wit_offence_details;?>" class="form-control"  id="inputPassword4" placeholder="Complainant`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">

                                                    <div class="form-group col-md-12">
                                                        <label for="inputEmail4" class="col-form-label">SD Reference</label>
                                                        <input type="text" required="required" readonly name="wit_sd_ref" value="<?php echo $row->wit_sd_ref;?>" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                    </div>


                                                </div>

                                                
                                                <hr>
                                                

                                                <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Witness</label>
                                                        <textarea required="required"  type="text" class="form-control" name="wit_witness" id="editor"><?php echo $row->wit_witness;?></textarea>
                                                </div>

                                                <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Witness Reports</label>
                                                        <textarea required="required"   type="text" class="form-control" name="wit_compt_results" id="editor1"></textarea>
                                                </div>

                                                <button type="submit" name="add_wit_result" class="ladda-button btn btn-success" data-style="expand-right">Add Witness Reports</button>

                                            </form>
                                            <!--End Complainant Form-->
                                        </div> <!-- end card-body -->
                                    </div> <!-- end card-->
                                </div> <!-- end col -->
                            </div>
                            <!-- end row -->

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
        <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
        <script type="text/javascript">
         CKEDITOR.replace('editor')
        </script>
        <script type="text/javascript">
         CKEDITOR.replace('editor1')
        </script>

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