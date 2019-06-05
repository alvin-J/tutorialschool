var reportvals = null;
var reportfirs = null;

(function(){
	var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
	$(document).find("#reporttblhere").load(baseurl+"report/getdata",{timezone : timezone});
})()


$(document).on("click",".collapsible li .addreportbtn",function(){
	$(this).parent().parent().parent().parent().parent().parent().parent(".collapsible li").find(".collapsible-body").toggle();
})

$(document).on("click",".reportbtn",function(){
	//	var data = $(this).data("");
})

$(document).on("click",".option_rad",function(){
	var dt 		   = $(this).val();
		reportvals = dt;
})

$(document).on("click",".option_rad_top",function(){
	reportfirs = $(this).val();
})


$(document).on("click",".reporthis",function(){
	/*
	$("<div>",{ class: "notificationdiv" })
					.append("<span class='alert alert-success'> You have successfully reported this. </span>")
						.appendTo(document.body);
						return;
	*/
	var liid = $(this).data("li_id");

	$.ajax({
		type 	 : "post",
		url 	 : baseurl+"report/addreport",
		data     : { reportid : reportvals, reportfirst : reportfirs },
		dataType : "json",
		success  : function(data){
			if (data === true || data === "true") {
				$("<div>",{ class: "notificationdiv" })
					.append("<span class='alert alert-success'> You have successfully reported this. </span>")
						.appendTo(document.body);

				setTimeout(function(){
					$(document).find("#"+liid).fadeOut(function(){
						$(document).find("#"+liid).remove();
					});
					$(document).find(".notificationdiv").fadeOut(function(){
						$(document).find(".notificationdiv").remove();
					})
				},1500)

				// window.location.reload();
			}
		},
		error : function(){
			alert("error")
		}
	})
})