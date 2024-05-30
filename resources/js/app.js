import './bootstrap';
import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

window.Echo.channel('pengguna-channel')
    .listen('pengguna-event', (data) => {
        alert(data.message); // Ubah dengan logika Anda untuk menampilkan notifikasi
    });
