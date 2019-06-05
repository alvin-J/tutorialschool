<div id="page-wrapper">
	<div class="header"> 
        <h4 class="page-header"> YOUR LIST OF CLASSES </h4>
	</div>

	<div id="page-inner">
		<div class="row">
			<?php 
				if ($class != false) {
					foreach($class as $r) {
						$status = null;

						if ($r->blstat == 0) {
							$status = 'awaiting confirmation';
						} else if ($r->blstat == 1) {
							$status = 'confirmed';
						} else if ($r->blstat == 2) {
							$status = 'declined';
						} else if ($r->blstat == 3) {
							$status = 'cancelled';
						}

						$date = date("F d, Y h:i A", strtotime($r->date_time));
						$url  = base_url()."classroom/waiting/".$r->classroomid;
						echo "<div class='col-md-8 els_overwrap'>
								<div class='row getmargbot elsdiv'>
									<div class='col-md-4 innerel'>
										<span> NAME </span>
										<p> {$r->name} </p>
									</div>
									<div class='col-md-4 innerel'>
										<span> SCHEDULED DATE AND TIME </span>
										<p> {$date} </p>
									</div>
									<div class='col-md-4 innerel'>
										<span> STATUS </span>
										<p> {$status} </p>
									</div>
								</div>";

							if ($r->blstat == 1) {
								echo "<div class='row getmargbot'>
											<div class='col-md-12 enterdiv'>
												 <a href='{$url}'> <p id='enterp'>ENTER </p> </a> 
											</div>
									  </div>";
							}
						echo "</div>";
					}
				} else {
					echo "<p style='text-align: center; margin-top: 32px;'>
								<i class='material-icons dp48' style='font-size: 87px;'>info_outline</i> <br/>
							 No class for you this time. 
						  </p>";
				}
			?>
		</div>
	</div>
</div>
</div>
		

