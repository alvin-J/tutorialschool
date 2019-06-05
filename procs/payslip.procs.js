function payslip() {
	var tid    = null;
	var period = null;

	this.earnings = function() {
		$(document).find("#theearnings").html("loading...");
		$(document).find("#theearnings").load(baseurl+"Payslips/earnings",
			{ teacherid : tid , period : period , status : true },function(data){
				console.log(data);
			})
	}

	this.listen = function(){
		$(document).on("click","#pslipul li",function(){
			$(this).addClass("selectedps").siblings().removeClass("selectedps");
			
			tid    = $(this).data("tid");
			period = $(this).data("period");
			p.earnings();
		})
		
	}
}

var p = new payslip();
	p.listen();