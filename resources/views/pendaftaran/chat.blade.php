<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chat - Bd. Ainun</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }

    body {
      background: #6e8f9b;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .chat-wrapper {
      background: #6e8f9b;
      width: 100%;
      max-width: 500px;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Header */
    .chat-header {
      background: #c8dde4;
      padding: 12px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
      flex-shrink: 0;
    }
    .back-btn {
      background: none;
      border: none;
      cursor: pointer;
      padding: 4px;
      display: flex;
      align-items: center;
    }
    .avatar {
      width: 42px;
      height: 42px;
      border-radius: 50%;
      background: linear-gradient(135deg, #a0bec8, #7da8b8);
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      overflow: hidden;
    }
    .avatar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .header-name {
      font-size: 16px;
      font-weight: 600;
      color: #1a3a45;
    }

    /* Chat body */
    .chat-body {
      flex: 1;
      padding: 20px 16px 16px;
      overflow-y: auto;
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .timestamp {
      text-align: center;
      font-size: 12px;
      color: #daeaf0;
      margin: 8px 0 12px;
    }

    /* Bubbles */
    .bubble-wrap {
      display: flex;
      align-items: flex-end;
    }
    .bubble-wrap.left  { justify-content: flex-start; }
    .bubble-wrap.right { justify-content: flex-end; }

    .bubble {
      background: #ffffff;
      border-radius: 16px 16px 16px 4px;
      padding: 10px 14px 8px;
      max-width: 72%;
      font-size: 14px;
      color: #1a3a45;
      line-height: 1.5;
    }
    .bubble.right {
      background: #3a6070;
      color: #ffffff;
      border-radius: 16px 16px 4px 16px;
    }
    .bubble-time {
      font-size: 10px;
      color: #aabcc4;
      margin-top: 4px;
      text-align: right;
    }
    .bubble.right .bubble-time {
      color: #a8c8d5;
    }

    /* Input row */
    .chat-input-row {
      background: #ffffff;
      padding: 10px 12px;
      display: flex;
      align-items: center;
      gap: 10px;
      flex-shrink: 0;
    }
    .chat-input {
      flex: 1;
      border: 1px solid #d0dde2;
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 14px;
      color: #1a3a45;
      outline: none;
      background: #f5f9fb;
      transition: border-color 0.2s;
    }
    .chat-input:focus { border-color: #7db8cc; }
    .chat-input::placeholder { color: #a0b8c0; }
    .send-btn {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: #3a6070;
      border: none;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
      transition: background 0.2s;
    }
    .send-btn:hover { background: #2e4f5c; }
    .send-btn:active { transform: scale(0.97); }
  </style>
</head>
<body>

<div class="chat-wrapper">

  <!-- Header -->
  <div class="chat-header">
    <button class="back-btn" onclick="history.back()">
      <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
           stroke="#3a5f6e" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="14,4 8,11 14,18"/>
      </svg>
    </button>
    <div class="avatar">
      <!-- Ganti src="foto.jpg" dengan foto dokter -->
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
        <circle cx="12" cy="8" r="5" fill="rgba(255,255,255,0.7)"/>
        <ellipse cx="12" cy="21" rx="8" ry="4.5" fill="rgba(255,255,255,0.5)"/>
      </svg>
    </div>
    <div class="header-name">Bd. Ainun</div>
  </div>

  <!-- Chat messages -->
  <div class="chat-body" id="chatBody">
    <div class="timestamp">Today 9:14am</div>

    <div class="bubble-wrap left">
      <div class="bubble">
        Apa masalah anda?
        <div class="bubble-time">9.14</div>
      </div>
    </div>

    <div class="bubble-wrap left">
      <div class="bubble">
        Ada yang bisa kami bantu?
        <div class="bubble-time">9.14</div>
      </div>
    </div>
  </div>

  <!-- Input -->
  <div class="chat-input-row">
    <input
      class="chat-input"
      id="msgInput"
      type="text"
      placeholder="Type message........"
    />
    <button class="send-btn" onclick="sendMessage()">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
        <polygon points="18,2 8,12 2,8" fill="#fff"/>
        <polyline points="18,2 12,18 8,12 2,8 18,2"
                  stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
      </svg>
    </button>
  </div>

</div>

<script>
  function getTime() {
    const now = new Date();
    return now.getHours() + '.' + String(now.getMinutes()).padStart(2, '0');
  }

  function addBubble(text, side) {
    const body = document.getElementById('chatBody');
    const wrap = document.createElement('div');
    wrap.className = 'bubble-wrap ' + side;
    const bubble = document.createElement('div');
    bubble.className = 'bubble' + (side === 'right' ? ' right' : '');
    bubble.innerHTML = escapeHtml(text) + '<div class="bubble-time">' + getTime() + '</div>';
    wrap.appendChild(bubble);
    body.appendChild(wrap);
    body.scrollTop = body.scrollHeight;
  }

  function escapeHtml(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  }

  function sendMessage() {
    const input = document.getElementById('msgInput');
    const text = input.value.trim();
    if (!text) return;
    addBubble(text, 'right');
    input.value = '';
    input.focus();
  }

  document.getElementById('msgInput').addEventListener('keydown', function(e) {
    if (e.key === 'Enter') sendMessage();
  });
</script>

</body>
</html>