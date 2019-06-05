function payroll() {
	this.teachername 	    = null;
	this.teacherid   	  	= null;
	this.teacherpayperiod   = null;
	this.rate 				= null;
	this.per 				= null;
	this.date_ 			    = null;

	// for booking deletion 
	this.bookingid 			= null;

	// check if earnings is clicked 
	this.isearning  		= null;

	// determines if paid or not :: value is fired from an ajax function call 
	this.ispaid 			= null; // setting the default value to null, means fresh

	// payroll payid 
	this.payid 				= null;
	this.header = function() {
		$(document).find("#headerpop").load(baseurl+"Payslips/header",{ teacherid : payroll.teacherid });
	}

	this.information = function() {
		$(document).find("#payrollinformation").load(baseurl+"Payslips/information", { teacherid : payroll.teacherid });	
	}

	this.period = function() {
		$(document).find("#payrollperiod").load(baseurl+"Payslips/period", { period : payroll.date_ , teacherid : payroll.teacherid }, function(){
			// var a =  $(document).find("#payrolldate").data("datefrom")+ "-"+$(document).find("#payrolldate").data("dateend");	
			var fromcal = $(document).find("#fromcal").val();
			var tocal   = $(document).find("#tocal").val();

			var dates = fromcal + "_" +tocal;
			
			if (fromcal.length == 0 || tocal.length ==0) {
				dates = null;
			}			

			payroll.hours(dates);

		});
	}

	this.hours = function(date_) {
		payroll.date_ = date_;
		$(document).find("#hoursrendered").html("<p> loading data.. please wait.. </p> ");
		$(document).find("#hoursrendered").load(baseurl+"Payslips/hoursrendered", {teacherid : payroll.teacherid, period : payroll.date_ });
	}

	this.earnings = function(stat = false, somefunction = false) {
		// <p> loading data.. please wait.. </p> 
	// 	$(document).find(".hrstbl").html("<p> loading data.. please wait.. </p> ");
		payroll.isearning = true;
		if (stat == "paid") {
			$(document).find("#paystat").removeClass("unpaid").addClass("paid").html("PAID")
		}
		$(document).find("#theearnings").load(baseurl+"Payslips/earnings",
			{ teacherid : payroll.teacherid , period : payroll.date_ , status : stat },function(){
				if (stat == "paid") $(document).find("#saverate").remove();
			$(document).find("#sendpayslip").show();

			if (somefunction != false) {
				somefunction();
			}
		});
	}

	this.poppayroll = function() {

		payroll.header();
		payroll.information();
		payroll.period();

		$(document).find(".blackerdiv").fadeIn();
	}

	this.saverate = function() {
		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"Payslips/saverate",
			data     : { teacherid : payroll.teacherid , rate : payroll.rate , per : payroll.per },
			dataType : "json",
			success  : function(data){
				if (data) alert("Data Saved");
		
				if (payroll.isearning == true) payroll.earnings(payroll.date_);
			}, error : function() {
				alert("error")
			}
		})
	}

	this.deletebooking = function(bookingid) {
	// 	alert(this.bookingid);

		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"Payslips/deletebooking",
			data     : { bookingid : bookingid},
			dataType : "json",
			success  : function(data) {
				payroll.hours();
			}, error : function() {
				alert("error")
			}
		})
	}

	this.createpayroll = function(somefunction = false) {
		//	alert(this.date_);
		$(document).find("#theearnings").children().remove();
		$.ajax({
			type 		: "post",
			url 		: baseurl+"Payslips/createpayroll",
			data 		: { teacherid : payroll.teacherid , period : payroll.date_ },
			dataType    : "json",
			success     : function(data) {
				if (data[0]=="notime") {
					alert("There are no time logs to compute for this account.")
					$(document).find("#theearnings").children().remove();
					$(document).find("#sendpayslip").hide();
				} else {
					if (data[0] == true || data[0] == "true") {
						payroll.ispaid = "paid"; // the teacher is already paid
					} else if (data[0] == false || data[0] == "false") {
						payroll.ispaid = "unpaid"; /// the teacher is not yet paid
					}
					payroll.payid = data[1];
					payroll.earnings(payroll.ispaid, somefunction);	
				}
			}, error : function() {
				alert("error")
			}
		})
	}

	this.sendpayslip = function() {
		// send payslip here
		$(document).find("#theearnings").children().remove();
		$("<p> refreshing... </p>").appendTo("#theearnings");
		
		payroll.createpayroll(function(){
			var html = JSON.stringify( $(document).find("#theearnings").html() );
	// console.log(html); return;	
				$(document).find("#loadingspan").html("<p style='margin: 0px;color: #fff;text-align: center;padding: 20px 0px;border-top: 1px solid #e78888;border-bottom: 1px solid #e78888;'> sending email.. please wait.. </p>");
				$.ajax({
					type 	 : "post",
					url 	 : baseurl+"Payslips/sendpayslip",
					data     : { html_ : html , payrollid : payroll.payid },
					dataType : "json",
					success  : function(data){
						alert("Payslip has been sent");
						$(document).find("#loadingspan").children().remove();
					}, error : function() {
						alert("error in sending email...")
					}
				})
		});


	}

	this.listen = function() {
		$(document).on("click",".v_pslip",function(){
			payroll.teacherid = $(this).data("tid");

			payroll.poppayroll();
		})

		$(document).on("click","#blackerdiv",function(e){
			if (e.target.id == "blackerdiv") {
				$(this).fadeOut();
				$(document).find("#theearnings").children().remove();
				$(document).find("#hoursrendered").children().remove();
			}
		})

		$(document).on("click","#saverate",function(){
			payroll.rate = $(document).find("#ratetxt").val();
			payroll.per  = $(document).find("#perselect").val();
			payroll.saverate();
		})

		$(document).on("click","#changepayper",function(){
			$(document).find("#selectdates").toggle();
		})

		$(document).on("click",'#selectdatebtn',function(){
			$(document).find("#theearnings").children().remove();

			var fromcal = $(document).find("#fromcal").val();
			var tocal   = $(document).find("#tocal").val();

			var dates = fromcal + "_" +tocal;
			
			payroll.hours(dates);	
		})

		$(document).on("change","#selectdates",function(){
			var dates = $(this).val();
			var text  = $("#selectdates option:selected").text();
			
			payroll.hours(dates);
			$(document).find("#payrolldate").html("<i class='material-icons dp48 iconperiod'>label</i> "+text);
			$(document).find("#paystat").removeClass("unpaid").removeClass("paid").html("")

			$(this).toggle();
		})

		$(document).on("click",".deletetime",function(){
			payroll.bookingid = $(this).data("bkid");

			var conf = confirm("Are you sure you want to delete this?");

			if (conf) {
				payroll.deletebooking(payroll.bookingid);	
			}
			
		})

		$(document).on("click","#pleasecreate",function(){
			payroll.createpayroll();
		})

		// sending of payslip to teacher
		$(document).on("click","#sendpayslip",function(){
			payroll.sendpayslip();
		})
	}
}

var payroll = new payroll();
	payroll.listen();
