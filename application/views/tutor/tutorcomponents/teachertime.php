 <div class='row'>
    <div class='col-md-12 midit'>
        <div class='thebuttondiv'>
        	<?php 
        		$present = null;
        		$absent  = null;

        		// absent id 
        		$absentid = null;
				$present 	 = "att_selected";
			/*
        		if ($attendance == "present") {
        			$present 	 = "att_selected";
        		} else {
        			$absent  	 = "att_selected";
        			$absentid	 = "data-skedid='{$attendance}'";
        		}
			*/
        	?>
            <span class='attendance <?php echo $present; ?>' id='presentme'> PRESENT </span>
            <span class='attendance <?php echo $absent; ?>' id='absentme' <?php echo $absentid; ?>> ABSENT </span>
        </div>
    </div>
</div>

<div class='row'>
<div class="col-md-4">
    <div class="classdivbox">
        <h4 class="sc_head" style="background:#96E2FA;"> MORNING </h4>
        <ul>
        	<?php 
        		for($h = 7; $h <= 11; $h++) {
        			$mins = 0;
        			while ($mins <= 30){
        				if ($mins == 0) { $mins = "00"; }
        				$time  = "{$h}:{$mins} AM";

        				$name 	 = null;
        				$hassked = null;
						$data_el = null;
        				foreach($data as $d) {
	        				if ($d['time'] == $time) {
	        					$hassked = "hassked";
	        					$name 	 = " - (<strong>".$d['student']."</strong>)";
								$data_el    = "data-stdid = '{$d['std_id']}' data-blid = '{$d['bl_id']}'";
	        				}
        				}
						
						$absentme = null;
						
						if (is_array($attendance)) {
							foreach($attendance as $a) {
							//	echo date("g:i A", strtotime($a->thedate))."=".$time."<br/>";
								if (date("g:i A", strtotime($a->thedate)) == $time) {
									$absentme = "imabsent";
									$hassked  = null;
								}
							}
						}
						
        				echo "<li class='{$hassked} {$absentme}' {$data_el}> {$time} {$name} </li>";
        				$mins += 30;
        			} 
        		}
        	?>                       
        </ul>
	</div>
</div>

<div class="col-md-4">
    <div class="classdivbox">
        <h4 class="sc_head" style="background:#FDB211;"> AFTERNOON </h4>
        <ul>
        	<?php 
        		for($h = 12; $h <= 17; $h++) {
        			$mins = 0;
        			while ($mins <= 30){
        				if ($mins == 0) { $mins = "00"; }
        				$time = date("g:i A",strtotime("{$h}:{$mins}"));

        				$name 	 = null;
        				$hassked = null;
						$data_el = null;
        				foreach($data as $d) {
	        				if ($d['time'] == $time) {
	        					$hassked = "hassked";
	        					$name 	 = " - (<strong> ".$d['student']."</strong>)";
								$data_el    = "data-stdid = '{$d['std_id']}' data-blid = '{$d['bl_id']}'";
	        				}
        				}
						
						$absentme = null;
						
						if (is_array($attendance)) {
							foreach($attendance as $a) {
								if (date("g:i A", strtotime($a->thedate)) == $time) {
									$absentme = "imabsent";
									$hassked  = null;
								}
							}
						}
						
        				echo "<li class='{$hassked} {$absentme}' {$data_el}>";
        					echo $time.$name;
        				echo "</li>";
        				$mins += 30;
        			} 
        		}
        	?>                       
        </ul>
	</div>
</div>

<div class="col-md-4">
    <div class="classdivbox">
        <h4 class="sc_head" style="background:#FFC7C8;"> EVENING </h4>
        <ul>
        	<?php 
        		for($h = 18; $h <= 23; $h++) {
        			$mins = 0;
        			while ($mins <= 30){
        				if ($mins == 0) { $mins = "00"; }

        				$time = date("g:i A",strtotime("{$h}:{$mins}"));
        				
        				$name 	 = null;
        				$hassked = null;
						$data_el = null;
        				foreach($data as $d) {
	        				if ($d['time'] == $time) {
	        					$hassked = "hassked";
	        					$name 	 = " - (<strong>".$d['student']."</strong>)";
								$data_el = "data-stdid = '{$d['std_id']}' data-blid = '{$d['bl_id']}'";
	        				}
        				}
						
						$absentme = null;
						
						if (is_array($attendance)) {
							foreach($attendance as $a) {
								if (date("g:i A", strtotime($a->thedate)) == $time) {
									$absentme = "imabsent";
									$hassked  = null;
								}
							}
						}
						
        				echo "<li class='{$hassked} {$absentme}' {$data_el}>";
        					echo $time.$name;
        				echo "</li>";
        				$mins += 30;
        			} 
        		}
        	?>                       
        </ul>
	</div>
</div>
</div>