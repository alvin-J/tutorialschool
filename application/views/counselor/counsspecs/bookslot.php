	<div class='col-md-12'>
		<h5> Book a slot <i class="fa fa-times closethewin" id="cancelthis"></i> </h5>
		<select id='month' class='dateselect'>
			<?php 
			/*
		    $thisyear = date("Y");
		    //$start 	  = strtotime("m/d/".$thisyear);
		    $start 	  = strtotime("01/01/".$thisyear);
		    $end   	  = strtotime("12/31/".$thisyear);

		    while($start <= $end) {
		    	echo "<option>";
		    		echo date("F",$start); 
				echo "</option>";
		        
		        $start = strtotime( date("m/d/Y", strtotime("+1 months", $start)) );
		     }
		     */
		     echo "<option>";
		     	echo date("F"); 
		     echo "</option>";
			?>
		</select>
		<select id='day' class='dateselect'>
		    <?Php 
		    	/*
		        for($i=1;$i<=31;$i++) {
		            echo "<option>";
		             	echo $i;
					echo "</option>";
				}
				*/
				echo "<option>";
			     	echo date("d"); 
			    echo "</option>";			
			?>
		</select>
		<select id='year' class='dateselect'>
		   <?php 
		    /*
		        $from = date("Y");
		        $end  = date("Y",strtotime("+2 years"));

		        for($year = $from ; $year <= $end ; $year++) {
		            echo "<option>";
		                echo $year;
		            echo "</option>";
		        } 
		    */
		        echo "<option>";
			     	echo date("Y"); 
			    echo "</option>";
		     ?>
		</select>
	</div>
	<div class='col-md-12'>
		<h5> Purpose of Booking </h5>
		<textarea id='bookingpurpose'></textarea>
	</div>
	
	<div class='col-md-12 timeslotbox' id='timeskeds'>
		
	</div>

	<div class='col-md-12' id='bookmediv'>
		<hr style="margin:5px 5px 13px 5px;"/>
		<button class='btn btn-primary' style='width:100%;' id='bookme'> Book Me </button>
		<hr style="margin:13px 5px 13px 5px;"/>
	</div>