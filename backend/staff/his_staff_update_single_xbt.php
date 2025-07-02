<!--Server side code to handle   Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
		if(isset($_POST['update__xbt']))
		{
			$xbt_compt_name = $_POST['xbt_compt_name'];
			//$xbt_sd_ref = $_POST['xbt_sd_ref'];
            $xbt_compt_type = $_POST['xbt_compt_type'];
            $xbt_compt_addr = $_POST['xbt_compt_addr'];
            $xbt_victim = $_POST['xbt_victim'];
            $xbt_number = $_GET['xbt_number'];
            $xbt_desc = $_POST['xbt_desc'];
            $xbt_offence_details = $_POST['xbt_offence_details'];
            //sql to insert captured values
			$query="UPDATE   his_exhibit  SET xbt_compt_name = ?, xbt_compt_type = ?, xbt_compt_addr = ?, xbt_victim = ?, xbt_offence_details = ?, xbt_desc = ? WHERE xbt_number = ?";
			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssss', $xbt_compt_name, $xbt_compt_type, $xbt_compt_addr, $xbt_victim,  $xbt_offence_details, $xbt_desc, $xbt_number);
			$stmt->execute();
			
			if($stmt)
			{
				$success = "Complainant Exhibits Updated";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Complainant Registration-->
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
                $xbt_number = $_GET['xbt_number'];
                $ret="SELECT  * FROM his_exhibit WHERE xbt_number=?";
                $stmt= $mysqli->prepare($ret) ;
                $stmt->bind_param('s',$xbt_number);
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
                                                <li class="breadcrumb-item active">Manage Exhibits</li>
                                            </ol>
                                        </div>
                                        <h4 class="page-title">Update  Exhibits</h4>
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
                                                        <input type="text" required="required" readonly name="xbt_compt_name" value="<?php echo $row->xbt_compt_name;?>" class="form-control" id="inputEmail4" placeholder="Complainant's First Name">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Victim(s)</label>
                                                        <input required="required" type="text" readonly name="xbt_victim" value="<?php echo $row->xbt_victim;?>" class="form-control"  id="inputPassword4" placeholder="Complainant`s Last Name">
                                                    </div>

                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label">Complainant's Address</label>
                                                        <input required="required" type="text" readonly name="xbt_compt_addr" value="<?php echo $row->xbt_compt_addr;?>" class="form-control"  id="inputPassword4" placeholder="Victim(s)">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label for="inputPassword4" class="col-form-label"> Type</label>
                                                        <input required="required" readonly type="text" name="xbt_compt_type" value="<?php echo $row->xbt_compt_type;?>" class="form-control"  id="inputPassword4" placeholder="Victim(s)">
                                                    </div>

                                                </div>

                                                <div class="form-group ">
                                                        <label for="inputCity" class="col-form-label">Details of Offence</label>
                                                        <input required="required" type="text" value="<?php echo $row->xbt_offence_details;?>" name="xbt_offence_details" class="form-control" id="inputCity">
                                                </div>
                                                <hr>
                                                

                                                <div class="form-group">
                                                        <label for="inputAddress" class="col-form-label">Exhibits</label>
                                                        <textarea required="required"  type="text" class="form-control" name="xbt_desc" id="editor"><?php echo $row->xbt_desc;?></textarea>
                                                </div>

                                                <button type="submit" name="update__xbt" class="ladda-button btn btn-primary" data-style="expand-right">Update  Exhibits</button>

                                            </form>
                                            <!--End  Form-->
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