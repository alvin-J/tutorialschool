<div class='stddets' id='stddets'>
	<p class='stdname'> <?php echo $data[0]->name; ?> <i class="fa fa-times closethewin" id="cancelthis"></i> </p>
	<div class='bodydiv'>
		<p class='stdheader'> Comment's last session </p>
		<p class='tcomment'> 
				<strong> Teacher's Feedback: </strong> <br/>
			<?php
				foreach($data as $d) {
					echo "<p>";
						echo $d->feedback;
					echo "</p>";
				}
				echo "<hr/>";
				echo "<strong> Counselor's Feedback: </strong> <br/>";
				foreach($data as $dd) {
					echo "<p>";
						echo $dd->couns_note;
					echo "</p>";
				}
			?>
		</p>
	</div>
	<div class='btndiv'>
		<button id='declinebtn'> DECLINE </button>
	</div>
</div>