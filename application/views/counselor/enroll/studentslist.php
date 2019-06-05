<ul class='nameullist' id='nameullist'>
	<?php 
		foreach($students as $st) {
			echo "<li data-stdid = '{$st->studentid}'>";
				echo "<div class='col-md-4 th'>
		    				Name
		    		  </div>
		    		  <div class='col-md-8'>
		    				{$st->name}
		    		  </div>";
			echo "</li>";
		}
	?>
</ul>