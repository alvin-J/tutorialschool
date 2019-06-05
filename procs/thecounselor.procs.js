function thecounselor() {
	var cinfo = new Object();

	var thislink = null;
	this.__start = function() {
		// load the bookings
			tc.loadbookings();
		// end load

		$(document).on("click","#callstudent",function(){
			window.open( $(this).data("href"), "Classroom", "width=1166,height=600" );
		})

		$(document).on("click","#fillnotes",function(){
			var stdid = $(this).data("stdid");
			window.open( baseurl+"Counselor/fillnotes/"+stdid, 
						"Counselor's Note","width=550,height=800")
		})

		$(document).on("click","#complete",function(){

			var conf = confirm("Are you sure you want to proceed?");

			if (conf) {
				cinfo.blid  = $(this).data("bl_id");

				$.ajax({
					url		 : baseurl+"Counselor/markcomplete",
					type 	 : "post",
					data 	 : { blid : cinfo.blid },
					dataType : "json",
					success  : function(data) {
						if (data) {
							alert("Completed");
							tc.loadbookings();
							$(document).find("#tableinformation")
								.children().remove();
						}
					},error  : function() {
						alert("error in marking Classroom as complete")
					}
				})
			}
		})

	}

	this.loadbookings = function() {
		// appearbookings
		$(document).find("#appearbookings")
			.load(baseurl+"Counselor/loadbookings",function(){
				$(document).on("click",".thebookingslist li",function() {
					$(this).siblings().removeClass("blli_box");
					$(this).addClass("blli_box");

					cinfo.blid  = $(this).data("bl_id")
					tc.showinformation();
				})
			});
		
	}



	this.showinformation = function() {
		$(document).find("#tableinformation")
			.html("loading information")
				.load(baseurl+"Counselor/showinformation",{ info : cinfo },function(){

				})
	}

}

var tc = new thecounselor();
	tc.__start();