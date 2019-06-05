<div class='row'>
    		<div class='col-md-4'>
    			<div class='classdivbox'>
    				<h4 class='sc_head' style='background:#96E2FA;'> MORNING </h4>
    				<ul>
    					<!--li class='noclass'> 7:00 AM - NO CLASS </li-->
                        <?php 
                            // class='hassked' :: to mark it as sked
                            // class='noclass' :: to call click the click event 

                            for($i = 1, $t = 7; $i <= 5 ; $i++, $t++) {
                                for($o = 0 , $m = 0; $o <= 1 ; $o++, $m+=30) {
                                    $thetime = (strlen($t)==1)?"0":"";
                                    $thetime .= $t.":";
                                    $thetime .= ($m==0)?"00":$m;
                                    $thetime .= " AM";

                                    $hassked = null;
                                    $noclass = null;

                                    if (in_array($thetime, $time)){
                                        $hassked = "hassked";
                                    } else {
                                        $noclass = "noclass";
                                    }

                                    $refdate = $thedate." ".$thetime;

                                    $passdate = null;
                                    if (strtotime($today) >= strtotime($refdate)) {
                                      // $hassked  = null;
                                        $noclass  = null;
                                        $passdate = "passdate";
										
										if ($hassked != null) {
											$hassked = "haspassedsked";
										}
                                    }
                                    echo "<li class='{$hassked} {$noclass} {$passdate}' data-thedate='{$refdate}'>";
                                        echo $thetime;
                                    echo "</li>";
                                }
                            }

                        ?>
                        
    				</ul>
	    		</div>
    		</div>
    		<div class='col-md-4'>
    			<div class='classdivbox'>
    				<h4 class='sc_head' style='background:#FDB211;'> AFTERNOON </h4>
    				<ul>
    					<?php 
                            
                            // for twelve
                                for($o = 0 , $m = 0; $o <= 1 ; $o++, $m+=30) {
                                       $thetime = "12:";
                                        $thetime .= ($m==0)?"00":$m;
                                        $thetime .= " PM";

                                        $hassked = null;
                                        $noclass = null;

                                        if (in_array($thetime, $time)){
                                            $hassked = "hassked";
                                        } else {
                                            $noclass = "noclass";
                                        }

                                        $refdate = $thedate." ".$thetime;
                                        $passdate = null;
                                        if (strtotime($today) >= strtotime($refdate)) {
                                         //   $hassked  = null;
                                            $noclass  = null;
                                            $passdate = "passdate";
											
											if ($hassked != null) {
												$hassked = "haspassedsked";
											}
                                        }

                                        echo "<li class='{$hassked} {$noclass} {$passdate}' data-thedate='{$refdate}'>";
                                            echo $thetime;
                                        echo "</li>";
                                }
                            // for twelve

                            for($i = 1, $t = 1; $i <= 5 ; $i++, $t++) {
                                for($o = 0 , $m = 0; $o <= 1 ; $o++, $m+=30) {
                                    $thetime = (strlen($t)==1)?"0":"";
                                    $thetime .= $t.":";
                                    $thetime .= ($m==0)?"00":$m;
                                    $thetime .= " PM";

                                    $hassked = null;
                                    $noclass = null;

                                    if (in_array($thetime, $time)){
                                        $hassked = "hassked";
                                    } else {
                                        $noclass = "noclass";
                                    }

                                     $refdate = $thedate." ".$thetime;
                                        $passdate = null;
                                        if (strtotime($today) >= strtotime($refdate)) {
                                            // $hassked  = null;
                                            $noclass  = null;
                                            $passdate = "passdate";
											
											if ($hassked != null) {
												$hassked = "haspassedsked";
											}
                                        }

                                    echo "<li class='{$hassked} {$noclass} {$passdate}' data-thedate='{$refdate}'>";
                                        echo $thetime;
                                    echo "</li>";
                                }
                            }
                        ?>
    				</ul>
    			</div>
    		</div>
    		<div class='col-md-4'>
    			<div class='classdivbox'>
    				<h4 class='sc_head' style='background:#FFC7C8;'> EVENING </h4>
    				<ul>
    					<?php 

                            for($i = 1, $t = 6; $i <= 6 ; $i++, $t++) {
                                for($o = 0 , $m = 0; $o <= 1 ; $o++, $m+=30) {
                                    $thetime = (strlen($t)==1)?"0":"";
                                    $thetime .= $t.":";
                                    $thetime .= ($m==0)?"00":$m;
                                    $thetime .= " PM";

                                    $hassked = null;
                                    $noclass = null;

                                    if (in_array($thetime, $time)){
                                        $hassked = "hassked";
                                    } else {
                                        $noclass = "noclass";
                                    }

                                    $refdate  = $thedate." ".$thetime;
                                    $passdate = null;
                                        if (strtotime($today) >= strtotime($refdate)) {
                                          //  $hassked  = null;
                                            $noclass  = null;
                                            $passdate = "passdate";
											
											if ($hassked != null) {
												$hassked = "haspassedsked";
											}
                                        }

                                    echo "<li class='{$hassked} {$noclass} {$passdate}' data-thedate='{$refdate}'>";
                                        echo $thetime;
                                    echo "</li>";
                                }
                            }
                        ?>
    				</ul>
    			</div>
    		</div>
    	</div>