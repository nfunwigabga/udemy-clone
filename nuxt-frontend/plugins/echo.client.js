import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
window.Pusher = Pusher

export default defineNuxtPlugin((nuxtApp) => {
    const config = useRuntimeConfig()
    const {$api} = useNuxtApp()

    const echo = new Echo({
        broadcaster: "pusher",
        key: config.public.PUSHER_APP_KEY,
        cluster: config.public.PUSHER_APP_CLUSTER,
        wsHost: config.public.PUSHER_APP_HOST,
        wssHost: config.public.PUSHER_APP_HOST,
        wsPort: config.public.PUSHER_APP_PORT,
        wssPort: config.public.PUSHER_APP_PORT,
        forceTLS: false, // set to true in prod
        disableStats: true,
        enabledTransports: ["ws", "wss"],
        authorizer: (channel, options) => {
            return {
                authorize: (socketId, callback) => {
                    $api(`/broadcasting/auth`, { 
                        method: 'POST', 
                        body: {
                            socket_id: socketId,
                            channel_name: channel.name
                        }
                    }).then(response => {
                        callback(false, response.data.value);
                    }).catch((error) => {
                        callback(true, error);
                    })
                }
            }
        }
    })

    nuxtApp.provide('echo', echo)
});