	    			<div class='col-md-8 white removepad roundthis' style=''>
	    				<p class='ptab' style='background: #989898;'> &nbsp; </p>
	    				<table class='informationtbl'>
	    					<tr>
	    						<th> Name </th>
	    						<td> <?php echo $inf[0]->name; ?> </td>
	    					</tr>
	    					<tr>
	    						<th> level of english proficiency  </th>
	    						<td> <?php echo $inf[0]->lep_desc; ?> </td>
	    					</tr>
	    					<tr>
	    						<th> correction preference </th>
	    						<td> <?php echo $inf[0]->cp_desc; ?> </td>
	    					</tr>
	    					<tr>
	    						<th> student-tutor talk time/pace </th>
	    						<td> <?php echo $inf[0]->stttp_desc; ?> </td>
	    					</tr>
	    				</table>
	    				<?php 
	    					if (isset($feedback)) {
	    						if (count($feedback) > 0) {
	    							echo "<table class='feedbacktbl'>";
	    								echo "<tr>";
	    									echo "<th colspan=5 style='text-align:center;'> Feedback from teachers </th>";
	    								echo "</tr>";
		    							foreach($feedback as $fb) {
		    								echo "<tr>";
			    								echo "<td>";
			    									echo $fb->name;
			    								echo "</td>";
			    								echo "<td>";
			    									echo $fb->feedback;
			    								echo "</td>";
			    							echo "</tr>";
		    							}
	    							echo "</table>";
	    						}
	    					}
	    				?>
	    				<p> &nbsp; </p>
	    			</div>
	    			<div class="col-md-4">
	    				<button class='btn btn-primary fullwidth' id='enrollfreetrial'> Enroll Free trial </button>
	    			</div>
	    			<span id='enrollwindow'> </span>