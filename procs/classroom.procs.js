function classroom() {

	this.classroomid = null;
	this.studentid   = null;
	this.teacherid   = null;

	var croom = new Object();

	this.savefeedback = function() {
		$.ajax({
			type 	 : "post",
			url 	 : baseurl+"Classroom/savefeedback",
			data     : { croomdata : croom },
			dataType : "json",
			success  : function(data){
				if (data) {
					alert("feedback Recorded")
				}
			}, error : function() {
				alert("error on saving feedback");
			}
		})
	}

	this.__start = function(){
		$(document).ready(function(){
			$(document).on("click","#showperledger",function(){
				$(document).find("#addmodule").fadeIn();
			})

			$(document).on("click","#addmodule",function(e){
				if (e.target.id == "addmodule") {
					$(this).fadeOut();
				}
			})

			$(document).on("click","#submitfeedback",function(){
				croom.thefb = $(document).find("#fbtextarea").val();
				croom.lesid = $(document).find("#lessondrop").val();
				croom.cid   = $(this).data("croomid");

				// performance ledger 
					croom.englvl     = $(document).find("#englvl").val();
					croom.conlvl     = $(document).find("#conlvl").val();
					croom.grammar    = $(document).find("#grammar").val();
					croom.speaking   = $(document).find("#speaking").val();
					croom.reading    = $(document).find("#reading").val();
					croom.writing 	 = $(document).find("#writing").val();
					croom.listening  = $(document).find("#listening").val();
				// end 

				cr.savefeedback();
			})
		})
	}
//	this.
	
}

var cr = new classroom();
	cr.__start();