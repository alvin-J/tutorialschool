<div id="page-wrapper">
  	<div class="header"> 
		<h4 class="page-header">
			Payment Confirmation
			<p class='booktutor' id='booknow'> 
          		<i class="fa fa-plus-circle bigfa"></i> &nbsp; 
             	<span class='btspan'> BOOK TUTOR </span>
      		</p>
		</h4>								
	</div>
    <div id="page-inner">
    	<?php if ($verified != null && $verified == true): ?>
    		<p class='verifiedtext'> Your payment is verified. Your Subscription is being updated. Please wait... </p>
    		<p id='creditingid' style='margin-top: 8px;'> updating... </p>
		<?php endif; ?>
    </div>
</div>