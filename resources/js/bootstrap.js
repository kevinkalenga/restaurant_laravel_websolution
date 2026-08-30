import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: window.pusherConfig.key,
    cluster: window.pusherConfig.cluster,
    forceTLS: true,
});

window.Echo.channel('order-placed')
    .listen('RTOrderPlacedNotificationEvent', (e) => {
        console.log('PUSHER EVENT RECEIVED:', e);
    });