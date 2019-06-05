<div id="page-wrapper">
  	<div class="header"> 
		<h4 class="page-header">
			Tutors
				<p class='booktutor'> 
                   	<i class="fa fa-plus-circle bigfa"></i> &nbsp; 
                	<span class='btspan'> BOOK TUTOR </span>
                </p>
		</h4>								
	</div>
    <div id="page-inner">
    	<div class='row white paddingbot'>
    		<p class='btutors'> BOOKMARKED TUTORS </p>
	    	<!--div class='row'-->
	    	<span id='bookmarked'>loading...</span>
    	</div>

    	<div class='row white paddingbot'>
    		<p class='btutors'> AVAILABLE TUTORS </p>
    		<?php 
    			if (count($availables) == 0) {
    				echo "<p> No available teachers </p>";
    			}

    			for($i = 0; $i <= count($availables)-1; $i++) {
	    			echo "<div class='col-md-4 teacherdets' data-teacherid = '{$availables[$i]->teacherid}' data-tfname='{$availables[$i]->name}'>";
				    	echo "<div class='row getmargbot'>";
					    	echo "<div class='col-md-3'>";
					    		echo "<img src='".base_url()."images/tutor.png'/>";
					    	echo "</div>";
					    	echo "<div class='col-md-6 padding25'>";
					    		echo "<p> {$availables[$i]->name} </p>";
					    	echo "</div>";
				    	echo "</div>";
				    echo "</div>";
				}
    		?>
    	</div>
    </div>
</div>