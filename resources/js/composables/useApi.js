// resources/js/composables/useApi.js
import { ref } from 'vue'
import axios from 'axios'

export function useApi() {
    const loading = ref(false)
    const error = ref(null)

    // CSRF token ophalen voor Laravel
    const getCsrfToken = async () => {
        try {
            await axios.get('/sanctum/csrf-cookie')
        } catch (err) {
            console.error('Could not fetch CSRF token:', err)
        }
    }

    // Algemene API request handler
    const request = async (method, url, data = null, customHeaders = {}) => {
        loading.value = true
        error.value = null

        try {
            const isFormData = data instanceof FormData

            const headers = {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                ...customHeaders
            }

            if (!isFormData) {
                headers['Content-Type'] = 'application/json'
            }

            const response = await axios({
                method,
                url: `/api${url}`,
                data: isFormData ? data : JSON.stringify(data),
                headers
            })

            return {
                success: true,
                data: response.data,
                status: response.status
            }
        } catch (err) {
            error.value = err.response?.data?.message || err.message
            return {
                success: false,
                error: err.response?.data?.errors || err.response?.data?.message || err.message,
                status: err.response?.status
            }
        } finally {
            loading.value = false
        }
    }

    // CRUD helpers
    const get = (url) => request('get', url)
    const post = (url, data) => request('post', url, data)
    const put = (url, data) => request('put', url, data)
    const patch = (url, data) => request('patch', url, data)
    const del = (url) => request('delete', url)

    return {
        loading,
        error,
        get,
        post,
        put,
        patch,
        delete: del,
        request
    }
}
