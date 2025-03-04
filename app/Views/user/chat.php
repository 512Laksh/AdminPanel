<?= $this->extend('user/layout.php');?>
<?= $this->section('content');?>
  <div class="chat">
    <div id="sidebar">
    <h2>Users</h2>
    <ul id="userList"></ul>
  </div>
  <div id="chatArea">
    <div id="messages"></div>
    <form id="messageForm">
      <input type="text" id="messageInput" placeholder="Type a message" required />
      <button type="submit" id="sendButton">Send</button>
    </form>
  </div>
  </div>
  <script src="/socket.io/socket.io.js"></script>
  <script>
    const socket = io();

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
        document.getElementById("messages").innerHTML = <h3>Chat with ${user}</h3>;
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

<?= $this->endSection('content');?>