import './bootstrap';
import 'tom-select/dist/css/tom-select.default.css';
import TomSelect from 'tom-select';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.TomSelect = TomSelect;
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'your-pusher-app-key',
    cluster: 'your-pusher-cluster',
    forceTLS: false
});

window.Echo.channel('user.' + window.userId)
    .listen('MatchRequestSent', (event) => {
        console.log(event);
        Livewire.emit('updateNotifications', event.matchRequest);
    });
