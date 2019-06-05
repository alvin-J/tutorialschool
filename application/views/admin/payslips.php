<div id="page-wrapper">
  	<div class="header"> 
		<h4 class="page-header">
			Payslips
			<p class='booktutor' id='booknow'> 
          		<i class="fa fa-plus-circle bigfa"></i> &nbsp; 
             	<span class='btspan'> ADD STUDENT </span>
      		</p>
		</h4>								
	</div>
    <div id="page-inner">
		<div class='row white'>
			<div class='col-md-12 getpadding_left_right'>
				<table class='tbl-adminstudent'>
					<thead>
						<tr>
							<th class='_130px'> ID </th>
							<th> TUTOR NAME </th>
							<th class='_140px'> STATUS </th>
							<th class='_140px'> ACTIONS </th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if (count($teachers) > 0) {
							for($a = 0; $a <= count($teachers)-1; $a++) {?>
								<tr>
									<td> <?php echo $teachers[$a]->teacherid; ?> </td>
									<td> <?php echo $teachers[$a]->name; ?> </td>
									<td> <?php echo $teachers[$a]->availability; ?> </td>
									<td> 
										<button class='btn btn-default v_pslip' data-tid='<?php echo $teachers[$a]->teacherid; ?>'> View Payslip </button>
									</td>
								</tr>
						<?php } }?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>

<div class='blackerdiv' id='blackerdiv'>
	<div class='innerwhite'>

		<div id='middlepopdiv'>
			<div class=''>
				<div class='col-md-6 borderright whiteleft'>

					<div class=''>
						<div class='divbox'>
							<div id='headerpop'>
			
							</div>

							<div class='divbox' id='payrollinformation'>
						
							</div>

							<div class='payrollperiod' id='payrollperiod'>
								
							</div>

							<div class='hrsrendered' id='hoursrendered'>
								
							</div>
							<p id='createpayroll'> <button class='thebtnpaypop' id='pleasecreate'> Create Payroll </button> </p>
						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='row margtop20'>
						<div class='col-md-3'>
							<img src='<?php echo base_url(); ?>images/logoanw.png' class='paylogo'/>
						</div>
						<div class='col-md-8 '>
							<p class='payheadtxt'> PAYSLIP </p>
						</div>
					</div>
					<div class='row margbot60'>
						<div class='col-md-12' id='theearnings'>
							
						</div>
					</div>
					<div class='row'>
						<div class='col-md-12'>
							<p style='text-align: right;'> <button class='thebtnpaypop' id='sendpayslip'> Send Payslip </button> </p>
						</div>
					</div>
				</div>	
				
			</div>
		</div>


	</div>
</div>