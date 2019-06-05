<?php 
	    			if (count($bookmarks) == 0) {
	    				echo "<p class='nobookmarked'> No bookmarked tutors </p>";
	    			}
	    			foreach($bookmarks as $bm) {
	    				$spancolor = null;
	    				$status    = null;
	    				switch($bm->availability) {
	    					case 0: $spancolor = "grey"; $status = 'DAY OFF'; break;
	    					case 1: $spancolor = "green"; $status = 'ACTIVE'; break;
	    					case 2: $spancolor = "red"; $status = 'FULL'; break;
	    				}
// <div class="col-md-4 teacherdets" data-teacherid="1" data-tfname="alvin sample">
	    				echo "<div class='col-md-4 borderdiv teacherdets' data-teacherid='{$bm->teacherid}' data-tfname='{$bm->name}'>";
		    				echo "<div class='rowwrap'>";
								echo "<div class='row'>";
									echo "<div class='col-md-4'>";
										echo "<img src='".base_url()."images/tutor.png'/>";
									echo "</div>";
									echo "<div class='col-md-8'>";
											echo "<p class='tutorfname'> {$bm->name} </p>";
											echo "<span class='spanstatus {$spancolor}'> STATUS: {$status} </span>";
									echo "</div>";
								echo "</div>";

								echo "<div class='row'>";
									echo "<div class='col-md-12 tutsdets'>";
										echo "<p> Age: {$bm->age}'s </p>";
											echo "<p> Teaching history: {$bm->exp} </p>";
											echo "<p> {$bm->dept} </p>";
										echo "</div>";
									echo "</div>";
								echo "</div>";
	    				echo "</div>";
	    			}
	    		?>