<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Application</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
    }

    #sidebar {
      width: 25%;
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      box-sizing: border-box;
      overflow-y: auto;
    }

    #sidebar h2 {
      margin-top: 0;
    }

    #userList {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    #userList li {
      padding: 10px;
      margin: 5px 0;
      background-color: #34495e;
      cursor: pointer;
      border-radius: 5px;
    }

    #userList li:hover {
      background-color: #1abc9c;
    }

    #chatArea {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    #messages {
      flex: 1;
      padding: 20px;
      box-sizing: border-box;
      overflow-y: auto;
      background-color: #ecf0f1;
    }

    #messages .message {
      margin: 10px 0;
      max-width: 60%;
      padding: 10px;
      border-radius: 10px;
      line-height: 1.4;
    }

    #messages .sent {
      background-color: #3498db;
      color: white;
      align-self: flex-end;
    }

    #messages .received {
      background-color: #95a5a6;
      color: white;
      align-self: flex-start;
    }

    #messageForm {
      display: flex;
      padding: 20px;
      box-sizing: border-box;
      background-color: #bdc3c7;
    }

    #messageInput {
      flex: 1;
      padding: 10px;
      border: 1px solid #7f8c8d;
      border-radius: 5px;
      outline: none;
    }

    #sendButton {
      padding: 10px 20px;
      margin-left: 10px;
      background-color: #2c3e50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    #sendButton:hover {
      background-color: #1abc9c;
    }
  </style>
</head>
<body>
  <div id="sidebar">
    <h2>Users</h2>
    <ul id="userList">laksh</ul>
  </div>
  <div id="chatArea">
    <div id="messages"></div>
    <form id="messageForm">
      <input type="text" id="messageInput" placeholder="Type a message" required />
      <button type="submit" id="sendButton">Send</button>
    </form>
  </div>

  <script src="Backend/socket.io/socket.io.js"></script>
  <script>
    const socket = io("http://localhost:3000");

    // Simulated current user for demonstration (replace with your token logic)
    const currentUser = { username: "JohnDoe" };

    // Sidebar user list
    const userList = ["Alice", "Bob", "Charlie"];
    const userListElement = document.getElementById("userList");
    let selectedUser = null;

    // Populate the user list
    userList.forEach((user) => {
      const userElement = document.createElement("li");
      userElement.textContent = user;
      userElement.addEventListener("click", () => {
        selectedUser = user;
        document.getElementById("messages").innerHTML = `<h3>Chat with ${user}</h3>`;
      });
      userListElement.appendChild(userElement);
    });

    // Send message functionality
    const messageForm = document.getElementById("messageForm");
    const messageInput = document.getElementById("messageInput");
    const messagesDiv = document.getElementById("messages");

    messageForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const messageText = messageInput.value;

      if (!selectedUser) {
        alert("Please select a user to chat with!");
        return;
      }

      // Display the sender's message in the chat
      displayMessage(messageText, "sent");

      // Emit the message via socket (private message logic)
      socket.emit("privateMessage", {
        to: selectedUser,
        message: messageText,
        from: currentUser.username,
      });

      messageInput.value = ""; // Clear the input field
    });

    // Receive a private message
    socket.on("privateMessage", ({ message, from }) => {
      if (from === selectedUser) {
        displayMessage(message, "received");
      }
    });

    // Function to display a message in the chat
    function displayMessage(message, type) {
      const messageElement = document.createElement("div");
      messageElement.textContent = message;
      messageElement.classList.add("message", type);
      messagesDiv.appendChild(messageElement);
      messagesDiv.scrollTop = messagesDiv.scrollHeight; // Auto-scroll
    }
  </script>
</body>
</html>