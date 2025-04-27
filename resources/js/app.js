import './bootstrap';
import 'tom-select/dist/css/tom-select.default.css';
import TomSelect from 'tom-select';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.TomSelect = TomSelect;
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',  // We'll still use Pusher for local testing
    key: 'your-pusher-app-key',  // Can be any dummy key for local testing
    cluster: 'your-pusher-cluster',  // Use a dummy cluster as well
    forceTLS: false
});

window.Echo.channel('user.' + window.userId)  // Replace `userId` with the authenticated user's ID
    .listen('MatchRequestSent', (event) => {
        console.log(event);  // Check if the event is coming through
        // Optionally, update the Livewire component
        Livewire.emit('updateNotifications', event.matchRequest);
    });
