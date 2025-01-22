const express = require("express");
const http = require("http");
const app = express();
// const socketIo = require("socket.io");
// const socketIo = require('socket.io')(httpserver, {
//     cors: {
//     origin: "http://localhost:3000", //specific origin you want to give access to,
//  },
// });

// const express = require('express');
const cors = require("cors");
const { createServer } = require('node:http');
const { Server } = require('socket.io');
// const connection = require('./config/db');
// require("dotenv").config();

// const app = express();
// const activeUsers = new Set();
const server = createServer(app);
const io = new Server(server,{
  cors:{
    origin: 'http://localhost:8080',
    methods: ['GET','POST']
  }
});





const { MongoClient } = require("mongodb");

// const server = http.createServer(app);
// const io = socketIo(server);

const mongoUri = "mongodb://127.0.0.1:27017";
const dbName = "chatApp";
let db, usersCollection, messagesCollection;

async function connectMongo() {
    try {
        const client = await MongoClient.connect(mongoUri);
        db = client.db(dbName);
        usersCollection = db.collection("users");
        messagesCollection = db.collection("messages");
        console.log("Connected to MongoDB");
    } catch (err) {
        console.error("MongoDB connection error:", err);
        process.exit(1);
    }
}

connectMongo();

app.use(express.static("../app/Views/user/chat/chat.php"));

io.on('connection', (socket) => {
socket.on('username', (username) => {
    console.log(username+" connected");
})



socket.on("joinRoom", async ({ sender, receiver }) => {
    const room = [sender, receiver].join("&");
    console.log(`${sender} joined room ${room}`);
    socket.join(room);

    try {
      const messages = await usersCollection.find({
          $or: [
            { sender, receiver },
            { sender: receiver, receiver: sender },
          ],
        })
        .sort({ timestamp: 1 })
        .toArray();
        console.log(messages);
      socket.emit("previousMessages", messages);
    } catch (err) {
      console.error("Error fetching messages:", err);
    }
});


socket.on("send-message", async ({ sender, receiver, message }) => {
    try {
      const room = [sender, receiver].sort().join("_");

      const chat = {
        sender,
        receiver,
        message,
        timestamp: new Date(),
      };

      console.log(chat);
      await db.collection("messages").insertOne(chat);

      io.to(room).emit("new-message", chat);
    } catch (err) {
      console.error("Failed to save/send message:", err);
    }

})
})



































































































// const users = new Map();

// io.on("connection", (socket) => {
//     console.log("User connected:", socket.id);

//     socket.on("login", async ({ username }) => {
//         if (!username?.trim()) {
//             return socket.emit("loginError", "Username is required");
//         }
//         console.log(username)
//         const user = { id: socket.id, username: username.trim() };
//         users.set(socket.id, user);

//         try {
//             await usersCollection.updateOne(
//                 { id: socket.id },
//                 { $set: user },
//                 { upsert: true }
//             );
//             socket.emit("loginSuccess", user);
//             io.emit("userList", Array.from(users.values()));
//         } catch (err) {
//             socket.emit("loginError", "Database error");
//             console.error("MongoDB error:", err);
//         }
//         console.log(users)
//     });
// // console.log(users)
//     socket.on("privateMessage", async ({ to, message }) => {
//         const sender = users.get(socket.id);
//         const recipient = users.get(to);

//         if (!sender || !recipient || !message?.trim()) {
//             return socket.emit("errorMessage", "Invalid message or recipient");
//         }

//         const messageData = {
//             from: sender.username,
//             to: recipient.username,
//             message: message.trim(),
//             type: "private",
//             timestamp: new Date()
//         };

//         try {
//             await messagesCollection.insertOne(messageData);
//             socket.emit("newMessage", messageData);
//             io.to(to).emit("newMessage", messageData);
//         } catch (err) {
//             socket.emit("errorMessage", "Failed to send message");
//             console.error("MongoDB error:", err);
//         }
//     });

//     socket.on("broadcastMessage", async ({ message }) => {
//         const sender = users.get(socket.id);
        
//         if (!sender || !message?.trim()) {
//             return socket.emit("errorMessage", "Invalid message");
//         }

//         const messageData = {
//             from: sender.username,
//             message: message.trim(),
//             type: "broadcast",
//             timestamp: new Date()
//         };

//         try {
//             await messagesCollection.insertOne(messageData);
//             io.emit("newMessage", messageData);
//         } catch (err) {
//             socket.emit("errorMessage", "Failed to broadcast message");
//             console.error("MongoDB error:", err);
//         }
//     });

//     socket.on("loadPreviousMessages", async ({ to }) => {
//         const sender = users.get(socket.id);
//         const recipient = users.get(to);

//         if (!sender || !recipient) {
//             return socket.emit("errorMessage", "Invalid request");
//         }

//         try {
//             const messages = await messagesCollection
//                 .find({
//                     $or: [
//                         { 
//                             from: sender.username, 
//                             to: recipient.username,
//                             type: "private"
//                         },
//                         { 
//                             from: recipient.username, 
//                             to: sender.username,
//                             type: "private"
//                         }
//                     ]
//                 })
//                 .sort({ timestamp: 1 })
//                 .limit(50)
//                 .toArray();

//             socket.emit("previousMessages", messages);
//         } catch (err) {
//             socket.emit("errorMessage", "Failed to load messages");
//             console.error("MongoDB error:", err);
//         }
//     });

//     socket.on("disconnect", async () => {
//         const user = users.get(socket.id);
//         if (user) {
//             users.delete(socket.id);
//             try {
//                 await usersCollection.deleteOne({ id: socket.id });
//                 io.emit("userList", Array.from(users.values()));
//             } catch (err) {
//                 console.error("MongoDB error:", err);
//             }
//         }
//     });
// });

const PORT = 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));