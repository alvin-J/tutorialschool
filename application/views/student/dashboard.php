		<div id="page-wrapper">
		  <div class="header"> 
                        <h4 class="page-header">
                            Dashboard
                            <p class='booktutor'> 
                            	<i class="fa fa-plus-circle bigfa"></i> &nbsp; 
                            	<span class='btspan noclass'> BOOK TUTOR </span>
                           	</p>
                        </h4>

					<!--ol class="breadcrumb">
					  <li><a href="#">Home</a></li>
					  <li><a href="#">Dashboard</a></li>
					  <li class="active">Data</li>
					</ol--> 
									
		</div>
            <div id="page-inner">
<?php 
	$englvl 	= 0;
	$conlvl 	= 0;
	$grammar 	= 0;
	$speaking 	= 0;
	$reading 	= 0;
	$writing 	= 0;
	$listening 	= 0;

	if (count($pl_vals) > 0) {
		$englvl 	= $pl_vals[0]->englvl*10;
		$conlvl 	= $pl_vals[0]->conlvl;
		$grammar 	= $pl_vals[0]->grammar*10;
		$speaking 	= $pl_vals[0]->speaking*10;
		$reading 	= $pl_vals[0]->reading*10;
		$writing 	= $pl_vals[0]->writing*10;
		$listening 	= $pl_vals[0]->listening*10;
	}
?>
			<div class="dashboard-cards"> 

                <div class="row">
                			<!-- booked classes -->
                			<div class="col-md-4 "> 
                				<h4 class='tblheads bclassh3'> BOOKED CLASSES </h4>
                				<ol class='bclass white'>
                					<?php 
                						if (count($bclass) == 0) {
                							echo "<p> No booked classes </p>";
                						} else {
                							foreach($bclass as $bc) {
                								echo "<li> <p style='margin: 0px; font-size: 12px; text-transform: uppercase;'> ".date("F d, Y @ h:i A",strtotime($bc->date_time))." </p> <p style='margin: 0px;'> ".$bc->name." </p> </li>";		
                							}
                						}
                					?>
                					<!--li> 6:00 AM - LESSON NAME (tutor name) </li>
                					<li> 6:00 AM - LESSON NAME (tutor name) </li>
                					<li> 6:00 AM - LESSON NAME (tutor name) </li>
                					<li> 6:00 AM - LESSON NAME (tutor name) </li-->
                				</ol>
                			</div>
                			<!-- end booked classes -->

                			<!-- bookmarked tutors -->
                			<div class="col-md-4 "> 
                				<h4 class='tblheads btutorsh3'> BOOKMARKED TUTORS </h4>
                				<ol class='bclass white'>
                					<?php 
                						if (count($bl) == 0) {
                							echo "<p style='padding: 10px; text-align: center; color: #bdbcbc;font-style: italic;'> You haven't bookmarked anyone yet. </p>";
                						} else {
                							foreach($bl as $b) {
                								echo "<li> ".$b->name." </li>";
                							}
                						}
                					?>
                					<!--li> 6:00 AM - FULL TUTOR NAME 1 </li>
                					<li> 6:00 AM - FULL TUTOR NAME 1 </li>
                					<li> 6:00 AM - FULL TUTOR NAME 1 </li>
                					<li> 6:00 AM - FULL TUTOR NAME 1 </li-->
                				</ol>
                			</div>
                			<!-- end bookmarked tutors -->
                	<div class='col-md-3'>
                		<div class="row">
		                    <div class="col-xs-12">
								<div class="card horizontal cardIcon waves-effect waves-dark">
								<div class="card-image red">
								<i class="material-icons dp48">import_export</i>
								</div>
								<div class="card-stacked red">
								<div class="card-content">
								<h3>84,198</h3> 
								</div>
								<div class="card-action">
								<strong>LESSON HOURS</strong>
								</div>
								</div>
								</div> 
		                    </div>
	                    </div>
	                    <div class="row">
		                    <div class="col-xs-12">
								<div class="card horizontal cardIcon waves-effect waves-dark">
								<div class="card-image orange">
								<i class="material-icons dp48">shopping_cart</i>
								</div>
								<div class="card-stacked orange">
								<div class="card-content">
								<h3>36,540</h3> 
								</div>
								<div class="card-action">
								<strong>LESSON COUNT</strong>
								</div>
								</div>
								</div> 
	                    	</div>
	                    </div>
	                    <div class="row">
		                    <div class="col-xs-12">
								<div class="card horizontal cardIcon waves-effect waves-dark">
								<div class="card-image blue">
								<i class="material-icons dp48">equalizer</i>
								</div>
								<div class="card-stacked blue">
								<div class="card-content">
								<h3>24,225</h3> 
								</div>
								<div class="card-action">
								<strong>PURPOSE</strong>
								</div>
								</div>
								</div> 
							</div>	 
	                    </div>
	                    <div class="row">
		                    <div class="col-xs-12">
								<div class="card horizontal cardIcon waves-effect waves-dark">
								<div class="card-image green">
								<i class="material-icons dp48">supervisor_account</i>
								</div>
								<div class="card-stacked green">
								<div class="card-content">
								<h3><?php echo $conlvl; ?></h3> 
								</div>
								<div class="card-action">
								<strong>CONVERSATION LEVEL</strong>
								</div>
								</div>
								</div> 
							</div> 
	                    </div>
                    </div>
                </div>
			   </div>
				<!-- /. ROW  --> 
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-7"> 
					<div class="cirStats">
						  	<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6"> 
										<div class="card-panel text-center">
											<h4>LISTENING</h4>
											<div class="easypiechart" id="easypiechart-blue" data-percent="<?php echo $listening; ?>" ><span class="percent"><?php echo $listening; ?>%</span>
											</div> 
										</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6"> 
										<div class="card-panel text-center">
											<h4>GRAMMAR</h4>
											<div class="easypiechart" id="easypiechart-red" data-percent="<?php echo $grammar; ?>" ><span class="percent"><?php echo $grammar; ?>%</span>
											</div>
										</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6"> 
										<div class="card-panel text-center">
											<h4>SPEAKING</h4>
											<div class="easypiechart" id="easypiechart-teal" data-percent="<?php echo $speaking; ?>" ><span class="percent"><?php echo $listening; ?>%</span>
											</div> 
										</div>
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6"> 
										<div class="card-panel text-center">
											<h4>READING</h4>
											<div class="easypiechart" id="easypiechart-orange" data-percent="<?php echo $reading; ?>" ><span class="percent"><?php echo $reading; ?>%</span>
											</div>
										</div>
								</div>  
							</div>
						</div>							
						</div><!--/.row-->
						<div class="col-xs-12 col-sm-12 col-md-5"> 
						     <div class="row">
								<div class="col-xs-12"> 
									<div class="card">
										<!--div class="card-image donutpad">
										  <div id="morris-donut-chart"></div>
										</div--> 
										<div class="card-action">
										  <b>Performance</b>
										</div>
										<div class='card_body'>
											<p class='englvl'> English Level: <span> <?php echo $englvl; ?>% </span> </p>
											<div class='fbs'>
												<table>
													<tr>
														<td colspan="2" class='fb_head'> Feedback from teachers </td>
													</tr>
													<?php
														foreach($feedbacks as $fbs) {
															echo "<tr>";
																echo "<td>";
																	echo $fbs->name;
																echo "</td>";
																echo "<td>";
																	echo $fbs->feedback;
																echo "</td>";
															echo "</tr>";
														}
													?>
												</table>
											</div>
										</div>
									</div>
								</div>
							 </div>
						</div><!--/.row-->
					</div>
					

				<div class="row">
				<div class="col-md-12">
				
					</div>		
				</div> 	
                <!-- /. ROW  -->

	   
                <!-- /. ROW  -->
 <div class="fixed-action-btn horizontal click-to-toggle">
    <a class="btn-floating btn-large red">
      <i class="material-icons">menu</i>
    </a>
    <ul>
      <li Title='Book Tutor'><a class="btn-floating red" id='booktutor'><i class="material-icons">library_books</i></a></li>
      <!--li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
      <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
      <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li-->
    </ul>
  </div>
		
				<footer><p>All rights reserved. </p>
				
        
				</footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
       