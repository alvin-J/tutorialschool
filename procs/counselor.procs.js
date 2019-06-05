function counselor() {
	var couns  = new Object();
	var time   = null;

	var months = ["January",
				  "February",
				  "March",
				  "April",
				  "May",
				  "June",
				  "July",
				  "August",
				  "September",
				  "October",
				  "November",
				  "December"];

	this.__start = function() {
	// pre load the time list	
		//cs.timeskeds();
	// end 

		$(document).on("click",".counslist",function(e){
			couns.cid = $(this).data('cid');
			// cs.getthedate();

			if (undefined == couns.datetime) {
				cs.getdefdate();	
			}
			
			var bh  = $(this).find("#bookhere").length;
			var dis = $(this);

			//cs.checkmybooking(function(){
				if ( bh == 0 ) {
					cs.bookslot(dis)	
				}
			// });

		})

		$(document).on("click",".timesel",function(){	
			$(document).find(".timesel").removeClass("timesel_sel")
			$(this).addClass("timesel_sel");

			time = $(this).data("time");
			cs.getthedate();
		})

		$(document).on("click","#bookme",function(){
			couns.purpose = $(document).find("#bookingpurpose").val();
			$(document).find("#bookmediv")
				.prepend("<p id='saving'> Booking... </p>")

			// save 
				cs.bookcouns();
			// end 
		})

		$(document).on("change",".dateselect",function(){
			cs.getthedate();
			cs.timeskeds();
		})
	}

	this.getdefdate = function() {
		var date_ = new Date();
			d 	  = date_.getDate();
			m     = date_.getMonth();
			y 	  = date_.getFullYear();

		couns.datetime = months[m]+" "+d+", "+y;

	}

	this.getthedate = function() {
		var m = $(document).find("#month").val().trim(),
			d = $(document).find("#day").val().trim(),
			y = $(document).find("#year").val().trim();

			// couns.datetime = y+"-"+m+"-"+d;
			couns.datetime = m+" "+d+", "+y;
			if (time != null) {
				couns.datetime = m+" "+d+", "+y+" "+time;
				// couns.datetime = y+"-"+d+"-"+m+" "+time;
			}
	}

	this.bookslot = function(win) {
		$(document).find("#bookhere").remove();
		$("<div>",{ id : "bookhere", text : "loading..." })
			.appendTo(win)
				.load(baseurl+"counselor/showbookslot", function(){
					cs.timeskeds();
				});
	}

	this.timeskeds = function() {
		couns.timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		
	//	cs.checkmybooking( function() {
			$(document).find("#timeskeds")
				.prepend("<p style='text-align: center; margin-top: 12px; background: #aa4747; color: #fff;'> loading... </p>")
					.load(baseurl+"Counselor/couns_timeskeds",{ info : couns },function(data){
			 
			})			
	//	})

	}

	this.bookcouns = function() {
		//  https://tokbox.com/developer/tutorials/web/basic-video-chat/
		var SERVER_BASE_URL = 'https://anwtestcall.herokuapp.com';
	 // var SERVER_BASE_URL = 'https://anwanothertestcall.herokuapp.com'; 
			 
	    fetch(SERVER_BASE_URL + '/session').then(function(res) {
	       return res.json()
	    }).then(function(res) {
	       apiKey    = res.apiKey;
	       sessionId = res.sessionId;
	 	   token     = res.token;

	 	   	couns.apiKey    = apiKey;
		    couns.sessionId = JSON.stringify(sessionId);
		 	couns.token     = JSON.stringify(token);
		//	console.log(apiKey+"-"+sessionId+"-"+token); return;

			$.ajax({
				type 		: "post",
				url 		: baseurl+"counselor/bookmecounselor",
				data 		: { info : couns },
				dataType    : "json",
				success     : function(data){
					if(data) {
						alert("Booking successful")
						$(document)
							.find("#saving").remove();
						window.location.reload();

					}
				}, error    : function() {
					alert("Error on bookcouns function")
				}
			})

		}).catch(function(error){
			alert("an error occured");
		});


	}

	this.checkmybooking = function(somefunc) {
		// needs cid 
		// needs date and time
		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"Counselor/checkforbooking",
			data 	 : { info : couns },
			dataType : "json",
			success  : function(data) {
				console.log(data);
				if (data == 0) {
					somefunc();
				} else {
					alert("You have already booked at this time")
				}
			}, error : function() {
				alert("error on checkmybooking function");
			}
		})
	}
}

var cs = new counselor();
	cs.__start();