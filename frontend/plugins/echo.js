import Echo from 'laravel-echo'

export default function ({ $axios }) {
    window.Pusher = require('pusher-js')
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: '09706933cb698727cfc2',
        cluster: 'ap1',
        forceTLS: true,

        authorizer: (channel, options) => {
            return {
                authorize: (socketId, callback) => {
                    $axios
                        .$post('api/broadcasting/auth', {
                            socket_id: socketId,
                            channel_name: channel.name,
                        })
                        .then((response) => {
                            callback(false, response)
                        })
                        .catch((error) => {
                            callback(true, error)
                        })
                },
            }
        },
    })
}
