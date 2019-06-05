<?php 
	$_1dplan  = null;
	$_8mplan  = null;
	$_1dpplan = null;
	
	switch($substype) {
		case "1D":
			$_1dplan  = "stdplan selectedplan";
			break;
		case "8M":
			$_8mplan  = "stdplan selectedplan";
			break;
		case "1DP":
			$_1dpplan = "stdplan selectedplan";
			break;
		case false:
			$_1dplan  = "stdplan";
			$_8mplan  = "stdplan";
			$_1dpplan = "stdplan";
			break;
	}
?>
<div class="row getmargin addhorbot <?php echo $_1dplan; ?>" 
	id='_1dstdplan' data-substype='_1d' 
	data-stdid='<?php echo $this->session->userdata("compid"); ?>'>
								<div class="col-md-2 promotext getmargp">
									<p class="promohead getmargp">1D </p>
									<p class='promobel getmargp'> STUDENT PLAN </p>
								</div>
								<div class="col-md-6 getmargp">
									<div class="lessdets">
										<p class="top"> DAILY LESSON PLAN </p>
										<p class='mid'> <strong> You were using some gestures have negative connotations. </strong> </p>
										<p class='bot'> I can listen to and understand talking about gestures. </p>
									</div>
								</div>
								<div class="col-md-2 promotext getmargp">
									<p class="priceheadt getmargp">5,000 </p>
									<p class='priceunit getmargp'> YEN / MONTH </p>
								</div>
								<div class="col-md-2 promotext getmargp buttonbox">
									<?php if ($_1dplan != null): ?>
										<button class='scribe'>SUBCRIBE</button>
									<?php endif; ?>
									<?php if ($_1dplan == null): ?>
										<p> Payment not available </p>
									<?php endif; ?>
								</div>
							</div>

							<div class="row getmargin addhorbot <?php echo $_8mplan; ?>" 
								 id='_8mstdplan' data-substype='_8m' 
								 data-stdid='<?php echo $this->session->userdata("compid"); ?>'>
								<div class="col-md-2 promotext getmargp">
									<p class="promohead getmargp">8M </p>
									<p class='promobel getmargp'> STUDENT PLAN </p>
								</div>
								<div class="col-md-6 getmargp">
									<div class="lessdets">
										<p class="top"> LIMITED MONTHLY PLAN </p>
										<p class='mid'> <strong> You were using some gestures have negative connotations. </strong> </p>
										<p class='bot'> I can listen to and understand talking about gestures. </p>
									</div>
								</div>
								<div class="col-md-2 promotext getmargp">
									<p class="priceheadt getmargp">4,000 </p>
									<p class='priceunit getmargp'> YEN / MONTH </p>
								</div>
								<div class="col-md-2 promotext getmargp buttonbox">
									<?php if ($_8mplan != null): ?>
										<button class='scribe'>SUBCRIBE</button>
									<?php endif; ?>
									<?php if ($_8mplan == null): ?>
										<p> Payment not available </p>
									<?php endif; ?>
								</div>
							</div>

							<div class="row getmargin addhorbot <?php echo $_1dpplan; ?>" 
								 id='_1dpstdplan' data-substype='_1dp' 
								 data-stdid='<?php echo $this->session->userdata("compid"); ?>' >
								<div class="col-md-2 promotext getmargp">
									<p class="promohead getmargp">1D </p>
									<p class='promobel getmargp'> STUDENT PLAN <br/> + COUNSELING</p>
								</div>
								<div class="col-md-6 getmargp">
									<div class="lessdets">
										<p class="top"> DAILY LESSON PLAN + COUNSELING </p>
										<p class='mid'> <strong> You were using some gestures have negative connotations. </strong> </p>
										<p class='bot'> I can listen to and understand talking about gestures. </p>
									</div>
								</div>
								<div class="col-md-2 promotext getmargp">
									<p class="priceheadt getmargp">5,500 </p>
									<p class='priceunit getmargp'> YEN / MONTH </p>
								</div>
								<div class="col-md-2 promotext getmargp buttonbox">
									<?php if ($_1dpplan != null): ?>
										<button class='scribe'>SUBCRIBE</button>
									<?php endif; ?>
									<?php if ($_1dpplan == null): ?>
										<p> Payment not available </p>
									<?php endif; ?>
								</div>
							</div>