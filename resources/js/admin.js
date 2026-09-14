 function scrollToBottom() {
            let chatContent = $('.chat-content')
            chatContent.scrollTop(chatContent.prop("scrollHeight"));
        }

if (loggedInUserId) {
    window.Echo.private('chat.' + loggedInUserId)
        .listen('.ChatEvent', (e) => {

            console.log('CHAT REÇU ADMIN:', e);

            let html = `
                <div class="chat-item chat-left">
                    <img src="${e.avatar}" alt="avatar">
                    <div class="chat-details">
                        <div class="chat-text">${e.message}</div>
                        <div class="chat-time">sending...</div>
                    </div>
                </div>
            `;

            $('.chat-content').append(html);
            scrollToBottom();
           
        });
}