// tutors

var tid   = null;
var tname = null;

function displaybookmarked() {
	$(document).find("#bookmarked").children().remove();
	$(document).find("#bookmarked").load(baseurl+"tutors/bookmarked");
}

(function(){
	displaybookmarked();
})();

$(document).on("click",".teacherdets", function(){
	tid = $(this).data("teacherid");
	tname = $(this).data("tfname");
	
	$(document).find("#optionsdiv").remove();
	$(document).find("#blackerdiv").remove();
	
	$("<div id='blackerdiv'>").appendTo($(this)).hide().fadeIn().on("click",function(){
		$(this).remove();
		$(document).find("#optionsdiv").remove();
	});
	
	$("<div id='optionsdiv'>").append("<ul>"+
						"<li id='booknow'> <i class='fa fa-book'></i>  Book a class </li>"+
						"<li id='bookmark'> <i class='fa fa-bookmark'></i>  Bookmark </li>"+
					  "</ul>").appendTo($(this)).hide().fadeIn();
})

$(document).on("click","#booknow",function(){

	book.teacher = tid;
	book.__start();

})

$(document).on("click","#bookmark",function(){
	
	$.ajax({
		type  	 : "post",
		url 	 : baseurl+"tutors/bookmark",
		data     : {teacherid : tid },
		dataType : "json",
		success  : function(data) {
			if (data === true || data === "true") {
				displaybookmarked();
			} else if (data === false || data == "false") {
				alert("error");
			} else {
				alert(data);
			}
		}, error : function()  {
			alert("error")
		}
	})
})