    var SERVER_BASE_URL = 'https://anwtestcall.herokuapp.com';
      fetch(SERVER_BASE_URL + '/session').then(function(res) {
        return res.json()
      }).then(function(res) {
        apiKey = res.apiKey;
        sessionId = res.sessionId;
        token = res.token;
        initializeSession();
      }).catch(handleError);

      function initializeSession() {
        var session = OT.initSession(apiKey, sessionId);

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
        });

      }

      function handleError(error) {
        if (error) {
          alert(error.message);
        }
      }

