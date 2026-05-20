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
    const request = async (method, url, data = null, headers = {}) => {
        loading.value = true
        error.value = null

        try {
            // Voor POST, PUT, PATCH, DELETE requests eerst CSRF token
            if (['post', 'put', 'patch', 'delete'].includes(method.toLowerCase())) {
                await getCsrfToken()
            }

            const response = await axios({
                method,
                url: `/api${url}`,
                data,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    ...headers
                }
            })

            return {
                success: true,
                data: response.data.data || response.data,
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
