<?php 
    
    $name = $info[0]->name;
?>
    <div class='paymentdiv'>
        <p class='payablehead'> <span> Amount Payable </span> <i class="fa fa-times closethewin" id="cancelthis"></i>  </p>
            <p class='payablehead'> <small class='smalltxt'> <?php echo $amount; ?> </small> </p>
             <p class='mat_head paymat'> <span> Information </span> </p>
    		<div class='bodydiv paddit paddbot_40'>
    			<div class='row'>
	    			<div class='col-md-12'>
	    				<div class='input_holder'>
	    					<p> Student Name </p>
	    					<span class='substxt'> <?php echo $name; ?> </span>
	    				</div>
	    			</div>
    			</div>
    			<div class='row getmarginbot'>
    				<div class='col-md-6'>
    					<div class='input_holder'>
    						<p> Subscription Plan </p>
    						<span class='substxt'> <?php echo $subtype; ?> </span> <br/>
    					</div>
    				</div>
    				<div class='col-md-6'>
    					<div class='input_holder'>
    						<p> Preferred Mode of Payment </p>
    						<span class='substxt'> BANK-to-BANK <span style='font-weight: normal;'> (B2B) </span> </span>
    					</div>
    				</div>
    			</div>
    			<div class='row getmarginbot'>
    				<div class='col-md-12'>
                        <div class='infobardiv'> 
                            <p> <span> PAYMENT INFORMATION </span> </p>
    					    <hr style='margin: 0px 0px 25px;'/>
                        </div>
    				</div>
    			</div>
    			<div class='row'>
    				<div class='col-md-12'>
    					<div class='input_holder blackenp'>
    						<p> Bank transaction code </p>
    						<input type='text' id='bnktrnscode'/>
    					</div>
    				</div>

    				<div class='col-md-6'>
    					<div class='input_holder blackenp'>
    						<p> Number of months </p>
    						<input type='text' id='numofmonths'/>
    					</div>
    				</div>
    				
    				<div class='col-md-6'>
    					<div class='input_holder blackenp'>
    						<p> Amount </p>
    						<input type='text' id='amount'/>
    					</div>
    				</div>
    			</div>
    		</div>

                <div class='row getmarginbot'>
                    <div class='col-md-12'>
                        <button class='subsbtn' id='procbtn'> PROCEED </button>
                    </div>
                </div>
        </div>