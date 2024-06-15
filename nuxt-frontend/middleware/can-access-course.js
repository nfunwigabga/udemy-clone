
export default defineNuxtRouteMiddleware(async(to, from) => {
    const {loggedIn} = useAuth()
    const {$api} = useNuxtApp()
    if(!loggedIn){
        return navigateTo('/')
    }
    const {data} = await $api(`/c/${to.params.course}/check-access`)
    
    // if(!data.value.can){
    //     return abortNavigation("Unauthorized access!")
    // }

})