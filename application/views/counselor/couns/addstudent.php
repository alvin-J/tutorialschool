<div id="newstudent">
	<h4> New Student </h4>
	<hr/>
	<div style='clear:both;'></div>
	
	<div class='col-md-12'>
		<div class='row'>
			<div class='col-md-2 alignright'>
				<p> Full Name </p>
			</div>
			<div class='col-md-10'>
				<input type='text' id='fname'/>
			</div>
		</div>
	</div>

	<div class='col-md-12'>
		<div class='row'>
			<div class='col-md-2 alignright'>
				<p> Email </p>
			</div>
			<div class='col-md-10'>
				<input type='email' id='emailtxt'/>
			</div>
		</div>
	</div>

	<div class='col-md-12'>
		<div class='row'>
			<div class='col-md-2 alignright'>
				<p> Password </p>
			</div>
			<div class='col-md-10'>
				<input type='password' id='pwd'/>
			</div>
		</div>
	</div>

	<div class='col-md-12'>
		<hr style='border-color: #d5d5d5;'/>
	</div>

	<div class='col-md-12'>
		<select class="selectdiv" id="lep"> 
			<option value="0"> LEVEL OF ENGLISH PROFICIENCY: </option>
			<optgroup label="proficiency">
				<option value="1">I can say basic greetings</option>
				<option value="2">I can make simple sentences</option>
				<option value="3">I can communicate/express my ideas in english</option>
				<option value="4">I can communicate/express my ideas like a native speaker</option>									
			</optgroup>
		</select>
	</div>

	<div class='col-md-12'>
		<select class="selectdiv" id="cp"> 
			<option value="0"> CORRECTION PREFERENCE: </option>
			<optgroup label="proficiency">
				<option value="1">Correct me proactively</option>
				<option value="2">correct me after the lesson</option>
			</optgroup>
		</select>
	</div>

	<div class='col-md-12'>
		<select class="selectdiv" id="stttp"> 
			<option value="0"> STUDENT-TUTOR TALK TIME/PACE : </option>
			<optgroup label="proficiency">
				<option value="1">please talk slowly</option>
				<option value="2">Please apply 70%-30% student-tutor talk time ratio</option>
			</optgroup>
		</select>
	</div>

	<div class='col-md-12'>
		<hr class='addmargtop' style='border-color: #d5d5d5;'/>
	</div>

	<div class='col-md-12 addstudentdiv'>
		<button class='btn btn-primary' id='addstudentnow'> Add Student </button>
	</div>
</div>
