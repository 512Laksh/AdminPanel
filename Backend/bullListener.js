const Bull = require('bull');
const myFirstQueue = new Bull('bullExample', { redis: { 
    port: 6379, 
    host: '127.0.0.1' 
} 
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




myFirstQueue.process( async(job, done ) => {
    console.log("Data", job.data );
    try{
        await db.collection("messages").insertOne(job.data);
    }catch(er){
        console.log("Error inserting message", er);
    }
    done();
});

myFirstQueue.on('completed', job => {
    console.log(`Job with id ${job.id} has been completed`);
    job.remove();
})