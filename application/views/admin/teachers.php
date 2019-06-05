<div id="page-wrapper">
  	<div class="header"> 
		<h4 class="page-header">
			TEACHERS
		</h4>								
	</div>
    <div id="page-inner">
		<div class='row white'>
			<div class='col-md-12 getpadding_left_right'>
				<table class='tbl-adminstudent' id='addteachertbl'> 
					<thead>
						<tr>
							<th class='_130px'> ID </th>
							<th> TUTOR NAME </th>
							<th class='_140px'> STATUS </th>
							<th class='_140px'> START DATE </th>
							<th class='_140px'> ACTIONS </th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if (count($teachers) > 0) {
							for($a = 0; $a <= count($teachers)-1; $a++) {?>
								<tr data-teacherid = '<?php echo $teachers[$a]->teacherid; ?>'>
									<td> <?php echo $teachers[$a]->teacherid; ?> </td>
									<td> <?php echo $teachers[$a]->name; ?> </td>
									<td> <?php echo $teachers[$a]->availability; ?> </td>
									<td> <?php echo $teachers[$a]->startdate; ?> </td>
									<td> </td>
								</tr>
						<?php } }?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>


<div class='addmodule' id='addmodule'>
	<div class='inner_mod_div' id='showteacherwindow'>
		
	</div>
</div>