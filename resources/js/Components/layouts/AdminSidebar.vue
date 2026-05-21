<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed, ref, onMounted, onUnmounted } from 'vue'
import { useTranslations } from '@/composables/useTranslations.js'
import { useNavigation } from '@/composables/useNavigation.js'

const props = defineProps({
    isCollapsed: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['toggle'])

const page = usePage()
const { t, currentLocale, setLocale } = useTranslations()
const { getSidebarLinks } = useNavigation()

// Responsive state
const isMobile = ref(false)
const isTablet = ref(false)
const mobileMenuOpen = ref(false)

// Check screen size
const checkScreenSize = () => {
    const width = window.innerWidth
    isMobile.value = width < 768
    isTablet.value = width >= 768 && width < 1024

    // Op mobiel altijd ingeklapt, op tablet optioneel
    if (isMobile.value && !props.isCollapsed) {
        emit('toggle')
    }
}

// Haal de huidige gebruiker op
const currentUser = computed(() => {
    if (page.props.auth?.user) {
        return page.props.auth.user
    }
    const storedUser = localStorage.getItem('user')
    if (storedUser) {
        return JSON.parse(storedUser)
    }
    return null
})

// Gebruik de sidebar links met role filtering
const links = computed(() => {
    const userRole = currentUser.value?.role || null
    return getSidebarLinks(t, userRole)
})

const navigation = computed(() => t.value?.navigation ?? {})



const toggleSidebar = () => {
    if (!isMobile.value) {
        emit('toggle')
    } else {
        mobileMenuOpen.value = !mobileMenuOpen.value
    }
}

const closeMobileMenu = () => {
    if (isMobile.value) {
        mobileMenuOpen.value = false
    }
}

// Helper functie voor iconen
const getIconPath = (icon) => {
    const icons = {
        dashboard: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
        calendar: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        information: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        users: 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'
    }
    return icons[icon] || icons.dashboard
}

onMounted(() => {
    checkScreenSize()
    window.addEventListener('resize', checkScreenSize)
})

onUnmounted(() => {
    window.removeEventListener('resize', checkScreenSize)
})
</script>

<template>
    <!-- Mobiele overlay -->
    <div
        v-if="isMobile && mobileMenuOpen"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity duration-300"
        @click="closeMobileMenu"
    ></div>

    <!-- Sidebar -->
    <aside
        :class="[
            'fixed left-0 top-0 h-screen bg-background-dark border-r border-primary border-opacity-30 flex flex-col transition-all duration-300 z-50',
            isMobile ? (mobileMenuOpen ? 'translate-x-0 w-64' : '-translate-x-full w-64') : (isCollapsed ? 'w-20' : 'w-64')
        ]"
    >
        <!-- Toggle Button - Alleen zichtbaar op desktop en tablet -->
        <button
            v-if="!isMobile"
            @click="toggleSidebar"
            class="absolute -right-3 top-20 bg-primary text-background rounded-full p-1.5 hover:bg-primary-hover transition-all duration-300 shadow-lg z-10"
            :class="{ 'rotate-180': isCollapsed }"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Mobiele close button -->
        <button
            v-if="isMobile && mobileMenuOpen"
            @click="closeMobileMenu"
            class="absolute top-4 right-4 text-text-muted hover:text-primary transition z-20"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Logo Section -->
        <div class="flex-shrink-0 p-4 border-b border-primary border-opacity-30">
            <Link href="/" class="flex items-center justify-center gap-3 hover:opacity-80 transition" @click="closeMobileMenu">
                <img
                    src="/img/logos/logoKroonWit.png"
                    alt="Koninklijke Harmonie Lentekrans Logo"
                    class="h-10 w-10 sm:h-12 sm:w-12 rounded-full object-cover flex-shrink-0"
                />
                <span
                    v-show="!isCollapsed || isMobile"
                    class="text-primary font-bold text-sm sm:text-base md:text-lg transition-opacity duration-300"
                >
                    Admin Panel
                </span>
            </Link>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 py-4 sm:py-6 overflow-y-auto">
            <div class="space-y-1 px-2 sm:px-3">
                <Link
                    v-for="link in links"
                    :key="link.href"
                    :href="link.href"
                    @click="closeMobileMenu"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg font-medium transition-all duration-300 group relative"
                    :class="[
                        page.url === link.href
                            ? 'bg-primary text-background'
                            : 'text-text-light hover:text-primary hover:bg-background-light',
                        (isCollapsed && !isMobile) ? 'justify-center' : ''
                    ]"
                >
                    <!-- Icon -->
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getIconPath(link.icon)"/>
                    </svg>

                    <span v-show="!isCollapsed || isMobile" class="transition-opacity duration-300">
                        {{ link.label }}
                    </span>

                    <!-- Tooltip voor collapsed mode (alleen desktop) -->
                    <div
                        v-if="!isMobile && isCollapsed"
                        class="absolute left-full ml-2 px-2 py-1 bg-background-light text-text-light text-sm rounded opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-200 whitespace-nowrap z-20"
                    >
                        {{ link.label }}
                    </div>
                </Link>
            </div>
        </nav>

        <!-- Footer met gebruiker info en taal wisselaar -->
        <div class="flex-shrink-0 border-t border-primary border-opacity-30 p-3 sm:p-4">
            <!-- Uitgebreide footer (normaal/mobiel) -->
            <div v-show="!isCollapsed || isMobile" class="space-y-3">
                <!-- Gebruiker info -->
                <div class="flex items-center gap-2 p-2 rounded-lg bg-background-dark/50">
                    <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                        <span class="text-primary text-sm font-bold">
                            {{ currentUser?.name?.charAt(0) || 'A' }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-text-light text-sm font-medium truncate">{{ currentUser?.name || 'Admin' }}</p>
                        <p class="text-text-muted text-xs">{{ currentUser?.role === 'admin' ? 'Administrator' : 'Gebruiker' }}</p>
                    </div>
                </div>

            </div>

            <!-- Compacte footer voor collapsed mode (alleen desktop) -->
            <div v-show="!isMobile && isCollapsed" class="flex flex-col items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                    <span class="text-primary text-sm font-bold">
                        {{ currentUser?.name?.charAt(0) || 'A' }}
                    </span>
                </div>
            </div>
        </div>
    </aside>

    <!-- Mobiele hamburger button -->
    <button
        v-if="isMobile && !mobileMenuOpen"
        @click="toggleSidebar"
        class="fixed bottom-4 right-4 z-50 bg-primary text-background p-3 rounded-full shadow-lg hover:bg-primary-hover transition md:hidden"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</template>

<style scoped>
/* Scrollbar styling */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(249, 115, 22, 0.5);
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(249, 115, 22, 0.8);
}

/* Mobiele animaties */
@media (max-width: 767px) {
    .translate-x-0 {
        transform: translateX(0);
    }

    .-translate-x-full {
        transform: translateX(-100%);
    }
}

/* Tablet aanpassingen */
@media (min-width: 768px) and (max-width: 1023px) {
    .w-64 {
        width: 16rem;
    }

    .w-20 {
        width: 5rem;
    }
}
</style>
