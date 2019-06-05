(function(){
	$("<span>",{ id : "subscriber" }).prependTo(document.body);
	
//  https://tokbox.com/developer/tutorials/web/basic-video-chat/
	var SERVER_BASE_URL = 'https://anwtestcall.herokuapp.com';
 // var SERVER_BASE_URL = 'https://anwanothertestcall.herokuapp.com'; 
 
 /*
    fetch(SERVER_BASE_URL + '/session').then(function(res) {
       return res.json()
    }).then(function(res) {
       apiKey    = res.apiKey;
//       sessionId = res.sessionId;
// 	     token     = res.token;
	
*/
  var sessionId = null,
      token     = null,
      apiKey    = null,
      cr_id     = null;

	   $.ajax({
	   		type 	 : "post",
	   		url   	 : baseurl+"Counselor/getclassroom",
	   		dataType : "json",
	   		success  : function(data) {

	   			sessionId = data['sessid'];
	   			token 	  = data['token'];
          apiKey    = data['apikey'];
          cr_id     = data['classroomid'];

	   			initializeSession();			
	   		},error  : function(){
	   			// alert("Error in getting classroom");
	   		}
	   })
 	   

//	}).catch(handleError);


      function handleError(error) {
      	console.log(error.message);
        //  alert(error.message);
      }

    var session;
						
      function initializeSession() {
        session = OT.initSession(apiKey, sessionId);
       	
        /*
        // Subscribe to a newly created stream

        // Create a publisher
        var publisher = OT.initPublisher('publisher', {
          insertMode: 'append',
          width: '100%',
          height: '100%'
        }, handleError);
		*/

        // Connect to the session
        session.connect(token, function(error) {
          // If the connection is successful, publish to the session
          if (error) {
            handleError(error);
          } else {
           // session.publish(publisher, handleError);
          }
        });
		

        session.on('streamCreated', function(event) {
        	/*
          session.subscribe(event.stream, 'subscriber', {
            insertMode: 'append',
            width: '100%',
            height: '100%'
          }, handleError);
          */
		  // start the timer here
		  	showcall();
		  // end 
        })
		  
      }

     function showcall() {
     	$(document).find("#subscriber")
     		.load(baseurl+"Counselor/showcall",{ crid : cr_id },function() {
     			
     		})
     }

     $(document).on("click",".declinediv",function(){
        $(document).find("#subscriber").children().remove();
     })

     $(document).on("click",".acceptdiv",function(){
      // http://anwdev.ariesvrebuldad.com/classroom/start/2747f2eb32285g5g5g5g
        $(document).find("#subscriber").children().remove();

        var cr   = $(this).data("crid");
        var href = baseurl+"classroom/start/"+cr;
        window.open( href, "Classroom", "width=1166,height=600" );
     })
})()