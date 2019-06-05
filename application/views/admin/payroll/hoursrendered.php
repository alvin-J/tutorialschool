<div class='pheader'> <p> Hours Rendered</p> <hr/> </div>
	<div class='hrstbl'>
		<table>
			<?php 
				if (count($date_) > 0) {
					foreach($date_ as $key => $d) {
						echo "<tr>";
							echo "<td>";
								echo date('F d, Y', strtotime($key)); 
							echo "</td>";
							echo "<td>";
								echo "<table class='smalltable'>";
									foreach($d as $sd) {	
										echo "<tr>";
											echo "<td> {$sd[0]} <i class='material-icons dp48 deletetime' data-bkid='{$sd[1]}'>delete</i></td>";
										echo "</tr>";
									}
								echo "</table>";
							echo "</td>";
						echo "</tr>";
					}
				} else {
					echo "<p style='text-align: center; color: #9e9494; margin: 15px 0px;'> Nothing found on this date </p>";
				}
			?>
			<!--tr>
				<td> October 2, 2xxx </td>
				<td> 8 Hours </td>
			</tr>
			<tr>
				<td> October 2, 2xxx </td>
				<td> 8 Hours </td>
			</tr-->
		</table>
	</div>