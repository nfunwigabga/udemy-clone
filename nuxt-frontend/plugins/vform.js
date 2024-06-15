import Form from "~/utils/vform"


export default defineNuxtPlugin((nuxtApp) => {
    return {
        provide:{
            form: (options) => new Form(options) 
        }
    }
})