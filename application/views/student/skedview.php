<?php 
	$datetime = date("F d, Y @ h:i A", strtotime($data[0]->date_time));
	$timezone = $data[0]->timezone;
	$bkid     = $data[0]->bl_id;
	$key      = $bkid.$data[0]->studentid.$data[0]->teacherid; 
	// http://anwdev.ariesvrebuldad.com/classroom/waiting/209b409bc8375558913d4
?>
<div class='skedview'>
	<h4> CHOOSE WHAT TO DO <i class="fa fa-times closethewin" id="closethis"></i></h4>
	<hr style='margin: 10px 0px;'/>
		<div class='col-md-7 dets'>
			<span>Date and Time</span>
			<p> <?php echo $datetime; ?> </p>
		</div>
		<div class='col-md-5 dets'>
			<span>Timezone</span>
			<p> <?php echo $timezone; ?> </p>
		</div>
		<div id='statusid'>&nbsp;</div>
		<div class='col-md-6 btnoption cancelbtn' data-bkid = '<?php echo $bkid; ?>'>
			CANCEL BOOKING
		</div>
		<div class='col-md-6 btnoption gotocroom' data-bkid = '<?php echo $bkid; ?>' 
			 data-keycode='<?php echo $key; ?>'>
			GO TO CLASSROOM
		</div>
</div>

