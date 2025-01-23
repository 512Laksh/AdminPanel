const express = require("express");
const http = require("http");
const app = express();
const cors = require("cors");
const { createServer } = require("node:http");
const { Server } = require("socket.io");
const server = createServer(app);
const io = new Server(server, {
  cors: {
    origin: "http://localhost:8080",
    methods: ["GET", "POST"],
  },
});

const { MongoClient } = require("mongodb");

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

io.on("connection", (socket) => {
  socket.on("username", (username) => {
    console.log(username + " connected");
    // socket.emit('online', username)
  });
  
  socket.on("joinRoom", async ({ sender, receiver }) => {
    const room = [sender, receiver].sort().join("&");
    console.log(`${sender} joined room ${room}`);
    socket.join(room);

    try {
      const messages = await db
        .collection("messages")
        .find({
          $or: [
            { sender, receiver },
            { sender: receiver, receiver: sender },
          ],
        })
        .sort({ timestamp: 1 })
        .toArray();
      // console.log(messages);
      socket.emit("previousMessages", messages);
    } catch (err) {
      console.error("Error fetching messages:", err);
    }
  });

  socket.on("send-message", async ({ sender, receiver, message }) => {
    try {
      const room = [sender, receiver].sort().join("&");

      const chat = {
        sender,
        receiver,
        message,
        timestamp: new Date(),
      };

      await db.collection("messages").insertOne(chat);
      // console.log(chat);
      io.to(room).emit("new-message", chat);
    } catch (err) {
      console.error("Failed to save/send message:", err);
    }
  });
});

const PORT = 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));
