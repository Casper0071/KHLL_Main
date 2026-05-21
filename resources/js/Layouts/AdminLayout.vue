<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { router } from '@inertiajs/vue3'
import axios from 'axios'
import VerticalNavbar from "@/Components/layouts/AdminSidebar.vue";

const isSidebarCollapsed = ref(false)
const user = ref(null)
const isAdmin = ref(false)
const isMobile = ref(false)

const toggleSidebar = () => {
    isSidebarCollapsed.value = !isSidebarCollapsed.value
}

const handleLogout = async () => {
    try {
        await axios.post('/api/logout')
        localStorage.removeItem('auth_token')
        localStorage.removeItem('user')
        delete axios.defaults.headers.common['Authorization']
        router.visit('/login')
    } catch (error) {
        console.error('Logout error:', error)
        // Force logout ook als API call faalt
        localStorage.removeItem('auth_token')
        localStorage.removeItem('user')
        delete axios.defaults.headers.common['Authorization']
        router.visit('/login')
    }
}

const checkAuth = async () => {
    const token = localStorage.getItem('auth_token')
    const storedUser = localStorage.getItem('user')

    if (token && storedUser) {
        try {
            // Zet token in axios headers
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`

            // Verifieer token met backend
            const response = await axios.get('/api/me')

            user.value = response.data.user
            isAdmin.value = user.value.role === 'admin'
        } catch (error) {
            console.error('Auth verificatie error:', error)
            // Token is ongeldig
            localStorage.removeItem('auth_token')
            localStorage.removeItem('user')
            delete axios.defaults.headers.common['Authorization']
            router.visit('/login')
        }
    } else {
        router.visit('/login')
    }
}

// Check scherm grootte voor responsive
const checkScreenSize = () => {
    isMobile.value = window.innerWidth < 768
    // Op mobiel altijd sidebar ingeklapt
    if (isMobile.value && !isSidebarCollapsed.value) {
        isSidebarCollapsed.value = true
    }
}

onMounted(() => {
    checkAuth()
    checkScreenSize()
    window.addEventListener('resize', checkScreenSize)
})

onUnmounted(() => {
    window.removeEventListener('resize', checkScreenSize)
})
</script>

<template>
    <div class="min-h-screen bg-background">
        <div class="flex">
            <!-- Sidebar -->
            <VerticalNavbar
                :isCollapsed="isSidebarCollapsed"
                @toggle="toggleSidebar"
            />

            <!-- Main Content -->
            <main
                class="flex-1 transition-all duration-300 min-h-screen"
                :class="{
                    'ml-0 md:ml-20': isSidebarCollapsed && !isMobile,
                    'ml-0 md:ml-64': !isSidebarCollapsed && !isMobile,
                    'ml-0': isMobile
                }"
            >
                <!-- Top Bar -->
                <div class="bg-background-light border-b border-primary border-opacity-20 px-4 sm:px-6 py-3 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 sm:gap-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="text-text-light text-sm sm:text-base">
                            Welkom, <span class="font-semibold">{{ user?.name || 'Admin' }}</span>
                        </p>
                        <span v-if="isAdmin" class="text-xs bg-green-500 text-white px-2 py-0.5 rounded-full">
                            Admin
                        </span>
                        <span v-else class="text-xs bg-blue-500 text-white px-2 py-0.5 rounded-full">
                            Gebruiker
                        </span>
                    </div>

                    <div class="flex items-center gap-3">
                        <!-- Gebruiker avatar (mobiel) -->
                        <div class="md:hidden flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                                <span class="text-primary text-sm font-bold">
                                    {{ user?.name?.charAt(0) || 'A' }}
                                </span>
                            </div>
                        </div>

                        <!-- Uitloggen knop -->
                        <button
                            @click="handleLogout"
                            class="flex items-center gap-1 text-red-500 hover:text-red-700 transition text-sm px-2 py-1 rounded-lg hover:bg-red-500/10"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="hidden sm:inline">Uitloggen</span>
                        </button>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="p-4 sm:p-6">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style scoped>
/* Transitions */
.transition-all {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}

/* Responsive margins */
@media (max-width: 767px) {
    main {
        margin-left: 0 !important;
    }
}

/* Scrollbar styling voor main content */
main::-webkit-scrollbar {
    width: 8px;
}

main::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

main::-webkit-scrollbar-thumb {
    background: rgba(249, 115, 22, 0.5);
    border-radius: 4px;
}

main::-webkit-scrollbar-thumb:hover {
    background: rgba(249, 115, 22, 0.8);
}
</style>
