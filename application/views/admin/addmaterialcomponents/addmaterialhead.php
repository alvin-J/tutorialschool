<?php 
    $mathead   = null;
    $matlvl    = null;
    $matcap    = null;
    $matcol    = null;
    $matorder  = null;
    $matcnt   = $matcount;

    if (isset($mats)) {
        $mathead  = $mats[0]->mat_headtext;
        $matlvl   = $mats[0]->matlvl;
        $matcap   = $mats[0]->matcapt;
        $matcol   = $mats[0]->matcol;
        $matorder = $mats[0]->matorder;
    }
?>
<p class='mat_head'> <span> Add Material </span> </p>
    				<div class='bodydiv paddit'>
    					<div class='input_holder'>
    						<p> Material Header Title </p>
    						<input type='text' class='inputtext' id='matheadtxt' value='<?php echo $mathead; ?>'/>
    					</div>
    					<div class='input_holder'>
    						<div class='row_'>
    							<div class='col-md-2 borderit'>
    								<p> Level </p>
    								<input type='text' class='noborder' id='matlvl' value='<?php echo $matlvl; ?>'/>		
    							</div>
    							<div class='col-md-5 borderit'>
    								<p> Level Caption </p>
    								<input type='text' class='noborder' id='matcapt' value='<?php echo $matcap; ?>'/>
    							</div>
    							<div class='col-md-3 borderit'>
    								<p> Color </p>
    								<select class='smallselect' id='matcol'>
                                        <?php
                                            $colors = ["Blue","Green","Red","pink","violet","yellow"];
                                            
                                            foreach($colors as $c) {
                                                $selected = ( strtolower($c) == strtolower($matcol))?"selected":null;
                                                echo "<option {$selected}>";
                                                    echo $c;
                                                echo "</option>";
                                            }
                                        ?>  
    								</select>
    							</div>
    							<div class='col-md-2 borderit'>
    								<p> Order </p>
    								<select class='smallselect' id='matorder'>
    									<?php
                                            for($i=1;$i<=$matcnt+5;$i++) {
                                                $selected = ( $i == $matorder )?"selected":null;
                                                echo "<option {$selected}>";
                                                    echo $i;
                                                echo "</option>";
                                            }
                                        ?>
    								</select>
    							</div>
    						</div>
    					</div>
    					<div class='row marginz'>
    						<div class='col-md-8'>
    							<button class='savebutton' id='savebtn'> Save </button>
    						</div>
    						<div class='col-md-4'>
                                <span id='allowaddmod'>
                                    <?php 
                                        if ($allow != null && $allow == true) {
                                            echo "<p class='addmod' id='openmod'> + Add Modules </p>";
                                        }
                                    ?>
                                    <!--p class='addmod' id='openmod'> + Add Modules </p-->
                                </span>
    						</div>
    					</div>
    				</div>