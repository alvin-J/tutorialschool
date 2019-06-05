<ul class='modlist'>
	<?php 
		if (count($mods) >= 1) {
			foreach($mods as $m) {
				echo "<li>";
					echo "<p> {$m->mat_mod_title} </p>";
					    echo "<p class='btnlink'>";
							echo "<span class='fa fa-pencil editmodule' data-modid = '{$m->mat_det_id}' aria-hidden='true'> Edit </span>";
							echo "<span class='fa fa-trash-o deletemodule' data-modid = '{$m->mat_det_id}' aria-hidden='true'> Delete </span>";
					    echo "</p>";
				echo "</li>";
			}
		} else {
			echo "<p style='text-align: center;color: #9b9b9b;'> No modules added yet </p>";
		}
	?>
</ul>