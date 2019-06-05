(function(){
	var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
	$.ajax({
		type 		: "post",
		url 		: baseurl+"payment/creditpayment",
		data 		: { timezone : timezone },
		dataType    : "json",
		success 	: function(data) {
			if (data==true || data=="true") {
				$(document).find("#creditingid").text("Your subscription has been updated. This page will refresh in 3 seconds...").addClass("verifiedtext");

				
				setTimeout(function(){
					window.location.replace(baseurl);
				},3000)

			}
		}, error 	: function() {
			alert("error");
		}
	})
})();