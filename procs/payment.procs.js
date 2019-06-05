(function(){
	this.stdid_       = null;
	this.substype_    = null;

	this.bnktranscode = null; 
	this.numofmonths  = null;
	this.amount 	  = null;

	// 
	
	// end 
	this.loadbtb = function() {
		$(document).find("#addmodule").fadeIn();
		$("<p class='lodingp' style='font-size:18px; color:#fff;'> Please wait... </p>").appendTo("#banktobank");
		
		$(document).find("#banktobank").load(baseurl+"Payment/loadbtb",{ stdid : stdid_ , substype : substype_}, function(){
			
		});
	}

	this.proceedpayment = function() {
		$.ajax({
			type 	: "post",
			url 	: baseurl+"Payment/savebtn",
			data 	: { stdid  : stdid_,
						subtyp : substype_,
						bnkcod : bnktranscode,
						nummos : numofmonths,
						amount : amount },
			dataType : "json", 
			success  : function(data) {
				if (data == true){
					alert("Payment added succesfully. This page will be reloaded.");
					window.location.reload();
				} else {
					alert(data);
					window.location.reload();
				}
			}, error : function() {
				alert("There's an error");
			}
		})
	}
	
	this.confirmdialog = function() {
		$(document)
			.find("#confinner")
			.load(baseurl+"Payment/screener")
	}
	
	// plan clicked
		$(document).on("click",".stdplan",function(){
			$(document).find("#confdialog").fadeIn();
			
			substype_ = $(this).data("substype");
			stdid_    = $(this).data("stdid");
			
			confirmdialog();
		})
		
		$(document).on("click","#confdialog",function(e){
			if (e.target.id == "confdialog") {
				$(this).fadeOut();
			}
		})
	// end plan clicked
	
	// setup payment clicked 
		 $(document).on("click","#setuppmethod",function(){
			$(document).find("#confdialog").fadeOut();
		 })
	// end 
	
	// b2b button
		// $(document).on("click",".b2bbtn", function(){
		$(document).on("click","#confb2b", function(){
			$(document).find("#confdialog").fadeOut();
			
			//substype_ = $(this).data("substype");
			//stdid_    = $(this).data("stdid");

			loadbtb();
		})
	// end event 

	$(document).on("click","#procbtn",function(){
		// $(document).find("#paymentnot").fadeIn();
		var aphere = $(this).parent();

		$("<p style='text-align: center;background: green;color: #fff;' id='pleasewait'> Please wait while we are processing the payment.</p>").prependTo(aphere);

		bnktranscode = $(document).find("#bnktrnscode").val();
		numofmonths  = $(document).find("#numofmonths").val();
		amount 	  	 = $(document).find("#amount").val();

		if (bnktrnscode.length == 0 || numofmonths.length == 0 || amount.length == 0) {
			alert("Please fill up all the fields"); return;
		}

		proceedpayment();
	})

	$(document).on("click",".proc_paypal",function(e){
		
		var conf = alert("You will be redirected to paypal.com our safe and trusted collector of payment.");
	
	})

	$(document).on("click",".addmodule",function(e){
		if (e.target.id == "addmodule") {
			$(this).fadeOut();
		}
	})
	
	var fvalue = null;
	$(document).on("click","#savepmode",function(){
		if (fvalue == null) {
			alert("Please choose payment method"); return;
		}
		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"payment/savepmethod",
			data 	 : { field : "paymentmethod", fvalue : fvalue },
			dataType : "json",
			success  : function(data){
				if (data == true || data == "true") {
					switch(fvalue) {
						case "b2b":
							$(document).find(".paypal_form").hide();
							$(document).find(".b2bbtn").show();
							break;
						case "ctc":
							$(document).find(".paypal_form").show();
							$(document).find(".b2bbtn").hide();
							break;
					}
					alert("Payment method has been saved.");
					
					window.location.href=baseurl+"payment#subscriptions";
				}
			}, error : function() {
				alert("error at savepmethod > payment.procs.js")
			}
		})
	})

	$(document).on("click","#btb",function(){
		fvalue = "b2b";
	})

	$(document).on("click","#ctc",function(){
		fvalue = "ctc";
	})
	
	$(document).on("click","#cancelthis",function() {
		$(this).parent().parent().parent().parent().fadeOut();
	})
	
	$(document).on("click","#cancelthis_b2b",function() {
		$(this).parent().parent().parent().fadeOut();
	})
	
	window.onload = function() {
		var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		
			$(document).find("#theplans")
				.load(baseurl+"Payment/planlist",{ timezone : timezone });
			/*
			$.ajax({
				type 	 : "POST",
				url 	 : baseurl+"Payment/checksubs",
				data     : { timezone : timezone },
				dataType : "json",
				success  : function(data) {
					switch(data) {
						case "1D":
								$(document).find("#_1dstdplan").css({"background":"rgb(197, 107, 107)","color": "#fff"});
							break;
						case "8M":
								$(document).find("#_8mstdplan").css({"background":"rgb(197, 107, 107)","color": "#fff"});
							break;
						case "1DP":
								$(document).find("#_1dpstdplan").css({"background":"rgb(197, 107, 107)","color": "#fff"});
							break;
					}
				}, error : function() {
					alert("error on checking the payment subscription");
				}
			})
			*/
	}
	
	
})()