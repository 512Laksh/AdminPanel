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

const Bull = require("bull");
const myFirstQueue = new Bull("bullExample", {
  redis: {
    port: 6379,
    host: "127.0.0.1",
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

  let userName;
  socket.on("username", async(username) => {
    userName = username;
    console.log(username + " connected");
    await db.collection("users").updateOne(
      {name : username},
      {$set :{status : "online"}},
      {upsert : true}
    )
    let user=await db.collection("users").find().toArray()
    io.emit("loggedIn",user)
  });

  socket.on("disconnect", async() => {
    console.log(userName + " disconnected");
      await db.collection("users").updateOne(
      {name : userName},
      {$set :{status : "offline"}},
      {upsert : true}
    )
    let user=await db.collection("users").find().toArray()
    io.emit("loggedIn",user)
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

      myFirstQueue.add(chat);

      // await db.collection("messages").insertOne(chat);
      io.to(room).emit("new-message", chat);
    } catch (err) {
      console.error("Failed to save/send message:", err);
    }
  });


  socket.on('typing', ({ username, sender, receiver }) => {
    const room = [sender, receiver].sort().join("&");
    io.to(room).emit("typing", username);
  });

  socket.on('stop typing', ({ username, sender, receiver }) => {
    const room = [sender, receiver].sort().join("&");
    io.to(room).emit("stop typing", username);
  });
});

const PORT = 3000;
server.listen(PORT, () => console.log(`Server running on port ${PORT}`));
