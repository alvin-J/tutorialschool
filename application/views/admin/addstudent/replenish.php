<?php 
    $transactiondetail = null;
    $dateofinput       = null;
    $substype          = null;

    $show              = false;

    // ===== 
        $payid         = null;
        $prevval       = date("Y-m-d",strtotime("+1 days", strtotime($info[0]->periodEnd)));
    // =====

    $disabled          = null;
    if ($info[0]->status == 0) {

        $transactiondetail = $info[0]->paymentDetails;
        $dateofinput       = $info[0]->inputDate;
        $substype          = $info[0]->subscriptionType;
		$numofmos 		   = (strlen($info[0]->numofmos)==0)?"N/A":$info[0]->numofmos;
		$amount 		   = $info[0]->amount;
		
        $payid             = $info[0]->p_inc_id;
       
        $show              = true;
        $disabled          = "disabled";
    }
?>

<div class='replenishdiv'>
    <div class='' style='overflow: hidden;'>
        <div class='col-md-5 pinkit roundleft paddtopbot addheight'>
            <div class='input_holder'>
                <p> Payment from </p>
                <h3> <?php echo $info[0]->name; ?> </h3>
            </div>
            <hr/>
            <div class='input_holder'>
                <p> Mode of Payment </p>
                <h4> Bank-to-Bank (b2b) </h4>
            </div>
            <hr/>
            <div class='input_holder'>
                <p> Last top-up </p>
                <h4> <?php echo date("M. d, Y D", strtotime($info[0]->inputDate)); ?> </h4>
            </div>
            <hr/>
            <div class='input_holder'>
                <p> Coverage </p>
                <h4 style='margin-bottom: 12px;'> <?php echo date("M. d, Y D", strtotime($info[0]->periodStart)); ?> - <?php echo date("M. d, Y D", strtotime($info[0]->periodEnd)); ?> </h4>
                <p><?php echo $validity; ?></p>
            </div>
            <hr/>
             <div class='input_holder'>
                <p> Validity of this subscription until </p>
                <h4> <?php echo date("M. d, Y D", strtotime($info[0]->periodEnd)); ?>  </h4>
            </div>
        </div>

        <?php if ($isvalid == "invalid"): ?>
            <div class='col-md-7 rightdivps'>
                <div class='underline'>
                    <div class='col-md-6'>
                        <img src='<?php echo base_url() ?>images/logoanw.png'/>
                    </div>
                    <div class='col-md-6'>
                        <p class='thedatetoday'> <?php echo date("M. d, Y h:i A"); ?> </p>
                    </div>
                </div>
                 <div class='paddtopbot_small borderbotdash overflowhid'>
                    <div class='col-md-6'>
                        <div class='input_holder'>
                            <p> Current subcription status </p>
                            <div class='dasheddiv'>
                                <hr/> <span>  <?php echo $validity; ?> </span>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='input_holder'>
                            <p> Top-up's Current Status </p>
                            <div class='dasheddiv'>
                                <hr/> 
                                <?php if($show): ?>
                                    <span class='untop'> UNUSED TOP-UP </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='paddtopbot_small overflowhid'>
                    <div class='col-md-12'>
                        <div class='input_holder'>
                            <p> Date of Input </p>
                            <div class='dasheddiv'>
                                <hr/> 
                                <?php if ($show): ?>
                                    <span class='timedatespan'> 
                                        <?php echo date("M. d, Y @ h:i A", strtotime($dateofinput)); ?> 
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='paddtopbot_small overflowhid'>
                    <?php if ($show): ?>
                    <div class='col-md-4'>
                        <div class='input_holder colorh'>
                            <p> Subscription Type </p>
                            <h4> <?php echo $substype; ?> </h4>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='input_holder colorh'>
                            <p> Number of Months </p>
                            <h4> 
                                <div id='staticinput'>
                                    <g id='numofmostext'> <?php echo $numofmos; ?> </g>
                                    <span id='changemonth'> <i class="material-icons dp48">mode_edit</i> change </span> 
                                </div>
                                <div id='editinput' class='displaynone'>
                                    <input type='text' id='numofmos_change' value='<?php echo $numofmos; ?>' style='margin-bottom: 5px;'/>
                                    <span id='savemosbtn'
    									  style='margin-left: 0px;'
    									  data-payid = '<?php echo $payid; ?>'> 
    										<i class="fa fa-floppy-o" aria-hidden="true"></i> save
    								</span>
    								<span style='margin-left: 0px;'> | </span>
    								<span id='closemosbtn'
    									  style='margin-left: 0px;'
    									  data-payid = '<?php echo $payid; ?>'> 
    										<i class="fa fa-times" aria-hidden="true"></i> close 
    								</span>
                                </div>
                            </h4>
                        </div>
                    </div> 
                    <div class='col-md-4'>
                        <div class='input_holder colorh'>
                            <p> Amount </p>
                            <h4> <?php echo number_format($amount,2); ?>  </h4>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div class='paddtopbot_small overflowhid borderbotdash'>
                    <div class='col-md-12'>
                        <div class='input_holder colorh'>
                            <p> Transaction Number </p>
                            <h4> <?php echo $transactiondetail; ?> </h4>
                        </div>
                    </div>
                </div>
                <div class='paddtopbot_small overflowhid'>
                    <div class='col-md-6'>
                        <p> Please verify the transaction number carefully before proceeding </p>
                    </div>
                    <div class='col-md-6'>
                        <button class='modalbtn' id="repbtn" 
                                data-payid = '<?php echo $payid; ?>'
                                data-prevval = '<?php echo $prevval; ?>'
                                > Approve </button> 
                        <!--button class='modalbtn'> Approve </button-->
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div> 

<style>
	.showmessage{
		background: #fff;
		position: fixed;
		z-index: 100000000000;
		width: 100%;
		top: 0px;
		text-align: center;
		padding: 20px;
		box-shadow: 0px 2px 4px #545454;
		font-size: 16px;
	}
</style>