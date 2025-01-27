<?= $this->extend('user/layout.php'); ?>
<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url("assets/css/chat.css") ?>">

<div class="container1">
    <h3 class=" text-center">Messaging</h3>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Chats</h4>
                    </div>
                </div>
                <div class="inbox_chat">

                    <?php foreach ($users as $user): ?>
                        <?php if ($user['uname'] != session()->get('user_name')): ?>
                            <div class="chat_list" data-username="<?= $user['uname'] ?>">
                                <div class="chat_people">
                                    <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png"
                                            alt="sunil"> </div>
                                    <div class="chat_ib">
                                        <h5><?= $user['uname'] ?><span class="chat_date"></span></h5>
                                        <p id="status" data-username="<?= $user['uname'] ?>"></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div>
            </div>
            <div class="mesgs">
                <div class="chatting">
                    <h4 id="receiver">Select a chat </h4>
                    <p id="ol"></p>
                </div>
                <div class="msg_history"></div>

                <div class="type_msg hidden">
                    <div class="input_msg_write d-flex m-2">
                        <input type="text" class="write_msg border border-1 " id="write_msg"
                            placeholder="Type a message" />
                        <button id="send-btn" type="button"><i class="fa fa-paper-plane"
                                aria-hidden="true"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <script src=" <?= base_url("cdn/socket.io.js") ?>"></script>
        <script>

            const socket = io('http://localhost:3000');

            // DOM Elements

            const currentUserSpan = document.getElementById('current-user');
            const recipientName = document.getElementById('recipient-name');
            const messageInput = document.getElementById('write_msg');
            const sendBtn = document.getElementById('send-btn');
            const usersList = document.getElementById('users-list');
            const userItem = document.querySelectorAll('.chat_list')
            const status = document.querySelectorAll('#status')
            // State
            let currentUser = null;
            let receiver = null;
            var typing = false;
            var timeout;
            let username = "<?= session()->get('user_name') ?>"
            socket.emit('username', username);


            messageInput.addEventListener('keypress', () => {
                if (!typing) {
                    typing = true;
                    socket.emit('typing', {
                        username: username,
                        sender: username,
                        receiver:receiver
                    });
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        typing = false;
                        socket.emit('stop typing', {
                        username: username,
                        sender: username,
                        receiver:receiver
                    });
                    }, 2000);
                }
            });

            socket.on('typing', function (data) {
                var typingMessage = document.getElementById('typing');
                if (!typingMessage && receiver==data) {
                    typingMessage = document.createElement('p');
                    typingMessage.id = 'typing';
                    typingMessage.textContent ='typing...';
                    document.querySelector('.chatting').appendChild(typingMessage);
                }
            });

            socket.on('stop typing', function () {
                var typingMessage = document.getElementById('typing');
                if (typingMessage) {
                    typingMessage.remove();
                }
            });

            socket.on('loggedIn', data => {
                console.log(data);
                status.forEach(p => {
                    data.forEach(element => {
                        if (element.name == p.dataset.username) {
                            if (element.status == "online") {
                                p.innerHTML = "<span class='dot dot-sm dot-success'></span>" + element.status
                                p.setAttribute(data - status, element.status)
                            } else {
                                p.innerHTML = "<span class='dot dot-sm dot-danger'></span>" + element.status
                                p.setAttribute(data - status, element.status)
                            }
                        }
                    });
                });
            })


            userItem.forEach(user => {
                user.addEventListener('click', () => {
                    document.querySelector(".type_msg").classList.remove('hidden')
                    receiver = user.dataset.username;
                    document.getElementById('receiver').textContent = receiver
                    let chatHistory = document.querySelector('.msg_history')
                    chatHistory.innerHTML = '';
                    socket.emit('joinRoom', {
                        sender: username,
                        receiver: receiver
                    });
                });
            });


            function sendMessage() {
                const message = messageInput.value.trim();
                if (message && receiver) {
                    socket.emit('send-message', {
                        sender: username,
                        receiver: receiver,
                        message: message
                    });
                    messageInput.value = '';
                }
            }

            socket.on('previousMessages', (messages) => {
                let chatHistory = document.querySelector('.msg_history')
                messages.forEach(msg => {
                    const date = new Date(msg.timestamp);
                    const messageDiv = document.createElement('div');
                    if (msg.sender === username) {
                        messageDiv.innerHTML = `
                        <div class="sent_msg">
                            <p>${msg.message}</p>
                            <span class="time_date"> ${date.getHours()}:${date.getMinutes()} | ${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}</span>
                        </div>
                        `
                        messageDiv.classList.add('outgoing_msg')
                    } else {
                        messageDiv.innerHTML = `
                        <div class="received_msg">
                            <div class="received_withd_msg">
                            <p>${msg.message}</p>
                            <span class="time_date"> ${date.getHours()}:${date.getMinutes()} | ${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}</span>
                        </div>
                        </div>
                        `
                        messageDiv.classList.add('incoming_msg')
                    }
                    chatHistory.appendChild(messageDiv);
                    chatHistory.scrollTop = chatHistory.scrollHeight;
                });
            });

            socket.on('new-message', (message) => {
                const date = new Date(message.timestamp);
                let chatHistory = document.querySelector('.msg_history')
                const messageDiv = document.createElement('div');
                if (message.sender === username) {
                    messageDiv.innerHTML = `
                        <div class="outgoing_msg">
                        <div class="sent_msg">
                            <p>${message.message}</p>
                            <span class="time_date"> ${date.getHours()}:${date.getMinutes()} | ${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}</span>
                        </div>
                        </div>
                        `
                } else {
                    messageDiv.innerHTML = `
                        <div class="incoming_msg">
                        <div class="received_msg">
                            <div class="received_withd_msg">
                                <p>${message.message}</p>
                            <span class="time_date"> ${date.getHours()}:${date.getMinutes()} | ${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}</span>
                            </div>
                        </div>
                        </div>
                        `
                }
                chatHistory.appendChild(messageDiv);
                chatHistory.scrollTop = chatHistory.scrollHeight;
            });


            sendBtn.addEventListener('click', sendMessage);
            messageInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

        </script>
        <?= $this->endSection('content') ?>