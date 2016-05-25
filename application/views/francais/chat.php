<center>
    <div class=comment style="position:relative;margin-top:20px;width:350px;height:550px;padding:0px;">
        <h1 style="color:#aab8c2"> Moi et <?php echo $user['username'],'(',$user['discr'],')';?> </h1>
        <nav id="nav_scroll">
            <ul class="messages">
                <?php foreach($messages as $message):
							if ($message['sender'] === $my_id):?>
                <li class="message2 left">
                    <?php echo $my_username.":</br>";
							else:?>
                    <li class="message2 right">
                        <?php echo $user['username'].":</br>";
							endif;
						  echo $message['data'];?>
                    </li>
                    <?php endforeach; ?>
            </ul>
        </nav>
        <form id="chat" action="">
            <div id="sendmessage">
                <input type="text" id="message_box" autocomplete="off" placeholder="Envoyer le message..." />
                <button id="send"></button>
            </div>
        </form>
    </div>
</center>

<script src="http://autobahn.s3.amazonaws.com/js/autobahn.min.js"></script>
<script>
    $(document).ready(function() {
				var $cont = $('nav ul');
				$cont[0].scrollTop = $cont[0].scrollHeight;

        var conn = new ab.Session('ws://178.148.74.218:8080',
            function() {
                conn.subscribe("<?php echo $chat_id;?>", function(topic, message) {
                    $('.messages').append(
                        $('<li>').attr('class', 'message2 ' + ((message.sender == <?php echo $my_id;?>) ? 'left' : 'right')).append(((message.sender == <?php echo $my_id;?>) ? "<?php echo $my_username.":<br/>";?>": "<?php echo $user['username'].":<br/>";?>") + message.data)
                    );
                    $('nav, ul').animate({scrollTop: $("nav ul")[0].scrollHeight}, 'slow');
										// $cont[0].scrollTop = $cont[0].scrollHeight;
                });
            },
            function() {
                console.warn('WebSocket connection closed');
            }, {
                'skipSubprotocolCheck': true
            }
        );

        $('#send').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "chat/send_message",
                data: {
                    chat_id: <?php echo $chat_id;?>,
                    msg_text: $("#message_box").val()
                },
                dataType: "text",
                cache: false,
                // success: function(data) {
                //     alert(data); //as a debugging message.
                // }
            });
            document.getElementById('message_box').value = '';
        });
    });
    $(window).bind('beforeunload', function() {
        $.ajax({
            type: "POST",
            url: "chat/set_user_id",
            data: {
                user_id: <?php echo $user['id'];?>
            },
            dataType: "text",
            cache: false,
            // success: function(data) {
            //     alert(data); //as a debugging message.
            // }
        });
        //prevent dialog -> undefined
        return undefined;
    });
</script>
