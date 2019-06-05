<div class=""> 
	<div class='col-md-5 pinkit roundleft paddtopbot addheight'>
		<div class='input_holder'>
			<p> Reported By </p>
			<h3> 
				<?php 
					if ( count($reportername) == 0) {
						echo "reporter not found";
					} else {
						echo $reportername[0]->name; 	
					}
				?> <span class='spanstat'> <?php echo $thetype; ?> </span> </h3>
		</div>
		<hr/>
		<!--div class='input_holder'>
			<p> Designation </p>
			<h3> Student </h3>
		</div>
		<hr/-->
		<?php 
			// var_dump($details);
		?>
		<div class='input_holder'>
			<p> Person Being Reported </p>
			<h3> <?php echo $details[0]->name; ?> </h3>
		</div>
		<hr/>

		<div class='input_holder'>
			<p> Lesson Date </p>
			<h3> <?php echo date("D. - M. d, Y ", strtotime($details[0]->date_time)); ?> </h3>
		</div>
		<hr/>
		<div class='input_holder'>
			<p> Status </p>
			<h3 id='thestatus'> <?php echo $status; ?> </h3>
		</div>
	</div>
	<div class='col-md-7 rightdivps'>
		<div class="underline">
			<div class='col-md-12'>
				<h3> Report Details </h3>
			</div>
		</div>

		<?php 
			foreach($thequestions as $tq) {
				echo "<div class='col-md-12 margintop'>";
					echo "<p>".$tq['question']."</p>";
					echo "<h3>".$tq['answer']."</h3>";
				echo "</div>";
			}
		?>
		<!--div class='col-md-12 margintop'>	
			<p> How long was the duration of the lesson? </p>
			<h3> -10 Minutes </h3>
		</div>

		<div class='col-md-12'>	
			<hr/>
			<p> Trouble Report </p>
			<h3> -Blackout </h3>
		</div-->

		<div class='col-md-12 bottomit'>	
			<hr/>
			<div class="btn-group fr">
				<button data-toggle="dropdown" class="btn btn-default dropdown-toggle unshad" aria-expanded="false">Set Status <span class="caret"></span></button>
				    <ul class="dropdown-menu">
						<li id='setopen'>
							<a href='#'>
								<i class="material-icons dp48 iconme">lock_open</i> OPEN
							</a>
						</li>
						<li class="divider"></li>
						<li id='setclose'>
							<a href='#'>
								<i class="material-icons dp48 iconme">lock_outline</i> CLOSE
							</a> 
						</li>
					</ul>
			</div>
		</div>

	</div>
</div>