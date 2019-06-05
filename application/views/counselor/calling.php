<style>
	.someonecalling {
		position: fixed;
		width: 100%;
		background: #060606b3;
		padding: 9px;
		z-index: 1000000;
		top: 0px;
		height: 100%;
	}

	.inside_sc {
		width: 27em;
		margin: auto;
		background: #ea5f5f;
		position: relative;
		top: 19px;
		/*padding: 11px;*/
		border-radius: 3px;
		box-shadow: 0px 3px 5px #333;
	}

	.callhead {
		padding: 3px 8px;
		font-size: 16px;
		border-bottom: 1px solid #cfcfcf;
		color: #fff;
		text-align: right;
	}

	.callername {
		font-size: 19px;
		color: #fff;
	}

	.smalldet {
		font-size: 12px;
		color: #c9c5c5;
	}

	.acceptdiv {
		background: #20c38f;
		color: #382d2d;
	}

	.declinediv {
		background: #4e4d4d;
		color: #fff;
	}

	.acceptdiv p, 
	.declinediv p {
		margin: 0px;
		text-align: center;
		padding: 9px;
	}

	.callicon {
		margin: 6px;
		font-size: 42px;
		color: #fff;
	}

	.acceptdiv:hover {
		background: #2defb1;
		cursor: pointer;
	}

	.declinediv:hover {
		background: #6f6f6f;
		cursor: pointer;
	}
</style>
<div class='someonecalling'>
	<div class='inside_sc'>
	    <p class='callhead getborder'> Incoming call... </p>
	    <div class='row getmargin getborder'>
	    	<div class='col-md-2'>
	    		<p class='callicon'> <i class="fa fa-phone" aria-hidden="true"></i> </p>
	    	</div>
	    	<div class='col-md-10'>
	    		<p class='callername getmargin'> Counselor </p>
	    		<p class='smalldet'> A New World English registered Counselor </p>
	    	</div>
	    </div>
	    <div class='showindow'>
	    	<div class='col-md-7 acceptdiv' data-crid = '<?php echo $crid; ?>'>
	    		<p class="" style="width: 100%;"> Accept Call </p>
	    	</div>
	    	<div class='col-md-5 declinediv'>
	    		<p class="" style="width: 100%;"> Reject Call </p>
	    	</div>
		</div>
	</div>
  </div>


