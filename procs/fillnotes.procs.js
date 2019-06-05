function fillnotes() {
	var fillnotes = new Object();

	this.__start = function() {
		var savenote = document.getElementById("savenote");
			savenote.addEventListener("click", function() {
				fillnotes.note 		= $(document).find("#notes").val();
				fillnotes.recmat 	= $(document).find("#lessmat").val();
				fillnotes.stdid 	= $(this).data("stdid");
				fn._save();
			});

		var addnew = document.getElementById("addnew");
			addnew.addEventListener("click",function(){
				var conf = confirm("Are you sure you want to add a new note?")

				if (conf) {
					window.location.reload();
				}
			})
	}

	this._save = function() {

		$("<p class='saving' id='stattext'> saving..please wait </p>").appendTo(".innerdiv");
		$.ajax({
			url 	 : baseurl+"Counselor/savenotes",
			type     : "post",
			data 	 : { info : fillnotes },
			dataType : "json",
			success  : function(data) {
				fillnotes.cnid = data;
				$(document).find("#stattext")
					.removeClass("saving")
						.addClass("success")
							.html("Success");

				setTimeout(function(){
					$(document).find("#stattext").remove();
				}, 2000)
			}, error : function() {
				alert("error on saving note")
			}
		})
	}

}

var fn = new fillnotes();
	fn.__start(); 