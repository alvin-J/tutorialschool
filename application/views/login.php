<!--div id="page-wrapper"-->
	<!--div id="page-inner"-->
		<!-- login page -->
		<div class='logindivbox'>	
			<!--div class='row'-->
				<div class='col-md-7'>
					<div class='divbox'>
						<div class='col-md-3'>
							<div class='imgdiv'>
								<img src='<?php base_url(); ?>images/logoanw.png'/>
							</div>
						</div>
						<div class='col-md-9 rightdetsbox'>
							<p class='compname'> A NEW WORLD </p>
							<p class='compdets'> ONLINE ENGLISH TUTORS </p>
						</div>
					</div>
					<div class='botbox'>
						<div class='col-md-12 paddsides'>
							<p class='regtext'> REGISTER <a href='<?php echo base_url(); ?>teacher/register' class='reglink'/>Register as Teacher</a></p>
							<div class='row getmargbot'>
								<div class="input-field col s12" style='border-bottom: 1px solid #837f7f;'>
								  <i class="material-icons prefix regicon"  style='color:#44474c'>person_pin</i>
								  <input type='text' name='fullname' id="fullnameid" class="validate" required="required" style='color:#333;'/>
								  <!--input id="icon_prefix" class="validate" type="text"-->
								  <label for="icon_prefix" class="thelable">Fullname</label>
								</div>
							</div>
							<div class='row getmargbot'>
								<div class="input-field col s12" style='border-bottom: 1px solid #837f7f;'>
								  <i class="material-icons prefix regicon"  style='color:#44474c'>email</i>
								  <input type='email' name='emailadd' id="eaddid" class="validate" required="required" style='color:#333;'/>
								  <!--input id="icon_prefix" class="validate" type="text"-->
								  <label for="icon_prefix" class="thelable">Email Address</label>
								</div>
							</div>
							<div class='row getmargbot'>
								<div class="input-field col s6" style='border-bottom: 1px solid #837f7f;'>
								  <i class="material-icons prefix regicon"  style='color:#44474c'>vpn_key</i>
								  <input type='password' name='regpword' id="pwordid" class="validate" required="required" style='color:#333;'/>
								  <!--input id="icon_prefix" class="validate" type="text"-->
								  <label for="icon_prefix" class="thelable">Password</label>
								</div>

								<div class="input-field col s6" style='border-bottom: 1px solid #837f7f;'>
								  <i class="material-icons prefix regicon"  style='color:#44474c'>dialer_sip</i>
								  <input type='text' name='skypename' id="skypenameid" class="validate" required="required" style='color:#333;'/>
								  <!--input id="icon_prefix" class="validate" type="text"-->
								  <label for="icon_prefix" class="thelable">Skype Name</label>
								</div>
							</div>

							<div class='row getmargbot margtop'>
								<select class='selectdiv' id='lep'> 
									<option value='0'> LEVEL OF ENGLISH PROFICIENCY: </option>
									<optgroup label='proficiency'>
										<?php
											foreach($drops[0] as $lep) {
												echo "<option value='{$lep->lep_id}'>";
													echo $lep->lep_desc;
												echo "</option>";		
											}
										?>
										<!--option> I can say basic greetings </option>	
										<option> I can make simple sentences </option>
										<option> I can communicate/express my ideas in English </option>
										<option> I can communicate/express my ideas like a native speaker </option-->
									</optgroup>
								</select>
								<select class='selectdiv' id='cp'> 
									<option value='0'> CORRECTION PREFERENCE: </option>
									<optgroup label='proficiency'>
										<?php 
											foreach($drops[1] as $cp) {
												echo "<option value='{$cp->cpchoice_id}'>";
													echo $cp->cp_desc;
												echo "</option>";		
											}
										?>
										<!--option> Correct me proactively </option>	
										<option> Correct me after the lesson </option-->
									</optgroup>
								</select>
								<select class='selectdiv' id='stttp'> 
									<option value='0'> STUDENT-TUTOR TALK TIME/PACE : </option>
									<optgroup label='proficiency'>
										<?php 
											foreach($drops[2] as $st) {
												echo "<option value='{$st->stttp_id}'>";
													echo $st->stttp_desc;
												echo "</option>";
											}
										?>
										<!--option> Please talk slowly </option>	
										<option> Please apply 70%-30% student-tutor talk time ratio </option-->
									</optgroup>
								</select>
							</div>

							<div class='torightconts'>
								<input type='submit' value='REGISTER' name='loginbtn' class='signupbtn' id='registerbtn' data-regtype='1'/>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-5 right_loginbox'>
					<p class='htext'> ALREADY HAVE AN ACCOUNT? </p>
					<form method='post' class='theforms'>
						<div class="input-field">
						  <i class="material-icons prefix"  style='color:#ebeef2'>email</i>
						  <input type='email' name='username' id="email_login" class="validate" required="required"/>
						  <!--input id="icon_prefix" class="validate" type="text"-->
						  <label for="icon_prefix" class="thelable">Email address</label>
						</div>
						
						<div class="input-field">
						  <i class="material-icons prefix" style='color:#ebeef2'>vpn_key</i>
						  <input type='password' name='password' id="icon_prefix" class="validate" required="required" />
						  <!--input id="icon_prefix" class="validate" type="text"-->
						  <label for="icon_prefix" class="thelable">Password</label>
						</div>

						<div class='torightconts'>
							<a href='#' class='fpr' id='forgotpword'>FORGOT PASSWORD? RESET</a>
							<br/>
							<input type='submit' value='Login' name='loginbtn' class='loginbtn'/>
						</div>
					</form>

					<div class='belowdiv'>
						<p class='bd_headtxt'> WANT TO KNOW ABOUT US? </p>
						<p class='bd_content'> We will be happy to talk about it with you. </p>
						<p class='cusn'> CONTACT US NOW </p>
					</div>
				</div>
			<!--/div-->
		</div>
		<!-- end log in page -->
	<!--/div-->
<!--/div-->

<div id='congratulations'>
	<div class='inner-congs'>
		<div class='row'>
			<div class='col-md-12'>
				<img src='<?php echo base_url() ?>images/check_03.png'/> <span class='congtext'> Congratulations! </span>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<p class='msgtext'> You have successfully registered for an account. </p>
			</div>
		</div>
		<hr/>
		<div class='row'>
			<div class='col-md-12'>
				<p class='ftext'> Do you want to schedule for a Free trial lesson? </p>
				<div class='thebtn'>
					<span class='nobtn'> NO </span>
					<!--a href='<?php //echo base_url(); ?>tutors'> <span class='yesbtn'> YES </span></a-->
					<a href='#'> <span class='yesbtn'> YES </span></a>
				</div>
			</div>
			<div class="col-md-12" id='ansno'>
				<p class='ansno'> 
					Thank you! Check your email for the confirmation. Please book a Free trial lesson at your most convenient time. 
				</p>
			</div>
		</div>
		<div class='row margtop'>
			<div class='col-md-12'>
				<p> 
					<span class='arr'> All rights reserved - A New World | Online english Tutor </span>
				</p>
			</div>
		</div>
	</div>
</div>