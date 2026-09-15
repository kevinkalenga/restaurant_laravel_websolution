 function scrollToBottom() {
            let chatContent = $('.chat-content')
            chatContent.scrollTop(chatContent.prop("scrollHeight"));
        }

if (loggedInUserId) {
    window.Echo.private('chat.' + loggedInUserId)
        .listen('.ChatEvent', (e) => {

            console.log('CHAT REÇU ADMIN:', e);

            if(e.senderId == $('#mychatbox').attr('data-inbox')) {

            

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
            }

            // Show message notification 
            $(".fp_chat_user").each(function(){
                let senderId = $(this).data('user');
                if(e.senderId == senderId){
                   let html = `<i class="beep"></i>new message`;

                   $(this).find(".got_new_message").html(html)
                   
                }
            })

            $('.message-envelope').addClass('beep')
           
        });
}