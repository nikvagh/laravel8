const express = require('express');
const app = express();
const server = require('http').createServer(app);
const io = require('socket.io')(server, {
    cors: { origin: "*"}
});

// io.on('connection', (socket) => {
//     console.log('connection');

//     socket.on('sendChatToServer', (message) => {
//         // console.log(message);

//         // io.sockets.emit('sendChatToClient', message); 
//         socket.broadcast.emit('sendChatToClient', message);
//     });

//     socket.on('disconnect', (socket) => {
//         console.log('Disconnect');
//     });
// });

// =====================

io.on('connection', (socket) => {
    console.log('connection');

    socket.on('sendChatToServer', (user_id,message) => {
        socket.broadcast.emit('sendChatToClient', user_id, message);
    });

    // socket.on('sendTaskMsgServer', (message) => {
    //     console.log('taskMsg');
    //     socket.broadcast.emit('sendTaskMsgClient', message);
    // });

    socket.on('disconnect', (socket) => {
        console.log('Disconnect');
    });

});

server.listen(3000, () => {
    console.log('Server is running');
});
// ===================

// var Redis = require('ioredis');
// var redis = new Redis();
// redis.subscribe('channel-name', function(err, count) {
// });
// redis.on('message', function(channel, message) {
//     console.log('Message Recieved: ' + message);
//     message = JSON.parse(message);
//     io.emit(channel + ':' + message.event, message.data);
// });
// server.listen(3000, function(){
//     console.log('Listening on Port 3000');
// });