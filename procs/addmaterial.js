var matheaddets 		= new Object();
	matheaddets.mathead = null;
	matheaddets.matlvl  = null;
	matheaddets.matcap  = null;
	matheaddets.matcol  = null;
	matheaddets.order   = null;
	matheaddets.matid   = null;
	matheaddets.allow   = null;

var modules 		  = new Object();
	modules._title    = null;
	modules.order     = null;
	modules._content  = null;
	modules.modid     = null;
	modules.file 	  = [];

var msg 			  = ""; // the message
var deletewhat 		  = null;

function setvals() {
	var $href  = window.location.href;
	// http://localhost/anw_elearning/admin/materials/add/1

	var a 	   = $href.split(","); // the material id
	var open_w = true;

		if (a.length >= 8) {
			matheaddets.matid = a[7];
			loadmodules();
			open_w = false; 

			if (a.length >= 9) {
				open_w = true;
				modules.modid = a[8];

					if (a.length >= 10) {
						// delete
						if ( a[9].length != 0 ) {
							deletewhat = a[10];
							deleteit   = false;

							if (a[9] === "undefined" || a[9] === undefined) {
								open_w	 = false;
								deleteit = false;
							} else {
								open_w	 = true;
								deleteit = true;
							}

							if (deletewhat === 'undefined' || deletewhat === undefined || deletewhat.length == 0) {
								open_w	 = false;
								deleteit = false;
							} else {
								open_w	 = true;
								deleteit = true;
							}
							
							if (deleteit) {
								open_w	 = false;
								__delete();
							}
						}
					}
			}
		}

		if (open_w) {
			themodules_add();
			openwindow();
		}
}

function loadaddmat() {
	$(document).find("#addmaterial").load(baseurl+"/admin/loadaddmat",{ matid : matheaddets.matid , allow : matheaddets.allow});	
}

function loadlistmats() {
	$(document).find("#listofmats").load(baseurl+"/admin/listofmats");	
}

function loadmodules() {
	$(document).find("#modlist_ap").load(baseurl+"/admin/modules",{ matid : matheaddets.matid });		
}

function clearmodules() {
	$(document).find("#modlist_ap").children().remove();
}

function themodules_add() {
	$(document).find("#inner_mod_div").load(baseurl+"/admin/add_module_pop",{ modid : modules.modid }, function(){
		// matfiles
		modules.file = [];
		
		var matfiles_count = $(document).find("#matfiles").children().length;
			
			for(var i = 0 ; i <= matfiles_count-1; i++) {
				modules.file.push( $(document).find("#matfiles_"+i).val() )
			}
			
			displayfiles();
	});		
}

function openwindow() {
	if (matheaddets.matid == null) return;
	$(document).find("#addmodule").fadeIn();
}

function returntonormallink(len) {
	var $href = window.location.href;

	var a = $href.split("/");

		if (a.length > len) {
			// matheaddets.matid = null;
			// modules.modid     = null;
			window.location.href = a[0]+"/"+a[1]+"/"+a[2]+"/"+a[3]+"/"+a[4]+"/"+a[5]+"/"+a[6];
		}
}

function __delete(){
	var ids = new Object();
		ids.mat = matheaddets.matid;
		ids.mod = modules.modid;

	var conf = confirm("Are you sure you want to delete this?");

	if (!conf) {
		return;
	}

	$.ajax({
		type 	 : "post",
		url 	 : baseurl+"/admin/delete",
		data     : { deletewhat : deletewhat , ids_ : ids },
		dataType : "json",
		success  : function(data){
			
			switch(deletewhat) {
				case "material": 
					matheaddets.matid = null; 
					loadlistmats(); 
					loadaddmat(); 
					loadmodules(); 
					themodules_add(); 
					break;
				case "module": 
					modules.modid 	  = null;
					loadmodules(); 
					themodules_add(); 
					break;
			}

			returntonormallink(6);
		}, 
		error 	 : function() {
			alert("error")
		}
	})
}

function remove_attc(filename) {
	console.log(modules.file);
	$.ajax({
		type 	 : "post",
		url 	 : baseurl+"Materials/removeattachment",
		data 	 : { filename_ : filename , modid_ : modules.modid },
		dataType : "json",
		success  : function(data) {
			/*
			if (data == "file not found") {
				// remove from the array in javascript 
					// not found 
						// alert :: file not found
				for(var i=0;i<=modules.file.length-1;i++) {
					if (modules.file[i] == filename ) {
						modules.file.splice(i,1);
					}
				}
					
				displayfiles();
			} else {
				// displayfiles();
				for(var i=0;i<=modules.file.length-1;i++) {
					if (modules.file[i] == filename ) {
						modules.file.splice(i,1);
					}
				}
					
				displayfiles();
				
				// alert("file has been removed");
				// $(document).find("#addmodule").fadeOut();
			}
			*/
			for(var i=0;i<=modules.file.length-1;i++) {
				if (modules.file[i] == filename ) {
					modules.file.splice(i,1);
				}
			}
		
			displayfiles();
		}, error : function() {
			alert("error removing the file attachment");
		}
	})
}

function displayfiles() {
	// <span class='thefilespan'>"+data[1]+" <i class='material-icons dp48 removespan'>not_interested</i> </span>
	$(document).find('#output').children().remove();
	var loc_msg = ""; 
	for(var i = 0; i <= modules.file.length-1; i++) {
		loc_msg += "<span class='thefilespan'>"+modules.file[i]+" <i class='material-icons dp48 removespan' data-filename='"+modules.file[i]+"'>not_interested</i> </span>";
	}
	
	if (modules.file.length == 0) {
		loc_msg = "Please choose file";
	}
	$(document).find('#output').html(loc_msg);
}


$(document).on("click","#savebtn",function(){
	matheaddets.mathead = $(document).find("#matheadtxt").val();
	matheaddets.matlvl  = $(document).find("#matlvl").val();
	matheaddets.matcap  = $(document).find("#matcapt").val();
	matheaddets.matcol  = $(document).find("#matcol").val();
	matheaddets.order   = $(document).find("#matorder").val();

	$.ajax({
		type 	 : "post",
		url  	 : baseurl+"/admin/addthismaterial",
		data 	 : { mats : matheaddets },
		dataType : "json",
		success  : function(data) {
			// matheaddets.matid   = null;
			// matheaddets.allow   = null;
			loadlistmats();
			loadaddmat();

			returntonormallink(6);
		}, error : function() {
			alert("error on saving the data")
		}
	})
})

setvals();

loadaddmat();
themodules_add();
loadlistmats();

$(document).on("click",".editmathead",function(){
	matheaddets.matid   = $(this).data("matid");
	matheaddets.allow   = true;
	loadaddmat();
	loadmodules();
})

$(document).on("click","#addmat",function(){
	matheaddets.matid   = null;
	matheaddets.allow   = null;
	loadaddmat();
	clearmodules();
})

$(document).on("click","#addmodule",function(e){
	if (e.target.id == 'addmodule') {
		var a = $(this);
		a.find("#inner_mod_div").animate({
			"margin-top":"-1000px"
		},300, function(){
			$(this).removeAttr("style");
		})
		a.fadeOut();
	}
})

$(document).on("click","#openmod",function(){
	modules.modid = null;
	themodules_add();
	openwindow();
})

$(document).on("click","#addthemodule",function(){
	modules._title    = $(document).find("#mattitle").val();
	modules.order     = $(document).find("#matorder").val();
	modules._content  = $(document).find("#matcontent").val();

	$.ajax({
		type 	 : "POST",
		url 	 : baseurl+"/admin/addthismodule",
		data     : { module : modules , matid : matheaddets.matid },
		dataType : "json",
		success  : function(data) {
			$(document).find("#addmodule").fadeOut();
			loadmodules();

			returntonormallink(6);
		}, error : function() {
			alert("error");
		}
	})
})

$(document).on("click",".editmodule",function(){
	modules.modid = $(this).data("modid");
	openwindow();
	themodules_add();
})

$(document).on("click",".deletemathead", function(){
	deletewhat 		  = "material";
	matheaddets.matid = $(this).data("matid");
	__delete();
})

$(document).on("click",".deletemodule",function() {
	deletewhat        = "module";
	modules.modid     = $(this).data("modid");
	__delete();
})


// stash the file :: copy this
			$(document).on("change","#attcfile",function(){
					var form 	 = $(document).find('#fileinfo')[0]; // standard javascript object here
					var formData = new FormData(form);

					$(document).find("#savethefile").addClass("disabled");
					$(document).find('#output').html("uploading file please wait...");
					
					$.ajax({	
						url		 : baseurl+'/Materials/upload',
						type 	 : 'POST',
						data 	 : formData,
						dataType : "json",
						success  :function(data){
							
							if (data[0] == true) { // uploaded
								// msg 	= "File has been succesfully uploaded.";
								// msg  += "<span class='thefilespan'>"+data[1]+" <i class='material-icons dp48 removespan'>not_interested</i> </span>";
								modules.file.push(data[1]);

							} else {
								msg = data + "<br/>" + msg;
							}
							
						displayfiles();
						//	$(document).find('#output').html(msg);

						},
						error    : function(a,b,c) {
							alert("error in uploading the file...");
						},
						cache: false,
						contentType: false,
						processData: false
					});
					
				console.log(modules.file);
			})
	// end of stashing the file 
	
// remove the attachment 
	$(document).on("click",".removespan", function(){
		var conf = confirm("Are you sure you want to remove this file");
	
		if (conf) {
			remove_attc( $(this).data("filename") );
		}
	
	})
// end removing attachment 