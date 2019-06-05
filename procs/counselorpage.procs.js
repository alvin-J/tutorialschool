function counselorspage() {
	var info = new Object();

	// name list
	var names  = [];

	this.___start = function() {
		cp.enrolltrial();
		cp.loadstudents();	
	}

	this.loadstudents = function() {
		$(document).find("#studentslist")
			.load(baseurl+"Counselor/loadstudents",function(){
				// name list button
					$(document).on("click","#nameullist li",function(){
						$(document).find("#addnewstudent").removeClass("selectedli");
						$(this).addClass("selectedli")
							.siblings()
								.removeClass("selectedli")

						info.stdid = $(this).data("stdid");
						cp.loadinformation();
					})
				// end 

				// enroll button 
					$(document).on("click","#enrollfreetrial",function(){
						cp.enrolltrial();
					})
				// end 

				// get the populated names
					cp.findname();
				// end 

				// listen for the keyboard input 
					$(document).on("keypress paste input","#searchtxt", function(){

					})
				// end listening
			})

		// enroll now 
			$(document).on("click","#enrollnow",function(){
				info.subtype = $(document).find("#subtype").val();
				cp.enrollnow();
			})
		// end 

		// close window 
			$(document).on("click","#closewindow",function(){
				$(document).find("#enrollwindow").children().remove();
			})
		// end

		// add new student window
			$(document).on("click","#addnewstudent",function(){
				$(document).find("#nameullist li").removeClass("selectedli");
				$(this).addClass("selectedli")
				cp.showaddstudent();
			})
		// end add new student window

		// add the student 
			$(document).on("click","#addstudentnow",function(){
				cp.checkemail(); // the proceed adding if return true
			})
		// end add new student

		$(document).on("click","#cancelthis",function(){
			$(document).find("#bookhere").fadeOut(function(){
				$(this).remove();
			})
		})
	}

	this.checkemail = function() {
		var email  = $(document).find("#emailtxt").val();

		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"Counselor/checkdup",
			data     : { email_ : email },
			dataType : "json",
			success  : function(data) {
				if (data == false) {
					alert("Duplicate found on email. Please choose another");
					$(document).find("#emailtxt").focus();
					return;
				} else {
					cp.addstudent(); // proceed adding if returned true
				}
			},error  : function() {
				alert("error on checking duplicate email")
			}
		})
	}

	this.addstudent = function() {
		$("<p> loading please wait... </p>").prependTo(".addstudentdiv");

		var datast   	 = new Object();
			datast.fname = $(document).find("#fname").val();
			datast.email = $(document).find("#emailtxt").val();
			datast.pwd   = $(document).find("#pwd").val();
			datast.lep   = $(document).find("#lep").val();
			datast.cp    = $(document).find("#cp").val();
			datast.stttp = $(document).find("#stttp").val();

		if (datast.lep == 0 || datast.cp == 0 || datast.stttp == 0) { alert("Please complete the necessary data."); return; }
		
		$.ajax({
			type 	 : "POST",
			url 	 : baseurl+"Counselor/addnewstudent",
			data     : { stdata : datast },
			dataType : "JSON",
			success  : function(data){
				if (data) {
					// $("<p> Success </p>").prependTo(".addstudentdiv");
					alert("Success");
					cp.loadstudents();

					$(document).find("#informationspan").children().remove();
				}
			}, error : function(){
				alert("Error in adding of student")
			}

		})
	}

	this.loadinformation = function() {
		$(document).find("#informationspan").html("loading student information")
			.load(baseurl+"Counselor/stdinformation",{ info : info}, function() {

			})
	}

	this.enrolltrial = function() {
		$(document).find("#enrollwindow")
			.load(baseurl+"counselor/enrollwindow",{ info : info },function(){

			})
	}

	this.showaddstudent = function() {
		$(document).find("#informationspan")
			.html("Preparing the window.. please wait")
				.load(baseurl+"Counselor/addstudent",function(){

				})
	}

	this.enrollnow = function(){
		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"Counselor/enrollnow",
			data     : { info : info },
			dataType : "json",
			success  : function(data){
				alert(data);
			}, error : function() {
				alert("error on enrolling student")
			}
		})
	}

	this.findname = function() {
		// nameullist
		
		var list   = $(document).find("#nameullist li");

		$(list).each(function(){
			var name = $(this).find("div").eq(1).text().trim();
			names.push(name);
		})
//		 console.log(names);
	}
}

var cp = new counselorspage();
	cp.___start();