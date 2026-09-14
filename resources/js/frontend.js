
import './bootstrap';

console.log('USER ID:', loggedInUserId);
if (loggedInUserId) {
    window.Echo.private('chat.' + loggedInUserId)
        .listen('.ChatEvent', (e) => {

            console.log('CHAT REÇU:', e);

            let html = `
                <div class="fp__chating">
                    <div class="fp__chating_img">
                        <img src="${e.avatar}" class="img-fluid w-100">
                    </div>
                    <div class="fp__chating_text">
                        <p>${e.message}</p>
                    </div>
                </div>
            `;

            $('.fp__chat_body').append(html);
        });
}