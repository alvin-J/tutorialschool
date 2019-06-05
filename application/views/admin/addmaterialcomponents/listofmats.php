<ul class='listofmats'>
	<?php 
		foreach($mats as $ms) {
			echo "<li>";
				echo "<p> {$ms->mat_headtext} </p>";
				echo "<p class='btnlink'>";
					echo "<span class='fa fa-pencil editmathead' data-matid = '{$ms->mat_id}' aria-hidden='true'> Edit </span>";
    				echo "<span class='fa fa-trash-o deletemathead' data-matid = '{$ms->mat_id}' aria-hidden='true'> Delete </span>";
				echo "</p>";
			echo "</li>";
		}
	?>
</ul>