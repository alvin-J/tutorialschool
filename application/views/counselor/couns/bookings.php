<ul class='thebookingslist'>
    <?php 
        foreach($bookings as $b) {
    ?>
    			<li data-bl_id = '<?php echo $b->bl_id; ?>'>
    				<table>
    					<tr>
    						<th> Name </th>
    						<td> <?php echo $b->name; ?> </td>
    					</tr>
    					<tr>
    						<th> Purpose </th>
    						<td> <?php echo $b->bookingreason; ?> </td>
    					</tr>
    					<tr>
    						<th> Date </th>
    						<td> 
                                <?php echo date("F d, Y @ h:i A", strtotime($b->date_time)); ?>
                            </td>
    					</tr>
    				</table>
    			</li>
    <?php } ?>
    		</ul>