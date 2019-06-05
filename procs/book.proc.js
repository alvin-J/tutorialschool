function book() {
	this.teacher   = null;
	this.datetime  = null;

	this.thetime   = [];
	this.proceed   = null;

	// this = external variable  :: public 
	// var  = internal variable  :: private

	this.init_container = function() {
		$("<span>",{ id : "initcontainer" }).appendTo(document.body);
	}

	this.__start = function() {
		$("<p class='lodingp'> Please wait... </p>").appendTo("#initcontainer");

		var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

		$(document).find("#initcontainer").load(baseurl+"/book",{ "values[]": [ book.teacher, book.datetime , timezone] }, function() {
			
			if (book.thetime.length == 0) {
				$(document).find("#tableofskeds").show();
			}
			
			if (book.teacher != null) {
				book.loadavailabletime();
			}
			
		})
	}

	this.hidebook = function() {
		$(document).find("#initcontainer").children().fadeOut(function(){
			$(document).find("#initcontainer").children().remove();
			})
		book.teacher  = null;
		book.datetime = null;
		book.thetime  = [];
	}
	
	this.checkavailability = function() {
		$(document).find("#av_stat").text("").removeClass("available").removeClass("grey")

		$.ajax({
			type 	 : "post",
			url  	 : baseurl+"book/checkavailability",
			data 	 : { teacher : book.teacher , datetime : book.datetime },
			dataType : "jSon",
			success  : function(data) {
				$(document).find("#av_stat").show();
				
				if (data[0] === false || data[0] === "false") {
					$(document).find("#av_stat").text("Available").addClass("available"); //  on "+data[1]
					alert("available")
					book.proceed 	= true;
				} else {
					$(document).find("#av_stat").text("NOT AVAILABLE").addClass("grey");
					alert("not")
					book.proceed    = false;
				}
			}
		})
	}

	this.loadavailabletime = function() {
		// use teacher id
		// use the date :: no time
		
		$(document).find("#tableofskeds").show();

		var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		$(document).find("#timeskeds").children().remove();
		$(document).find("#timeskeds").load(baseurl+"Book/loadtime",{ timezone : timezone , selecteddate : book.datetime }, function(){
		
			$.ajax({
				type 	 : "post",
				url 	 : baseurl+"book/getavailabletime",
				data 	 : { teacher : book.teacher , datetime : book.datetime },
				dataType : "json",
				success  : function(data) {
					// console.log(data);
					var date_ = data[1];
					var data  = data[0];
					
					var skeds = $(document).find("#timeskeds").children("tr").children("td");
						skeds.removeAttr("style")
					$(document).find("#dateavail").text(date_);
					
					var d = book.thetime;
					
						for(var i = 0; i <= skeds.length-1; i++) {
							
							for(var z = 0; z <= data.length-1; z++) {
								
								if ( skeds[i].textContent.trim() == data[z] ) {
									console.log( skeds[i].textContent.trim() );
									skeds.eq(i).css({
											"text-decoration":"double line-through",
											"color":"red"
											})
								}	
							}
						}
						
						for(var a = 0; a <= skeds.length-1; a++) {
							for(var b = 0; b <= d.length-1; b++) {
								if ( skeds[a].textContent.trim() == d[b] ) {
									skeds.eq(a).css({
										"background-color":"pink"
									})
								}
							}
						}
						

				// 	book.checkavailability();
				},error :function() {
					alert("error in getting the available time");
				}
			}) // end getavailabletime function
			
		}); // end of loadtime function 
	}

	this.listenevents = function() {
		$(document).on("click",".booktutor",function(){
			book.__start();
		})

		$(document).on("click","#booktutor",function(){
			book.__start();	
		})

		$(document).on("click",".godrop",function(){
			if ( $(document).find(".dropbodydiv").hasClass("shown") ) {
				$(document).find(".dropbodydiv").fadeOut("100").removeClass("shown");	
			} else {
				$(document).find(".dropbodydiv").fadeIn().addClass("shown");
			}	
		})

		$(document).on("click",".overall_wrap",function(e){
			if (e.target.id == "overall_wrap") {
				if (book.teacher !== null || book.datetime !== null) {
					var conf = confirm("You have unsaved data. Are you sure you want to close?");

					if (conf) {
						book.hidebook();
					}
				} else {
					book.hidebook();
				}
			}
		})

		$(document).on("click",".boxme",function(){
			$(document).find("#selectedtutor").text( $(this).data("tname") )
 			book.teacher = $(this).data("teacherid");
		
			$(this).addClass("selectedteacher").siblings().removeClass('selectedteacher')
			
 			// if (book.datetime == null) {
 				book.loadavailabletime();
 			// } 
			
 			$(document).find(".dropbodydiv").fadeOut("100").removeClass("shown");
		})

		// set default time
		/*
			$(document).ready(function(){
				book.datetime = $(document).find("#selecteddate").val();	
			})
		*/
		// end 

		$(document).on("change keyup paste input","#selecteddate",function(){
			book.datetime = $(this).val();

			if(book.teacher != null) {
				book.loadavailabletime();
			}
		})
  		
  		$(document).on("click","#startbook",function(){
 			var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

  			var exit = false;

  		

  			if (book.teacher === null) {
  				alert("You have not selected a teacher");
  				exit = true;
  			}

  			if (book.datetime == null) {
  				book.datetime = $(document).find("#selecteddate").val();
  			}

  			if (book.thetime == null || book.thetime.length == 0) {
  				alert("Please select time");
  				exit = true;
  			}

  		//	book.datetime = book.datetime +" "+ book.thetime;
  		//	book.checkavailability();

  			if (book.proceed == false) {
  				alert("Cannot proceed. Please check availability.");
  				exit = true;
  			}

  			if (exit) {
  				return;
  			}

			$(document).find("#bookingstats").show();
  			$.ajax({
  				type      : "POST",
  				url       : baseurl+"book/booknow",
  				data 	  : { teacher : book.teacher , datetime : book.datetime , _timezone : timezone, time : book.thetime},
  				dateType  : "jSon",
  				success   : function(data){
  					if (data == "true" || data == true) {
						$(document).find("#bookingstats").hide();  
  						alert("Booking successful");
  						window.location.reload();
  					} else {
						$(document).find("#bookingstats").hide(); 
  						alert("An error encountered while booking a schedule. Please check availability of teacher.");
  					}
  				}
  			}) 
  		})

  		$(document).on("click","#cancelthis",function(){
  			if (book.teacher !== null || book.datetime !== null) {
				var conf = confirm("You have unsaved data. Are you sure you want to close?");

				if (conf) {
					book.hidebook();
				}
			} else {
				book.hidebook();
			}
  		})

  		$(document).on("click","#tableofskeds tbody tr td", function(){
  			var ttime = $(this).text();

  			if (ttime.trim() == "----" || $(this).hasClass("passdate")) {
				alert("Cannot book this time.")
  				return;
  			} 

  			if (book.datetime == null) {
  				book.datetime = $(document).find("#selecteddate").val();
  			}

  			ttime = ttime.trim();

  			var localdatetime = book.datetime+" "+ttime;
  			
  			var thethis = $(this);
  			$.ajax({
				type 	 : "post",
				url  	 : baseurl+"book/checkavailability",
				data 	 : { teacher : book.teacher , datetime : localdatetime },
				dataType : "jSon",
				success  : function(data) {
					
					if (data[0] === false || data[0] === "false") {
						if (book.thetime.length == 0) {
		  					book.thetime.push(ttime);
		  					thethis.addClass("active");
		  				} else {
		  					if ( book.thetime.indexOf(ttime) == -1 ) { 
		  						book.thetime.push(ttime);
		  						thethis.addClass("active");
		  					} else {
		  						book.thetime.splice( book.thetime.indexOf(ttime), 1 );
		  						thethis.removeClass("active");
		  					}
		  				}
					} else {
						alert("This is not available")
					}
				}
			})

  			// console.log(book.thetime);
  			//  book.thetime = ttime;

  		})
	}

}

var book = new book();
	book.init_container();
	book.listenevents();

