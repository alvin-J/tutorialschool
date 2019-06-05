<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'/>
<link rel='stylesheet' href='<?php echo base_url(); ?>style/notes.style.css'/>
<div class='innerdiv'>
	<h3 style="font-weight: normal;text-align: center;color: #717171;"> Counselor's Note <i class="fa fa-file" aria-hidden="true" style='float: right;' id='addnew' title="Add New"></i>
 </h3>
	<hr/>
	<p> STUDENT NAME </p>
	<h2> <?php echo $name; ?> </h2>
	<hr/>
	<p> RECOMMENDED LESSON MATERIAL </p>
	<select id='lessmat'>
		<?php
			foreach($mats as $ms) {
				echo "<option value='{$ms->mat_id}'>";
					echo $ms->mat_headtext;
				echo "</option>";
			}
		?>
	</select>
	<hr/>
	<p> COUNSELOR'S NOTE </p>
	<textarea id='notes'></textarea>
	<hr/>
	<button id='savenote' data-stdid = '<?php echo $stdid; ?>'> Save note </button>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
	var baseurl = "<?php echo base_url(); ?>";
</script>
<script src='<?php echo base_url(); ?>procs/fillnotes.procs.js'></script>