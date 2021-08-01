function ChatClient() {
	this.getMessages = function(callback, lastRun) {
		var t = this;
		var lastest = null;
		$.ajax({
			url: 'chat.get.php',
			type: 'POST',
			dataType: 'json',
			data: {'lastRun': lastRun},
			timeout: 30000,
			cache: false,
			success: function(result) {
				//convert json response
				var obj = $.parseJSON(result);
				if(obj.result) {
					callback(obj.msg);
					lastest = obj.last;
				}
				console.log(obj.output);
			},
			error: function(e) {
				console.log(e);
			},
			completed: function() {
				t.getMessages(callback, lastRun);
			}
		});
	};
};

var c = new ChatClient();

$(document).ready(function() {
	c.getMessages(function(message) {
		var chat = $('#chatList').empty();

		for(var i = 0;i < message.lenght;i++) {
			chat.append('<div class="well-sm"><p>'+message[i].text+'</p></div>');
		}

		$('#chatList').scrollTop($('#chatList')[0].scrollHeight);
	});
});