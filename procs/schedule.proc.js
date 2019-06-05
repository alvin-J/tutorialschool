// call from outside this script
var today = null;
var bkid  = null;

function moveit(olddate, newdate) {
	var months_t = ['January','February','March','April','May','June','July','August','September','October','November','December'];

	$.ajax({
		type 	 : "post",
		url 	 : baseurl+"schedule/movedate",
		data     : { olddate : olddate, newdate : newdate },
		dataType : "json",
		success  : function(data) {
			$(document).find("#gobacktoday").show();

			var direction = data[2];
			var moveto    = data[1];
			var dates     = data[0];
			
			if(direction=="right") {			
				for (var rem = 1; rem <= moveto ; rem++) {
					$(document).find("#thedates").children().eq(0).remove();
				}

				var a = (moveto == 1)?2:1; 

				for(var i = a ; i <= dates.length-1 ; i++ ) {
					var dd    = new Date(dates[i]);
					var month = months_t[dd.getMonth()];
					var day   = dd.getDate();

					$("<li class='datelist' data-thedate='"+dates[i]+"'> <p class='monthcap'> "+month+
											" </p> <p class='monthdate'> "+day+
											" </p> </li>").appendTo("#thedates");
				}
			} else if (direction == "left") {
				for (var rem = 1; rem <= moveto ; rem++) {
						var l = $(document).find("#thedates").children().length-1;
						$(document).find("#thedates").children().eq(l).remove();
					}



				for(var i = moveto-1 ; i >= 0 ; i-- ) {
					var dd    = new Date(dates[i]);
					var month = months_t[dd.getMonth()];
					var day   = dd.getDate();
					
					$("<li class='datelist' data-thedate='"+dates[i]+"'> <p class='monthcap'> "+month+
											" </p> <p class='monthdate'> "+day+
											" </p> </li>").prependTo("#thedates");

				}

			}		
			
		}
	})
}

function displaydates(thedate) {
	var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
	
//	$(document).find("#daydivs").children().remove()
	$(document).find("#daydivs").load(baseurl+"schedule/daydivs",{ thedate : thedate , timezone_ : timezone });
	
		/*
		setInterval(function(){
			displaydates(thedate);
		},55000)
		*/
}

function display_date_option(thedate) {
	$(document).find("#contentshowhere").load(baseurl+"schedule/displayoption",{ date_ : thedate });
}
	
(function(){
	var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

	//setTimeout(function(){
		$(document).find(".skeddate").load(baseurl+"schedule/sked_dates",{ timezone : timezone }, function(){
			var thedate = $(document).find(".selecteddate").data("thedate");
				displaydates(thedate);
		});
	//},100)	
})();

$(document).on("click",".noclass",function() {
	var thedate	 	  = $(this).data("thedate");

	book.datetime 	  = thedate;
 	book.thetime.push($(this).text());

 	$(this).addClass("skedselected").siblings().removeClass('skedselected')

	book.__start();
})

$(document).on("click",".booktutor",function() {
	book.__start();	
})


$(document).on("click",".datelist",function(){
	var olddate   = $(document).find(".selecteddate").data("thedate");
	var newdate   = thedate = $(this).data("thedate");

		moveit(olddate, newdate);
		displaydates(thedate);

		$(this).addClass("selecteddate").siblings().removeClass("selecteddate")
})

$(document).on("click","#previousdate",function(){
	var olddate   = $(document).find(".selecteddate").data("thedate");
	var newdate   = thedate = $(document).find("#thedates").children().eq(1).data("thedate");

	moveit(olddate, newdate);
	displaydates(thedate);

	$(document).find("#thedates").children().eq(1).addClass("selecteddate").siblings().removeClass("selecteddate")
})

$(document).on("click","#nextdate",function(){
	var olddate   = $(document).find(".selecteddate").data("thedate");
	var newdate   = thedate = $(document).find("#thedates").children().eq(3).data("thedate");

	moveit(olddate, newdate);
	displaydates(thedate);

	$(document).find("#thedates").children().eq(3).addClass("selecteddate").siblings().removeClass("selecteddate")
})

$(document).on("click","#gobacktoday",function(){
	window.location.reload();
})

$(document).on("click",".hassked",function(){
	var thedate	 	  = $(this).data("thedate");
	
	$(document).find("#showoption").fadeIn();
	display_date_option(thedate);
})

$(document).on("click",".cancelbtn",function(){
	var conf = confirm("Are you sure you want to cancel your booking?");
	
	if (conf) {
		var bkid = $(this).data("bkid");
		$(document).find("#statusid").html("<p> Please wait while we are removing your booking... </p>");
		$.post(baseurl+"Schedule/cancelbooking",{ bkid_ : bkid },function(data){
			if (data) {
				alert("Cancelation successful");
				window.location.reload();
			}
		})
	}
	
})

$(document).on("click",".gotocroom",function(){
	// http://anwdev.ariesvrebuldad.com/classroom/waiting/209b409bc8375558913d4
	var key  = $(this).data("keycode");
	window.location.href = baseurl+"classroom/waiting/"+key;
})

$(document).on("click","#closethis",function(){
	$(document).find("#contentshowhere").children().remove();
	$(document).find("#showoption").fadeOut();
})

















