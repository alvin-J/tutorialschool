<?php 
	$name  = null;
	$email = null;
	$skype = null;
	$pwd   = null;
	$exp   = null;
	
	$q1    = null;
	$q2    = null;
	if (isset($def)) {
		$name  = $def['name'];
		$email = $def['email'];
		$skype = $def['skype'];
		$pwd   = $def['password'];
		$exp   = $def['yearsofexp'];
		
		$q1    = $def['q1'];
		$q2    = $def['q2'];
	}
?>
<div class='regcenter'>
	<div class='row'>
		<form method='post' name='regteacher'>
			<div class='col-md-6 centerdiv'>
				<h4> Register as Teacher </h4>
				<hr/>
				<div class='personalinformation'>
					<p> Personal Information </p>

						<div class="input-field col s12 regdiv">
							<i class="material-icons prefix regicon"  style='color:#44474c'>person_pin</i>
								 <input type='text' name='fullname' id="fullnameid" class="validate" required="required" style='color:#333;' value='<?php echo $name; ?>'/>
							<label for="icon_prefix" class="thelable">Fullname</label>
						</div>

						<div class="input-field col s6 regdiv">
							<i class="material-icons prefix regicon"  style='color:#44474c'>email</i>
								 <input type='email' name='email' id="fullnameid" class="validate" required="required" style='color:#333;' value='<?php echo $email; ?>'/>
							<label for="icon_prefix" class="thelable">Email Address</label>
						</div>
						<div class="input-field col s6 regdiv">
							<i class="material-icons prefix regicon"  style='color:#44474c'>dialer_sip</i>
								 <input type='text' name='skype' id="fullnameid" class="validate" required="required" style='color:#333;' value='<?php echo $skype; ?>'/>
							<label for="icon_prefix" class="thelable">Skype</label>
						</div>
						<div class="input-field col s6 regdiv">
							<i class="material-icons prefix regicon"  style='color:#44474c'>vpn_key</i>
								 <input type='password' name='password' id="fullnameid" class="validate" required="required" style='color:#333;' value='<?php echo $pwd; ?>'/>
							<label for="icon_prefix" class="thelable">Password</label>
						</div>
						<div class="input-field col s6 regdiv">
							<i class="material-icons prefix regicon"  style='color:#44474c'>person_pin</i>
								 <input type='text' name='yearsofexp' id="fullnameid" class="validate" required="required" style='color:#333;' value='<?php echo $exp; ?>'/>
							<label for="icon_prefix" class="thelable">Years of experience</label>
						</div>
				</div> 
				<div class='examproper'> 
					<p> Pre-evaluation Test </p>
					<hr/>
					<div class='col-md-12 qdivs'>
						<p> 1. Lorem Ipsum Dolor set amit consectitur </p>
						<textarea name='q1'><?php echo $q1; ?></textarea>
					</div>

					<div class='col-md-12 qdivs'>
						<p> 2. Lorem Ipsum Dolor set amit consectitur </p>
						<textarea name='q2'><?php echo $q2; ?></textarea>
					</div>

					<div class='col-md-12 qdivs'>
						<input type='submit' value='Register' class='regteachbtn' name='regmenow'/>
					</div>
				</div>
			</div>	
		</form>
	</div>
</div>