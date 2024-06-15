import Errors from "./Errors"
import { deepCopy } from './util'


class Form {
    originalData =  {}
    busy = false
    successful=false 
    recentlySuccessful=false
    recentlySuccessfulTimeoutId=undefined
    errors = new Errors()
    progress = undefined
    
    // static axios
    static routes = {}
    static errorMessage = 'Something went wrong. Please try again.'
    static recentlySuccessfulTimeout = 2000
    static ignore = ['busy', 'successful', 'errors', 'progress', 'originalData', 'recentlySuccessful', 'recentlySuccessfulTimeoutId']
    
    constructor (data = {}) {
        this.update(data)
    }

    static make(augment=null) {
        return new this(augment)
    }

    /**
   * Update the form data.
   */
    update (data) {
        this.originalData = Object.assign({}, this.originalData, deepCopy(data))

        Object.assign(this, data)
    }

    /**
   * Fill the form data.
   */
    fill (data = {}) {
        this.keys().forEach((key) => {
            (this)[key] = data[key]
        })
    }

    /**
   * Get the form data.
   */
    data () {
        return this.keys().reduce((data, key) => ({ ...data, [key]: (this)[key] }), {})
    }

    /**
   * Get the form data keys.
   */
    keys () {
        return Object.keys(this).filter(key => !Form.ignore.includes(key))
    }

    /**
   * Start processing the form.
   */
    startProcessing () {
        this.errors.clear()
        this.busy = true
        this.successful = false
        this.progress = undefined
        this.recentlySuccessful = false
        clearTimeout(this.recentlySuccessfulTimeoutId)
    }

    /**
     * Finish processing the form.
     */
    finishProcessing () {
        this.busy = false
        this.successful = true
        this.progress = undefined
        this.recentlySuccessful = true
        this.recentlySuccessfulTimeoutId = setTimeout(() => {
        this.recentlySuccessful = false
        }, Form.recentlySuccessfulTimeout)
    }

    /**
     * Clear the form errors.
     */
    clear () {
        this.errors.clear()
        this.successful = false
        this.recentlySuccessful = false
        this.progress = undefined
        clearTimeout(this.recentlySuccessfulTimeoutId)
    }

    /**
     * Reset the form data.
     */
    reset () {
        Object.keys(this)
        .filter(key => !Form.ignore.includes(key))
        .forEach((key) => {
            (this)[key] = deepCopy(this.originalData[key])
        })
    }


    /**
     * Submit the form via a GET request.
     */
    get(url, config = {}) {
        return this.submit('get', url, config)
    }

    /**
     * Submit the form via a POST request.
     */
    post(url, config = {}) {
        return this.submit('post', url, config)
    }

    /**
     * Submit the form via a PATCH request.
     */
    patch(url, config = {}) {
        return this.submit('patch', url, config)
    }

    /**
     * Submit the form via a PUT request.
     */
    put(url, config = {}) {
        return this.submit('put', url, config)
    }

    /**
     * Submit the form via a DELETE request.
     */
    delete(url, config = {}) {
        return this.submit('delete', url, config)
    }

    /**
     * Submit the form data via an HTTP request.
     */
    async submit(method, url, config = {}) {
        this.startProcessing()
        const {$api} = useNuxtApp()
        config = {
            method: method,
            body: {},
            params: {},
            ...config
        }

        if (method.toLowerCase() === 'get') {
            config.params = { ...this.data(), ...config.params }
        } else {
            config.body = { ...this.data(), ...config.body }
        }
        
        const {data, error} = await $api(url, config)
        
        if(error.value){
            this.handleErrors(error.value.data)
            return Promise.reject(error.value)
        }

        this.finishProcessing()
        return Promise.resolve(data.value)

    }

    /**
     * Handle the errors.
     */
    handleErrors (error) {
        this.busy = false
        this.progress = undefined
        
        if (error) {
            this.errors.set(this.extractErrors(error))
        }
    }

    /**
     * Extract the errors from the response object.
     */
    extractErrors (errorbag) {
        if (!errorbag || typeof errorbag !== 'object') {
            return { error: Form.errorMessage }
        }

        if (errorbag.errors) {
            return { ...errorbag.errors }
        }

        if (errorbag.message) {
            return { error: errorbag.message }
        }

        return { ...errorbag }
    }
}

export default Form