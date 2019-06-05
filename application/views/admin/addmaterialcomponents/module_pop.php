<?php 
	$mattitle = null;
	$matcont  = null;
	$matorder = null;
	$matfiles = null;
	
	$matcount = $mod_count;
	if (isset($modules)) {
		$mattitle = $modules[0]->mat_mod_title;
		$matcont  = $modules[0]->mat_det;
		$matorder = $modules[0]->matmodorder;
		$matfiles = $modules[0]->matfiles;
	}
?>
<p class='mod_masthead'> 
			<span class='masthead_text'> ADD MATERIAL MODULE </span>
</p>
		<div class='mod_content'>
			<div class='row'>
				<div class='col-md-9'>
					<p> Material Title </p>
					<input type='text' class='anwtextinput' id='mattitle' value='<?php echo $mattitle; ?>'/>
				</div>
				<div class='col-md-3'>
					<p> Lesson # </p>
					<select style='display:block; padding: 12px;' class='anwtextinput' id='matorder'>
						<?php 
							for($i = 1; $i <= $matcount+5 ; $i++) {
								$selected = ($i == $matorder)?"selected":null;
								echo "<option {$selected}>";
									echo $i;
								echo "</option>";
							}
						?>
					</select>
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<p> Material Content </p>
					<textarea id='matcontent'><?php echo $matcont; ?></textarea>
				</div>
			</div>
			<div class='row'>
				<div class='col-md-12'>
					<form id='fileinfo' method="post" enctype="multipart/form-data">
						<label for='attcfile' class='btn btn-default btn-xxs'> Attach File </label>
						<p id='output'> 
							<?php 
								if ($matfiles != null) {
									$matfiles = (array) json_decode($matfiles);
									echo "<div id='matfiles'>";
										$count = 0;
										foreach($matfiles as $m) {
											echo "<input type='hidden' value='{$m}' id='matfiles_{$count}'/>";
											$count++;
											// echo "<span class='thefilespan'> <g>".$m."</g> <i class='material-icons dp48 removespan' data-filename='{$m}'>not_interested</i> </span>";
										}
									echo "</div>";
								} else {
									echo "No file(s) chosen";
								}								
							?>
						</p>
						<input type='file' style='display: none;' name='attcfile' id='attcfile'/>
					</form>
				</div>
			</div>
		</div>
		