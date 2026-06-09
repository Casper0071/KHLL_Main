<template>
    <div class="login-page">
        <div class="login-container">
            <!-- Logo -->
            <div class="login-header">
                <img
                    src="/img/logos/logoKroonWit.png"
                    alt="Koninklijke Harmonie Lentekrans Logo"
                    class="login-logo"
                />
                <h1 class="login-title">Admin Login</h1>
                <p class="login-subtitle">Log in om het admin panel te betreden</p>
            </div>

            <!-- Error en Success messages -->
            <div v-if="error" class="login-error">
                {{ error }}
            </div>
            <div v-if="successMessage" class="login-success">
                {{ successMessage }}
            </div>

            <!-- Login Form -->
            <form @submit.prevent="handleLogin" class="login-form">
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        placeholder="voorbeeld@khll.nl"
                        class="form-input"
                    />
                </div>

                <div class="form-group">
                    <label class="form-label">Wachtwoord</label>
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        placeholder="Voer uw wachtwoord in"
                        class="form-input"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="loading"
                    class="login-button"
                >
                    <div class="button-content">
                        <div v-if="loading" class="button-spinner"></div>
                        <span>{{ loading ? 'Bezig met inloggen...' : 'Inloggen' }}</span>
                    </div>
                </button>
            </form>

            <!-- Link terug naar homepagina -->
            <div class="login-footer">
                <Link href="/" class="back-home-link">
                    <svg class="back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Terug naar homepagina
                </Link>
            </div>
        </div>
    </div>
</template>

<script setup>
// ============================================
// Imports
// ============================================
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import axios from 'axios'

// ============================================
// Reactive State
// ============================================
const form = ref({
    email: '',
    password: ''
})
const loading = ref(false)
const error = ref('')
const successMessage = ref('')

// ============================================
// Methods
// ============================================
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

            localStorage.setItem('auth_token', token)
            localStorage.setItem('user', JSON.stringify(user))
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

            successMessage.value = 'Inloggen succesvol! Doorverwijzen...'

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
/* ============================================
   PAGE CONTAINER
   ============================================ */
.login-page {
    min-height: 100vh;
    background: var(--background);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}

/* ============================================
   LOGIN CARD
   ============================================ */
.login-container {
    max-width: 28rem;
    width: 100%;
    background: var(--background-light);
    border-radius: 1rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    padding: 1.5rem;
    border: 1px solid rgba(234, 183, 81, 0.2);
}

@media (min-width: 640px) {
    .login-container {
        padding: 2rem;
        border-radius: 1rem;
    }
}

/* ============================================
   HEADER SECTION
   ============================================ */
.login-header {
    text-align: center;
    margin-bottom: 1.5rem;
}

@media (min-width: 640px) {
    .login-header {
        margin-bottom: 2rem;
    }
}

.login-logo {
    width: 4rem;
    height: 4rem;
    border-radius: 9999px;
    object-fit: cover;
    margin: 0 auto 0.75rem auto;
}

@media (min-width: 640px) {
    .login-logo {
        width: 5rem;
        height: 5rem;
        margin-bottom: 1rem;
    }
}

.login-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-light);
}

@media (min-width: 640px) {
    .login-title {
        font-size: 1.5rem;
    }
}

.login-subtitle {
    color: var(--text-muted);
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

@media (min-width: 640px) {
    .login-subtitle {
        font-size: 0.875rem;
    }
}

/* ============================================
   MESSAGE BANNERS
   ============================================ */
.login-error {
    background: #ef4444;
    color: white;
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

.login-success {
    background: #10b981;
    color: white;
    padding: 0.75rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
}

/* ============================================
   FORM STYLES
   ============================================ */
.login-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-light);
    margin-bottom: 0.25rem;
}

.form-input {
    width: 100%;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    background: var(--background-dark);
    border: 1px solid rgba(234, 183, 81, 0.3);
    color: var(--text-light);
    font-size: 1rem;
    transition: all 0.2s ease;
}

.form-input::placeholder {
    color: var(--text-muted);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(234, 183, 81, 0.2);
}

/* ============================================
   BUTTON STYLES
   ============================================ */
.login-button {
    width: 100%;
    background: var(--primary);
    color: var(--background);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
}

.login-button:hover:not(:disabled) {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.login-button:active:not(:disabled) {
    transform: translateY(0);
}

.login-button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.button-content {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.button-spinner {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid var(--background);
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* ============================================
   FOOTER LINK
   ============================================ */
.login-footer {
    margin-top: 1.5rem;
    text-align: center;
}

.back-home-link {
    color: var(--primary);
    font-size: 0.875rem;
    transition: color 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    text-decoration: none;
}

.back-home-link:hover {
    color: var(--primary-hover);
}

.back-icon {
    width: 1rem;
    height: 1rem;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 480px) {
    .login-container {
        padding: 1rem;
        border-radius: 0.75rem;
    }
}
</style>
