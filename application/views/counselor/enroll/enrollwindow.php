<div class='outerdiv'>
	<div class='innerdiv'>
		<div class='overflow'>
			<h4> ENROLL <i class="fa fa-times" aria-hidden="true" style='float: right; margin-right: 12px;' id='closewindow' title="Close"></i> </h4>
			<h2> FREE TRIAL </h2>
			 	
			<h5> PAYMENT INFORMATION </h5>
			<div style='clear:both;'></div>
			<hr/>
			<div class='col-md-6' style='text-align: right;'>
				<h6> STUDENT NAME </h6>
				<p> <?php echo $inf[0]->name; ?> </p>
			</div>
			<div class='col-md-6' style='text-align: left;'>
				<h6> SUBSCRIPTION TYPE </h6>
				<select id='subtype'>
					<option value='1D'> 1D Student Plan </option>
					<option value='8M'> 8M Student Plan </option>
					<option value='1DP'> 1D Student Plan + Counseling </option>
				</select>
			</div>
			<div style='clear:both; '></div>
			<hr style='margin: 17px 0px;'/>
				<div class="statusdiv <?php echo $class; ?>">
					<small class="small_style">
						<?php 
							if ($paymentstatus == "valid") {
								echo "There is still a valid payment for this account. Cannot enroll in a Free Trial Lesson";
							} else if ($paymentstatus == "invalid") {
								echo "You are about to enroll this student to a free trial lesson.";
							}
						?>	
					</small>
				</div>
			<hr style="margin: 17px 0px;">
			<p style="text-align:center;"> 
			 	<?php 
			 		if ($paymentstatus != "valid") {
			 			echo "<button class='btn btn-primary' id='enrollnow'> Enroll Now </button>";		
			 		}
			 	?>
			</p>
		</div>
	</div>
</div>