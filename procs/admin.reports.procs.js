function adminreports() {
	var what = null;
	var id   = null;

	this.set = function(fromtbl = false){
		$(document).find("#thestatus").html("..loading");
		$.ajax({
			type 		: "post",
			url 		: baseurl+"Report/setstatus",
			data 		: { status : what, trbid : id },
			dataType    : "json",
			success     : function(data){
				if (data) {
					if (fromtbl == false) {
						$(document).find("#thestatus").html( (what==1)?"CLOSED":"OPEN" );
					} else {
						window.location.reload();
					}
				}
			}, error    : function(){
				alert("Error");
			}
		})
	}

	this.listen = function() {
		// $(document).on("click",".tbl-adminstudent tbody tr",function(){
			// $(document).find("#reportmodalview").show();
		// })
		
		$(document).on("click","#actiononrep",function(){
			var val     = $(this).val();
			var trblid  = id   = $(this).data("trblid");
			
			switch(val) {
				case "open":
						what = 0;
						ar.set(true);
						$(document).find("#reportmodalview").fadeOut();
					break;
				case "close":
						what = 1;
						ar.set(true);
						$(document).find("#reportmodalview").fadeOut();
					break;
				case "view":
						$(document).find("#reportmodalview").show();
						$(document).find("#innerdata").load(baseurl+"Report/viewreport",{ trblid : trblid })
					break;
			}
		})
		
		$(document).on("click","#reportmodalview",function(e){
			if ( e.target.id == "reportmodalview" ) {
				$(this).fadeOut();
			}
		})

		$(document).on("click","#setclose",function(){
			what = 1;
			ar.set();
		})

		$(document).on("click","#setopen",function(){
			what = 0;
			ar.set();
		})
	}
}

var ar  = new adminreports();
	ar.listen();