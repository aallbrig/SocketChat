    $(function(){
      var name = prompt("What is your name?");
      var sendBtn = $('#send');
      var clearBtn = $('#clear');
      var messageInput = $('#message');
      var chatOutput = $('#chat');
      var people = $('#names');
      function chatMessageTemplaet(obj){
        return "<p><span class='chatName'>" + obj.name + "</span>" + obj.message + "</p>";
      }
      function nameDisplayTemplate(obj){
        return "<li class='list-group-item'>" + obj.name + "</li>";
      }
      function addPerson(obj){
        people.append(nameDisplayTemplate(obj));
      }
      function sendMessage (message) {
        socket.message('app.chatMessage', {name:name, message:message});
      }
      function addMessageToOutput (obj) {
        chatOutput.append(chatMessageTemplaet(obj));

      }
      function clearInput () {
        messageInput.val('');
      }
      // Events
      sendBtn.click(function(e){
        var message = messageInput.val();
        clearInput();
        sendMessage(message);
      });
      messageInput.keypress(function(e){
        if(e.which == 13) {
          var message = messageInput.val();
          clearInput();
          sendMessage(message);
        }
      });
      var socket = new BrainSocket(
        new WebSocket('ws://localhost:8080'),
        new BrainSocketPubSub()
      );
      socket.connection.onopen = function(){
        console.log('connection open');
        socket.message('app.personJoin', {name:name});
        socket.message('app.getPeople');
      }
      socket.connection.onclose = function(){
        console.log('connection closed');
        socket.message('app.personLeave', {name:name});
      }
      window.onbeforeunload = socket.connection.onclose;
      console.log(socket);
      socket.Event.listen('app.chatMessage',function(msg){
          console.log(msg);
          addMessageToOutput(msg.client.data);
      });
      socket.Event.listen('app.sendPeople', function(msg){
        // list of people currently in chat
        for(key in msg.server.data) {
          console.log(msg.server.data[key]);
          addPerson(msg.server.data[key]);
        };
      });
      socket.Event.listen('app.personJoin',function(msg){
          console.log(msg);
          if(msg.client.data.name == name) return;
          addPerson(msg.client.data);
      });
      socket.Event.listen('app.success',function(msg){
          console.log(msg);
      });
      socket.Event.listen('app.error',function(msg){
          console.log(msg);
      });
    });