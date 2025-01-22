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
loginBtn.addEventListener('click', () => {
    const username = usernameInput.value.trim();
    if (username) {
        socket.emit('login', { username });
    }
});

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
    loginScreen.classList.add('hidden');
    chatScreen.classList.remove('hidden');
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
userItem.onclick = () => selectUser(currentUser);
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
        if (item.textContent === user.username) {
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