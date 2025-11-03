<!-- Chatbot -->
<div id="chatbot-container" 
     style="position: fixed; bottom: 100px; right: 24px; width: 340px; background: white; border: 1px solid #ddd; border-radius: 20px; box-shadow: 0 6px 20px rgba(0,0,0,0.25); display: none; z-index: 99999; overflow: hidden;">
    <div style="background-color: #8D85EC; color: white; padding: 12px 16px; font-weight: bold; display: flex; justify-content: space-between; align-items: center;">
        <span>💬 EventBot</span>
        <button id="closeChat" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">×</button>
    </div>

    <div id="chat-content" 
         style="height: 260px; overflow-y: auto; padding: 16px; font-size: 14px; color: #333; display: flex; flex-direction: column; gap: 10px;">
        <p style="text-align: center; color: gray;">Hello 👋! How can I help you today?</p>
    </div>

    <div style="display: flex; border-top: 1px solid #ddd;">
        <input id="chat-input" type="text" placeholder="Type a message..." 
               style="flex: 1; border: none; padding: 10px; outline: none; font-size: 14px;">
        <button id="sendChat" 
                style="background-color: #8D85EC; color: white; border: none; padding: 10px 15px; font-weight: 600; cursor: pointer;">
            Send
        </button>
    </div>
</div>

<!-- Floating Chat Button -->
<button id="openChat" 
        style="position: fixed; bottom: 24px; right: 24px; background: linear-gradient(135deg, #8D85EC, #6C63FF); color: white; border: none; border-radius: 50%; width: 70px; height: 70px; font-size: 28px; cursor: pointer; box-shadow: 0 8px 20px rgba(0,0,0,0.3); z-index: 99999; transition: all 0.3s ease;">
    💬
</button>

<style>
/* Message bubble styles */
.chat-message {
    max-width: 80%;
    padding: 8px 12px;
    border-radius: 12px;
    line-height: 1.4;
    word-wrap: break-word;
    position: relative;
}

.user-message {
    align-self: flex-end;
    background-color: #8D85EC;
    color: white;
    border-bottom-right-radius: 4px;
}

.bot-message {
    align-self: flex-start;
    background-color: #f3f3f3;
    color: #333;
    border-bottom-left-radius: 4px;
}

.message-time {
    font-size: 11px;
    color: gray;
    margin-top: 2px;
}

/* Glow + Hover animation for floating button */
#openChat:hover {
    transform: scale(1.1);
    box-shadow: 0 0 20px rgba(141, 133, 236, 0.8);
}

/* Small bounce animation when page loads */
@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-5px); }
}
#openChat {
  animation: bounce 2s infinite;
}
</style>

<script>
document.getElementById('openChat').addEventListener('click', () => {
    document.getElementById('chatbot-container').style.display = 'block';
    document.getElementById('openChat').style.display = 'none';
});

document.getElementById('closeChat').addEventListener('click', () => {
    document.getElementById('chatbot-container').style.display = 'none';
    document.getElementById('openChat').style.display = 'block';
});

document.getElementById('sendChat').addEventListener('click', sendMessage);
document.getElementById('chat-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') sendMessage();
});

function formatTime() {
    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes().toString().padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12;
    return `${hours}:${minutes} ${ampm}`;
}

function sendMessage() {
    const input = document.getElementById('chat-input');
    const chatContent = document.getElementById('chat-content');
    const userMessage = input.value.trim();
    if (!userMessage) return;

    const time = formatTime();
    const userBubble = `
        <div style="display:flex; flex-direction:column; align-items:flex-end;">
            <div class='chat-message user-message'>${userMessage}</div>
            <span class='message-time'>${time}</span>
        </div>`;
    chatContent.innerHTML += userBubble;
    input.value = '';
    chatContent.scrollTop = chatContent.scrollHeight;

    fetch("{{ route('chatbot.message') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ message: userMessage })
    })
    .then(res => res.json())
    .then(data => {
        const botTime = formatTime();
        const botBubble = `
            <div style="display:flex; flex-direction:column; align-items:flex-start;">
                <div class='chat-message bot-message'>${data.reply}</div>
                <span class='message-time'>${botTime}</span>
            </div>`;
        chatContent.innerHTML += botBubble;
        chatContent.scrollTop = chatContent.scrollHeight;
    })
    .catch(() => {
        const errorBubble = `
            <div style="display:flex; flex-direction:column; align-items:flex-start;">
                <div class='chat-message bot-message' style='color:red;'>Error connecting to server.</div>
                <span class='message-time'>${formatTime()}</span>
            </div>`;
        chatContent.innerHTML += errorBubble;
    });
}
</script>
