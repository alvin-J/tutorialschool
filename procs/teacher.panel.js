(function(){
	this.timezone = null;
	this.the_date = null;

	this.att 	  = null;
	
	// used in declining the reserved class
		this.bl_id = null;
		this.stdid = null;
	// 
	
	this.time_s = [];
	
	this.startclock = function(){
		timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

		$(document).find("#theclock").load(baseurl+"Teacher/startclock",{ timezone : timezone })
		
		setTimeout(function(){
			startclock();
		},500)
	}

	this.tutorskeds = function() {
		$(document).find("#theskedsofme").load(baseurl+"Teacher/getbookings",{ thedate : the_date });
	}

	this.attendance = function(id = false) {
		
		$.ajax({
			type		: "post",
			url 		: baseurl+"Teacher/attendance",
			data 		: {  
							timezone : timezone,
							thedate  : the_date,
							att 	 : att,
							times    : time_s
					 },
			dataType 	: "json",
			success 	: function(data){
				tutorskeds();
				if (data) {
					$(document).find("#"+id).addClass("att_selected").siblings().removeClass("att_selected");
				}
			}, error 	: function() {
				alert("An error occured.")
			}
		})
	}
	
	this.stddetails = function(t) {
		$(document).find("#stddets").remove();
		$("<span>",{ id : "stddets", text : "loading please wait..." })
			.appendTo(t)
			.load(baseurl+"Teacher/stddets",{ stdid_ : stdid }); 
		
	}
	
	this.declinebtn = function() {
		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"Teacher/declinethis",
			data     : { blid : bl_id },
			dataType : "json",
			success  : function(data) {
				alert(data);
			}, error : function() {
				alert("error on decline button")
			}
		})
	}

	this.listen = function() {
		$(document).on("click","#declinebtn",function(){
			var conf = confirm("Are you sure you want to decline this?");
			
			if (conf) {
				declinebtn();
			}
			
		})
		
		$(document).on("click","#cancelthis",function(){
			$(document).find("#stddets").remove();
		})
		
		$(document).on("click",".hassked",function(e){
			
			if (e.target.tagName == "LI") {
				bl_id = $(this).data("blid"); // global
				stdid = $(this).data("stdid"); // global
		
				stddetails( $(this) );
			}
			
		})
		
		$(document).on("click",".datelist",function(){
			var itstime = $(this).data("thedate");

			the_date = itstime;
			tutorskeds();
		})

		$(document).on("click",".attendance",function(e){
			var id = e.target.id;

			if (id == "presentme") {
				att = "present";
			} else if (id == "absentme") {
				att = "absent";
			} else {
				alert("unknown call... please go back."); return;
			}

			attendance(id);

		})
		
		$(document).on("click",".classdivbox ul li",function(){
			
			if ($(this).hasClass("hassked")) {
				return;	
			}
			
			var ttime = $(this).text().trim();
			
				var iot = time_s.indexOf(ttime);
			
				if (iot == -1 || time_s.length == 0) { // not found
					// add
					 time_s.push(ttime);
				     $(this).addClass("forabsent");
				} else { // found
					// remove
					time_s.splice(iot,1);
					$(this).removeClass("forabsent");
				}
			
		})

	}

	tutorskeds();
	startclock();
	listen();
})()