// registration js 
var proceed = false;
var message = null;

var details = new Object();
// fullnameid
// eaddid
// pwordid
// skypenameid

// u_type

function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

$(document).on("blur","#fullnameid",function(){
	details.fullname = $(this).val();

	if (details.fullname.length == 0) {
		proceed = false;
		message = "Fullname cannot be empty";
	}
})

$(document).on("blur","#eaddid",function(){
	details.email = $(this).val();

	if (details.email.length == 0) {
		proceed = false;
		message = "email address cannot be empty";
	}
})

$(document).on("blur","#pwordid",function(){
	details.pword = $(this).val();
	if (details.pword.length == 0) {
		proceed = false;
		message = "password cannot be empty";
	}
})

$(document).on("blur","#skypenameid",function(){
	details.skype = $(this).val();
	if (details.skype.length == 0) {
		proceed = false;
		message = "skype ID cannot be empty";
	}
})

// student 
	$(document).on("change","#lep",function(){
		var val = $(this).val();

		if (val != 0) {
			proceed 		= true;
			details.lep		= val;
		} else if (val == 0) {
			proceed = false;
		}

	})

	$(document).on("change","#cp",function(){
		var val = $(this).val();

		if (val != 0) {
			proceed 		= true;
			details.cp		= val;
		} else if (val == 0) {
			proceed = false;
		}
	})

	$(document).on("change","#stttp",function(){
		var val = $(this).val();

		if (val != 0) {
			proceed 		= true;
			details.stttp	= val;
		} else if (val == 0) {
			proceed = false;
		}
	})

	// the answer is no
		$(document).on("click",".nobtn",function(){
			if (proceed == false) {
				alert("cannot proceed"); return;
			}

			$(document).find("#ansno").fadeIn();
			$(document).find(".ansno").text("Please wait while we are sending you an email confirmation.");

			$.ajax({
				type 		: "POST",
				url 		: baseurl+"contact/sendemail_no",
				data 		: { eadd : details.email },
				dataType 	: "json",
				success     : function(data) {
					// $(document).find("#ansno").fadeIn();
					$(document).find(".ansno").text("Thank you! Check your email for the confirmation. Please book a Free trial lesson at your most convenient time.");

					setTimeout(function(){
						window.location.reload();
					},10000)
				}, error 	: function() {
					alert("error");
				}
			})
			
		})
	// end 

	// yes btn 
		$(document).on("click",".yesbtn",function(){
			$(document).find("#congratulations").fadeOut();
			book.__start();
		})
	// end yes 

	// forgot password 
		$(document).on("click","#forgotpword",function(){
			var loginemail = $(document).find("#email_login").val();

			if (loginemail.length == 0) {
				alert("Please input your email address.");
				$(document).find("#email_login").focus();
			} else {
				var tthis = $(this);

				$(this).html("<p style='color: #fff !important;'> Please wait while we are currently processing your request...</p>");
				$.ajax({
					type 		: "POST",
					url 		: baseurl+"Register/forgotpassword",
					data 		: { loginemail : loginemail },
					dataType 	: "json",
					success     : function(data) {
						alert(data);
						tthis.html("FORGOT PASSWORD? RESET");
					}, error 	: function() {
						alert("error")
					}
				})
			}
		})
	// end forgot 

// end student
$(document).on("click",'#registerbtn',function(){
	details.u_type   = $(this).data("regtype");
	details.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		
	if (validateEmail(details.email)) {
		// true email 
		proceed = true;
	} else { // not true email
		details.email = null;
		proceed = false;
	}

	if (proceed == false) {
		alert("Cannot proceed. Please check all the fields.");
		return;
	}

	$.ajax({
		type 		: "POST",
		url		    : baseurl+"register",
		data 		: details,
		dataType 	: "json",
		success	    : function(data) {
			if (data === "true" || data === true) {
				$(document).find("#congratulations").fadeIn();
			} else {
				alert(data);
			}
		}, error :function() {
			alert("error")
		}
	})
})