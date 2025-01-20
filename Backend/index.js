const express = require('express');
const { Server } = require('socket.io');
const app = express();
const http = require('http');
const server = http.createServer(app);
const io = new Server(server, {
    connectionStateRecovery: {}
  });
const port = 3000;

app.get('/',(req,res)=>{
    res.send('../app/Views/user/chat.php')
})

io.on('connection', (socket) => {
    console.log('A user connected');

    socket.on('chat message', (msg) => {
        io.emit('chat message', msg);
    console.log('message: '+msg);
    })

    socket.on('disconnect', () => {
        console.log('A user disconnected');
    });
    
});

server.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});