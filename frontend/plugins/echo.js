import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
import * as EVNAPP from '@/api/app'
import axios from 'axios'

Pusher.logToConsole = true

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '7c957645c57e4378d473',
    cluster: 'ap1',
    forceTLS: false,
    encrypted: true,
    enabledTransports: ['ws'],
    authorizer: (channel, options) => {
        return {
            authorize: (socketId, callback) => {
                console.log('Authorizing....')
                axios
                    .post(
                        EVNAPP.default.broadcastAuth,
                        {
                            socket_id: socketId,
                            channel_name: channel.name,
                        },
                        {
                            withCredentials: true,
                            headers: {
                                Authorization: 'Bearer ' + localStorage.getItem('auth._token.laravelSanctum'),
                            },
                        }
                    )
                    .then((response) => {
                        console.log('suc', response.data)
                        // eslint-disable-next-line node/no-callback-literal
                        callback(false, response.data)
                    })
                    .catch((error) => {
                        console.log('err', error)
                        // eslint-disable-next-line node/no-callback-literal
                        callback(true, error.data)
                    })
            },
        }
    },
})
