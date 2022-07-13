<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Chat App Socket.io | CodeCheef</title>
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <style>
            .chat-ul{
                padding: 0;
            }
            .chat-ul li{
                list-style: none;
            }
            .senderName{
                font-size: 12px;
            }
            .message{
                font-size: 15px;
            }
        </style>
    </head>
    <body>

        <div class="container">
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- JavaScript Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.socket.io/4.0.1/socket.io.min.js" integrity="sha384-LzhRnpGmQP+lOvWruF/lgkcqD+WDVt9fU3H4BWmwP5u5LTmkUGafMcpZKNObVMLU" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <script>
            
            @if(Auth::check())
                var user_id = "{{ Auth::user()->id }}";
                var ip_address = "{{ env('APP_HOST') }}";
                var socket_port = "{{ env('SOCKET_PORT') }}";
                let socket = io(ip_address + ':' + socket_port);
            @endif

            @if(request()->has('type'))

                @if(request()->type == 'personal')
                    $(function() {
                        
                        let chatInput = $('.personalChat #chatInput');
                        let messages = [];

                        var sender_id = 3;
                        var receiver_id = 1;

                        chatInput.keypress(function(e) {
                            let message = $(this).html();
                            // console.log(message);
                            if(e.which === 13 && !e.shiftKey) {
                                console.log('hh');

                                axios.post('api/messages/send', {
                                    sender_id: sender_id,
                                    receiver_id: receiver_id,
                                    message: message
                                }).then((resp) => {
                                    // app.messages.push(resp.data)
                                    // app.newMessage = ''
                                })

                                socket.emit('sendChatToServer', user_id , message);
                                $('.chat-content ul').append(`<li><small>${user_id}</small> <br/> ${message}</li>`);
                                chatInput.html('');
                                return false;
                            }
                        });

                        axios.post('api/messages', {
                            sender_id: sender_id,
                            receiver_id: receiver_id,
                            // message: message
                        }).then((resp) => {
                            let messageData =  resp.data.result.messageData;

                            let msgHtml = '';
                            messageData.forEach(function(val){
                                // console.log(val);
                                msgHtml += `<li><small class="senderName text-primary text-capitalize">${val.sender.name}</small> <br/> <span class="message">${val.message}</span></li>`;
                            })

                            $('.chat-content ul').html(msgHtml);
                            messages = messageData;
                            
                            // app.messages.push(resp.data)
                            // app.newMessage = ''
                        })

                        socket.on('sendChatToClient', (user_id,message) => {
                            // console.log('555');
                            $('.chat-content ul').append(`<li><small>${user_id}</small> <br/> ${message}</li>`);
                        });
                    });
                @elseif(request()->type == 'task')
                    $(function() {
                        
                        let chatInput = $('.taskChat #chatInput');
                        let messages = [];

                        var sender_id = 3;
                        var receiver_id = 1;

                        chatInput.keypress(function(e) {
                            let message = $(this).html();
                            // console.log(message);
                            if(e.which === 13 && !e.shiftKey) {

                                axios.post('api/messages/send', {
                                    sender_id: sender_id,
                                    receiver_id: receiver_id,
                                    message: message
                                }).then((resp) => {
                                    // app.messages.push(resp.data)
                                    // app.newMessage = ''
                                })

                                socket.emit('sendTaskMsgServer', user_id , message);
                                $('.chat-content ul').append(`<li><small>${user_id}</small> <br/> ${message}</li>`);
                                chatInput.html('');
                                return false;
                            }
                        });

                        axios.post('api/messages', {
                            sender_id: sender_id,
                            receiver_id: receiver_id,
                            // message: message
                        }).then((resp) => {
                            let messageData =  resp.data.result.messageData;

                            let msgHtml = '';
                            messageData.forEach(function(val){
                                // console.log(val);
                                msgHtml += `<li><small class="senderName text-primary text-capitalize">${val.sender.name}</small> <br/> <span class="message">${val.message}</span></li>`;
                            })

                            $('.chat-content ul').html(msgHtml);
                            messages = messageData;
                            
                            // app.messages.push(resp.data)
                            // app.newMessage = ''
                        })

                        socket.on('sendTaskMsgClient', (user_id,message) => {
                            // console.log('555');
                            $('.chat-content ul').append(`<li><small>${user_id}</small> <br/> ${message}</li>`);
                        });
                    });
                @endif

            @else

                
            @endif
        </script>

        @yield('js')

    </body>
</html>