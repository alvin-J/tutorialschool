(function(){
	var SERVER_BASE_URL = 'https://anwtestcall.herokuapp.com';
 // var SERVER_BASE_URL = 'https://anwanothertestcall.herokuapp.com'; 
 
    fetch(SERVER_BASE_URL + '/session').then(function(res) {
       return res.json()
    }).then(function(res) {
        apiKey    = res.apiKey;
    	sessionId = sesid;
 		token     = tok;

console.log(sesid);
console.log("--------");
console.log(tok);

 		makeacall();

	}).catch(handleError);

    function handleError(error) {
    	alert("error");
    }

    var session;

      function makeacall() {
        session = OT.initSession(apiKey, sessionId);

        // Subscribe to a newly created stream

        // Create a publisher
        var publisher = OT.initPublisher('publisher', {
          insertMode: 'append',
          width: '100%',
          height: '100%'
        }, handleError);

        // Connect to the session
        session.connect(token, function(error) {
          // If the connection is successful, publish to the session
          if (error) {
            handleError(error);
          } else {
            session.publish(publisher, handleError);
          }
        });
	
        session.on('streamCreated', function(event) {
          session.subscribe(event.stream, 'subscriber', {
            insertMode: 'append',
            width: '100%',
            height: '100%'
          }, handleError);
		  // start the timer here
			alert("here");
		  // end 
        })
		  
      }

})()