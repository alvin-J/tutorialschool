<?php 
	if (count($info) == 0) { die("Didn't retrieved anything"); }
	$stname   = $info[0]->stname;
	$tename   = $info[0]->tename;
	$cid 	  = $info[0]->classroomid;

	// student 
		$ststatus = null;
		if ($info[0]->isstudentpres == 0) {
			$ststatus = "not ready yet";
		} else if ($info[0]->isstudentpres == 1) {
			$ststatus = "<p> ...is Ready </p>";
		}

	// teacher 

		$testatus = null;
		if ($info[0]->isteacherpres == 0) {
			$testatus = "not ready yet";
		} else if ($info[0]->isteacherpres == 1) {
			$testatus = "<p> ...is Ready </p>";
		}		


?>
<div id="page-wrapper">
	<div class="header"> 
        <h4 class="page-header"> Classroom's waiting area </h4>
	</div>

	<div id="page-inner">
		<div class='row'>
			<div class='col-md-5'>
				<div class='white leftboxdiv'>
					<div class='innerbox studentbox'>
						<h4> STUDENT </h4>

						<div class='detailsbox'>
							<p> <?php echo $stname; ?> </p>
							<span> <?php echo $ststatus; ?> </span>
						</div>
					</div>
					<div class='innerbox teacherbox'>
						<h4> TEACHER </h4>

						<div class='detailsbox'>
							<p> <?php echo $tename; ?> </p>
							<span> 
								<?php echo $testatus; ?>
							</span>
						</div>
					</div>
				</div>
				<hr style='border-color: #bdbdbd;'/>
				<div class='row'>
					<div class='col-md-12'>
						<a href='<?php echo base_url(); ?>classroom/start/<?php echo $cid; ?>' style='text-underline:none;' target='_blank'> <p id='proctoclass'> PROCEED TO CLASSROOM </p> </a>
					</div>
				</div>

			</div>

			<div class='col-md-7'>
				<!--div class='row'>
					<div class='col-md-12'>
						<h4> class starts in </h4>
						<p id='classtimer'> 00:23:00 </p>
					</div>
				</div-->

				<div class='row'>
					<div class='col-md-12'>
						<h3> Lesson Feedback(s) </h3>
						<hr style='margin: 20px 0px 0px 0px; border-top-color: #a1a1a1;'/>
				<?php if (count($fbs) > 0){ ?>
					<?php foreach($fbs as $fb){//for($i=0;$i<=1;$i++): ?>
						<div class='dateofbox'>
							<p> <?php echo date("F d, Y", strtotime($fb->dateoffb)); ?>  </p>
							<hr/>
						</div>

						<div class='feedbacktable'>
							<table>
								<tr>
									<td> <h3> Teacher Name </h3> </td>
									<td> <?php echo $fb->name; ?> </td>
								</tr>
								<tr>
									<td> <h3> Lesson Material </h3> </td>
									<td> <?php echo $fb->mat_headtext; ?> </td>
								</tr>
								<tr>
									<td colspan="2"> <h3> Feedback: </h3> </td>
								</tr>
								<tr> 
									<td colspan="2" style='padding: 10px 0px;'> 
										<?php echo $fb->feedback; ?>
									</td>
								</tr>
							</table>
						</div>
					<?php }//endfor; ?>
				<?php } else { ?>
					<p style='margin-top: 25px;'> No feedback found </p>
				<?php } ?>
					</div>

				</div>

			</div>

		</div>
	</div>
</div>