<table class='earningstbl'>
	<tr>
		<td class='bigithead'> Earnings </td>
		<td> &nbsp; </td>
		<td class='bigithead'> Amount </td>
		<td> &nbsp; </td>
	</tr>
	<tr>
		<td> Rate per <?php echo $per; ?></td>
		<td> &nbsp; </td>
		<td> &nbsp; </td>
		<td> <?php echo number_format($rate,2); ?> </td>
	</tr>
	<tr>
		<td> Hours Rendered </td>
		<td style='color:#db5d5d;'> <strong> <?php echo $hrend; ?> <?php echo $per; ?>(s) </strong> </td>
		<td> &nbsp; </td>
		<td> <?php echo number_format($total,2); ?> </td>
	</tr>
	<tr>
		<td> Number of Lessons (30 mins interval) </td>
		<td style='color:#db5d5d;'>  <strong> ( <?php echo $numberoflessons; ?> ) </strong> </td>
		<td> &nbsp; </td>
		<td> &nbsp; </td>
	</tr>
	<tr class='totearns'>
		<td class='bigithead'> Total Earnings </td>
		<td> &nbsp; </td>
		<td class='bigithead'> Amount </td>
		<td class='theamount bigithead'> <?php echo number_format($total,2); ?> </td>
	</tr>
</table>

<?php if ($status == "paid"): ?>
	<div class=''>
		<p class='paidtext'> 
			<i class="material-icons dp48" style='margin-bottom: 15px;'>verified_user</i> <br/>
			PAID 
		</p>
	</div>
<?php endif; ?>

<span id='loadingspan'> </span>