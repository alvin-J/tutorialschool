<?php 
	$name = null;
	if (count($data) > 0) {
		$name = $data[0]->name;
	} else {
		$name = "NO EMPLOYEE FOUND";
	}

?>
<div class='row getmarg borderbot'>
	<div class='col-md-12'>
		<span id='thename'> <?php echo $name; ?> </span>
	</div>
	<!--div class='col-md-6 floatright'>
		<span style='color: #9f9f9f;'> Payroll Computation </span>
	</div-->
</div>