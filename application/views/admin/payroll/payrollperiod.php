<?php 
	$date 	   = null;
	$isunpaid  = null;
	$unpaidtxt = null;

	if (count($data) > 0) {
		$date = date("F d, Y",strtotime($data[0]->ppdatestart)) ." - ".date("F d, Y",strtotime($data[0]->ppdateend));

		if ($data[0]->pid == null) {
			$isunpaid  = "unpaid";
			$unpaidtxt = "UNPAID";
		} else {
			$unpaidtxt = "PAID";
		}
	} else {
		// return;
	}
?>
<div class='pheader'> <p> Payroll Period</p> <hr/> </div>
	<p id='payrolldate' data-datefrom='<?php //echo date("m/d/Y",strtotime($data[0]->ppdatestart)); ?>' data-dateend='<?php // echo date("m/d/Y",strtotime($data[0]->ppdateend)); ?>'> 
		<!--i class="material-icons dp48 iconperiod selectcalicon">today</i>
		<?php // echo $date; ?>
		<input type='text' class='daterangepick'/-->
		<div class="input-group input-daterange">
		    <input type="text" class="form-control calendarselect fromcal" id='fromcal' value='<?php echo "01-November-2018";//echo date("d-F-Y"); ?>'>
		    <div class="input-group-addon">to</div>
		    <input type="text" class="form-control calendarselect tocal" id='tocal' value='<?php echo "31-November-2018"; //echo date("t-F-Y"); ?>'>
		</div>
	</p>
	
		<div class='payperdets'>
			<button id='selectdatebtn'> Find Lessons </button>
			<!--span id='changepayper'> <i class="material-icons dp48">swap_horiz</i> change </span-->
			<select id='selectdates'>
				<option> -- Please Select --</option>
				<?php
					for($i = 0; $i <= count($period)-1; $i++) {
						$pstart = date("m/d/Y",strtotime($period[$i]->ppdatestart));
						$pend   = date("m/d/Y",strtotime($period[$i]->ppdateend));

						$pstart_txt = date("F d, Y",strtotime($period[$i]->ppdatestart));
						$pend_txt   = date("F d, Y",strtotime($period[$i]->ppdateend));

						echo "<option value='{$pstart} - {$pend}'> {$pstart_txt} - {$pend_txt} </option>";
					}
				?>
			</select>
		</div>

   <!--calendar -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <!-- end calendar -->

 	<!-- calendar -->
 	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
 	<!-- end calendar -->

<script type="text/javascript">
	
	var months = ['01','02','03','04','05','06','07','08','09','10','11','12'];
	var today  = new Date(),
		day    = today.getDate(),
		month  = months[today.getMonth()],
		year   = today.getFullYear();

    $(".calendarselect").datetimepicker({
    	 format		: "dd-MM-yyyy",
    	 timezone   : 'GMT',
         autoclose  : true,
         todayBtn	: true,
         minView	: 2,
         startDate	: year + "-" + month + "-" +day
    });
</script>

<style>
.datetimepicker table thead tr th,
.datetimepicker table tfoot tr th {
	color: #c98893 !important;
}

.datetimepicker table tbody tr td.active {
	background:pink !important;
}
	</style>