<div class='row'>
    		<div class="col-xs-12">
		    	<div class='datepaginator'>
		    		<i class="fa fa-caret-left datenav" id='previousdate'></i>
			    		<ul id='thedates'>
                            <?php 
                                foreach($period as $p => $value) {
                                    $selected = null;
                                    if ($value->format("Y-m-d") == date("Y-m-d")) {
                                        $selected = "selecteddate";
                                    }

                                    echo "<li class='{$selected} datelist' 
                                                data-thedate='{$value->format("Y-m-d")}'>";
                                        echo "<p class='monthcap'> ".$value->format("F")." </p>";
                                        echo "<p class='monthdate'> ".$value->format("d")." </p>";
                                    echo "</li>";
                                }
                            ?>
			    		</ul>
			    	<i class="fa fa-caret-right datenav" id='nextdate'></i>
		    	</div>
	    	</div>
    	</div>

    	