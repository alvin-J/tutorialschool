<link rel='stylesheet' href='<?php echo base_url(); ?>style/book.style.css'/>


<div class='overall_wrap' id='overall_wrap'>
	<div class='bookinnerwrap'>

	<div class='row getmargbot'>
		<h5 class='rowheadtxt'> 
			<span class='toolbartext'> BOOK A SCHEDULE </span>
			<i class="fa fa-times closethewin" id='cancelthis'></i>
		</h5>
	</div>
		
	<div class='row getmargbot' id='bookingstats' style='display: none;'>
		<p class='getmargbot' style='padding: 7px 0px 7px; text-align: center; background: #ffc1cc;'> PLEASE WAIT WHILE WE ARE BOOKING. </p>
	</div>



	<!--div class='row getmargbot booknowtoolbar'>
		<?php //if ($status == null): ?>
			<p id='startbook' class='waves-effect waves-light flatbtn booknowtrig'><i class="fa fa-book"></i> &nbsp; Book Now </p>
		<?php //endif; ?> 
		<?php //if ($status == true): ?>
			<p class='p_exp'> Cannot book a tutor. </p>
		<?php //endif; ?> 	
	</div-->

	<div class='row getmargbot bottomdivbox'>
		<div class='col-md-6 borderright'>
			<p class='tbottxt fontit'> Teachers: 
				<span id='selectedtutor'>
					<?php 
						if (isset($teacherdets)) {
							echo $teacherdets[0]->name;
						} else {
							echo "-- No selected --";		
						}
					?>	
				</span> 
			</p>
			<div class='teacherdiv'>
				<?php 
				//	var_dump($available_teachers);
					if ( count( $available_teachers) > 0)  {
						for ($i = 0; $i <= count($available_teachers)-1; $i++) {
							echo "<div class='col-md-12 boxme teachersmalldiv'  data-teacherid = '{$available_teachers[$i]->teacherid}' data-tname='{$available_teachers[$i]->name}'>";
								echo "<p class=''> {$available_teachers[$i]->name} </p>";
								echo "<span> EXP: {$available_teachers[$i]->exp} </span>";
							echo "</div>";
						}
					}
				?>
			</div>
		</div>

		<div class='col-md-6'>
			<p class='hdtxt fontit'> Selected Date: </p>
			<div class="input-append">
				<?php
					if ($isselected) {
						echo "<p style='margin: 0px;'> {$selected_date} </p>";
					} else {
						echo "<input type='text' value='{$selected_date}' class='date calendarselect' placeholder ='click to select date and time' id='selecteddate' readonly>";
					}
				?>
				<span class="add-on"><i class="icon-remove"></i></span>
				<span class="add-on"><i class="icon-th"></i></span>
			</div>
			<div class='thetimetablediv'>
				<table id='tableofskeds'>
					<thead>
						<th colspan="3" style='background: transparent;  color: #333;'> 
							<p class='tabletext fontit'> List of Available Time: 
								<span id='dateavail' style='color:#843241; font-size: 11px;'> </span> 
							</p> 
						</th>
					</thead>
					<!--thead>
						<th> Morning </th>
						<th> Afternoon </th>
						<th> Evening </th>
					</thead-->
					<tbody id='timeskeds'>
						<th style='font-weight: normal; font-size: 13px; padding: 8px; text-align: center;'> 
							--- ###### ---
						</th>
					</tbody>
				</table>
			</div> 
		</div>
	</div>

	<div class='row getmargbot'>
		<!--p class='tophead fontit'> <span> BOOK </span> </p-->
		<div class='navdivbook'>
			<ul>
				<li>
					<p class='captiontext'>
						<?php if ($status == null): ?>
							<!--p id='startbook' class='waves-effect waves-light flatbtn booknowtrig'><i class="fa fa-book"></i> &nbsp; Book Now </p-->
							<span id='startbook' class='booknowtrig'>
								<i class="material-icons dp48">play_for_work</i> Book Now 
							</span>
						<?php endif; ?> 
						<?php if ($status == true): ?>
							<p class='p_exp'> Cannot book a tutor. </p>
						<?php endif; ?> 
						<!--i class="material-icons dp48">play_for_work</i>
						<span id=''> Save </span-->
					</p>
				</li>
			</ul>
		</div>
	</div>
	
	</div>
</div>


</div>

    <!--calendar -->
    <link href="<?php // echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <!-- end calendar -->

 	<!-- calendar -->
 	<script src="<?php // echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
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