<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Application</title>

    <style> -->
      <?= $this->extend('user/layout.php');?>
      <?= $this->section('content');?>  
      <link rel="stylesheet" href="<?= base_url("assets/css/chat.css")?>">

    <div class="container">
        <!-- Login Screen -->
        <!-- <div id="login-screen">
            <h2>Chat Login</h2>
            <input type="text" id="username" placeholder="Enter username">
            <button id="login-btn">Login</button>
        </div> -->

        <!-- Main Chat Screen -->
        <div id="chat-screen" class="">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-profile">
                    <span id="current-user"></span>
                </div>
                <!-- <div class="chat-modes">
                    <button class="mode-btn active" data-mode="private">Private</button>
                    <button class="mode-btn" data-mode="broadcast">Broadcast</button>
                </div> -->
                <div id="users-list">
                  <?php foreach($users as $user) : ?>
                    <?php if($user['uname'] != session()->get('user_name')) : ?>
                    <div class="user-item" data-username="<?= $user['uname']?>"><?= $user['uname']?></div>
                    <?php endif; ?>
                  <?php endforeach;?> 
                </div>
            </div>

            <!-- Chat Area -->
            <div class="chat-area">
                <div class="chat-header">
                    <span id="recipient-name">Select a user to chat</span>
                    <span id="chat-mode"></span>
                </div>
                <div id="messages" class="messages-container"></div>
                <div class="message-input">
                    <input type="text" id="message-input" placeholder="Type a message...">
                    <button id="send-btn">Send</button>
                </div>
            </div>
        </div>
    </div>
    <!-- <script src="<?//= base_url("../../../../public/cdn/socket.io.js")?>"></script> -->
    <script src="https://cdn.socket.io/4.8.1/socket.io.min.js" integrity="sha384-mkQ3/7FUtcGyoppY6bz/PORYoGqOl7/aSUMn2ymDOJcapfS6PHqxhRTMh1RR0Q6+" crossorigin="anonymous"></script>
    <!-- <script src="<?//= base_url("assets/javascript/chat.js")?>"></script> -->
    <script>
      const socket = io('http://localhost:3000');

// DOM Elements
const loginScreen = document.getElementById('login-screen');
const chatScreen = document.getElementById('chat-screen');
const usernameInput = document.getElementById('username');
const loginBtn = document.getElementById('login-btn');
const currentUserSpan = document.getElementById('current-user');
const recipientName = document.getElementById('recipient-name');
const chatMode = document.getElementById('chat-mode');
const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');
const messagesContainer = document.getElementById('messages');
const usersList = document.getElementById('users-list');
const modeBtns = document.querySelectorAll('.mode-btn');
const userItem = document.querySelectorAll('.user-item')

// State
let currentUser = null;
let selectedUser = null;
let chatType = 'private';

// Event Listeners
// loginBtn.addEventListener('click', () => {
//     const username = usernameInput.value.trim();
//     if (username) {
//         socket.emit('login', { username });
//     }
// });

const username = "<?= session()->get('user_name')?>";
if(username){
  socket.emit('login', { username });
}

sendBtn.addEventListener('click', sendMessage);
messageInput.addEventListener('keypress', e => {
    if (e.key === 'Enter') sendMessage();
});

modeBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        chatType = btn.dataset.mode;
        modeBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        
        // Reset UI for broadcast mode
        if (chatType === 'broadcast') {
            selectedUser = null;
            recipientName.textContent = 'Broadcasting to all users';
            chatMode.textContent = '(Broadcast Mode)';
            document.querySelectorAll('.user-item').forEach(item => item.classList.remove('active'));
        } else {
            recipientName.textContent = selectedUser ? `Chatting with ${selectedUser.username}` : 'Select a user to chat';
            chatMode.textContent = '(Private Mode)';
        }
        messagesContainer.innerHTML = '';
    });
});

// Socket Events
socket.on('loginSuccess', user => {
    currentUser = user;
    currentUserSpan.textContent = `Logged in as: ${user.username}`;
    // loginScreen.classList.add('hidden');
    // chatScreen.classList.remove('hidden');
});

socket.on('userList', users => {
    usersList.innerHTML = '';
    users.forEach(user => {
        if (user.id !== currentUser?.id) {
            const div = document.createElement('div');
            div.className = 'user-item'
            div.textContent = user.username;
            div.onclick = () => selectUser(user);
            usersList.appendChild(div);
        }
    });
});

// userItem.onclick = () => selectUser();
socket.on('newMessage', message => {
    const div = document.createElement('div');
    
    if (message.type === 'broadcast') {
        div.className = 'message broadcast';
        div.textContent = `${message.from} (Broadcast): ${message.message}`;
    } else {
        div.className = `message ${message.from === currentUser.username ? 'sent' : 'received'}`;
        div.textContent = `${message.from}: ${message.message}`;
    }
    
    messagesContainer.appendChild(div);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});

socket.on('previousMessages', messages => {
    messagesContainer.innerHTML = '';
    messages.forEach(message => {
        const div = document.createElement('div');
        div.className = `message ${message.from === currentUser.username ? 'sent' : 'received'}`;
        div.textContent = `${message.from}: ${message.message}`;
        messagesContainer.appendChild(div);
    });
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});

// Functions
function selectUser(user) {
    if (chatType === 'broadcast') return;
    
    selectedUser = user;
    recipientName.textContent = `Chatting with ${user.username}`;
    
    document.querySelectorAll('.user-item').forEach(item => {
        item.classList.remove('active');
        if (item.textContent === user.usern ame) {
            item.classList.add('active');
        }
    });
    
    socket.emit('loadPreviousMessages', { to: user.id });
}

function sendMessage() {
    const message = messageInput.value.trim();
    if (!message) return;

    if (chatType === 'broadcast') {
        socket.emit('broadcastMessage', { message });
    } else if (selectedUser) {
        socket.emit('privateMessage', { 
            to: selectedUser.id, 
            message 
        });

    } else {
        alert('Please select a user to chat with');
        return;
    }

    messageInput.value = '';
}
    </script>
    <?= $this->endSection('content')?>