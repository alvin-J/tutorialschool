function replenish() {

	this.studentid = null;
	this.timezone  = null;

	// for replenishment;	
		this.dateofext	= null;
		this.prevval	= null;
		this.payid		= null;
		this.transnum   = null;
	// end 
	
	// number of months 
		this.numofmos   = null;
	// end 
	this.loadreplenish = function() {
		$(document).find("#replenish_").load(baseurl+"admin/replenish_window",{ timezone : rep.timezone, stdid : rep.studentid });
	}

	this.replenishnow = function() {
		$("<p class='showmessage'>  Processing transaction.. please wait.. </p>").appendTo(document.body);
		$.ajax({
			type 	: "post",
			url 	: baseurl+"admin/replenish",
			data 	: { studentid : rep.studentid, 
						dateofext_ : rep.dateofext, 
						pre_val : rep.prevval, 
						payid   : rep.payid,
						numofmos : rep.numofmos
					  },
			dataType : "json",
			success  : function(data) {
				if (data) {
					alert("Account succesfully replenished. This page will reload.");
					window.location.reload();
				}
			},
			error 	 : function() {
				alert("error in extending")
			}
		}) 
	}
	
	this.changemonth = function() {
		/*
		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"admin/changemos",
			data     : { numofmos : rep.numofmos , payid : rep.payid },
			dataType : "json",
			success  : function(data) {
				if (data) {
		*/
					$(document).find("#numofmostext").text(rep.numofmos)
					$(document).find("#staticinput").show();
					$(document).find("#editinput").hide();
		/*
				}
			}, error : function() {
				alert("technical Error on changing the month");
			}
		})
		*/
	}

	this.listen = function() {
		rep.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

		$(document).on("click",".replenish",function(){
			rep.studentid = $(this).data("stdid");
			rep.loadreplenish();

			$(document).find(".addmodule").fadeIn();
		})

		$(document).on("click",".drop",function(){

		})

		$(document).on("click",".addmodule",function(e){
			if (e.target.id == 'addmodule') {
				$(this).fadeOut();
			}
		})

		$(document).on("click","#extendit",function(){
			$(document).find("#thecalendar").toggle();
			$(document).find("#extendcal").focus();
		})

		$(document).on("click","#repbtn",function(){

			if (document.getElementById("extendcal")) {
				var dot  = $(document).find("#extendcal").val();

				if (dot.length == 0) {
					alert("Cannot continue with empty date."); return;
				}

				rep.dateofext  = dot; 
			}

			rep.prevval	   = $(this).data("prevval");
			rep.payid	   = $(this).data("payid");
			rep.replenishnow();

			// student id
			// date of extension
			// validity until date of prev's subscription

			// if has bank account trans number -> get the paymentid and -> update
			// if none create a new entry
		})
		
		// listen to change month link
		$(document).on("click","#changemonth",function(){
			$(document).find("#staticinput").hide();
			$(document).find("#editinput").show();
		})
		
		$(document).on("click","#savemosbtn",function(){
			rep.numofmos = $(document).find("#numofmos_change").val();
			// rep.payid    = $(this).data("payid");
			
			rep.changemonth();
		})
		
		$(document).on("click","#closemosbtn",function(){
			$(document).find("#editinput").hide();
			$(document).find("#staticinput").show();
		})
		// end 
	}

}

var rep = new replenish();
	rep.listen();