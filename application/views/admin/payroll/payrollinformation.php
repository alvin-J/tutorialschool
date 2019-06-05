<?php 
	$rate = null;
	$per  = null;

	if (count($data) > 0) {
		$rate = $data[0]->rate;
		$per  = $data[0]->per;
	}
?>
<!--div class='pheader'> <p> Payroll Information </p> <hr/> </div-->
	<p class='smallheader'> Rate </p>
		<div class='therate'>
			<div class='ratebox'>
				<input type='text' class='getmarg' placeholder="000.00" id='ratetxt' value='<?php echo number_format($rate,2); ?>'/>
				<select id='perselect'>
					<!--option> -- Please Select --</option-->
					<?php 
						$options = ["hour"]; // ,"day"
						for($i = 0; $i <= count($options)-1; $i++) {
							$selected = ($per == $options[$i])?"selected":null;
							echo "<option value='{$options[$i]}' {$selected}> ".$options[$i]." </option>";
						}
					?>
					<!--option value='hour'> HOUR </option>
					<option value='day'> DAY </option-->
				</select>
				<div id='saverate'> save </div>
			</div>
		
	</div>