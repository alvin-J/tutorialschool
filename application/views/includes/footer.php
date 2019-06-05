	 <!-- /. PAGE WRAPPER  -->
</div>
    <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
	 

	<!-- Bootstrap Js -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	
	<script src="<?php echo base_url(); ?>assets/materialize/js/materialize.min.js"></script>
	
    <!-- Metis Menu Js -->
    <script src="<?php echo base_url(); ?>assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="<?php echo base_url(); ?>assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/morris/morris.js"></script>
	
	
	<script src="<?php echo base_url(); ?>assets/js/easypiechart.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/easypiechart-data.js"></script>
	
	 <script src="<?php echo base_url(); ?>assets/js/Lightweight-Chart/jquery.chart.js"></script>
	
    <!-- Custom Js -->
    <script src="<?php echo base_url(); ?>assets/js/custom-scripts.js"></script> 
 	<script src='<?php echo base_url()."procs/register.procs.js" ?>'></script>

 	<!-- calling API -->
	 	<script src="https://static.opentok.com/v2/js/opentok.min.js"></script> 
	 	<script src='<?php echo base_url()."procs/listentocall.procs.js" ?>'></script>
 	<!-- end calling API -->
	
	<!-- calendar -->
		<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
 	<!-- end calendar -->
	
 	<!-- check for payment -->
 		<?php if($this->session->userdata("type") == 1): ?>
 	 		<script src='<?php echo base_url()."procs/check.payment.procs.js" ?>'></script>
 	 	<?php endif; ?>
 	<!-- end payment -->

    <!-- foot scripts here -->
    	<?php 
	        if (isset($headscript) && isset($headscript['js'])) {
	            foreach($headscript['js'] as $st) {
	                echo "<script src='".$st."'></script>";
	            }
	        }
    	?>
    <!-- end foot scripts -->


</body>

</html>