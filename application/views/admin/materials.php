<div id="page-wrapper">
  	<div class="header"> 
		<h4 class="page-header">
			Materials
			<a href='<?php base_url();?>materials/add'>
				<p class='booktutor'> 
                   	<i class="fa fa-plus-circle bigfa"></i> &nbsp; 
                	<span class='btspan'> ADD MATERIAL </span>
            	</p>
        	</a>
		</h4>								
	</div>
    <div id="page-inner">
    	<div class='row white'>
    		<div class='col-md-12 msgdiv'>
    			<p>
    		You can choose from more than 4,000 teaching materials according to purpose and level.
It is recommended for those who want to strengthen the points and those who want to enjoy different lessons every time.
				</p>
			</div>
    	</div>

    	<div class='row'>
	    	<div class="card-content"> 
	    		<?php
	    			foreach($heads as $h) {
	    				echo "<ul class='collapsible' data-collapsible='accordion'>";
	    					echo "<li class=''>"; // active
	    						echo "<div class='collapsible-header fontsize50'>";
									echo "<p class='pheadpad' style='color:{$h['matcol']}'> LV {$h['matlvl']}";
										echo "<span class='rightdets'>";
											echo "<span class='spantext'>";
												echo $h['mattxt'];
											echo "</span>";
											echo "<span class='matedit'> 
														<a href='".base_url()."admin/materials/add/{$h['mat_id']}/'> ADD </a> 
													| 
														<a href='".base_url()."admin/materials/add/{$h['mat_id']}'> EDIT </a>
													| 
														<a href='".base_url()."admin/materials/add/{$h['mat_id']}/13/delete/material'> DELETE </a>
											</span>";
										echo "</span>"; 
									echo "</p>";
								echo "</div>";
								echo "<div class='collapsible-body white'>";
			    					foreach($materials as $m) {
			    						if ($m->mat_head_id == $h['mat_id']) {
											echo "<div class='row getmargin'>";
												echo "<div class='col-md-2'>";
													echo "<p class='lessphead'> Lesson {$m->matmodorder} </p>";
												echo "</div>";
												echo "<div class='col-md-7'>";
													echo "<div class='lessdets'>";
														echo "<p class='' style='color:{$h['matcol']}'> {$m->mat_mod_title} </p>";
															// echo "<strong> You were using some gestures have negative connotations. </strong>";
														echo "<p> {$m->mat_det} </p>";
														$attch = (array) json_decode($m->matfiles);
														
														echo "<p class='matstext'>";
															if (count($attch) > 0) {																
																foreach($attch as $a) {
																	echo "<a href='".base_url()."/upload/".htmlentities($a)."' target='_blank'><span>".$a."</span></a>";
																}
															} else {
																echo "<small style='color: #a7a7a7;'> --no attachment-- </small>";
															}
														echo "</p>";
													echo "</div>";
												echo "</div>";
												echo "<div class='col-md-3'>";
												// http://localhost/anw_elearning/admin/materials/add/8/
													echo "<div class='lessdets'>";
														echo "<p class='control_p'>";
															echo "<span> <a href='".base_url()."admin/materials/add/{$h['mat_id']}'> ADD </a> </span>";
																echo "<i> | </i>";
															echo "<span> <a href='".base_url()."admin/materials/add/{$h['mat_id']}/{$m->mat_det_id}'> EDIT </a></span>";
																echo "<i> | </i>";
															echo "<span> <a href='".base_url()."admin/materials/add/{$h['mat_id']}/{$m->mat_det_id}/delete/module/'> DELETE </a> </span>";
														echo "</p>";
													echo "</div>";
												echo "</div>";
											echo "</div>";
										}
			    					}
		    					echo "</div>";	
	    					echo "</li>";
	    				echo "</ul>";
	    			}
	    		?>
	        </div>
    	</div>
    </div>
</div>