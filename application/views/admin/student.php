<div id="page-wrapper">
  	<div class="header"> 
		<h4 class="page-header">
			STUDENT <?php echo " - ".$this->uri->segment(3)." subscriptions"; ?>
			<p class='booktutor' id='booknow'> 
          		<i class="fa fa-plus-circle bigfa"></i> &nbsp; 
             	<span class='btspan'> ADD STUDENT </span>
      		</p>
		</h4>								
	</div>
    <div id="page-inner">
		<div class='row white'>
			<!--div class='col-md-12 getpadding_left_right'-->
			<div class='col-md-6 borderright'>
				<table class='tbl-adminstudent'>
					<thead>
						<tr>
							<th class='_130px'> ID </th>
							<th> STUDENT NAME </th>
							<th class='_140px'> TYPE </th>
							<th class='_140px'> <!--STUDENT PLAN --> </th>
							<th class='_140px'> ACTIONS </th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if (count($student) > 0) {
							for($a = 0; $a <= count($student)-1; $a++) {?>
								<tr>
									<td> <?php echo $student[$a]->studentid; ?> </td>
									<td> <?php echo $student[$a]->name; ?> </td>
									<td> Top-up <?php //echo $student[$a]->lep_lvl; ?> </td>
									<td> <?php // echo $student[$a]->subscriptionType; ?> </td>
									<td> 
										<button class='waves-effect waves-light btn btn-primary replenish' data-stdid='<?php echo $student[$a]->studentid; ?>'> Review </button>
										<!--ul class='dropselection'>
											<li><span> DROP </span>
												<ul> 
													<li class='drop' data-stdid='<?php //echo $student[$a]->studentid; ?>'> 
														<p class='p_ul'> 
															<i class="material-icons dp48 p_icon">thumb_down</i>
															<span class='thetxtspan'> DROP <span> 
														</p> 
													</li>
													<li class='replenish' data-stdid='<?php //echo $student[$a]->studentid; ?>'>
														<p class='p_ul'> 
															<i class="material-icons dp48 p_icon">restore</i> 
															<span class='thetxtspan'> REPLENISH <span> 
														</p> 
													</li>
												</ul-->
											</li>
										</ul>
									</td>
								</tr>
						<?php } 
						} else if (count($student) == 0) {
							echo "<tr> <td colspan=4> No payments for now </td> </tr>";
						}?>
					</tbody>
				</table>
			</div>
			<div class='col-md-6'>
				<h4> Options </h4>
				<hr/>
				<a class='waves-effect waves-light btn' href='<?php echo base_url()."admin/students"; ?>'> New Top-ups </a>
				<a class='waves-effect waves-light btn' href='<?php echo base_url()."admin/students/expired"; ?>'> Expired Accounts </a>
			</div>
		</div>
    </div>
</div>

<div class='addmodule' id='addmodule'>
	<div class='inner_mod_div' id='replenish_'>
		
	</div>
</div>