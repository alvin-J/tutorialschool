
<ul class="collapsible removeattr" data-collapsible="accordion">
			<?php 
				$liid = null;
				foreach($bookings as $b){
					$liid = "book_".$b->bl_id;
			?>
    			<li id='<?php echo $liid; ?>'>
    				<div class='marginbot white'>
		    		<div class='col-md-12 removemar_p repdet_head collapsible-header'>
		    			<table class='reporttbl'>
		    				<thead>
		    					<th> LESSON TIME </th>
		    					<th> TUTOR ID </th>
		    					<th> TUTOR NAME </th>
		    					<th> LIMIT </th>
		    					<th> &nbsp; </th>
		    				</thead>
		    				<tbody>
		    					<tr>
		    						<td> <?php echo date("F d, Y h:i A",strtotime($b->date_time)); ?> </td>
		    						<td> <?php echo $b->teacherid; ?> </td>
		    						<td> <?php echo $b->name; ?> </td>
		    						<td> <?php echo date("F d, Y h:i A",strtotime($b->date_time)); ?> </td>
		    						<td> <button class='addreportbtn reportbtn'> REPORT </button> </td>
		    					</tr>
		    				</tbody>
		    			</table>
		    		</div>
		    		<!--hr class='borderbothr'/-->
		    		<div class='col-md-10 getcenter  collapsible-body thecollapse'>
		    			<div class='getmargbot'>
		    				<div class='row'>
		    				<?php
		    					$count   = 0;
		    					$headval = null;
		    					$qval    = null;
		    					foreach($questions as $key => $qs) {
		    						if ($key == "header") {
			    						foreach($qs as $q_key => $hqs) {
			    							foreach($hqs as $h) {
			    								$hv      = explode(" ",$h['topquestion']);
			    								$headval = $hv[0];

			    								unset($hv[0]);
			    								$topq    = implode(" ",$hv);
				    							echo "<div class='col-md-6'>";
							    					echo "<p> ".$topq." </p>";
							    				echo "</div>";

							    				$innercount = 0;
							    				foreach($h['optioname'] as $ops) {
							    					$theid = $key."_".$q_key."_".$count."_".$innercount."_".$b->bl_id;
							    					$ho    = explode(" ",$ops);
							    					$qval  = $ho[0];
							    					unset($ho[0]);
							    					$n_ops = implode(" ",$ho);

							    					$theval = $headval."_".$qval."_".$b->bl_id;
							    					echo "<div class='col-md-3'>";
							    						echo "<p>";
													      echo "<input name='{$q_key}' type='radio' id='{$theid}' value='{$theval}' class='option_rad_top'>";
													      echo "<label for='{$theid}'> {$n_ops} </label>";
													    echo "</p>";
							    					echo "</div>";
							    					$innercount++;
							    				}
						    				}
			    						}
		    						} 
		    						$count++;
		    					}
		    				?>
		    				</div>
		    			</div>
		    			<div class='marginer'></div>
		    			<div class='getmargbot'>
		    				<div class='row'>
			    				<div class='col-md-12'>
			    					<?php
			    					$count = 0;
			    					$headval = null;
			    					$qval    = null;
			    					foreach($questions as $key => $qs) {
			    						if ($key == "other") {
				    						foreach($qs as $q_key => $hqs) {
				    							foreach($hqs as $h) {
				    								$hv      = explode(" ",$h['topquestion']);
				    								$headval = $hv[0];

				    								unset($hv[0]);
				    								$topq    = implode(" ",$hv);

					    							//echo "<div class='col-md-6'>";
								    					echo "<p style='margin-bottom: 20px;'> ".$topq." </p>";
								    				//echo "</div>";

								    				$innercount = 0;
								    				foreach($h['optioname'] as $ops) {
								    					$theid = $key."_".$q_key."_".$count."_".$innercount."_".$b->bl_id;
								    					$ho    = explode(" ",$ops);
								    					$qval  = $ho[0];
								    					unset($ho[0]);
								    					$n_ops = implode(" ",$ho);

								    					$theval = $headval."_".$qval."_".$b->bl_id;
								    					echo "<div class='col-md-5'>";
								    						echo "<p>";
														      echo "<input name='{$q_key}' type='radio' id='{$theid}' value='{$theval}' class='option_rad'>";
														      echo "<label for='{$theid}'> {$n_ops} </label>";
														    echo "</p>";
								    					echo "</div>";
								    				$innercount++;
								    				}
							    				}
				    						}
			    						} 
			    						$count++;
			    					}
			    				?>
			    					<div style='clear:both'>
			    						<div class='col-md-3 addpadd'>
			    							<button class='reportbtn reporthis' data-li_id = '<?php echo $liid; ?>'> SUBMIT </button> 
			    						</div>	
			    						<!--span class='alert alert-success'> You have successfully reported this. </span-->
			    						
			    					</div>
			    				</div>
		    				</div>
		    			</div>
		    		</div>
		    		</div>
	    		</li>
	    	<?php } ?>
    		</ul>
