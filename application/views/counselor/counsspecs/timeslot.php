<?Php 
     if (!isset($time)) {
          $time = [];
     }
?>

<h5 style="text-align: center;"> Available time slots </h5>
      <hr style="margin:5px 5px 13px 5px;" />
      <div class='col-md-4 removepad'>
         <h5 class='mtxt'> MORNING </h5>
               <ul>
                  <?php 
                        $s = strtotime("5:30 AM");
                        $e = strtotime("11:00 AM");

                        while($s <= $e) {
                                 $thetime = date("h:i A",$s);

                                 $date_   = date("Y-m-d");

                                 if ( strtotime($thetime) <= strtotime(date("h:i A")) ) {
                                    array_push($time, $thetime);
                                 }

                                 $sel = (in_array($thetime,$time))?"bookedtime":"btn btn-default timesel remstyle";

                           $s = strtotime( date("h:i A", strtotime("+30 minutes",$s)) );
                              echo "<li class='{$sel}' style='width:100%;' data-time='".$thetime."'>";
                           echo $thetime;
                           echo "</li>";
                        }
                                 
                     ?>
            </ul>
      </div>
      <div class='col-md-4 removepad'>
         <h5 class='mtxt'> AFTERNOON </h5>
               <ul>  
                  <?php 
                     $s = strtotime("11:30 AM");
                     $e = strtotime("5:00 PM");

                     while($s <= $e) {
                              $thetime = date("h:i A",$s);
                              
                              if ( strtotime($thetime) <= strtotime(date("h:i A"))) {
                                    array_push($time, $thetime);
                              }

                              $sel = (in_array($thetime,$time))?"bookedtime":"btn btn-default timesel remstyle";

                        $s = strtotime( date("h:i A", strtotime("+30 minutes",$s)) );
                        echo "<li class='{$sel}' style='width:100%;' data-time='".$thetime."'>";
                                 echo $thetime;
                        echo "</li>";
                     }
                           
                     ?>
               </ul>
      </div>
      <div class='col-md-4 removepad'>
         <h5 class='mtxt'> EVENING </h5>
         <ul>  
               <?php 
                     $ss = strtotime("5:30 PM");
                     $ee = strtotime("11:00 PM");

                     while($ss <= $ee) {
                              $thetime = date("h:i A",$ss);

                              if ( strtotime($thetime) <= strtotime(date("h:i A"))) {
                                 array_push($time, $thetime);
                              }

                              $sel = (in_array($thetime,$time))?"bookedtime":"btn btn-default timesel remstyle";

                        $ss = strtotime( date("h:i A", strtotime("+30 minutes",$ss)) );
                        echo "<li class='{$sel}' style='width:100%;' data-time='".$thetime."'>";
                           echo $thetime;
                        echo "</li>";
                     }
                              
                  ?>
           </ul>
      </div>
      