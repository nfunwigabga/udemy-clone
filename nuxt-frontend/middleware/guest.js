
export default defineNuxtRouteMiddleware((to, from) => {
    const {loggedIn} = useAuth()
    if(loggedIn){
        return navigateTo('/')
    }
})