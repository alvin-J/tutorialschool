<div id="page-wrapper">
    <div class="header"> 
        <div class='row getmarginbot'>
            <div class='col-md-12'>
                <h4 class="page-header"> PAYSLIP </h4>
            </div>
        </div>
    </div>
    <div id="page-inner">
    	<div class="row">
    		<div class='col-md-6'>
    			<div class='card'>
    				<div class='card-action'> List of Payslip </div>
    				<div class='card-content'>
    					<?php if (count($data)!=0): ?>
	    					<ul class='paysliplist' id='pslipul'>
	    						<?php for($a=0;$a<=count($data)-1;$a++):  ?>
		    						<li data-tid='<?php echo $data[$a]->tid; ?>' data-period = '<?php echo date("Y-m-d", strtotime($data[$a]->ppdatestart))."_".date("Y-m-d", strtotime($data[$a]->ppdateend)); ?>'>
		    							<h3> Payroll Period: <strong> 
		    								<?php 
		    									echo date("M. d", strtotime($data[$a]->ppdatestart)); 
		    									if ( date("Y",strtotime($data[$a]->ppdatestart)) != date("Y",strtotime($data[$a]->ppdateend)) ) {
		    										echo date("Y",strtotime($data[$a]->ppdatestart));
		    									}
		    									echo " - ";
		    									echo date("M. d, Y", strtotime($data[$a]->ppdateend));
											?> </strong> </h3>
		    							<p> Status: <strong> 
		    								<?php 
		    									if($data[$a]->status == 1) {
		    										echo "PAID";
		    									} else if ($data[$a]->status == 0) {
		    										echo "UNPAID";
		    									}
		    								?> </strong> </p>
		    						</li>
	    						<?php endfor; ?>
	    					</ul>
    					<?php endif; ?>
    				</div>
    			</div>
    		</div>
    		<div class='col-md-6'>
    			<div class='card'>
    				<div class='card-content'>
    					<p style='border-bottom: 1px solid #ccc; padding: 7px 4px;'> Details </p>
                        <span id='theearnings'> 
                            <p style='margin: 0px; text-align: center; padding: 30px;'> ---- click the payslip ---- </p>
                        </span>
    				</div>
    			</div>
    		</div>
    	</div>
   	</div>
</div>

