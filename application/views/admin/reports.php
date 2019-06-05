<div id="page-wrapper">
  	<div class="header"> 
		<h4 class="page-header">
			REPORTS <a class='reportnavs' href='<?php echo base_url(); ?>admin/reports/teacher'> teacher </a> <a class='reportnavs' href='<?php echo base_url(); ?>admin/reports/student'> student </a>
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
							<th colspan=5 class='headth'> Showing reports from <?php echo $this->uri->segment(3)."s"; ?></th>
							<p> <span> close | open </span> </p>
						</tr>
					</thead>
					<thead>
						<tr>
							<th class='_130px'> DATE </th>
							<th> LESSON ID </th>
							<?php 
								if ($from == "student"){
									echo "<th class='_140px'> ENGLISH LEVEL </th>";		
								}
							?>
							<th class='_140px'> STATUS </th>
							<th class='_140px'> ACTIONS </th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if (count($reports) > 0) {
							//	var_dump($reports);
							for($a = 0; $a <= count($reports)-1; $a++) {?>
								<tr>
									<td> <?php echo $reports[$a]->reportdate; ?> </td>
									<td> Lesson #<?php echo $reports[$a]->trbclassid; ?> </td>
									
									<?php 
										if ($from == "student"){
											echo "<td> {$reports[$a]->lep_lvl} </td>";		
										}
									?>
									
									<td> <?php echo $reports[$a]->t_status; ?> </td>
									<td> 
										<select style='display: block;' id='actiononrep' data-trblid = '<?php echo $reports[$a]->troubleid; ?>'>
											<option value='def'> --- choose --- </option>
											<option value='open'> OPEN </option>
											<option value='close'> CLOSE </option>
											<option value='view'> VIEW </option>
										</select>
									</td>
								</tr>
						<?php } }?>
					</tbody>
				</table>
			</div>
		</div>
    </div>
</div>

<div class='modalview' id='reportmodalview'>
	<div class='modalinner vreportsdiv' id='innerdata'>
		<p> loading.. please wait </p>
	</div>
</div>