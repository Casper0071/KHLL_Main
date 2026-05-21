<!-- Pages/Login.vue -->
<template>
    <div class="min-h-screen bg-background flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-background-light rounded-2xl shadow-xl p-6 sm:p-8 border border-primary border-opacity-20">
            <!-- Logo -->
            <div class="text-center mb-6 sm:mb-8">
                <img src="/img/logos/logoKroonWit.png" alt="Logo" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full mx-auto mb-3 sm:mb-4" />
                <h1 class="text-xl sm:text-2xl font-bold text-text-light">Admin Login</h1>
                <p class="text-text-muted text-xs sm:text-sm mt-1">Log in om het admin panel te betreden</p>
            </div>

            <!-- Error en Success messages -->
            <div v-if="error" class="bg-red-500 text-white p-3 rounded-lg mb-4 text-sm">
                {{ error }}
            </div>
            <div v-if="successMessage" class="bg-green-500 text-white p-3 rounded-lg mb-4 text-sm">
                {{ successMessage }}
            </div>

            <!-- Login Form -->
            <form @submit.prevent="handleLogin" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-text-light mb-1">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        placeholder="Voorbeeld@gmail.nl"
                        class="w-full px-4 py-2 rounded-lg bg-background-dark border border-primary border-opacity-30 text-text-light placeholder-text-muted focus:outline-none focus:border-primary"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-text-light mb-1">Wachtwoord</label>
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        placeholder="Voer uw wachtwoord in"
                        class="w-full px-4 py-2 rounded-lg bg-background-dark border border-primary border-opacity-30 text-text-light placeholder-text-muted focus:outline-none focus:border-primary"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-primary text-background py-2 rounded-lg font-medium hover:bg-primary-hover transition disabled:opacity-50"
                >
                    <div class="flex items-center justify-center gap-2">
                        <div v-if="loading" class="animate-spin rounded-full h-5 w-5 border-b-2 border-background"></div>
                        <span>{{ loading ? 'Bezig met inloggen...' : 'Inloggen' }}</span>
                    </div>
                </button>
            </form>

            <!-- Link terug naar homepagina -->
            <div class="mt-6 text-center">
                <Link
                    href="/"
                    class="text-primary hover:text-primary-hover transition text-sm inline-flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Terug naar homepagina
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import {Link, router} from '@inertiajs/vue3'
import axios from 'axios'

const form = ref({
    email: '',
    password: ''
})
const loading = ref(false)
const error = ref('')
const successMessage = ref('')

const handleLogin = async () => {
    loading.value = true
    error.value = ''
    successMessage.value = ''

    try {
        const response = await axios.post('/api/login', {
            email: form.value.email,
            password: form.value.password
        })

        if (response.data.success) {
            const token = response.data.token
            const user = response.data.user

            // Sla token op in localStorage
            localStorage.setItem('auth_token', token)
            localStorage.setItem('user', JSON.stringify(user))

            // Zet default header voor axios
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

            successMessage.value = 'Inloggen succesvol! Doorverwijzen...'

            // Redirect naar admin dashboard
            setTimeout(() => {
                router.visit('/admin')
            }, 1000)
        }
    } catch (err) {
        console.error('Login error:', err)

        if (err.response?.data?.errors) {
            error.value = Object.values(err.response.data.errors).flat()[0]
        } else if (err.response?.data?.message) {
            error.value = err.response.data.message
        } else {
            error.value = 'Inloggen mislukt. Controleer je gegevens.'
        }
    } finally {
        loading.value = false
    }
}
</script>

<style scoped>
/* Extra kleine schermen */
@media (max-width: 480px) {
    .p-6 {
        padding: 1rem;
    }

    .rounded-2xl {
        border-radius: 1rem;
    }
}
</style>
