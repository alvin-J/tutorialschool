<?Php 
     if (!isset($time)) {
          $time = [];
     }
?>
<h3> Time Schedules </h3>
     <hr/>
     	<div class='col-md-4'>
     		<h4> MORNING </h4>
	              <ul>
	                   <?php 
               		$s = strtotime("5:30 AM");
               		$e = strtotime("11:00 AM");

               		while($s <= $e) {
                              $thetime = date("h:i A",$s);
                              $sel = (in_array($thetime,$time))?"bookedtime":"btn btn-default timesel";

               			$s = strtotime( date("h:i A", strtotime("+30 minutes",$s)) );
               	    		echo "<li class='{$sel}' style='width:100%;' data-time='".$thetime."'>";
               			echo $thetime;
               			echo "</li>";
               		}
               					
               		?>
	               </ul>
          </div>
          <div class='col-md-4'>
           	<h4> AFTERNOON </h4>
	         	    <ul>	
     	               <?php 
                    	$s = strtotime("11:30 AM");
                    	$e = strtotime("5:00 PM");

                    	while($s <= $e) {
                              $thetime = date("h:i A",$s);
                              $sel = (in_array($thetime,$time))?"bookedtime":"btn btn-default timesel";

                    		$s = strtotime( date("h:i A", strtotime("+30 minutes",$s)) );
                    		echo "<li class='{$sel}' style='width:100%;' data-time='".$thetime."'>";
                    	         	echo $thetime;
                    		echo "</li>";
                    	}
                    			
                    	?>
	               </ul>
          </div>
          <div class='col-md-4'>
          	<h4> EVENING </h4>
	     		<ul>	
	                   <?php 
               		$ss = strtotime("5:30 PM");
               		$ee = strtotime("11:00 PM");

               		while($ss <= $ee) {
                              $thetime = date("h:i A",$ss);
                              $sel = (in_array($thetime,$time))?"bookedtime":"btn btn-default timesel";

               			$ss = strtotime( date("h:i A", strtotime("+30 minutes",$ss)) );
               			echo "<li class='{$sel}' style='width:100%;' data-time='".$thetime."'>";
               				echo $thetime;
               			echo "</li>";
               		}
               					
               	    ?>
	               </ul>
          </div>