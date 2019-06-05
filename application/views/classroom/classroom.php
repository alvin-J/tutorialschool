<?php // $this->load->view("includes/header"); ?>
 <script src="<?php echo base_url(); ?>assets/js/jquery-1.10.2.js"></script>
 <script src="https://static.opentok.com/v2/js/opentok.min.js"></script> 
 <script src='<?php echo base_url(); ?>procs/classroom.procs.js'></script>

 <link rel='stylesheet' href='<?php echo base_url(); ?>style/classroom.style.css'/>
 <link rel='stylesheet' href='<?php echo base_url(); ?>style/admin/materials.style.css'/>

 <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" rel="stylesheet" />
 <link href="<?php echo base_url(); ?>assets/css/font-awesome.css" rel="stylesheet" />

 <script>
 	var baseurl = "<?php echo base_url(); ?>";
 	var cid     = "<?php echo $cid; ?>";
 </script>
    <style>
       body, html {
			background-color: gray;
			height: 100%;
			margin: 0px;
		}
		#videos {
			position: relative;
			width: 70%;
			height: 100%;
			float: left;
		}
		#subscriber {
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			margin-left: 50px;
			z-index: 10;
		}
		#publisher {
			position: absolute;
			width: 360px;
			height: 240px;
			bottom: 10px;
			left: 10px;
			z-index: 100;
			border: 3px solid white;
			border-radius: 3px;
		}
		#textchat {
			position: relative;
			width: 20%;
			float: right;
			right: 0;
			height: 100%;
			background-color: #333;
		}
		#history {
			 width: 100%;
			 height: calc(100% - 40px);
			 overflow: auto;
			 padding-top: 10px;
			 padding-bottom: 10px;
		}
		input#msgTxt {
					height: 40px;
					position: absolute;
					bottom: 0;
					width: 100%;
		}
		#history .mine {
			color: #6F6E6E;
			text-align: right;
			background: #e9e9e9;
			float: right;
			clear:both;
			padding: 5px 22px;
			font-size: 15px;
			margin: 0px 4px 5px 0px;
			border-radius: 99px 0px 99px 99px;
		}
		#history .theirs {
			color: #FFF;
			background: #de556d;
			padding: 5px 22px;
			float: left;
			clear:both;
			font-size: 15px;
			margin: 0px 0px 5px 0px;
			border-radius: 0px 99px 99px;
			margin-left: 3px;
		}
		
		#timer{
			float: left;
			background: #de556d;	
			position: relative;
			z-index: 1000;
			width: 195px;
		}
		
		#timer table {
			color: #fff;
		}
		
		#timer table tr {
			
		}
		
		#timer table tr td{
			font-size: 11px;
			padding: 5px;
		}
 
		.clearboth {
			clear:both;
		}
		
		.timerstatus {
			margin: auto;
			font-size: 11px;
			text-align: center;
			background: #f5b3b3;
			padding: 9px;
			text-transform: uppercase;
			color: #801d1d;
			line-height: 18px;
		}
    </style>

    <div id="videos">
        <div id="subscriber"></div>
        <div id="publisher"></div>
		<div id="timer">
			<table>
				<tr>
					<td style='width:95px; font-size:17px;'> Timer: </td>
					<td> HH </td>
					<td> MM </td>
					<td> SS </td>
				</tr>
				<tr>
					<td colspan=4 style='text-align: right; font-size: 25px; font-weight: bold;' id='timerid'> 00:00:00 </td>
				</tr>
			</table>
			<p class='timerstatus'> Timer will start when both the student and teacher are on the same room. </p>

		<?php if ($usertype == 2): //  ?>
			<p style='text-align:center; margin: 0px; padding: 10px 0px;'> 
				<button id='showperledger' class='btn btn-default'> Performance Ledger </button>
			</p>
		<?php endif; ?>
		</div>
    </div>
	
	<div id="textchat">
         <div id="history"></div>
         <form>
            <input type="text" placeholder="Your message here" id="msgTxt"></input>
         </form>
    </div>
	

    <script>
//  https://tokbox.com/developer/tutorials/web/basic-video-chat/
	var SERVER_BASE_URL = 'https://anwtestcall.herokuapp.com';
 // var SERVER_BASE_URL = 'https://anwanothertestcall.herokuapp.com'; 
 
    fetch(SERVER_BASE_URL + '/session').then(function(res) {
       return res.json()
    }).then(function(res) {
       apiKey    = res.apiKey;
       sessionId = res.sessionId;
 	   token     = res.token;

 	   runinit();

	}).catch(handleError);

    function runinit() {
            $.ajax({
        	type  	 : "post",
        	url 	 : baseurl+"Classroom/checktoken",
        	data     : { cid : cid },
        	dataType : "json",
        	success  : function(data) {
        		//if (data == false) {

        			if (data[0]['sessionid'].length == 0 || data[0]['token'].length == 0) { 
        			//	console.log(cid)
        			//	console.log(token)
        			//	console.log(sessionId)
        			//	return;
        				$.ajax({
        					type 	 : "post",
        					url 	 : baseurl+"Classroom/updatetoken",
        					data 	 : { cid : cid , token : token, sid : sessionId },
        					dataType : "json",
        					success  : function(data){
        						if (data == true) {
        							initializeSession();
        						} 
        					}, error : function() {
        						alert("Error updating the Classroom"); return;
        					}
        				})
        			} else {
        				sessionId = data[0]['sessionid'];
        				token     = data[0]['token'];	
	
        				initializeSession();
        			}
        		//} else {
        			
        			
        		//}
			
		//	console.log("sess:"+sessionId);
		//	console.log("token:"+token);
			return;
        	}, error : function() {
        		alert("error in getting the data of the Classroom"); return;
        	}
        }) 
    }
	
	var session;
	var timer; 
	
	var time 	  = new Object();
		time.hour = 0;
		time.min  = 0;
		time.ss   = 0;
					
      function initializeSession() {
        session = OT.initSession(apiKey, sessionId);

        // Subscribe to a newly created stream

        // Create a publisher
        var publisher = OT.initPublisher('publisher', {
          insertMode: 'append',
          width: '100%',
          height: '100%'
        }, handleError);

        // Connect to the session
        session.connect(token, function(error) {
          // If the connection is successful, publish to the session
          if (error) {
            handleError(error);
          } else {
            session.publish(publisher, handleError);
          }
        });
	
        session.on('streamCreated', function(event) {
          session.subscribe(event.stream, 'subscriber', {
            insertMode: 'append',
            width: '100%',
            height: '100%'
          }, handleError);
		  // start the timer here
			$(document).find(".timerstatus").fadeOut();

				timer = setInterval(function(){
					time.ss++;

					if(time.ss >= 60) {
						time.min++;
						time.ss = 0;
					}

					if (time.min >= 60) {
						time.hour++;
						time.min = 0;
					}

					var sszero = "0", ssmin = "0", sshour = "0";
					
					if (time.ss > 9) {
						sszero = "";
					}
					
					if ( time.min > 9 ) {
						ssmin = "";
					}

					if ( time.hour > 9 ) {
						sshour = "";
					}

				//	var timedet = document.getElementById("timer");
				// 		timedet.innerHTML = sshour+""+time.hour+":"+ssmin+""+time.min+":"+sszero+""+time.ss;
					$(document).find("#timerid").html( sshour+""+time.hour+":"+ssmin+""+time.min+":"+sszero+""+time.ss );
				},1000)
		  // end 
        })
		
		/*
		session.on("clientDisconnected", function(event) {
			alert("The session disconnected. " + event.reason)
			$(document).find(".timerstatus").html("User has been disconnected. Timer is paused").fadeOut();
			clearInterval(timer);
		});
		*/
/*
,"clientDisconnected", function(event) {
			alert("The session disconnected. " + event.reason)
			$(document).find(".timerstatus").html("User has been disconnected. Timer is paused").fadeOut();
			clearInterval(timer);
		}
*/		
		var msgHistory = document.querySelector('#history');
		session.on('signal:msg', function signalCallback(event) {
			var msg = document.createElement('p');
				msg.textContent = event.data;
				msg.className = event.from.connectionId === session.connection.connectionId ? 'mine' : 'theirs';
				/*
					if (event.from.connectionId === session.connection.connectionId) {
						msg.textContent = msg.textContent + "YOU";
					}
				*/
				// msg.textContent = ( event.from.connectionId === session.connection.connectionId ? '' : '' ) + msg.textContent;
				
				msgHistory.appendChild(msg);
				msg.scrollIntoView();
		});
		  
      }

      function handleError(error) {
        if (error) {
          alert(error.message);
        }
      }
		// Text chat
		var form   = document.querySelector('form');
		var msgTxt = document.querySelector('#msgTxt');
		
		
		// Send a signal once the user enters data in the form
		form.addEventListener('submit', function submit(event) {
		  event.preventDefault();
		  var themsg =  msgTxt.value;
			  msgTxt.value = '';
		  
		  session.signal({
			type: 'msg',
			data: themsg
		  }, function signalCallback(error) {
			if (error) {
				alert("error... look at the console.")
			  console.error('Error sending signal:', error.name, error.message);
			} else {
			  msgTxt.value = '';
			}
		  });
		});
		 
		window.onbeforeunload = function (event) {
		  var message = 'Sure you want to leave?';
		  if (typeof event == 'undefined') {
			event = window.event;
		  }
		  if (event) {
			event.returnValue = message;
		  }
		  return message;
		}

    </script>
<?php // $this->load->view("includes/footer"); 
	$englvl 	= null;
	$conlvl 	= null;
	$grammar 	= null;
	$speaking 	= null;
	$reading 	= null;
	$writing 	= null;
	$listening 	= null;
	$groupid 	= null;

	if (count($plvals) > 0) {
		$englvl 	= $plvals[0]->englvl;
		$conlvl 	= $plvals[0]->conlvl;
		$grammar 	= $plvals[0]->grammar;
		$speaking 	= $plvals[0]->speaking;
		$reading 	= $plvals[0]->reading;
		$writing 	= $plvals[0]->writing;
		$listening 	= $plvals[0]->listening;
		$groupid 	= $plvals[0]->groupid;
	}
?>

<div class="addmodule" id="addmodule">
<div class="inner_mod_div">
	<span id="inner_mod_div"> 
	<p class="mod_masthead"> <span class="masthead_text"> Add Feedback </span> </p>
		<div class="mod_content addpaddbot">
			<table class='feedbacktbl_holder'>
				<tr>
					<td class='tdleft'> Lesson Name </td>
					<td> 
						<select class='btn btn-default lessondrop' id='lessondrop'>
							<?php 
								foreach($mats as $ms) {
									echo "<option value='{$ms->mat_id}'>";
										echo "Level: ".$ms->matlvl." - ".$ms->mat_headtext;
									echo "</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<hr/>
					</td>
				</tr>
				<tr>
					<td colspan="2" class='plheader'>
						Performance Score
					</td>
				</tr>

				<tbody class='pldets'>
				<tr>
					<td class='tdleft'> English Level </td>
					<td>
						<select class='btn btn-default' id='englvl'>
							<?php 
								for($i = 0; $i <= 10; $i++) {
									$selected = ($englvl == $i)?"selected":null;
									echo "<option {$selected}>";
										echo $i;
									echo "</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td class='tdleft'> Conversation Level </td>
					<td> <input type='text' id='conlvl' value='<?php echo $conlvl; ?>'/> </td>
				</tr>
						<tr>
							<td class='tdleft'> Grammar </td>
							<td>
								<select class='btn btn-default' id='grammar'>
									<?php 
										for($i = 0; $i <= 10; $i++) {
											$selected = ($grammar == $i)?"selected":null;
											echo "<option {$selected}>";
												echo $i;
											echo "</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class='tdleft'> Speaking </td>
							<td>
								<select class='btn btn-default' id='speaking'>
									<?php 
										for($i = 0; $i <= 10; $i++) {
											$selected = ($speaking == $i)?"selected":null;
											echo "<option {$selected}>";
												echo $i;
											echo "</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class='tdleft'> Reading </td>
							<td>
								<select class='btn btn-default' id='reading'>
									<?php 
										for($i = 0; $i <= 10; $i++) {
											$selected = ($reading == $i)?"selected":null;
											echo "<option {$selected}>";
												echo $i;
											echo "</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class='tdleft'> Writing </td>
							<td>
								<select class='btn btn-default' id='writing'>
									<?php 
										for($i = 0; $i <= 10; $i++) {
											$selected = ($writing == $i)?"selected":null;
											echo "<option {$selected}>";
												echo $i;
											echo "</option>";
										}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td class='tdleft'> Listening </td>
							<td>
								<select class='btn btn-default' id='listening'>
									<?php 
										for($i = 0; $i <= 10; $i++) {
											$selected = ($listening == $i)?"selected":null;
											echo "<option {$selected}>";
												echo $i;
											echo "</option>";
										}
									?>
								</select>
							</td>
						</tr>
				</tbody>
				
					<tr>
						<td colspan="2">
							<hr/>
						</td>
					</tr>
				

				<tr>
					<td class='tdleft'> Feedback </td>
					<td>
						<textarea class='fbtxtarea' id='fbtextarea'></textarea>
					</td>
				</tr>
				<tr>
					<td> </td>
					<td> <button class='btn btn-default' id='submitfeedback' data-croomid = '<?php echo $this->uri->segment('3'); ?>'> Submit Feedback </button> </td>
				</tr>
			</table>
		</div>
	</span>
</div>
</div>
