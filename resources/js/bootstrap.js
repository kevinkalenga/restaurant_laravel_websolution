import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Echo.channel('order-placed')
      .listen('RTOrderPlacedNotificationEvent', (e) => {
         console.log(e)
      })
