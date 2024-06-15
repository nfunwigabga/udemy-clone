

export default defineNuxtPlugin((nuxtApp) => {
    const config = useRuntimeConfig()
    // const {strategy: auth} = useAuth()

    return {
        provide:{
            api: (request, options) =>  {
                return useFetch(request, {
                    baseURL: config.public.baseURL,
                    credentials: 'include',
                    headers:{
                        'content-type': 'application/json',
                        'accept': 'application/json',
                        // 'Authorization': auth.token.get()
                    },
                    ...options 
                })
            }
        }
    }
})