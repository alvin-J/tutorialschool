<div id="page-wrapper">
    <div class="header"> 
        <div class='row getmarginbot'>
            <div class='col-md-12'>
                <h4 class="page-header"> SELECT COUNSELOR </h4>
            </div>
        </div>
    </div>
    <div id="page-inner">
        <div class="">
            <div class='row getmarginbot'>
                <div class='col-md-12 '>
                	<div class='row '>

                		<?php 
                			foreach($counselors as $c) {
                			// for($i = 5; $i >= 0 ; $i--): ?>
	                		<div class='col-md-2 counslist' data-cid = '<?php echo $c->counselorid; ?>'>
	                			<table>
		                				<tr>
		                					<th> Counselor: </th>
		                					<td> <?php echo $c->name; ?> </td>
		                				</tr>
		                				<tr>
		                					<th> Attendance: </th>
		                					<td> <span> PRESENT </span> </td>
		                				</tr>
		                		</table>
	                		</div>
	                	<?php } ?>
	                </div>
	                <!--div class='row'>
                		<button class='btn btn-primary' id='bookme'> Book Me </button>
                	</div-->
               	</div>
               	<!--div class="col-md-6">
               		<div class='timescheds' id='timeskeds'> <p> Loading... please wait. </p>	</div>
               	</div-->
            </div>
        </div>
    </div>
</div>