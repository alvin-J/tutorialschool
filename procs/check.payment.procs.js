// check for payment

	(function(){
		var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		$.ajax({
			type 		: "POST",
			url 		: baseurl+"Payment/checkvalidity",
			data 		: { _timezone : timezone },
			dataType	: "json",
			success 	: function(data) {
				if (data == "invalid" && data != null) {
					$("<div>",{ class : "notifdiv" })
						.append("<p> Your subscription has expired! </p>")
							.prependTo(document.body).fadeIn("1000");
				}
			},
			error 		: function() {
				alert("error on checking of payment script")
			}
		})
	})();
// end 

