(function(){
	this.teacherid = null;

	// new teacher 
		this.tname 		= null;
		this.ttypeid 	= null; 
		this.t_age 		= null;
		this.tyexp 		= null;
		this.trate 		= null;
		this.tper 		= null;
		this.tskypeid 	= null;
		this.tdept 		= null;
		this.temail 	= null;
		this.tpword 	= null;
	// end new teacher

	this.showteacherwin = function() {
		$(document).find("#showteacherwindow").load(baseurl+"/Admin/showteacherwindow",{ teacherid_ : teacherid }, function() {
			$(document).find("#addmodule").fadeIn();
		});
	}

	this.saveteacher = function() {
		$.ajax({
			type 		: "post",
			url 		: baseurl+"Admin/addteacher",
			data 		: { 
							tname 		: tname,
							ttypeid 	: ttypeid, 
							t_age		: t_age,
							tyexp		: tyexp,
							trate		: trate,
							tper		: tper,
							tskypeid	: tskypeid,
							tdept		: tdept,
							temail		: temail,
							tpword		: tpword,
							userid      : teacherid
				 			},
			dataType 	: "json",
			success 	: function(data) {
				if (data) {
					alert("Saving successful");
				}
			}, error  	: function() {
				alert("error on saving teacher")
			}
		})
	}
	
	this.addthisteacher = function() {
		$(document).find("#twindowshow").load(baseurl+"/Admin/showteacherwindow",{ teacherid_ : teacherid });
	}
	
	this.setactive = function(setwhat) {
		var conf = confirm("Are you sure about this action?");

		var msg = null;
		if (setwhat == "active") {
			msg = "Teacher has been successfully activated.";
		} else if (setwhat == "inactive") {
			msg = "Teacher's account has been deactivated.";
		}

		if (conf) {
			$.ajax({
				type  	 : "post",
				url 	 : baseurl+"Admin/setactive",
				data     : { teacherid_ : teacherid , setto : setwhat },
				dataType : "json",
				success  : function(data){
					if (data) {
						alert(msg);
						$(document).find("#trholder").remove();
					}
				}, error : function(){
					alert("error on setting active.. admin/setactive")
				}
			})
		}
	}
	
	$(document).on("click","#setactive",function(){
		setactive("active");
	})

	$(document).on("click","#setinactive",function(){
		setactive("inactive");
	})

	$(document).on("click","#cancelthis",function(){
		$(document).find("#trholder").fadeOut().remove();
	})

	$(document).on("click","#addteachertbl tbody tr",function(e){
		if (e.target.tagName == "TR" || e.target.tagName == "TD") {
			if (e.target.id != "trholder") {
				$(document).find("#trholder").remove();

				teacherid = $(this).data("teacherid");

				if (teacherid == null || teacherid.length == 0) {
					return;
				}

				// load 
				$("<tr id='trholder'> <td colspan=20> <div id='twindowshow'> </div> </td> </tr>").insertAfter( $(this) );
				addthisteacher();
			}
		}
	})

	$(document).on("click","#addteacher",function(){
		showteacherwin();
	})

	$(document).on("click",".addmodule",function(e){
		if (e.target.id == "addmodule") {
			$(this).fadeOut();
		}
	})

	$(document).on("click","#saveteacher",function(){
		tname 		= $(document).find("#tname").val();
		ttypeid 	= $(document).find("#ttypeid").val();
		t_age 		= $(document).find("#t_age").val();
		tyexp 		= $(document).find("#tyexp").val();
		trate 		= $(document).find("#trate").val();
		tper 		= $(document).find("#tper").val();
		tskypeid 	= $(document).find("#tskypeid").val();
		tdept 		= $(document).find("#tdept").val();
		temail 		= $(document).find("#temail").val();
		tpword 		= $(document).find("#tpword").val();
		saveteacher();
	})

})()
