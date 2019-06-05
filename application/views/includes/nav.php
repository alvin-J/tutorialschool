
     <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle waves-effect waves-dark" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand waves-effect waves-dark" href="<?php echo base_url(); ?>"> 
                    <strong>
                        <div class='logohold'>
                            <img src='<?php echo base_url(); ?>images/logoanw.png'/>
                            <div class='logotext'>
                                <p class='thecompname'> A New World </p>
                                <p class='thecompdet'> ONLINE ENGLISH TUTOR </p>
                            </div>
                        </div>
                    </strong>
                </a>
				
		<div id="sideNav" href=""><i class="material-icons dp48">toc</i></div>
            </div>

            <ul class="nav navbar-top-links navbar-right"> 
				<!--li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown4"><i class="fa fa-envelope fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li-->				
				<!--li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown2"><i class="fa fa-bell fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li-->
				  <li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown1"><i class="fa fa-user fa-fw"></i> <b><?php echo strtoupper($this->session->userdata("fullname")); ?></b> <i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </nav>
		<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
<!--li><a href="#"><i class="fa fa-user fa-fw"></i> My Profile</a>
</li-->
<!--li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
</li--> 
<li><a href="<?php echo base_url(); ?>/logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
</li>
</ul>

	   <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <!-- active-menu -->
                    <li>
                        <a class="<?php echo ($title == "- Student")?"active-menu":""; ?> waves-effect waves-dark" href="<?php echo base_url(); ?>">DASHBOARD </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()."schedule" ?>" class="<?php echo ($title == "- Schedule")?"active-menu":""; ?> waves-effect waves-dark"> SCHEDULE</a>
                    </li>
					<li>
                        <a href="<?php echo base_url(); ?>tutors" class="<?php echo ($title == "- Tutors")?"active-menu":""; ?> waves-effect waves-dark">
 TUTORS</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>payment" class="<?php echo ($title == "- Payment")?"active-menu":""; ?> waves-effect waves-dark"> PAYMENTS </a>
                    </li>
                    <li>
                       <a href="<?php echo base_url(); ?>counselor/student" class="<?php echo ($title == "- Counselor")?"active-menu":""; ?> waves-effect waves-dark"> COUNSELOR </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url(); ?>materials" class="<?php echo ($title == "- Materials")?"active-menu":""; ?> waves-effect waves-dark"> MATERIALS </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>contact" class="<?php echo ($title == "- Contact Us")?"active-menu":""; ?> waves-effect waves-dark"> CONTACT US </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>report" class="<?php echo ($title == "- Trouble Report")?"active-menu":""; ?> waves-effect waves-dark"> TROUBLE REPORT </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url(); ?>classroom/waiting" class="<?php echo ($title == "- Classroom")?"active-menu":""; ?> waves-effect waves-dark"> CLASSROOM </a>
                    </li>


                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->