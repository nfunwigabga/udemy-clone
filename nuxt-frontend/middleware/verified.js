
export default defineNuxtRouteMiddleware((to, from) => {
    const {loggedIn, user} = useAuth()
    
    if(loggedIn && !user.verified){
        return navigateTo({name: 'verification.notice'})
    }
    
})